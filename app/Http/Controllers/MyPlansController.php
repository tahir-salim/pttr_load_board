<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerPaymentProfile;
use App\Models\State;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class MyPlansController extends Controller
{

    public function addCard()
    {
        $cardDetails = [];
        if (Auth::user()->subscriptions[0] != null) {
            $paymentProfiles = CustomerPaymentProfile::where('customer_profile_id', Auth::user()->subscriptions[0]->customer_profile_id)->get();
            $refId = 'ref' . time();

            foreach ($paymentProfiles as $paymentProfile) {

                $request = new AnetAPI\GetCustomerPaymentProfileRequest();
                $request->setMerchantAuthentication(getMerchantAuthentication());
                $request->setRefId($refId);
                $request->setCustomerProfileId($paymentProfile->customer_profile_id);
                $request->setCustomerPaymentProfileId($paymentProfile->customer_payment_profile_id);

                $controller = new AnetController\GetCustomerPaymentProfileController($request);
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                if (($response != null)) {
                    if ($response->getMessages()->getResultCode() == "Ok") {
                        $card = [
                            'payment_profile' => $paymentProfile->customer_payment_profile_id,
                            'card_number' => $response->getPaymentProfile()->getPayment()->getCreditCard()->getCardNumber(),
                            'expiry_date' => $paymentProfile->expired_at,
                            'type' => $response->getPaymentProfile()->getPayment()->getCreditCard()->getCardType(),
                            'is_active' => $paymentProfile->live_mode,
                        ];

                        array_push($cardDetails, $card);
                    }
                }
            }
        }
        $activeCard = collect($cardDetails)->firstWhere('is_active', 1);
        // dd($cardDetails);
        return view('Global.my-plans', get_defined_vars());
    }
    public function myPlans(Request $requests)
    {
        try {
            $requests->validate([
                'card_number' => ['required', new CardNumber],
                'year' => ['required', new CardExpirationYear($requests->month)],
                'month' => ['required', new CardExpirationMonth($requests->year)],
            ]);

            $state = State::find($requests->state);
            $customerProfileId = Auth::user()->subscriptions[0]->customer_profile_id;
            $cardNumber = str_replace(' ', '', $requests->card_number);
            $expirationDate = $requests->year . '-' . $requests->month;

            $refId = 'ref' . time();

            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($cardNumber);
            $creditCard->setExpirationDate($expirationDate);
            $creditCard->setCardCode($requests->cvv);
            $paymentCreditCard = new AnetAPI\PaymentType();
            $paymentCreditCard->setCreditCard($creditCard);

            $billto = new AnetAPI\CustomerAddressType();
            $billto->setFirstName($requests->first_name);
            $billto->setLastName($requests->last_name);
            $billto->setAddress($requests->address);
            $billto->setCity($requests->city);
            $billto->setState($state->name);
            $billto->setZip($requests->zip);
            $billto->setCountry($state->country_name);

            $paymentprofile = new AnetAPI\CustomerPaymentProfileType();
            $paymentprofile->setCustomerType('individual');
            $paymentprofile->setBillTo($billto);
            $paymentprofile->setPayment($paymentCreditCard);
            if ($requests->has('is_allow_autopayment')) {
                $paymentprofile->setDefaultPaymentProfile(true);
            } else {
                $paymentprofile->setDefaultPaymentProfile(false);
            }

            $paymentprofiles[] = $paymentprofile;

            // Assemble the complete transaction request
            $paymentprofilerequest = new AnetAPI\CreateCustomerPaymentProfileRequest();
            $paymentprofilerequest->setMerchantAuthentication(getMerchantAuthentication());

            // Add an existing profile id to the request
            $paymentprofilerequest->setCustomerProfileId($customerProfileId);
            $paymentprofilerequest->setPaymentProfile($paymentprofile);
            $paymentprofilerequest->setValidationMode("testMode");

            // Create the controller and get the response
            $controller = new AnetController\CreateCustomerPaymentProfileController($paymentprofilerequest);
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            // dd($response);
            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                $customerPaymentProfileId = $response->getCustomerPaymentProfileId();

                $customerPaymentProfile = new CustomerPaymentProfile();
                $customerPaymentProfile->customer_profile_id = $customerProfileId;
                $customerPaymentProfile->customer_payment_profile_id = $customerPaymentProfileId;
                if ($requests->has('is_allow_autopayment')) {

                    $customerPaymentProfile->first_name = $requests->first_name;
                    $customerPaymentProfile->last_name = $requests->last_name;
                    $customerPaymentProfile->address = $requests->address;
                    $customerPaymentProfile->city = $requests->city;
                    $customerPaymentProfile->state = $state->name;
                    $customerPaymentProfile->zip = $requests->zip;
                    $customerPaymentProfile->country = $state->country_name;
                    $customerPaymentProfile->live_mode = 1;
                    $customerPaymentProfile->card_no = encrypt($cardNumber);
                    $customerPaymentProfile->expired_at = $expirationDate;
                    $customerPaymentProfile->save();

                    $subscriptions = Subscription::where('customer_profile_id', $customerProfileId);

                    foreach ($subscriptions->get() as $key => $item) {
                        $refId = 'ref' . time();

                        $subscription = new AnetAPI\ARBSubscriptionType();

                        $creditCard = new AnetAPI\CreditCardType();
                        $creditCard->setCardNumber($cardNumber);
                        $creditCard->setExpirationDate($expirationDate);

                        $payment = new AnetAPI\PaymentType();
                        $payment->setCreditCard($creditCard);

                        //set profile information
                        $profile = new AnetAPI\CustomerProfileIdType();
                        $profile->setCustomerProfileId($item->customer_profile_id);
                        $profile->setCustomerPaymentProfileId($item->customer_payment_profile_id);

                        $subscription->setPayment($payment);

                        $request = new AnetAPI\ARBUpdateSubscriptionRequest();
                        $request->setMerchantAuthentication(getMerchantAuthentication());
                        $request->setRefId($refId);
                        $request->setSubscriptionId($item->subscription_id);
                        $request->setSubscription($subscription);

                        $controller = new AnetController\ARBUpdateSubscriptionController($request);

                        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                        // dd($response);

                        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                            Subscription::where('customer_profile_id', $customerProfileId)->update(['customer_payment_profile_id' => $customerPaymentProfileId]);
                            CustomerPaymentProfile::where('customer_profile_id', $customerProfileId)->whereNot('customer_payment_profile_id', $customerPaymentProfileId)
                                ->where('live_mode', 1)->update(['live_mode' => 0]);

                        } else {
                            $errorMessages = $response->getMessages();
                            return redirect()->back()->with('error', $errorMessages[0]->getText());
                        }
                    }

                } else {
                    $customerPaymentProfile->first_name = $requests->first_name;
                    $customerPaymentProfile->last_name = $requests->last_name;
                    $customerPaymentProfile->address = $requests->address;
                    $customerPaymentProfile->city = $requests->city;
                    $customerPaymentProfile->state = $state->name;
                    $customerPaymentProfile->zip = $requests->zip;
                    $customerPaymentProfile->country = $state->country_name;
                    $customerPaymentProfile->live_mode = 0;
                    $customerPaymentProfile->card_no = encrypt($cardNumber);
                    $customerPaymentProfile->expired_at = $expirationDate;
                    $customerPaymentProfile->save();
                }

                return redirect()->back()->with('success', 'Card Added Successfully');
            } else {
                $errorMessages = $response->getMessages();
                return redirect()->back()->with('error', $errorMessages[0]->getText());

            }
            return $response;

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteCustomerPaymentProfile($customerPaymentProfileId)
    {
        $paymentProfile = CustomerPaymentProfile::where('customer_payment_profile_id', $customerPaymentProfileId)->first();

        $refId = 'ref' . time();

        $request = new AnetAPI\DeleteCustomerPaymentProfileRequest();
        $request->setMerchantAuthentication(getMerchantAuthentication());
        $request->setCustomerProfileId($paymentProfile->customer_profile_id);
        $request->setCustomerPaymentProfileId($paymentProfile->customer_payment_profile_id);

        $controller = new AnetController\DeleteCustomerPaymentProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            CustomerPaymentProfile::where('customer_payment_profile_id', $customerPaymentProfileId)->delete();
            return redirect()->back()->with('success', 'Card Removed Successfully');
        } else {
            $errorMessages = $response->getMessages();
            return redirect()->back()->with('error', $errorMessages[0]->getText());
        }
        return $response;
    }

    public function autoCustomerPaymentProfile($customerPaymentProfileId)
    {
        $customerProfileId = Auth::user()->subscriptions[0]->customer_profile_id;
        $customerPaymentProfile = CustomerPaymentProfile::where('customer_payment_profile_id', $customerPaymentProfileId)->first();

        $refId = 'ref' . time();

        $request = new AnetAPI\GetCustomerPaymentProfileRequest();
        $request->setMerchantAuthentication(getMerchantAuthentication());
        $request->setRefId($refId);
        $request->setCustomerProfileId($customerProfileId);
        $request->setCustomerPaymentProfileId($customerPaymentProfileId);

        $controller = new AnetController\GetCustomerPaymentProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            $billto = new AnetAPI\CustomerAddressType();
            $billto = $response->getPaymentProfile()->getbillTo();

            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber(decrypt($customerPaymentProfile->card_no));
            $creditCard->setExpirationDate($customerPaymentProfile->expired_at);

            $paymentCreditCard = new AnetAPI\PaymentType();
            $paymentCreditCard->setCreditCard($creditCard);
            $paymentprofile = new AnetAPI\CustomerPaymentProfileExType();
            $paymentprofile->setBillTo($billto);
            $paymentprofile->setCustomerPaymentProfileId($customerPaymentProfileId);
            $paymentprofile->setPayment($paymentCreditCard);

            // Submit a UpdatePaymentProfileRequest
            $request = new AnetAPI\UpdateCustomerPaymentProfileRequest();
            $request->setMerchantAuthentication(getMerchantAuthentication());
            $request->setCustomerProfileId($customerProfileId);
            $request->setPaymentProfile($paymentprofile);

            $controller = new AnetController\UpdateCustomerPaymentProfileController($request);
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                $subscriptions = Subscription::where('customer_profile_id', $customerProfileId);
                // dd($subscriptions->get());
                foreach ($subscriptions->get() as $key => $item) {
                    $refId = 'ref' . time();

                    $subscription = new AnetAPI\ARBSubscriptionType();

                    $creditCard = new AnetAPI\CreditCardType();
                    $creditCard->setCardNumber(decrypt($customerPaymentProfile->card_no));
                    $creditCard->setExpirationDate($customerPaymentProfile->expired_at);

                    $payment = new AnetAPI\PaymentType();
                    $payment->setCreditCard($creditCard);

                    //set profile information
                    $profile = new AnetAPI\CustomerProfileIdType();
                    $profile->setCustomerProfileId($item->customer_profile_id);
                    $profile->setCustomerPaymentProfileId($item->customer_payment_profile_id);

                    $subscription->setPayment($payment);

                    $request = new AnetAPI\ARBUpdateSubscriptionRequest();
                    $request->setMerchantAuthentication(getMerchantAuthentication());
                    $request->setRefId($refId);
                    $request->setSubscriptionId($item->subscription_id);
                    $request->setSubscription($subscription);

                    $controller = new AnetController\ARBUpdateSubscriptionController($request);

                    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

                    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                        $customerPaymentProfile->update(['live_mode' => 1]);
                        CustomerPaymentProfile::where('customer_profile_id', $customerProfileId)->whereNot('customer_payment_profile_id', $customerPaymentProfileId)->where('live_mode', 1)->update(['live_mode' => 0]);
                        $subscriptions->update(['customer_payment_profile_id' => $customerPaymentProfileId]);
                    } else {
                        $errorMessages = $response->getMessages();
                        return redirect()->back()->with('error', $errorMessages[0]->getText());
                    }
                }
                return redirect()->back()->with('success', 'Card Updated Successfully');
            } else if ($response != null) {
                $errorMessages = $response->getMessages();
                return redirect()->back()->with('error', $errorMessages[0]->getText());
            }

            return $response;
        } else {
            return redirect()->back()->with('error', $response->getMessages()[0]->getText());
        }

        return $response;

    }
}
