<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendUserInformation;
use App\Models\Company;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use App\Models\CustomerPaymentProfile;


class PaymentController extends Controller
{
    public function handlePaymentResponse(Request $request)
    {
        
        
        $request->validate([
            'card_number' => ['required', new CardNumber],
            'year' => ['required', new CardExpirationYear($request->month)],
            'month' => ['required', new CardExpirationMonth($request->year)],
             'cvv' => ['required', new CardCvc($request->card_number)],
        ]);
        
        
        
       
        
        $userData = session('userData');
        $seatsData = session('seatsData');

        $allRequest = [
            'promo_owner_amount' => $request->promo_owner_amount,
            'promo_user_amount' => $request->promo_user_amount,
            'regular_owner_amount' => $request->regular_owner_amount,
            'regular_user_amount' => $request->regular_user_amount];
        session()->put('allAmount', $allRequest);

        $cardNumber = str_replace(" ", "",$request->card_number);
        $expiration_month = $request->month;
        $expiration_year = $request->year;
        $cvv = $request->cvv;
        $expirationDate = $expiration_month . '-' . $expiration_year;


        $promoOwnerAmount = $request->promo_owner_amount;
        $regularOwnerAmount = $request->regular_owner_amount;
        
        if(!isset($seatsData['seat'])){
            $promoUserAmount = $request->promo_user_amount * count($seatsData);
            $regularUserAmount = $request->regular_user_amount * count($seatsData);
        }else{
             
            $regularUserAmount = 0;
            $promoUserAmount = 0;
        }
        $totalPromoAmount = $promoOwnerAmount + $promoUserAmount;
        $totalRegularAmount = $regularOwnerAmount + $regularUserAmount;
        
      
        
        

        // Email
        $email = $userData['email']; // Main Acoount Email

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('app.transaction_name'));
        $merchantAuthentication->setTransactionKey(config('app.transaction_key'));
        
        // $customerProfileId = '1090296774';
        // $customerPaymentProfileId = '1102136351';
        // $customerShippingAddressId = '1164137256';
        // $refId = 'ref_1164137256';
        // $subscriptionResponse = $this->createSubscription($merchantAuthentication, $customerProfileId, $customerPaymentProfileId, $customerShippingAddressId, $refId);
        //  dd($subscriptionResponse);
         
        // Create a credit card object
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expirationDate);
        $creditCard->setCardCode($cvv);

        // Create a payment object
        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        // Create a transaction request
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($totalPromoAmount);
        $transactionRequestType->setPayment($payment);

        // Create a create transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $refId = "ref" . time();
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        
         // Create customer profile
        $customerProfile = $this->createCustomerProfile($merchantAuthentication, $email, $creditCard);
        if ($customerProfile != null && $customerProfile->getMessages()->getResultCode() == "Ok") {

            // Extract customer profile ID and payment profile ID
            $customerProfileId = $customerProfile->getCustomerProfileId();
            $customerPaymentProfileId = $customerProfile->getCustomerPaymentProfileIdList()[0];
            $customerShippingAddressId = $customerProfile->getCustomerShippingAddressIdList()[0];


            // echo $customerProfileId;
            // echo "</br>";
            // echo $customerPaymentProfileId;
            // echo "</br>";
            // echo $customerShippingAddressId;


            // Create subscription
            sleep(3);
            $subscriptionResponse = $this->createSubscription($merchantAuthentication, $customerProfileId, $customerPaymentProfileId, $customerShippingAddressId, $refId);
            
            if ($subscriptionResponse != null) {
              
                // Execute the request
                $controller = new AnetController\CreateTransactionController($request);
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
                    $tresponse = $response->getTransactionResponse();
                    $transId = $tresponse->getTransId();
                    if($tresponse->getMessages() == null){
                        $cancel = $this->cancelSubscription($merchantAuthentication, $subscriptionResponse[0], $refId);
                        return redirect()->back()->with('error',$tresponse->getErrors()[0]->getErrorText()); 
                    }else{
                        $transDescription = $tresponse->getMessages()[0]->getDescription();
                    }
                } else {
                    $cancel = $this->cancelSubscription($merchantAuthentication, $subscriptionResponse[0], $refId);
                    return redirect()->back()->with('error',  $response->getMessages()->getMessage()[0]->getText());
                }
                
                $companyData = session('companyData');
                $ownerPackage = session('ownerPackage');
                $ownerAmount = Package::where('id', $ownerPackage['package_id'])->pluck('promo_owner_amount');
                $package = Package::find($ownerPackage['package_id']);
                if(!isset($seatsData['seat'])){
                $userSubscriptionAmount = ($totalPromoAmount - $ownerAmount[0]) / count($seatsData);
                }else{
                    $userSubscriptionAmount = $totalPromoAmount - $ownerAmount[0];
                }

                $owner = new User();
                $owner->name = $userData['first_name'] . ' ' . $userData['last_name'];
                $owner->email = $userData['email'];
                $owner->email_verified_at = Carbon::now();
                $owner->password = Hash::make($userData['password']);
                $owner->phone = $userData['phone'];
                if ($package->type == 1) {
                    $owner->type = 1;
                }elseif($package->type == 3){
                    $owner->type = 3;
                } else {
                    $owner->type = 4;
                }
                $owner->package_id = $ownerPackage['package_id'];
                $owner->expired_at = Carbon::now()->addMonth(1);
                $owner->status = 1;
                $owner->save();

                $city = $this->extractCityFromAddress($companyData['address']);
                $country = $this->extractCountryFromAddress($companyData['address']);
                $expiredAt = $expiration_year . '-' . $expiration_month;

                $customerPaymentProfile = new CustomerPaymentProfile();
                $customerPaymentProfile->first_name = $userData['first_name'];
                $customerPaymentProfile->last_name = $userData['last_name'];
                $customerPaymentProfile->address = $companyData['address'];
                $customerPaymentProfile->city = $city;
                $customerPaymentProfile->state = $companyData['state'];
                $customerPaymentProfile->zip = $companyData['zip_code'];
                $customerPaymentProfile->country = $country;
                $customerPaymentProfile->customer_profile_id = $customerProfileId;
                $customerPaymentProfile->customer_payment_profile_id = $customerPaymentProfileId;
                $customerPaymentProfile->live_mode = 1;
                $customerPaymentProfile->card_no = encrypt($cardNumber);
                $customerPaymentProfile->expired_at = $expiredAt;
                $customerPaymentProfile->save();



                $ownerId = $owner->id;
                
                $company = new Company();
                $company->name = $companyData['company_name'];
                $company->email = $companyData['company_email'];
                $company->mc = isset($companyData['mc']) ? $companyData['mc'] : null;
                $company->dot = isset($companyData['dot']) ? $companyData['dot'] : null;
                $company->zip_code = isset($companyData['zip_code']) ? $companyData['zip_code'] : null;
                $company->address = isset($companyData['address']) ? $companyData['address'] : null;
                $company->phone = isset($companyData['company_phone']) ? $companyData['company_phone'] : null;
                $company->user_id = $ownerId;
                $company->save();
                
                

                $ownerSubscription = new Subscription();
                $ownerSubscription->user_id = $ownerId;
                $ownerSubscription->package_id = $ownerPackage['package_id'];
                $ownerSubscription->invoice_no = 'INVOICE_NO_' . rand(100000000, 999999999);
                $ownerSubscription->transaction_id = $transId;
                $ownerSubscription->customer_profile_id = $customerProfileId;
                $ownerSubscription->customer_payment_profile_id = $customerPaymentProfileId;
                $ownerSubscription->subscription_id = $subscriptionResponse[0];
                $ownerSubscription->subscription_detail = 'subscription created successfully';
                $ownerSubscription->transaction_detail = $transDescription;
                $ownerSubscription->expired_at = Carbon::now()->addMonth(1);
                $ownerSubscription->amount = $ownerAmount[0];
                $ownerSubscription->is_active = 1;
                $ownerSubscription->save();

                

                $count = 1;
                
                if(!isset($seatsData['seat'])){
                    foreach ($seatsData as $key => $seat) {
                        $seats = [
                            'name' => $seat['name'],
                            'email' => $seat['email'],
                            'email_verified_at' => Carbon::now(),
                            'password' => Hash::make($seat['password']),
                            'phone' => $seat['phone'],
                            'type' => null,
                            'package_id' => $ownerPackage['package_id'],
                            'parent_id' => $ownerId,
                            'expired_at' => Carbon::now()->addMonth(1),
                        ];

                        if ($package->type == 1) {
                            $seats['type'] = 1;
                        }elseif($package->type == 3){
                            $seats['type'] = 3;
                        } else {
                            $seats['type'] = 4;
                        }

                        $seatUser = User::create($seats);

                        Mail::to($seat['email'])->send(new SendUserInformation($seat, $userData));

                        Subscription::create([
                            'user_id' => $seatUser->id,
                            'package_id' => $ownerPackage['package_id'],
                            'invoice_no' => 'INVOICE_NO_' . rand(100000000, 999999999),
                            'transaction_id' => $transId,
                            'customer_profile_id' => $customerProfileId,
                            'customer_payment_profile_id'=> $customerPaymentProfileId,
                            'subscription_id' => $subscriptionResponse[$count++],
                            'subscription_detail','subscription created successfully',
                            'transaction_detail' => $transDescription,
                            'expired_at' => Carbon::now()->addMonth(1),
                            'amount' => $userSubscriptionAmount,
                            'is_active' => 1,
                        ]);
                    }
                }
                session()->forget(['seatsData', 'companyData', 'ownerPackage', 'userData', 'allAmount']);
                session()->flush();

                return redirect()->route('login')->with('success', 'Payment successful!');
            } else {
                return redirect()->back()->with('error',"Error creating subscription.");
            }
        } else {
            return redirect()->back()->with('error',"Error creating customer profile.");
        }

        
    }

    // Helper method to create a customer profile
    public function createCustomerProfile($merchantAuthentication, $email, $creditCard)
    {
        $userData = session('userData');
        $userFirstName = $userData['first_name'];
        $userLastName = $userData['last_name'];

        //company session
        $companyData = session('companyData');
        $companyName = $companyData['company_name'];
        $companyAddress = $companyData['address'];
        $companyCity = $companyData['city'];
        $companyState = $companyData['state'];
        $companyZip = $companyData['zip_code'];
        $companyCountry = $companyData['country'];
        $companyPhone = formatPhoneNumber($companyData['company_phone']);

        // Create a customer address
        $billTo = new AnetAPI\CustomerAddressType();
        $billTo->setFirstName($userFirstName);
        $billTo->setLastName($userLastName);
        $billTo->setCompany($companyName);
        $billTo->setAddress($companyAddress);
        $billTo->setCity($companyCity);
        $billTo->setState($companyState);
        $billTo->setZip($companyZip);
        $billTo->setCountry($companyCountry);
        $billTo->setPhoneNumber($companyPhone);

        // Create a customer shipping address
        $customerShippingAddress = new AnetAPI\CustomerAddressType();
        $customerShippingAddress->setFirstName($userFirstName);
        $customerShippingAddress->setLastName($userLastName);
        $customerShippingAddress->setCompany($companyName);
        $customerShippingAddress->setAddress($companyAddress);
        $customerShippingAddress->setCity($companyCity);
        $customerShippingAddress->setState($companyState);
        $customerShippingAddress->setZip($companyZip);
        $customerShippingAddress->setCountry($companyCountry);
        $customerShippingAddress->setPhoneNumber($companyPhone);

        // Create an array of any shipping addresses
        $shippingProfiles[] = $customerShippingAddress;

        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        // Create a customer payment profile
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setPayment($paymentCreditCard);
        $paymentProfile->setBillTo($billTo);

        // Create a customer profile
        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("Customer Profile created successfully");
        $customerProfile->setMerchantCustomerId("M_" . time());
        $customerProfile->setEmail($email);
        $customerProfile->setpaymentProfiles([$paymentProfile]);
        $customerProfile->setShipToList($shippingProfiles);

        // Create create customer profile request
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId("ref" . time());
        $request->setProfile($customerProfile);
        // Execute the request
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            return $response;
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            return redirect()->back()->with('error', $errorMessages[0]->getText());
        }
        // return $response;
    }

    // Helper method to create a subscription
    public function createSubscription($merchantAuthentication, $customerProfileId, $customerPaymentProfileId, $customerShippingAddressId, $refId)
    {
        $subscriptionIds = [];
        $seatsData = session('seatsData');
        $allAmount = session('allAmount');
        $promo_owner_amount = $allAmount['promo_owner_amount'];
        $promo_user_amount = $allAmount['promo_user_amount'];
        $regular_owner_amount = $allAmount['regular_owner_amount'];
        $regular_user_amount = $allAmount['regular_user_amount'];


        $userData = session('userData');
        $id = strlen($userData['first_name'] . $userData['last_name']);
        $End = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        // $ref_id_owner = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

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
        $subscription->setAmount($regular_owner_amount);
        $subscription->setTrialAmount($promo_owner_amount);

        // Set customer profile
        $profile = new AnetAPI\CustomerProfileIdType();
        $profile->setCustomerProfileId($customerProfileId);
        $profile->setCustomerPaymentProfileId($customerPaymentProfileId);
        $profile->setCustomerAddressId($customerShippingAddressId);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($End);
        $order->setDescription("Description of the subscription" . $End);
        $subscription->setOrder($order);
        $subscription->setProfile($profile);

        // Create a new subscription request for each user
        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        // $refId = "ref" . $ref_id_owner;
        $request->setRefId($refId);
        $request->setSubscription($subscription);

        // Execute the request
        $controller = new AnetController\ARBCreateSubscriptionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            // Handle error
            $SubscriptionIdX = $response->getSubscriptionId();
            array_push($subscriptionIds, $SubscriptionIdX);
        } else {
            // Handle error
            $errorMessages = $response->getMessages();
            return redirect()->back()->with('error', $errorMessages[0]->getText());
        }

        $Ends = str_pad(rand(0000, 9999), 3, '0', STR_PAD_LEFT);
        // $ref_id_user = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        if(!isset($seatsData['seat'])){
            foreach ($seatsData as $user) {
                $id = strlen($user['name']);
    
                // Create a subscription for the user
                $subscription = new AnetAPI\ARBSubscriptionType();
                $subscription->setName("Sample Subscription for User " . $id);
    
                // Set payment schedule
                $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
                $interval->setLength(1);
                $interval->setUnit("months");
    
                $paymentSchedule = new AnetAPI\PaymentScheduleType();
                $paymentSchedule->setInterval($interval);
                $paymentSchedule->setStartDate(Carbon::now());
                $paymentSchedule->setTotalOccurrences($Ends);
                $paymentSchedule->setTrialOccurrences(6);
    
                $subscription->setPaymentSchedule($paymentSchedule);
                $subscription->setAmount($regular_user_amount);
                $subscription->setTrialAmount($promo_user_amount);
    
                // Set customer profile
                $profile = new AnetAPI\CustomerProfileIdType();
                $profile->setCustomerProfileId($customerProfileId);
                $profile->setCustomerPaymentProfileId($customerPaymentProfileId);
                $profile->setCustomerAddressId($customerShippingAddressId);
    
                $order = new AnetAPI\OrderType();
                $order->setInvoiceNumber($Ends);
                $order->setDescription("Description of the subscription" . $Ends);
                $subscription->setOrder($order);
                $subscription->setProfile($profile);
    
                // Create a new subscription request for each user
                $request = new AnetAPI\ARBCreateSubscriptionRequest();
                $request->setMerchantAuthentication($merchantAuthentication);
                // $refId = "ref" . $ref_id_user;
                $request->setRefId($refId);
                $request->setSubscription($subscription);
    
                // Execute the request
                $controller = new AnetController\ARBCreateSubscriptionController($request);
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                
                // Handle response
                if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                    // Extract subscription ID and add it to the array
                    $SubscriptionIdX = $response->getSubscriptionId();
                    array_push($subscriptionIds, $SubscriptionIdX);
                } else {
                    // Handle error
                    $errorMessages = $response->getMessages();
                    return redirect()->back()->with('error', $errorMessages[0]->getText());
                }
                $Ends = $Ends - 1;
            }
        }
        
        return $subscriptionIds;
    }

   public function cancelSubscription($merchantAuthentication, $subscriptionId, $refId)
    {
        /* Create a merchantAuthenticationType object with authentication details
           retrieved from the constants file */
    
        
        // Set the transaction's refId
        $refId = 'ref' . time();
    
        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);
    
        $controller = new AnetController\ARBCancelSubscriptionController($request);
    
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
        {
            // $successMessages = $response->getMessages()->getMessage();
            // echo "SUCCESS : " . $successMessages[0]->getCode() . "  " .$successMessages[0]->getText() . "\n";
            return true;
            
         }
        else
        {
            
            return false;
            // echo "ERROR :  Invalid response\n";
            // $errorMessages = $response->getMessages()->getMessage();
            // echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
            
        }
    
        return $response;
    
      }

    public function extractCountryFromAddress($address)
    {
        // Split the address by commas
        $addressParts = explode(',', $address);

        // Check if the address contains at least 3 parts (Street, City, State, Country)
        if (count($addressParts) >= 3) {
            // Trim whitespace and get the country name (last part)
            $country = trim(end($addressParts));

            return $country;
        }

        return 'Country not found';
    }

    public function extractCityFromAddress($address)
    {
        // Split the address by commas
        $addressParts = explode(',', $address);

        // Check if the address contains at least 3 parts (Street, City, State/ZIP)
        if (count($addressParts) >= 3) {
            // Trim whitespace and get the city name (second last part)
            $city = trim($addressParts[count($addressParts) - 2]);

            return $city;
        }

        return 'City not found';
    }

}
