<?php

namespace App\Http\Controllers;

require base_path('vendor') . '/authorizenet/authorizenet/autoload.php';
use App;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use App\Models\City;
use App\Models\CustomerPaymentProfile;
use App\Models\State;

use net\authorize\api\contract\v1\GetTransactionListForCustomerRequest;
use net\authorize\api\controller\GetTransactionListForCustomerController;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

//use net\authorize\api\constants\ANetEnvironment;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->ajax()) {

        //     $data = Subscription::whereHas('user', function ($q) {
        //         $q->where('parent_id', Auth::id());
        //     })->orWhere('user_id', Auth::id())->orderBy('created_at', 'DESC');

        //     return DataTables::of($data)->addIndexColumn()->addColumn('expired_at', function ($row) {
        //         return Carbon::parse($row->expired_at)->format('d M Y h:i:s a');
        //     })->addColumn('user_name', function ($row) {
        //         if ($row->user->parent_id == null) {

        //             return $row->user->name . "<i class='fas fa-user-tie' style='float: right; color:#0682be; font-size:23px;'></i>";
        //         } else {
        //             return $row->user->name;
        //         }

        //     })->addColumn('amount', function ($row) {
        //         return '$' . $row->amount;

        //     })->addColumn('is_active', function ($row) {
        //         $expiryCheck = $row->expired_at;
        //         if ($expiryCheck < Carbon::now()) {
        //             $row->is_active = 0;
        //             $row->save();
        //             if ($row->is_active == 0) {
        //                 return '<span class="badge badge-danger">In Active</span>';
        //             } else {
        //                 return '<span class="badge badge-success">Active</span>';
        //             }
        //         } else {
        //             if ($row->is_active == 1) {
        //                 return '<span class="badge badge-success">Active</span>';
        //             } else {
        //                 return '<span class="badge badge-danger">In Active</span>';
        //             }
        //         }

        //     })->addColumn('actions', function ($row) {
        //         $updateUsers = User::whereHas('subscriptions', function ($q) {
        //             $q->where('expired_at', '<', now())->where('is_active', 0);
        //         })->where('parent_id', Auth::id())->pluck('id')->toArray();
                
        //         $createUsers = User::whereHas('subscriptions', function ($q) {
        //             $q->where('expired_at', '<', now())->where('is_active', 0)->where('subscription_detail','canceled');
        //         })->where('parent_id', Auth::id())->pluck('id')->toArray();
                
        //         if (in_array($row->user_id, $updateUsers) == true) {
        //             return '<div class=""><a href="' . route(auth()->user()->type . '.billing.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a>'
        //             . '<a href="' . route(auth()->user()->type . '.update_subscriptions', [$row->user_id]) . '"class="btn btn-outline-info">Update subscription</a></div>';
        //         }elseif (in_array($row->user_id, $createUsers) == true) {
        //             return '<div class=""><a href="' . route(auth()->user()->type . '.billing.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a>'
        //             . '<a href="' . route(auth()->user()->type . '.create_subscriptions', [$row->user_id]) . '"class="btn btn-outline-secondary">Create Subscription</a></div>';
        //         } else {
        //             return '<div class="d-flex btnWrap"><a href="' . route(auth()->user()->type . '.billing.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a></div>';
        //         }

        //     })->rawColumns(['user_name', 'is_active', 'actions'])
        //         ->make(true);
        // } 
         if ($request->ajax()) {
            $data = Subscription::where(function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('parent_id', Auth::id());
                })->orWhere('user_id', Auth::id());
            })->orderBy('created_at', 'DESC');
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('expired_at', function ($row) {
                    return Carbon::parse($row->expired_at)->format('d M Y h:i:s a');
                })
                ->addColumn('user_name', function ($row) {
                    if ($row->user->parent_id == null) {
                        return $row->user->name . "<i class='fas fa-user-tie' style='float: right; color:#0682be; font-size:23px;'></i>";
                    } else {
                        return $row->user->name;
                    }
                })
                ->addColumn('amount', function ($row) {
                    return $row->amount;
                })
                ->addColumn('is_active', function ($row) {
                    $expiryCheck = $row->expired_at;
                    if ($expiryCheck < Carbon::now()) {
                        $row->is_active = 0;
                        $row->save();
                        if ($row->is_active == 0) {
                            return '<span class="badge badge-danger">In Active</span>';
                        } else {
                            return '<span class="badge badge-success">Active</span>';
                        }
                    } else {
                        if ($row->is_active == 1) {
                            return '<span class="badge badge-success">Active</span>';
                        } else {
                            return '<span class="badge badge-danger">In Active</span>';
                        }
                    }
                })
                ->addColumn('actions', function ($row) {
                    $updateUsers = User::whereHas('subscriptions', function ($q) {
                        $q->where('expired_at', '<', now())->where('is_active', 0);
                    })->where('parent_id', Auth::id())->pluck('id')->toArray();
                    
                    $createUsers = User::whereHas('subscriptions', function ($q) {
                        $q->where('expired_at', '<', now())->where('is_active', 0)->where('subscription_detail','canceled');
                    })->where('parent_id', Auth::id())->pluck('id')->toArray();
                    
                    if (in_array($row->user_id, $updateUsers)) {
                        return '<div class=""><a href="' . route(auth()->user()->type . '.billing.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a>'
                        . '<a href="' . route(auth()->user()->type . '.update_subscriptions', [$row->user_id]) . '"class="btn btn-outline-info">Update subscription</a></div>';
                    } elseif (in_array($row->user_id, $createUsers)) {
                        return '<div class=""><a href="' . route(auth()->user()->type . '.billing.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a>'
                        . '<a href="' . route(auth()->user()->type . '.create_subscriptions', [$row->user_id]) . '"class="btn btn-outline-secondary">Create Subscription</a></div>';
                    } else {
                        return '<div class="d-flex btnWrap"><a href="' . route(auth()->user()->type . '.billing.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a></div>';
                    }
                }) 
                ->filter(function ($instance) use ($request) {
                    
                        if ($request->has('search') && $request->search['value'] != '') {
                            $search = $request->search['value'];
                            $instance->where(function ($query) use ($search) {
                             $query->whereHas('user', function ($q) use ($search) {
                                    $q->where('name', 'like', "%{$search}%");
                                })
                                ->orwhere('id', 'like', "%{$search}%")
                                ->orWhere('amount', 'like', "%{$search}%")
                                ->orWhere('invoice_no', 'like', "%{$search}%")
                                ;
                            });
                        }
                       
                    })
                ->rawColumns(['user_name', 'is_active', 'actions'])
                ->make(true);
        }
        return view('Billing.index', get_defined_vars());
    }

    public function show($id)
    {
        $subscription = Subscription::with('user', 'package')->where('id', $id)->first();
        // dd($subscription);
        if($subscription != null){
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(config('app.transaction_name'));
            $merchantAuthentication->setTransactionKey(config('app.transaction_key'));
            
            // // Set the transaction's refId
            $refId = 'ref' . time();
            
            $request = new AnetAPI\ARBGetSubscriptionRequest();
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscriptionId($subscription->subscription_id);
            $request->setIncludeTransactions(true);
        	    
            // Controller
            $controller = new AnetController\ARBGetSubscriptionController($request);
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            // dd($response);
            if(($response != null) && ($response->getMessages()->getResultCode() == "Ok")){
                $allTransactions = $response->getSubscription()->getarbTransactions();
                // dd($allTransactions);
                $subscriptions = $response->getSubscription();
                // dd($subscriptions);
                $paymentSchedule = $subscriptions->getpaymentSchedule()->gettrialOccurrences();
                
                if(isset($allTransactions)){
                    if(count($allTransactions) <= $paymentSchedule){
                        $trialAmount = $subscriptions->gettrialAmount();
                    }else{
                        $amount = $subscriptions->getamount();
                    }    
                }
            }
        }

        return view('Billing.detail', get_defined_vars());
    }

    public function pdf($id)
    {
        $subscription = Subscription::with('user', 'package')->where('id', $id)->first();
        $ownerId = $subscription->user->parent_id;
        
        if($ownerId == null){
            $ownerId = $subscription->user->id;
        }
        $company = Company::where('user_id',$ownerId)->first();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('Billing.download-pdf', compact('subscription','company'));
        return $pdf->stream($subscription->user->name . '-' . $subscription->subscription_id . '.pdf');
    }

    public function cancelSubscription($id)
    {
        
        $subscription = Subscription::where('user_id' , $id)->first();
        $subscriptionId = $subscription->subscription_id;

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('app.transaction_name'));
        $merchantAuthentication->setTransactionKey(config('app.transaction_key'));

        $refId = 'ref' . time();

        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);

        $controller = new AnetController\ARBCancelSubscriptionController($request);

        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $user = User::find($subscription->user_id);
            $user->delete();
            $subscription->delete();

            return back()->with('success', 'Subscripiton cancelled and user deleted successfully');
        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
        }
    }

    public function updateSubscription($id)
    {
        // dd(User::find($id));
        $user = User::find($id);
        $userSubscription = $user->subscriptions[0];
        $customerPaymentProfile = CustomerPaymentProfile::where('customer_profile_id', Auth::user()->subscriptions[0]->customer_profile_id)->where('live_mode', 1)->first();
        // dd($userSubscription,$customerPaymentProfile);
        // $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        // $merchantAuthentication->setName(\SampleCodeConstants::MERCHANT_LOGIN_ID);
        // $merchantAuthentication->setTransactionKey(\SampleCodeConstants::MERCHANT_TRANSACTION_KEY);

        // Set the transaction's refId
        $refId = 'ref' . time();

        $subscription = new AnetAPI\ARBSubscriptionType();

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber(decrypt($customerPaymentProfile->card_no));
        $creditCard->setExpirationDate($customerPaymentProfile->expired_at);

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        //set profile information
        $profile = new AnetAPI\CustomerProfileIdType();
        $profile->setCustomerProfileId($customerPaymentProfile->customer_profile_id);
        $profile->setCustomerPaymentProfileId($customerPaymentProfile->customer_payment_profile_id);
        // $profile->setCustomerAddressId("141414");

        $subscription->setPayment($payment);

        //set customer profile information
        //$subscription->setProfile($profile);

        $request = new AnetAPI\ARBUpdateSubscriptionRequest();
        $request->setMerchantAuthentication(getMerchantAuthentication());
        $request->setRefId($refId);
        $request->setSubscriptionId($userSubscription->subscription_id);
        $request->setSubscription($subscription);

        $controller = new AnetController\ARBUpdateSubscriptionController($request);

        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $errorMessages = $response->getMessages()->getMessage();
            // echo "SUCCESS Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";

            $userSubscription->update(['subscription_detail' => 'subscription updated', 'expired_at' => Carbon::now()->addMonth(1), 'is_active' => 1]);
            $user->update(['expired_at' => Carbon::now()->addMonth(1)]);

            return redirect()->route(auth()->user()->type . '.billing.index')->with('success', 'User Subscription Updated Successfully');

        } else {
            // echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
            return redirect()->route(auth()->user()->type . '.billing.index')->with('error', $errorMessages[0]->getText());
        }

        // return $response;

    }

        
    public function getStates($id)
    {
        $states = State::where('country_id', $id)->orderBy('name','ASC')->get();
        return response()->json($states);
    }

    public function getCities($id)
    {
        // dd($id);
        $cities = City::where('state_id', $id)->orderBy('name','ASC')->get();
        return response()->json($cities);
    }

    public function updateUserSubscription(Request $requests)
    {
        // dd($requests->all(),'123');
        $requests->validate([
            'card_number' => ['required', new CardNumber],
            'year' => ['required', new CardExpirationYear($requests->month)],
            'month' => ['required', new CardExpirationMonth($requests->year)]
        ]);
        //  dd($requests->all(),'123');
        // $string = str_replace(' ', '', $request->card_number);
        $user = Auth::user();

        $profileIdRequested = $user->subscriptions[0]->customer_profile_id;
        $subscription = Subscription::where('user_id', $requests->user_id)->first();
        $subscriptionId = $subscription->subscription_id;
        $cardNumber = str_replace(' ', '', $requests->card_number);
        // dd($cardNumber);
        $expirationDate = $requests->month . '-' . $requests->year;

        /* Create a merchantAuthenticationType object with authentication details retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('app.transaction_name'));
        $merchantAuthentication->setTransactionKey(config('app.transaction_key'));

        // Retrieve an existing customer profile along with all the associated payment profiles and shipping addresses
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
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
            $request->setMerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscriptionId($subscriptionId);
            $request->setSubscription($subscription);

            $controller = new AnetController\ARBUpdateSubscriptionController($request);

            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {

                Subscription::where('user_id', $requests->user_id)->update([
                    'invoice_no' => "INVOICE_NO_" . rand(111111111, 999999999),
                    'transaction_detail' => 'Subscription Updated Successfully',
                    'expired_at' => Carbon::now()->addDays(30),
                    'is_active' => 1,
                ]);
                
                $user->expired_at = Carbon::now()->addDays(30);
                $user->save();
                return redirect()->route($user->type . '.billing.index')->with('success', 'User Subscription Updated Successfully');

            } else {
                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                return redirect()->back()->with('error',$errorMessages[0]->getText());
                // echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
            }

        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
            return redirect()->back()->with('error',$errorMessages[0]->getText());
        }
    }
    
    public function createSubscription($id)
    {
        return view('auth.create-user-subscription', get_defined_vars());
    }
    
    public function createUserSubscription(Request $requests)
    {
        $requests->validate([
            'card_number' => ['required', new CardNumber],
            'year' => ['required', new CardExpirationYear($requests->month)],
            'month' => ['required', new CardExpirationMonth($requests->year)]
        ]);
        $user = Auth::user();

        $profileIdRequested = $user->subscriptions[0]->customer_profile_id;
        $subscription = Subscription::where('user_id', $requests->user_id)->first();
        $subscriptionId = $subscription->subscription_id;
        $cardNumber = str_replace(' ', '', $requests->card_number);
        $expirationDate = $requests->month . '-' . $requests->year;

        /* Create a merchantAuthenticationType object with authentication details retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('app.transaction_name'));
        $merchantAuthentication->setTransactionKey(config('app.transaction_key'));

        // Retrieve an existing customer profile along with all the associated payment profiles and shipping addresses
        $request = new AnetAPI\GetCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setCustomerProfileId($profileIdRequested);
        $controller = new AnetController\GetCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $customerProfileId = $response->getProfile()->getCustomerProfileId();
            $customerPaymentProfileId = $response->getProfile()->getPaymentProfiles()[0]->getCustomerPaymentProfileId();
            
            // Set the transaction's refId
            $refId = 'ref' . time();
        
            // Subscription Type Info
            $subscription = new AnetAPI\ARBSubscriptionType();
            $subscription->setName("Sample Subscription");
        
            $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
            $interval->setLength(30);
            $interval->setUnit("days");
        
            $paymentSchedule = new AnetAPI\PaymentScheduleType();
            $paymentSchedule->setInterval($interval);
            $paymentSchedule->setStartDate(new DateTime('2035-08-30'));
            $paymentSchedule->setTotalOccurrences("12");
            $paymentSchedule->setTrialOccurrences("1");
        
            $subscription->setPaymentSchedule($paymentSchedule);
            $subscription->setAmount(rand(1,99999)/12.0*12);
            $subscription->setTrialAmount("0.00");
            
            $profile = new AnetAPI\CustomerProfileIdType();
            $profile->setCustomerProfileId($customerProfileId);
            $profile->setCustomerPaymentProfileId($customerPaymentProfileId);
        
            $subscription->setProfile($profile);
        
            $request = new AnetAPI\ARBCreateSubscriptionRequest();
            $request->setmerchantAuthentication($merchantAuthentication);
            $request->setRefId($refId);
            $request->setSubscription($subscription);
            $controller = new AnetController\ARBCreateSubscriptionController($request);
        
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {

                Subscription::where('user_id', $requests->user_id)->update([
                    'invoice_no' => "INVOICE_NO_" . rand(111111111, 999999999),
                    'transaction_detail' => 'Subscription Created Successfully',
                    'expired_at' => Carbon::now()->addDays(30),
                    'is_active' => 1,
                ]);
                $user->expired_at = Carbon::now()->addDays(30);
                $user->save();
                return redirect()->route($user->type . '.billing.index')->with('success', 'User Subscription Created Successfully');

            } else {
                echo "ERROR :  Invalid response\n";
                $errorMessages = $response->getMessages()->getMessage();
                return redirect()->back()->with('error',$errorMessages[0]->getText());
            }

        } else {
            echo "ERROR :  Invalid response\n";
            $errorMessages = $response->getMessages()->getMessage();
            return redirect()->back()->with('error',$errorMessages[0]->getText());
        }
    }
}
