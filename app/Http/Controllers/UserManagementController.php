<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendUserInformation;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CustomerPaymentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Yajra\DataTables\DataTables;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::where('parent_id', Auth::id())->orderBy('created_at', 'DESC');
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->addColumn('package_name', function ($row) {
                return $row->package->name;
            })
            ->addColumn('company_name', function ($row) {
                $company = Company::where('user_id', Auth::id())->first();
                return $company->name;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<a class="badge badge-success" onclick="return confirm(`Are you sure you want to In-Active User`)" href="' . route(auth()->user()->type . ".user_management_status", [$row->id]) . '" tile="" >Active</a>';

                } else {
                    return '<a class="badge badge-danger" onclick="return confirm(`Are you sure you want to Active User`)" href="' . route(auth()->user()->type . ".user_management_status", [$row->id]) . '" tile="">InActive</a>';
                }
            })->filter(function ($instance) use ($request) {
                        if ($request->has('search') && $request->search['value'] != '') {
                            $search = $request->search['value'];
                            $instance->where(function ($query) use ($search) {
                                 $query->whereHas('package', function ($q) use ($search) {
                                    $q->where('name', 'like', "%{$search}%");
                                })
                                ->orwhere('name', 'like', "%{$search}%")
                                ->orWhere('id', 'like', "%{$search}%");
                            });
                        }
                    })
            ->rawColumns(['package_name', 'status', 'company_name'])
            ->make(true);
        }
        return view('User-management.index', get_defined_vars());
    }

    public function ChangeStatus($id)
    {
        $user = User::find($id);
        if ($user->status == 1) {
            $user->status = 0;
            $user->save();
        } else {
            $user->status = 1;
            $user->save();
        }
        return back()->with('success', 'Status Changed Successfully');
    }

    public function createUser()
    {
        return view('User-management.create-user');
    }

    public function userPayment(Request $request)
    {
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'alt_phone' => $request->alt_phone,
        ];

        session()->put('user', $user);

        $package = Auth::user()->package;
        $customerPaymentProfile = CustomerPaymentProfile::where('customer_profile_id', Auth::user()->subscriptions[0]->customer_profile_id)->where('live_mode', 1)->first();
        $expirationDate = explode('-', $customerPaymentProfile->expired_at);
        $expiryYear = $expirationDate[0];
        $expiryMonth = $expirationDate[1];

        return view('User-management.payment', get_defined_vars());
    }

    public function emailValidation(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists(); // Check if the email exists in the DB

        if (isset($exists)) {
            // return redirect()->route(auth()->user()->type . '.user_management.create_user')->with('error', 'Duplicate Email Found');
            return response()->json(['exists' => $exists]);
        }
        
    }

    public function handlePayment(Request $requests)
    {
        $requests->validate([
            'card_number' => ['required', new CardNumber],
            'year' => ['required', new CardExpirationYear($requests->month)],
            'month' => ['required', new CardExpirationMonth($requests->year)],
            'cvv' => ['required', new CardCvc($requests->card_number)],
        ]);

        $seat = session()->get('user');

        $expirationDate = $requests->month . '-' . $requests->year;
        $merchantAuthentication = getMerchantAuthentication();

        // Create a credit card object
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($requests->card_number);
        $creditCard->setExpirationDate($expirationDate);
        $creditCard->setCardCode($requests->cvv);

        // Create a payment object
        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        // Create a transaction request
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($requests->promo_user_amount);
        $transactionRequestType->setPayment($payment);

        // Create a create transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $refId = "ref" . time();
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);

        // Execute the request
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
   
        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            $tresponse = $response->getTransactionResponse();
            $transId = $tresponse->getTransId();
            $transDescription = $tresponse->getMessages()[0]->getDescription();
            $customerPaymentProfile = CustomerPaymentProfile::where('customer_profile_id', Auth::user()->subscriptions[0]->customer_profile_id)->where('live_mode', 1)->first();
            $customerProfileId = $customerPaymentProfile->customer_profile_id;
            $customerPaymentProfileId = $customerPaymentProfile->customer_payment_profile_id;
            $promoUserAmount = $requests->promo_user_amount; 
            $regularUserAmount = $requests->regular_user_amount;
            $subscriptionResponse = $this->createSubscription($merchantAuthentication, $customerProfileId, $customerPaymentProfileId, $refId, $promoUserAmount, $regularUserAmount);
            // dd($subscriptionResponse);
            if ($subscriptionResponse != null && $subscriptionResponse->getMessages()->getResultCode() == "Ok") {

                $subscriptionId = $subscriptionResponse->getSubscriptionId();

                    $seat = session()->get('user');

                    $userData = Auth::user();

                    $newUser = new User();
                    $newUser->name = $seat['name'];
                    $newUser->email = $seat['email'];
                    $newUser->email_verified_at = Carbon::now();
                    $newUser->password = Hash::make($seat['password']);
                    if ($userData->type == 'trucker') {
                        $newUser->type = 1;
                    }elseif ($userData->type == 'broker') {
                        $newUser->type = 3;
                    }elseif ($userData->type == 'combo') {
                        $newUser->type = 4;
                    } else {
                        $newUser->type = 2;

                    }
                    $newUser->phone = $seat['phone'];
                    $newUser->alt_phone = $seat['alt_phone'];
                    $newUser->package_id = $userData->package_id;
                    $newUser->parent_id = $userData->id;
                    $newUser->expired_at = Carbon::now()->addDays(30);
                    $newUser->status = 1;
                    $newUser->save();

                    $subscriber = new Subscription();
                    $subscriber->user_id = $newUser->id;
                    $subscriber->package_id = $userData->package_id;
                    $subscriber->invoice_no = "INVOICE_NO_" . rand(111111111, 999999999);
                    $subscriber->transaction_id = $transId;
                    $subscriber->transaction_detail = $transDescription;
                    $subscriber->customer_profile_id = $customerProfileId;
                    $subscriber->customer_payment_profile_id = $customerPaymentProfileId;
                    $subscriber->subscription_id = $subscriptionId;
                    $subscriber->subscription_detail = 'subscription created successfully';
                    $subscriber->transaction_detail = $transDescription;
                    $subscriber->amount = $promoUserAmount;
                    $subscriber->expired_at = Carbon::now()->addDays(30);
                    $subscriber->is_active = 1;
                    $subscriber->save();

                    Mail::to($seat['email'])->send(new SendUserInformation($seat, $userData));

                    session()->forget(['user']);
                    // session()->flush();

                    return redirect()->route(auth()->user()->type . '.user_management.index')->with('success', "Payment And Subscription Created Successfully");
                } else {
                    $errorMessages = $subscriptionResponse->getMessages()->getMessage();
                    return redirect()->route(auth()->user()->type . '.user_management.index')->with('error', $errorMessages[0]->getText());
                }
        } else {
            return redirect()->route(auth()->user()->type . '.user_management.index')->with('error', "Error processing payment.");
        }
    }

 
    // Helper method to create a subscription
    private function createSubscription($merchantAuthentication, $customerProfileId, $customerPaymentProfileId, $refId, $promoUserAmount, $regularUserAmount)
    {
        // Set customer profile
        $profile = new AnetAPI\CustomerProfileIdType();
        $profile->setCustomerProfileId($customerProfileId);
        $profile->setCustomerPaymentProfileId($customerPaymentProfileId);


        $id = rand(000, 999);
        $End = rand(000, 999);

        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName("Sample Subscription for Owner " . $id);

        // Set payment schedule
        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength(1);
        $interval->setUnit("months");

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(Carbon::now());
        $paymentSchedule->setTotalOccurrences($End);
        $paymentSchedule->setTrialOccurrences(6);

        $subscription->setPaymentSchedule($paymentSchedule);

        // Set amount for regular and trial period
        $subscription->setAmount($regularUserAmount);
        $subscription->setTrialAmount($promoUserAmount);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($End);
        $order->setDescription("Description of the subscription" . $End);
        $subscription->setOrder($order);

        $subscription->setProfile($profile);

        // Create a new subscription request for each user
        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $refId = "ref" . $End;
        $request->setRefId($refId);
        $request->setSubscription($subscription);

        // Execute the request
        $controller = new AnetController\ARBCreateSubscriptionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        return $response;
    }

    public function updateSubscriptionFromCustomerProfile(Request $requests)
    {
        $requests->validate([
            'card_number' => ['required', new CardNumber],
            'year' => ['required', new CardExpirationYear($requests->month)],
            'month' => ['required', new CardExpirationMonth($requests->year)],
        ]);
        // dd($requests->all());
        $user = Auth::user();

        $profileIdRequested = $user->subscriptions[0]->customer_profile_id;
        $subscriptionId = $user->subscriptions[0]->subscription_id;

        $cardNumber = str_replace(' ', '', $requests->card_number);
        $expirationDate = $requests->month . '-' . $requests->year;

        /* Create a merchantAuthenticationType object with authentication details retrieved from the constants file */
       

        // Retrieve an existing customer profile along with all the associated payment profiles and shipping addresses
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication(getMerchantAuthentication());
        $request->setCustomerProfileId($profileIdRequested);
        $controller = new AnetController\GetCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $customerProfileId = $response->getProfile()->getCustomerProfileId();
            $customerPaymentProfileId = $response->getProfile()->getPaymentProfiles()[0]->getCustomerPaymentProfileId();
            // Set the transaction's refId
            $refId = 'ref' . time();

            $subscription = new AnetAPI\ARBSubscriptionType();

            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($cardNumber);
            $creditCard->setExpirationDate($expirationDate);

            $payment = new AnetAPI\PaymentType();
            $payment->setCreditCard($creditCard);

            //set profile information
            $profile = new AnetAPI\CustomerProfileIdType();
            $profile->setCustomerProfileId($customerProfileId);
            $profile->setCustomerPaymentProfileId($customerPaymentProfileId);

            $subscription->setPayment($payment);

            $request = new AnetAPI\ARBUpdateSubscriptionRequest();
            $request->setMerchantAuthentication(getMerchantAuthentication());
            $request->setRefId($refId);
            $request->setSubscriptionId($subscriptionId);
            $request->setSubscription($subscription);

            $controller = new AnetController\ARBUpdateSubscriptionController($request);

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            // dd($response);
            if ($response != null && $response->getMessages()->getResultCode() == "Ok") {

                Subscription::where('user_id', $user->id)->update([
                    'invoice_no' => "INVOICE_NO_" . rand(111111111, 999999999),
                    'transaction_detail' => 'Subscription Updated Successfully',
                    'expired_at' => Carbon::now()->addMonth(1),
                    'is_active' => 1,
                ]);
                
                User::where('id', $user->id)->update(['expired_at' => Carbon::now()->addMonth(1),'status' => 1]);

                return redirect()->route($user->type . '.billing.index')->with('success', 'Your Subscription Updated Successfully');

            } else {
                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                // echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
                return redirect()->back()->with('error', $errorMessages[0]->getText());
            }

        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
            return redirect()->back()->with('error', $errorMessages[0]->getText());
        }

    }
}
