@extends('layouts.app')
@section('content')
    @if(!auth()->check())
    <div class="col-md-1">
    </div>
    @endif
    <div class="col-md-10">
        <div class="mainBody">
            <div class="main-header globalcustom">
                <h2>Product & delivery Schedule</h2>
                @if(!auth()->check())
                    <a class="themeBtn" href="{{route('login')}}" title="">Back to Login</a>
                @endif
            </div>
            <div class="contBody helpcenterPg">
                <div class="row">
                    <div class="col-md-12">  
                        <div class="Content">
                            <h3>Products</h3>
                            <ol class="customcounters">
                            <li value="1">Freight Matching
                            <ol>
                            <li value="1.1">Subscription Level: Your subscription level, as indicated on your Order Form (ADD THE SUBSCRIPTION LEVELS OFFERED), unless you’re utilizing our free App.<br>
                            Regardless of your subscription level or use, these terms apply unless otherwise noted.</li>
                            <li value="1.2">Throughout your usage, you warrant and represent that you are a legitimate shipper, freight broker, 3PL, freight forwarder, intermodal company, rail company, or motor carrier (including dispatchers and drivers).</li>
                            <li value="1.3">Authority: You agree not to engage in any freight or commodity brokering or transportation transactions without the appropriate authority or sufficient insurance coverage or bond. You will not transport freight beyond the geographic limits of your authority or transport unauthorized commodities. You also agree not to represent yourself as operating under the authority of any third party without<br>
                            explicit permission.</li>
                            <li value="1.4">Disclaimer: Our platform serves as a meeting place for you and our other customers to exchange information, offer, sell, and buy services. We do not participate in the<br>
                            actual transactions between parties and do not guarantee the accuracy, reliability, or legality of any shared information. You are solely responsible for verifying the credentials of any party you do business with, including safety and authority<br>
                            records.</li>
                            <li value="1.5">Priority Booking (for brokers): Charges will only apply for booked loads. You must provide complete data sets without any missing fields in the format or template provided by us. Complete and accurate data must be supplied for every load<br>
                            selected for Priority Booking. Before sharing Priority Booking data with anyone other than the carrier involved in negotiation, we will aggregate and make commercially reasonable efforts to prevent it from being identifiable as originating<br>
                            from you.</li>
                            <li value="1.6">PTTR Tracking (for carriers): By accepting a tracking request, you expressly consent to and grant us the right to collect and disclose location information available<br>
                            through your mobile device, electronic logging device, or other authorized trackable technology for use in PTTR Tracking. This may include sharing location information with brokers or shippers who requested tracking during the approximate time the<br>
                            load is in transit. Aggregated and deidentified location information is considered Product Data.</li>
                            <li value="1.7">PTTR Tracking (for brokers): Due to coverage limitations, PTTR Tracking should not be relied upon for emergency location or safety purposes or in situations requiring<br>
                            guaranteed results.</li>
                            <li value="1.8">Credit Reporting: We republish business credit information sourced from third-party providers and are not responsible for its content or accuracy. Any questions or<br>
                            concerns about this credit information should be directed to the third-party providers.</li>
                            <li value="1.9">Peer Review: We offer peer reviews moderated for compliance with the Acceptable Use Policy. Accuracy or claims made in peer reviews are not verified or moderated by us.</li>
                            <li value="1.10">Search History (for carriers): You authorize us to sell your load board lane search history, equipment posting history, and Contact Data to our broker and shipper customers.</li>
                            </ol>
                            </li>
                            <li value="2">PTTR IQ
                            <ol>
                            <li value="2.1">Subscription Level: This section pertains to the following Products: (Name of products you think are mandatory to be here), all of which necessitate a subscription to (Service).<br>
                            Additionally, it applies to Market Conditions Index, PTTR LOADBOARD™ software, and other products or services.</li>
                            <li value="2.2">Contribution of Shared Data: You or, as applicable, your third-party transportation management software provider, must provide comprehensive rate data sets in the format<br>
                            specified in your Order Form. Data submissions should not include rates that, due to specialized or unique circumstances, do not reflect a competitive market rate. We will aggregate and take commercially reasonable efforts to anonymize such data, preventing it<br>
                            from being identifiable as originating from you</li>
                            <li value="2.3">Accuracy of Our Product Data: Our rate forecasts serve as directional indicators, not explicit guarantees of future rates. We do not assure future performance or accuracy of forwardlooking statements, as actual results may differ. Rate forecasts are provided as-is, and we<br>
                            disclaim all liability regarding their accuracy or completeness to the fullest extent permitted by law.</li>
                            <li value="2.4">Critical Mass: In the absence of adequate data for a particular Product, we reserve the right to temporarily suspend, without penalty, the provision of data related to that particular lane<br>
                            or dashboard until Critical Mass is restored.</li>
                            <li value="2.5">Exclusivity: Without our written consent, you may not contribute rate data to any other service that aggregates data for trucking lane rates and is reasonably considered a<br>
                            competitive service by us.</li>
                            <li value="2.6">PTTR Carrier Select: Matched carriers are selected based solely on basic transportation requirements such as geographical activity and equipment type. The matching results do not<br>
                            imply endorsement of these carriers by us. You are responsible for verifying the authority, reputation, business practices, and safety records of each carrier before engaging in<br>
                            transactions. We are not party to the transaction between you and any specific carrier.</li>
                            </ol>
                            </li>
                            <li value="3">Carrier Compliance
                            <ol>
                            <li value="3.1">PTTR Onboard (OR WHATEVER YOU LIKE TO KEEP THE NAME OF THE FORM): We do not guarantee that the OnBoard questionnaire covers all questions required by the<br>
                            customer, that completed Service/Forms will be properly or timely submitted, or that provided data is error-free or current.</li>
                            <li value="3.2">CarrierWatch: Your Order Form specifies the number of carriers you may monitor. We reserve the right to periodically audit your account. If an audit reveals more<br>
                            monitored carriers than indicated on your Order Form, we will add additional carriers to your next invoice in batches of 1,000, with charges per batch applicable for the remainder of the subscription period at our current market rate.</li>
                            </ol>
                            </li>
                            <li value="4">Betas and Trials
                            <ol>
                            <li value="4.1">Definitions: This section outlines the additional terms and conditions governing your access and usage of Betas or Trials.</li>
                            <li value="4.2">Compliance: You are required to adhere to the terms associated with any Beta as outlined on the Site or provided to you elsewhere. For Trials, except for payment<br>
                            obligations which are waived, you must comply with the Terms and Conditions and this Schedule. We reserve the right to add or modify terms, including adjusting usage limits, related to Beta access or Trials at any time.</li>
                            <li value="4.3">Suspension: We retain the right to suspend or terminate your access to any Beta or Trial upon notification of termination from our end. Your access to and use of each<br>
                            Beta will cease automatically upon the release of a publicly available version of the respective Beta. Following the suspension or termination of your access to any Beta or Trial for any reason, you will no longer be entitled to access or use the applicable<br>
                            Beta or Trial.</li>
                            <li value="4.4">Disclaimer: Betas may contain bugs, errors, defects, or potentially harmful components. Therefore, we provide Betas to you “as is,” without any warranty, express or implied. Subject to legal limitations, we disclaim all warranties, including<br>
                            but not limited to merchantability, satisfactory quality, fitness for a particular purpose, non-infringement, or quiet enjoyment, and any warranties arising from trade usage or course of dealing</li>
                            <li value="4.5">Limitation of Liability: Our total liability to you for any losses resulting from any Beta or Trial is capped at $100, notwithstanding any provisions in the Terms and<br>
                            Conditions.</li>
                            </ol>
                            </li>
                            </ol>
                            <h3>Delivery Methods</h3>
                            <ol class="customcounters">
                            <li value="5">API
                            <ol>
                            <li value="5.1">Accessibility. Certain Products and Product Data may be accessible through APIs. If APIs are provided and you utilize them, you are bound by these terms in addition to the other terms<br>
                            governing your Product usage outlined in this Schedule. To request API access, please contact (developer support email of PTTR)</li>
                            <li value="5.2">API License. We provide you with a limited, revocable, non-exclusive, non-transferable, and non-sublicensable license during the Term to (i) utilize the API solely for communicating and<br>
                            interoperating with a specific Product on non-PTTR platforms; and (ii) exhibit specific PTTR logos and trademarks in accordance with usage guidelines specified by us solely in connection with<br>
                            API and Product use, excluding any association with the advertising, promotion, distribution, or sale of other products or services.</li>
                            <li value="5.3">Certification. Your integration of the API must undergo certification by us at your expense before you integrate the API into an Interface Client, which may entail examining design<br>
                            documents, scrutinizing source code, ensuring proper use and placement of our trademarks, testing the Interface Client and your system against our test system, and assessing and<br>
                            monitoring the Interface Client’s impact on the test system.</li>
                            <li value="5.4">Subscription. To access the API, you must subscribe to the appropriate Product level. We retain the right, at our sole discretion, to approve or disallow any API usage.</li>
                            <li value="5.5">Security. You must employ all reasonable measures to maintain all Product Data in a secure environment at all times, adhering to the highest security standards. All API-driven data<br>
                            transfers must be encrypted with at least 128-bit SSL encryption, or for transmissions directed to us, must be as secure as the protocol accepted by the API servers.</li>
                            <li value="5.6">Monitoring. You acknowledge our right to monitor any API activity to ensure quality, enhance Products, and ensure compliance. You shall not impede such monitoring or obstruct any API<br>
                            activity in any manner. We reserve the right to utilize any reasonable technical means to counteract such interference.</li>
                            <li value="5.7">Current Version. You are required to adopt the latest version of the API within six (6) months of its release. Any older API versions must be updated and discontinued from use, distribution,<br>
                            support, or maintenance by you.</li>
                            <li value="5.8">Usage Restrictions. APIs are designated for per-user-based searching and posting exclusively, not for analytic data retrieval. Your access includes sixty (60) searches per user per hour, one<br>
                            thousand (1000) searches per user per month, and up to two hundred fifty (250) posts per user per month. The standard posting frequency is every two (2) hours, including load deletion and<br>
                            reposting.</li>
                            </ol>
                            </li>
                            <li value="6">Mobile Access
                            <ol>
                            <li value="6.1">App Availability. Certain Products may be accessible to you through mobile Apps. Notwithstanding Section 3.1 of the Terms and Conditions, some Apps may be provided to you free of charge or without<br>
                            an Order Form. However, our aggregate liability to you for any loss incurred due to such free Products shall not exceed $100, as stipulated in the Terms and Conditions.</li>
                            <li value="6.2">Message Charges. Your mobile carrier’s messaging, data, and other applicable rates and fees may be applicable to your use of the Apps. We disclaim any liability for the cost of such messages. You may<br>
                            receive recurring messages. For inquiries regarding your text plan or data plan, please contact your wireless provider.</li>
                            <li value="6.3">App Usage. The use of Apps, including location information, is contingent upon network capabilities, environmental factors such as structures, weather, geography, and other variables. Usage may be<br>
                            restricted to mobile devices within the United States. Additionally, certain Apps may be prohibited or limited by your mobile carrier, and compatibility may vary across carriers and devices. You are solely<br>
                            responsible for verifying with your mobile carrier the availability of Apps for your devices, any usage restrictions, and associated costs. Due to coverage limitations, location information or data received via<br>
                            Apps should not be relied upon for emergency or safety purposes.</li>
                            <li value="6.4">SMS Policy – Marketing Communications
                            <ol>
                            <li value="6.4.1">Purpose and Enrollment. Periodically, we send essential communications regarding your account, including Product tips, news, promotions, location-based alerts, and billing updates. You may enroll via<br>
                            an online form or by texting “Subscribe” to (subscription number)</li>
                            <li value="6.4.2">Opt-Out. You may opt out of the SMS Service at any time by texting “STOP” to (subscription number), after which you will receive a final SMS confirming your unsubscription. Following this, you will<br>
                            cease to receive SMS messages from us. If you wish to re-enroll, simply sign up as previously outlined.</li>
                            <li value="6.4.3">Assistance. Text “HELP” to (subscription number) if you require guidance on supported keywords. We will respond with instructions on using the SMS Service and how to unsubscribe.</li>
                            <li value="6.4.4">Carriers. We can deliver messages to a range of mobile carriers, including major carriers like AT&amp;T, Verizon Wireless, Sprint, and T-Mobile, among others. Minor carriers are also included. Your mobile<br>
                            carrier is not responsible for any delays or undelivered messages.</li>
                            <li value="6.4.5">Message Viewing. It’s important to note that anyone with access to your mobile device may view the messages you receive via the SMS Service, and we disclaim liability if this occurs.</li>
                            <li value="6.4.6">Consent. You acknowledge that consenting to the SMS Service is not a requirement to receive any products from us.</li>
                            <li value="6.4.7">Authorization. By opting into the SMS Service, you authorize us to contact you via text message at your mobile number using automated dialing systems or other applicable technology.</li>
                            <li value="6.4.8">Number Changes. If you change or deactivate your mobile number, you agree to promptly update your mobile Contact Data with us to ensure messages are directed to the intended recipient.</li>
                            <li value="6.4.9">Privacy. For privacy inquiries, please refer to the Privacy Policy.</li>
                            </ol>
                            </li>
                            <li value="6.5">SMS Policy – Product Communications
                            <ol>
                            <li value="6.5.1">Purpose and Enrollment. We offer essential communications (“PTTR Product Alerts”) sent to you via text message, including optional product messages, alerts, notifications, and location-based alerts.<br>
                            Message frequency may vary. You can enroll in these notifications through the Notification Settings in our PTTR One product at (your website link), where you can select your preferred notifications.</li>
                            <li value="6.5.2">Opt-Out. You can opt out of the SMS Service anytime by texting “STOP” to (subscription number). Upon receipt, we’ll send you a final SMS confirming your unsubscription. Following this, you won’t<br>
                            receive further SMS messages from us. To re-enroll, simply sign up as previously described.</li>
                            <li value="6.5.3">Assistance. Text “HELP” to (Number) if you forget supported keywords. We’ll respond with instructions on using the SMS Service and how to unsubscribe. Alternatively, you can reach out to us for<br>
                            assistance at (customer support email of PTTR)</li>
                            <li value="6.5.4">Carriers. We can deliver messages to various mobile carriers, including major carriers like AT&amp;T, Verizon Wireless, Sprint, and T-Mobile USA, as well as minor carriers such as Indigo Wireless, MetroPCS,<br>
                            and Bluegrass Cellular. Your mobile carrier is not responsible for any delays or undelivered messages.</li>
                            <li value="6.5.5">Message Viewing. Please note that anyone with access to your mobile phone may view the messages you receive via the SMS Service, and we disclaim liability for this.</li>
                            <li value="6.5.6">Consent. Your consent to the SMS Service is not required to receive products from us.</li>
                            <li value="6.5.7">Authorization. By opting into the SMS Service, you authorize us to contact you via text message at<br>
                            your mobile phone number using automated dialing systems or other applicable technology</li>
                            <li value="6.5.8">Privacy. For privacy concerns, please refer to the Privacy Policy.</li>
                            <li value="6.5.9">Message and Data Rates. Standard message and data rates may apply.</li>
                            <li value="6.6">Distracted Driving. Always drive vigilantly in accordance with road conditions and traffic laws. Using<br>
                            the App while driving is strictly prohibited. Only operate the App when your vehicle is stationary in a legally permitted location. Alternatively, a non-driving passenger may use the App, provided it doesn’t<br>
                            interfere with safe driving practices or distract the driver’s attention from the road.</li>
                            <li value="7">In the event that a truck experiences a breakdown or stops due to any issue while on the road, our application is equipped to offer assistance promptly. Our system will provide mechanics with access to a<br>
                            feature allowing them to locate nearby repair facilities efficiently. This service aims to minimize downtime and ensure swift resolution of mechanical issues encountered during transit. We prioritize<br>
                            the safety and efficiency of our drivers and vehicles, and this policy underscores our commitment to providing timely support in case of roadside emergencies.</li>
                            </ol>
                            </li>
                            </ol>
                            </li>
                            </ol>
                            <h3>Definations</h3>
                            <p>We and You hereby reference the Terms and Conditions and all definitions provided therein. All terms capitalized herein but not specifically defined shall carry the meanings ascribed to them in the Terms<br>
                            and Conditions.</p>
                            <p>The term “API” refers to application programming interface.</p>
                            <p>“Beta” denotes certain functionalities, technologies, and services offered to You by Us, which are not yet generally accessible. This includes, but is not limited to, any products, services, or features designated as<br>
                            “beta,” “preview,” “pre-release,” “early access,” “ea,” “early release,” or “experimental,” along with associated Product Data</p>
                            <p>“Critical Mass” signifies the threshold at which We merge Your Shared Data with a minimum of three (3) independent sources of Shared Data.</p>
                            <p>“Interface Client” encompasses any software capable of accessing or communicating with APIs.</p>
                            <p>“Location Information” pertains to the location and related details concerning a specific load, authorized by You for tracking purposes by Us on behalf of a shipper or broker.</p>
                            <p>“SMS Service” refers to vital communications dispatched by Us via SMS concerning Your account, encompassing Product tips, news, promotions, location-based alerts, and billing updates.</p>
                            <p>“Trials” denote complimentary trial periods offered for any Product.</p>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    @if(!auth()->check())
    <div class="col-md-1">
    </div>
    @endif
@endsection
