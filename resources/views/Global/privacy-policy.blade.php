@extends('layouts.app')
@section('content')
    @if(!auth()->check())
    <div class="col-md-1">
    </div>
    @endif
    <div class="col-md-10">
        <div class="mainBody">
            @if(auth()->check())
                @include('layouts.notifications')
            @endif
            <div class="main-header globalcustom">
                <h2>Privacy Policy</h2>
                @if(!auth()->check())
                    <a class="themeBtn" href="{{route('login')}}" title="">Back to Login</a>
                @endif
            </div>
            <div class="contBody helpcenterPg">
                <div class="row">
                    <div class="col-md-12">  
                        <div class="Content">
                            <!--<p>For Californian residents seeking detailed insights into their privacy rights, kindly click here.</p>-->
                            <!--<p>We prioritize your privacy. Take a thorough look at this Privacy Notice to understand how we gather, utilize, share, and handle information pertaining to individuals -->
                            <!--    (referred to as “Personal Data”), along with insights into your rights and options concerning your Personal Data.</p>-->
                            <!--<p>In this Privacy Notice, PTTR serves as the controller of your Personal Data, as detailed herein, unless specified otherwise. It covers the gathering and handling of Personal -->
                            <!--    Data by us across various interactions: visiting our branded websites linked to this Privacy Notice, utilizing our online products and services where we operate as the -->
                            <!--    controller of your Personal Data, engaging with our branded social media platforms, visiting our facilities, communicating with us (including via emails, phone calls and texts), -->
                            <!--    or participating in our events, webinars, trade shows, or contests.</p>-->
                            <!--<p>This Privacy Notice doesn’t extend to instances where we process Personal Data on behalf of our customers in a processor or service provider capacity. This occurs, for example, -->
                            <!--    when we enable customers to create their own websites/applications for offering their products and services, sending electronic communications to others, or using, collecting, -->
                            <!--    sharing, or handling Personal Data via our online products and services. Our customers’ privacy policies may diverge from ours, and we don’t assume responsibility for those -->
                            <!--    practices. For insights into the privacy practices of customers utilizing our products and services as controllers, please reach out to them directly.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    1.	Personal Data Collection: We gather Personal Data from you in three distinct ways: Information Provided by You: Directly supplied information, encompassing personal -->
                            <!--    identifiers, professional details, financial data, commercial interactions, visual content, or online activities shared with us via this website or other channels, is -->
                            <!--    collected and recorded. Automatically Collected Information: We automatically amass and store data concerning your website and service usage, including text message -->
                            <!--    exchanges within these services. This is facilitated through cookie technology and similar online identifiers, tracking your IP address, web browser, location, or activities -->
                            <!--    on this site. Other Collected Information: We may amalgamate data from external sources with the Personal Data we receive from you. These external sources may include -->
                            <!--    third-party entities or publicly accessible databases, offering insights into your employment, educational background, commercial engagements, and online activities. -->
                            <!--    Certain product or service offerings necessitate the collection and processing of Personal Data (refer to Section 2 below). Personal Data excludes information rendered -->
                            <!--    anonymous or aggregated to prevent identification. If you furnish us or our service providers with Personal Data concerning other individuals, you attest to having the -->
                            <!--    authority to do so and securing any requisite consent for utilizing this information in accordance with this Privacy Notice. If you suspect improper provision of your -->
                            <!--    Personal Data or wish to exercise your rights regarding it, please refer to the Contact Us section (Section 14) below.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    2.	Personal Data Processing and Utilization: We engage in the processing of your Personal Data for the following purposes. Where mandated by law, we seek your consent for -->
                            <!--    using and processing your Personal Data. Otherwise, we rely on other legitimate legal bases (including, but not confined to, (a) contractual performance or (b) legitimate -->
                            <!--    interest) to gather and process your Personal Data. Service Provision and Website Accessibility: Personal Data processing ensures compliance with applicable contracts, terms -->
                            <!--    of use, or service agreements, gauging demand, and enhancing our offerings. In the absence of a contract, processing furthers our legitimate interest in refining and -->
                            <!--    operating our websites and services. Website and Service Security: Personal Data is processed to safeguard and monitor our website and services, encompassing data -->
                            <!--    aggregation, account verification, anomaly investigation, and policy enforcement, essential to upholding a secure environment and protecting our and others’ rights. -->
                            <!--    User Account Administration: For users who register an account with us, Personal Data processing manages user accounts, fulfilling obligations under relevant contracts or -->
                            <!--    service terms. Response to Contact Requests: Personal Data processing enables responses to electronic or telephonic inquiries, either to honor contractual obligations or -->
                            <!--    based on legitimate interest in addressing queries and fostering communication. Communications may be recorded and processed for training, quality assurance, and -->
                            <!--    administrative purposes, with prior consent or provision for objections to recorded calls, if legally required. Payment Management: Financial information and other Personal -->
                            <!--    Data may be processed for verification and collection purposes, essential for contractual fulfillment.<br>-->
                            <!--    Visitor Tracking: For facility visitors, Personal Data processing may occur for security, health, or safety reasons, including any necessary non-disclosure agreements (NDAs), -->
                            <!--    serving our legitimate interest in safeguarding premises and confidential information from unauthorized access. Marketing and Advertising: Personal Data processing facilitates -->
                            <!--    targeted advertising, market research, and tailored content delivery based on Personal Data, serving our legitimate interest in promoting our websites, services, or products. -->
                            <!--    Consent will be sought where legally mandated before engaging in marketing or advertising activities. Compliance with Legal and Safety Obligations: Personal Data processing -->
                            <!--    occurs in conjunction with public and governmental authorities, legal rights protection, auditing, and abuse prevention concerning our services and products.         -->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    3.	Safeguarding Personal Data: We employ commercially reasonable measures to safeguard the Personal Data in our possession against loss, misuse, unauthorized access, -->
                            <!--    disclosure, alteration, or destruction. While adhering to generally accepted standards for data protection, it’s important to note that no storage or transmission method is -->
                            <!--    entirely immune to risks. Consequently, Personal Data transmitted to or from the website or via email may not be completely secure. We urge you to explore more secure methods -->
                            <!--    for sharing sensitive information when necessary. Responsibility lies with you to safeguard passwords, ID numbers, or any special access features used on this site, ensuring -->
                            <!--    you log out of accessed accounts after sessions.         -->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    4.	Your Rights as an Individual: Depending on applicable local data protection laws, you may possess certain rights concerning your Personal Data. These rights may -->
                            <!--    encompass: Requesting and receiving copies of the Personal Data we hold; Seeking additional information about our Personal Data processing practices; Rectifying inaccurate -->
                            <!--    or incomplete Personal Data, considering our usage thereof; Requesting the deletion of your Personal Data; Limiting or objecting to our Personal Data processing activities. -->
                            <!--    In cases where Personal Data processing involves direct marketing (either by us or third parties), you may not need to provide specific reasons for such objections; -->
                            <!--    Requesting the transfer of your Personal Data to another controller (i.e., data portability), where feasible; Restricting certain disclosures of your Personal Data to -->
                            <!--    third parties; Avoiding decisions solely based on automated processing, including profiling, that have legal effects; Withdrawing consent to the processing of your Personal -->
                            <!--    Data (where processing relies on consent and not another lawful basis). We are committed to non-discrimination against you, as prohibited by applicable law, for exercising -->
                            <!--    these rights. You can exercise these rights, where applicable, by contacting us via email info@pttrloadboard.com, or by calling +1 (888) 706-7013. We pledge to respond to -->
                            <!--    any such requests within 30 days of receipt.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    5.	Retention of Personal Data: Personal Data will be retained for the duration necessary to fulfill our legitimate business needs or the purposes for which it was collected, -->
                            <!--    or as required by law.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    6.	Data Transfers Beyond EU/EEA: Data submitted on our website is transferred to a server in the U.S. and stored there. Your data may be utilized and disclosed by the -->
                            <!--    Company, its divisions, holding companies, subsidiaries, affiliates, or other entities outside the European Union (EU) and the European Economic Area (EEA), including in -->
                            <!--    the U.S. Please be aware that countries beyond your own may apply differing data protection standards than those you are accustomed to in your home country.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    7.	Sharing Personal Data with Third Parties: We refrain from selling your Personal Data to unrelated companies for their independent use. However, we may share your -->
                            <!--    Personal Information with the following categories of recipients:-->
                            <!--    <ul>-->
                            <!--        <li>PTTR divisions, holding companies, subsidiaries, and affiliates.</li>-->
                            <!--        <li>Third-party service providers or other entities that assist us in providing our products and services, as well as supporting our relationship with you -->
                            <!--        (such as shipping or direct mailing organizations). These service providers have access to personal information necessary for their functions but are restricted from -->
                            <!--        using it for other purposes. Moreover, they are obligated to process personal information in accordance with this Privacy Notice and applicable data protection laws.</li>-->
                            <!--        <li>Law enforcement, government agencies, or other regulators to comply with legal requirements, enforce our agreements, and safeguard the rights, property, or safety -->
                            <!--            of PTTR, our users, or third parties.</li>-->
                            <!--        <li>Transactional parties involved in the acquisition or sale of some or all of our assets, including through a sale or in connection with bankruptcy.</li>-->
                            <!--        <li>Your employer or coworkers if you receive our products or services in the scope of your employment.</li>-->
                            <!--        <li>Brokers and shippers responsible for a load will only receive your geolocation information from PTTR for loads requiring tracking and only after obtaining your -->
                            <!--            explicit consent.</li>-->
                            <!--    </ul>-->
                            <!--</p>-->
                            <!--<p>The aforementioned categories exclude text messaging originator opt-in data and consent, which will not be shared with any third parties. Additionally, we may share Personal -->
                            <!--    Information that has been deidentified or aggregated with third parties for various purposes</p>-->
                            <!--<p>8.	Policies Regarding Promotion and Marketing: While we may seek your consent to contact you for promotional and marketing purposes, you have the right to opt-out of receiving -->
                            <!--    promotional or marketing emails at any time. You can do so by replying to any unwanted email, using the unsubscribe function in our newsletter, contacting us at -->
                            <!--    <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>. Please note that requests to unsubscribe from PTTR emails may take up to 5 business days to process.</p>-->
                            <!--<p>9.	Cookies and Tracking Technologies: Please refer to our Cookies and Tracking Technologies Notification below for further details.</p>-->
                            <!--<p>10.	Third-party Websites: Our website may include links to other third-party sites. By clicking on these links, you are directed to websites operated by entities other than us, which may have-->
                            <!--    different privacy policies. We advise you to review the privacy policies of such third-party operators, as we are not responsible for their privacy practices.-->
                            <!--</p>-->
                            <!--<p>11.	Children: Our website is not intended for individuals under 16 years of age. If you are under 16, please refrain from accessing, using, or providing any information on our -->
                            <!--    website or its features. We do not knowingly collect Personal Data from individuals under 16 years of age. If we become aware of collecting Personal Data from a child under -->
                            <!--    16 without parental consent, we will promptly delete that information. If you suspect that we may have information about a child under 16, please contact us via email at -->
                            <!--    <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    12.	Data Breaches: While we implement measures to mitigate the risk of data breaches, we have established controls and procedures to address such incidents. Additionally, we -->
                            <!--    adhere to the necessary procedures for notifying the relevant Supervisory Authority and affected data subjects (where applicable).-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    13.	Changes to this Privacy Policy: We reserve the right to update this Privacy Policy at our discretion to reflect necessary changes or legal requirements. Any material changes -->
                            <!--    will be prominently displayed on our websites.     -->
                            <!--</p>-->
                            <!--<p>14.	Contact Us: For any comments or questions regarding this Privacy Policy, please reach out to us via email at <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>.-->
                            <!--</p>-->
                            <!--<p>California Consumer Privacy Act Notifications This page, titled the California Consumer Privacy Act disclosure page (“Disclosure”), complements the above Privacy Notice and takes -->
                            <!--    effect as of July 27, 2021. While the Privacy Notice outlines the personal information we collect, its sources, purposes of use, limited sharing circumstances, and recipients, -->
                            <!--    these additional disclosures are mandated by the California Consumer Privacy Act:-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    Categories of collected personal information: The personal information PTTR gathers, or has gathered from consumers in the twelve months before this Disclosure’s effective date, -->
                            <!--    falls into the categories specified by the California Consumer Privacy Act:-->
                            <!--</p>-->
                            <!--<ul>-->
                            <!--    <li>Identifiers (e.g., name, address, phone number, username, IP address)</li>-->
                            <!--    <li>Protected classifications (e.g., age, gender)</li>-->
                            <!--    <li>Financial and commercial information (e.g., credit card numbers, purchase history)</li>-->
                            <!--    <li>Internet or other online activity information</li>-->
                            <!--    <li>Geolocation data (e.g., computer/device location)</li>-->
                            <!--    <li>Audio or visual information</li>-->
                            <!--    <li>Professional information (e.g., job title)</li>-->
                            <!--    <li>Inferences drawn from any of the above</li>-->
                            <!--</ul>-->
                            <!--<p>-->
                            <!--    Categories of disclosed personal information for business purposes: In the twelve months preceding this Disclosure’s effective date, PTTR has shared personal information falling -->
                            <!--    into the categories established by the California Consumer Privacy Act with the third parties identified in the “Disclosing Personal Information to Third Parties” section of -->
                            <!--    the Privacy Notice:-->
                            <!--</p>-->
                            <!--<ul>-->
                            <!--    <li>Identifiers</li>-->
                            <!--    <li>Protected classifications</li>-->
                            <!--    <li>Financial and commercial information</li>-->
                            <!--    <li>Internet or other online activity information</li>-->
                            <!--    <li>Geolocation data</li>-->
                            <!--    <li>Audio or visual information</li>-->
                            <!--    <li>Professional/educational information</li>-->
                            <!--</ul>-->
                            <!--<p>Right to Access or Delete Personal Information: The California Consumer Protect Act may afford you the right to request details about the personal information PTTR holds about -->
                            <!--    you, obtain a copy of it, or have it deleted. If you wish to exercise any of these rights, please visit -->
                            <!--    <a href="{{route(auth()->user()->type.'.help-center')}}" target="_blank">Click to Support</a>  -->
                            <!--    or contact Customer Service. Depending on your data choices, certain services may be limited or unavailable. You can exercise these rights by emailing us at -->
                            <!--    <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>, or calling <a href="tel:+1 (888) 706-7013" title="">+1 (888) 706-7013</a>. We commit to responding to -->
                            <!--    such requests within 30 days of receipt.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    Sharing Your Personal Information: In the twelve months before this Disclosure’s effective date, PTTR has not sold any personal information of consumers, as defined under the -->
                            <!--    California Consumer Privacy Act.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    No Discrimination: PTTR pledges not to discriminate against any consumer for exercising their rights under the California Consumer Privacy Act.-->
                            <!--</p>-->
                            <!--<h3>Tracking Technologies and Cookie Usage</h3>-->
                            <!--<p>Cookies and other Tracking Mechanisms: A cookie is a small file placed in your web browser by a website to remember details about your interactions. We utilize cookies and similar -->
                            <!--    tracking technologies for essential functions related to your website, product, or service usage. These may include storing preferences, entered information, or maintaining -->
                            <!--    your logged-in status. Additionally, with your consent, we may employ cookies and tracking technologies for broader purposes.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    Essential Cookies and Technologies: These are essential for our website, products, and services to operate and cannot be disabled. While you can configure your browser or device -->
                            <!--    to manage these cookies, doing so may impact functionality. These cookies don’t store personal data and are solely used for facilitating communication transmission, ensuring you -->
                            <!--    receive the requested information service. Their use is rooted in our legitimate interest in providing access and ensuring the proper technical operation of our offerings.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    Analytical/Performance Cookies: With your consent, we employ tools like Google Analytics or Segment to gather statistical data on website and service usage. These analytics -->
                            <!--    services utilize cookies to collect information such as IP addresses, browser details, and content interactions. This data helps us understand user behavior, identify popular -->
                            <!--    features, and analyze user demographics and interests. Targeting Cookies: These cookies track your activity on our site or while using our services to enhance content relevance -->
                            <!--    and assess marketing effectiveness. We may share this data with third parties for similar purposes. While these cookies are optional, not allowing them may result in less -->
                            <!--    personalized advertising.-->
                            <!--</p>-->
                            <!--<h3>Managing Your Preferences:</h3>-->
                            <!--<p>Upon your initial website visit, you’ll encounter a banner offering choices regarding the acceptance or rejection of various types of cookies and tracking technologies, excluding -->
                            <!--    those strictly necessary for specific services.</p>-->
                            <!--<p>-->
                            <!--    You can also customize how your web browser handles cookies through its settings. Some devices provide control options within device settings. However, refusing cookies may -->
                            <!--    affect website functionality and service availability. Each browser and device have unique settings, so refer to the respective menus for adjusting preferences.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    You can find guidance on managing cookie settings for specific browsers via the following links:-->
                            <!--</p>-->
                            <!--<p><a href="https://support.google.com/chrome/answer/95647?hl=en" target="_blank" rel="noopener">Chrome Cookie Settings</a><br>-->
                            <!--    <a href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer?redirectlocale=en-US&amp;redirectslug=Cookies" target="_blank" rel="noopener">Firefox Cookie Settings</a><br>-->
                            <!--    <a href="https://support.microsoft.com/en-us/windows/manage-cookies-in-microsoft-edge-view-allow-block-delete-and-use-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank" rel="noopener">Internet Explorer Cookie Settings</a><br>-->
                            <!--    <a href="https://support.apple.com/en-us/105082" target="_blank" rel="noopener">Safari Cookie Settings</a>-->
                            <!--</p>-->
                            <!--<p>You can decline cookies by adjusting browser settings, but this may limit website functionality.&nbsp; Additionally, you can prevent Google from collecting and using data (cookies and IP address) by<br>-->
                            <!--    installing the browser plug-in available at <a href="https://tools.google.com/dlpage/gaoptout?hl=en-GB" target="_blank" rel="noopener">https://tools.google.com/dlpage/gaoptout?hl=en-GB</a>.-->
                            <!--</p>-->
                            <!--<p>For further details on terms of use and data privacy, refer to:</p>-->
                            <!--<p><a href="https://policies.google.com/technologies/partner-sites?hl=en" target="_blank" rel="noopener">Google’s Privacy Policy</a><br>-->
                            <!--    <a href="https://marketingplatform.google.com/about/analytics/terms/gb/" target="_blank" rel="noopener">Google Analytics Terms of Service</a><br>-->
                            <!--    <a href="https://policies.google.com/?hl=en&amp;gl=uk" target="_blank" rel="noopener">Google’s Privacy Policy (EU/EEA)</a><br>-->
                            <!--    <a href="https://support.google.com/analytics/answer/6004245?hl=e" target="_blank" rel="noopener">Google Analytics Opt-out Browser Add-on</a>-->
                            <!--</p>-->
                            <p>PTTR Loadboard (“PTTR Loadboard,” “We,” “Our,” “Company,” or “Us”) understands the importance of securing your private information. Our freight management company provides services for carriers and brokers via our website and customer service channels. To provide you with the best services, we collect, store, record, use, share, and handle your personal information. Please read our privacy policy stated below to find out how we collect, use, and disclose your information.</p>

                            <p>“You,” (“your company,” “Customer,””User,” agree to our collection and use of your personal information as described in Our site's Privacy Policy by visiting our website or utilizing any of our corporate services. This Privacy Policy may be changed by PTTR Loadboard at any time and without previous notification. Effective date of the new policies, along with any modifications to the policy can be accessed on this website page in future.</p>
                            
                            <h3>1. Information We Collect</h3>
                            <p>The service providers, advertisers, and partners gather information from the platform, services, or digital channels.</p>
                            
                            <h4>1.1. Information You Share</h4>
                            <p>We may collect information that you input on the registration portal, on the broker, carrier, or combo user dashboard, live chat, and all other sections or functionalities of the platform. This can include, but is not limited to:</p>
                            
                            <h4>1.1.1. Identification Data:</h4>
                            <p>This includes information such as full name, role, company name, address, email address, phone number, user ID, or login credentials.</p>
                            
                            <h4>1.1.2. Interaction Records:</h4>
                            <p>This includes message content, your contacts in the Private Network, shipment information, communication timestamps, methods of contact (e.g., email, chat, phone), and any files or information uploaded.</p>
                            
                            <h4>1.1.3. Financial and Commercial Information:</h4>
                            <p>This includes billing details, payment history, invoicing data, transaction amounts, tax identification numbers (TIN or EIN), and payment methods.</p>
                            
                            <h4>1.1.4. Internet Or Other Online Activity:</h4>
                            <p>Data regarding your browsing behavior, usage patterns, IP addresses, search queries, interactions with PTTR Loadboard's website, platform features, and online services.</p>
                            
                            <h4>1.1.5. Geolocation Data:</h4>
                            <p>Apart from the location-based information you enter on the site or share through any of our service means, PTTR Loadboard also has the right to obtain the physical location of the user's computer or device (such as IP address or GPS coordinates).</p>
                            
                            <h4>1.1.6. SMS Notification Charges:</h4>
                            <p>PTTR Load Board offers SMS notifications to keep users informed about key updates and logistics activity, including load statuses, alerts, and essential platform communications. Standard message rates, as determined by your mobile carrier, may apply for each SMS notification. By opting in, users agree to receive these messages and accept any associated charges. PTTR is not responsible for any fees incurred.</p>
                            
                            <h4>1.2. Information from Automated Methods</h4>
                            <p>While you use our Platform, we may use automated tracking technologies to gather and/or aggregate information about how You use our platform or relevant services. Among the categories of information gathered are, but are not restricted to:</p>
                            
                            <h4>1.2.1. Technical Data:</h4>
                            <ul>
                             	<li>IP Address: Your unique Internet Protocol address, which identifies your device on the network.</li>
                             	<li>Browser Information: The type, version, and settings of the web browser you are using (e.g., Chrome, Firefox, Safari).</li>
                            </ul>
                            
                            <h4>1.2.2. Usage Data:</h4>
                            <ul>
                             	<li>Session Data: The date and time you access the website, how long you stay on each page, and the actions you take (such as clicks, scrolls, and form submissions).</li>
                             	<li>Page Interaction: The specific pages you visit on our site, including time spent per page and interactions with various site elements like buttons, images, or videos.</li>
                             	<li>Referring URL: The address of the website that directed you to our site (i.e., the referring page or search engine).</li>
                            </ul>
                            
                            <h4>1 Data Retention Policy</h4>
                            <p>PTTR Load Board securely retains user data for a period of up to 12 months, allowing us to maintain service quality, enhance platform functionality, and fulfill legal obligations. Once data surpasses this retention period or is no longer required, it is securely deleted or anonymized to protect user privacy. Users can request data review, modifications, or deletion in line with applicable laws. For questions regarding data storage and retention, users are encouraged to reach out to PTTR’s support team.</p>
                            
                            <h4>2. Credit Score / Days to Pay Clause</h4>
                            <p>The PTTR Load Board provides carriers with access to brokers' credit scores and Days to Pay (DTP) data, offering insights into financial reliability and payment history to support informed decision-making. This helps carriers assess broker trustworthiness and reduce business risks.</p>
                            
                            <p>Please note, the credit scores and DTP data are provided by a third-party service. PTTR is not responsible for the accuracy of this information and cannot make changes or address disputes. Users should contact the third-party provider directly for any updates or concerns regarding the data.</p>
                            
                            <h4>3. PIPEDA Policy</h4>
                            <p>PIPEDA, or the Personal Information Protection and Electronic Documents Act, is Canada’s federal privacy law governing the handling of personal information by private sector organizations. For PTTR, compliance with PIPEDA is crucial to protect user data and maintain trust with Canadian customers. This policy mandates PTTR to ensure transparent data practices, secure storage, and control over how personal information is collected, used, and disclosed. Adhering to PIPEDA helps PTTR uphold privacy rights, avoid regulatory issues, and build confidence with its users by prioritizing their data security and privacy.</p>
                            
                            <h4>1.2.3. Cookies and Tracking Technologies</h4>
                            <ul>
                             	<li><strong>Cookies:</strong> These are the small data files placed on your device (mobile or PC) to track your browsing activity, preferences, and session information.</li>
                             	<li><strong>Web Beacons and Pixels:</strong> Transparent images embedded in web pages and emails used to track user behavior, including the number of views of specific content and email engagement.</li>
                             	<li><strong>Local Storage and Session Storage:</strong> To provide a more customized experience, remembering preferences and for faster loading times to be facilitated, various methods of storing data in your browser are relied on.</li>
                            </ul>
                            
                            <h4>Data Collection</h4>
                            <p>When you interact with the PTTR platform, we collect information about your usage, referred to as "Usage Information." This includes details such as device type, IP address, access times, approximate location (via IP), and browsing activity. PTTR uses this data to improve the platform's performance, ensure security, and provide tailored notifications or recommendations. Any information collected through cookies or automated technologies is anonymized and aggregated to ensure privacy.</p>
                            
                            <h4>Managing Cookies</h4>
                            <p>As per compliance with regulations such as GDPR and CCPA, we give users the right to manage and control their preferences. However, please note that doing so may hinder the functionality of our services.</p>
                            
                            <h4>To Control or Remove Cookies</h4>
                            <ol>
                             	<li>Find the settings option in your internet browser, which can usually be found labeled “Privacy” or “Security.”</li>
                             	<li>Search for the part that says “Cookies” and have a look through the various options that are possible for cookies.</li>
                             	<li>It is possible through most browsers nowadays either to completely disable cookies or clear them after each session, or disallow specific websites from using cookies.</li>
                            </ol>
                            
                            <h4>Deactivating Web Beacons or Pixels</h4>
                            <ol>
                             	<li>You might be able to stop web beacons by changing email configurations within your email program to forbid the display of images.</li>
                             	<li>Besides that, blocking programs and browser extensions would assist in blocking pixels as well as beacons.</li>
                            </ol>
                            
                            <h4>Clearing Local and Session Storage Memory</h4>
                            <ol>
                             	<li>Select your browser’s developer tools (it’s usually listed under the “More Tools” or “Developer Tools” tab).</li>
                             	<li>Disable or modify what you don’t want in the ‘Application’ tab under local storage and session storage, so any remaining saved preferences/settings will be wiped clean.</li>
                            </ol>
                            
                            <h4>Cookies and Similar Technologies</h4>
                            <p>PTTR uses cookies, web beacons, and similar tools for analytics and functionality. These technologies track platform interactions, device details, and performance metrics, helping us compile statistics, detect fraud, and improve user experience. Users can manage their cookie preferences through browser settings, though disabling certain cookies may limit platform functionality.</p>
                            
                            <h4>Targeting and Advertising Cookies</h4>
                            <p>PTTR partners with third-party services, such as Google AdWords and Facebook Pixel, to display relevant advertisements and track their effectiveness. These tools may collect data like ad clicks and order placements. This information enables PTTR to tailor marketing efforts and enhance ad relevance for users. For more details, users are encouraged to review the privacy policies of these services.</p>
                            
                            <p>By using PTTR, users agree to the collection and use of data as outlined. PTTR maintains high standards of data security and privacy while utilizing insights to optimize platform features and user experience.</p>
                            
                            <h4>Device Specific Restrictions</h4>
                            <ul>
                              <li>To manage permissions on your mobile device, navigate to your privacy or cookie settings. Adjust preferences as needed to control technology use on our platform. Regularly reviewing and updating these settings is recommended, as disabling certain features may impact your browsing experience.</li>
                            </ul>
                            
                            <h4>1.3. Information Collected for Brokers Members</h4>
                            <p>We may collect specific data relevant to brokers to facilitate freight management, communication, and compliance. This includes:</p>
                            <ul>
                              <li>Business Identification: Broker name, company registration number, DOT number, and business address.</li>
                              <li>Contact Information: Name, email ID, cellular or telephone number of representatives.</li>
                              <li>Financial Information: Tax identification numbers, payment information, and invoice data.</li>
                              <li>Operational Data: Shipping choices, insurance certificates, and brokerage licensing details.</li>
                              <li>Platform Usage Data: Information about load searches, booking history, and dashboard interactions (all included).</li>
                            </ul>
                            
                            <h4>1.4. Information Collected for Carrier Members</h4>
                            <p>We gather specific information from carriers to support load matching, route optimization, and safety compliance. This includes:</p>
                            <ul>
                              <li>Carrier Identification: Carrier name, DOT number, MC number, and vehicle registration details.</li>
                              <li>Drivers Information: The load drivers' names, license numbers, ELD data, and contact information for communication between us and the broker members.</li>
                              <li>Equipment and Fleet Details: Vehicle type, load capacity, equipment certificates, and inspection history.</li>
                              <li>Financial Details: Bank details for payments, invoicing information, and tax identification numbers.</li>
                              <li>Tracking and Geolocation Data: GPS coordinates, route data, and real-time tracking for active loads.</li>
                              <li>Platform Usage Data: Data on dashboard use, load availability, and trip history for service enhancement.</li>
                            </ul>
                            <p>Note: If you have opted for Combo Membership, then both Broker Membership and Carrier Membership are applicable to you—making you a dual member.</p>
                            
                            <h3>2. Use of Information</h3>
                            
                            <h4>2.1. General Users</h4>
                            <p>The below clauses state why we collect, hold, use, and disclose the personal information you share manually or through automated means:</p>
                            <ul>
                              <li>To provide you with access and usage of our online dashboard.</li>
                              <li>To verify you and/or your company.</li>
                              <li>To register you on our platform and enable you to find carriers, search trucks, search loads, post trucks, post loads, maintain the private network, track shipments, use rate viewer and also other tools and various other features on the platform.</li>
                              <li>To personalize your dashboard interface, suggest appropriate loads, and provide a communication flow that is absolutely streamlined between brokers and carriers.</li>
                              <li>To contact you so that we're able to communicate information regarding our business, any support requests, or any other inquiries.</li>
                              <li>To maintain internal records and for administrative, billing, and invoice purposes.</li>
                              <li>To perform analytics (including profiling on our website), conduct market research, support business development and planning, and drive product development, including enhancing and managing our business operations, related applications, and social media platforms.</li>
                              <li>To advertise and market our services, send promotional information regarding events, experiences, and other information that may be of interest to you.</li>
                            </ul>
                            
                            <h4>2.2. Use of Information for Carrier Members</h4>
                            <p>We use or hold the collected carrier information for the purpose stated below:</p>
                            
                            <h4>2.2.1. Load Matching and Route Optimization</h4>
                            <p>The details of your fleet (regardless of size), vehicle types, and load capacity enable the site to find suitable freight loads. The route information and real-time geolocation data are always in utilization to assign loads optimally.</p>
                            
                            <h4>2.2.2. Safety Compliance and Monitoring</h4>
                            <p>The details of the driver and also the vehicle (Including ELD data, license numbers, and inspection history) may be used to adhere to verification compliance with US federal and state regulations.</p>
                            
                            <h4>2.2.3. Transaction and Payment Management</h4>
                            <p>The financial details, such as bank account information, invoicing details, and tax identification numbers, are used to process payments for completed loads.</p>
                            
                            <h4>2.2.4. Real-Time Load Tracking and Communication</h4>
                            <p>Your GPS data and real-time tracking information to monitor and share the progress of active shipments with the carrier and broker to stay informed about delivery statuses, delays, or any issues during transit.</p>
                            
                            <h4>2.3. Use of Information for Brokers</h4>
                            <p>We use or hold the collected information for the purpose stated below:</p>
                            
                            <h4>2.3.1. Freight and Load Matching</h4>
                            <p>Broker-related data such as company registration, DOT number, and operational preferences are used to suggest the most relevant carriers for your loads based on their available capacity, route preferences, and operational standards.</p>
                            
                            <h4>2.3.2. Verification</h4>
                            <p>We use your personal and business information to check the legitimacy and compliance with the industry standards (both present and future) on our platform.</p>
                            
                            <h4>2.3.3. Transaction and Payment Management</h4>
                            <p>The financial information, including invoicing details, tax identification numbers (TIN or EIN), and payment methods, is used to process payments for services rendered and completed loads.</p>
                            
                            <h4>2.3.4. Communication and Coordination with Carriers</h4>
                            <p>Your contact information (such as email, phone number, and other communication channels) may/might be used as a reference to interact directly with carriers or brokers.</p>
                            
                            <h3>3. Disclosure of Personal Information to Third Parties</h3>
                            <p>We may share personal information with the following third parties:</p>
                            <ul>
                              <li><strong>Employees, Contractors, and Related Entities:</strong> To support our internal operations and services.</li>
                              <li><strong>IT Service Providers:</strong> Including data storage, web hosting, and server providers.</li>
                              <li><strong>Marketing and Advertising Providers:</strong> For promotional and advertising purposes.</li>
                              <li><strong>Carriers and Brokers:</strong> If you are a broker, we may share your information with carriers to facilitate deliveries. If you are a carrier, we may share your information with shippers to fulfill orders. If you are a customer receiving shipments, we may share your information with carriers delivering goods to you.</li>
                              <li><strong>Professional Advisors:</strong> These include legal, financial, and insurance advisors, auditors, bankers, and insurance brokers.</li>
                              <li><strong>Payment Processors:</strong> To enable transactions and payments.</li>
                              <li><strong>Business Partners:</strong> Including current or potential agents, collaborators, or partners.</li>
                              <li><strong>Sponsors or Promoters:</strong> Of any promotions, contests, or competitions we may organize.</li>
                              <li><strong>Business Transactions:</strong> In the course of a business merger or transfer of assets, our Company has the right to transfer your information as part of such transactions.</li>
                              <li><strong>Data Collection and Processing Providers:</strong> Including analytics services and third-party cookies.</li>
                              <li><strong>Authorities and Legal Entities:</strong> PTTR Loadboard may be required to disclose personal information to authorities, law enforcement, government agencies, or other legal entities under certain circumstances. We may share information as mandated by law, in connection with litigation, or for matters related to national security, including:
                                <ol>
                                  <li><strong>Compliance with Legal Processes:</strong> To adhere to valid legal processes, including subpoenas, court orders, search warrants, or as otherwise permitted or required by law.</li>
                                  <li><strong>Emergency Situations:</strong> Whenever an individual's life, health, or security is threatened in an event of an emergency.</li>
                                  <li><strong>Special Cases:</strong> As permitted by applicable law, when we believe it is necessary to investigate, identify, or take preventive action in situations involving potential harm, fraud, abuse, or illegal activity. This may include actions to protect you, others, or our rights and property or to address a threat of harm or interference with our operations.</li>
                                </ol>
                              </li>
                            </ul>
                            
                            
                            <h4>Google Analytics and Advertising Features</h4>
                            <p>We have enabled Google Analytics Advertising Features to help our tech team, and others understand and analyze how users interact with our website. Both We and Third Party entities have access to use your first-party cookies (such as the Google Analytics cookie) and other first-party identifiers in your browsers, along with Third Party cookies (such as Google advertising cookies) and any other Third Party identifiers. These cookies and identifiers collect technical and usage data about your interaction with our site.</p>
                            <p>You can pause or completely stop the use of Google Analytics Advertising Features through the Google Analytics Opt-out Browser Add-on, which you will find available <a href="https://tools.google.com/dlpage/gaoptout/" target="_blank" rel="noopener">here</a>. To opt out of personalized advertising on the Google content network, change the settings at Google's Ads Preferences Manager <a href="https://adssettings.google.com/anonymous?hl=en" target="_blank" rel="noopener">here</a>.</p>
                            <p>To understand how Google uses data when you interact with third-party websites and apps, please refer to Google's Privacy &amp; Terms <a href="https://policies.google.com/privacy?hl=en-US" target="_blank" rel="noopener">here</a>.</p>
                            
                            <h4>Overseas Disclosure</h4>
                            <p>PTTR Loadboard has the right to save Personal Information and Automated Information in the United States of America. We also firmly ensure full compliance with international data protection laws, such as GDPR. In order to ensure the confidentiality of the personal information collected from users in the EU/EEA, we make use of protective measures such as standard contractual clauses (SCC). Please be aware, though, that nations outside of our own may implement data protection laws that differ from those in your own, and we cannot be held responsible for this in any way. We also do not give any personal information to third parties for their independent use.</p>
                            
                            <h3>4. Your Rights and Control Over Information</h3>
                            <h4>4.1. Your Choice</h4>
                            <p>To practice these rights, we suggest that users carefully read our Privacy Policy clauses. By providing PTTR Loadboard with personal information, you give us permission to collect, store, use, and disclose that information as described in this Privacy Policy. While providing personal information is not mandatory, please be aware that failure to do so may affect our ability to properly cater to your needs.</p>
                            
                            <h4>4.2. Information from Third Parties</h4>
                            <p>If we receive personal information about you from a third party, we will treat that information as mentioned in our Privacy Statement. If you are submitting personal information about any other identity, be it a business or a person, you pledge that you have obtained their consent to provide that information to us.</p>
                            
                            <h4>4.2.1 Third-Party Integrations and Information Sharing Policy for PTTR</h4>
                            <p><strong>Third-Party Integrations:</strong> When accessing PTTR services integrated with third-party platforms, certain data may be exchanged. These providers operate independently, and their usage of personal information may differ from PTTR’s practices. PTTR does not control these external parties, so users should carefully review their privacy policies.</p>
                            
                            <p><strong>Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, user data may be transferred as part of the transaction. PTTR requires any buyer to adhere to the established privacy policy to protect user information.</p>
                            
                            <p><strong>Affiliates and Subsidiaries:</strong> PTTR may share personal information with its affiliates and subsidiaries for service delivery and improvements. Employees, contractors, and agents of these entities are obligated to maintain confidentiality and use personal information in compliance with PTTR’s privacy policy.</p>
                            
                            <h4>4.3. Opt-Out and Unsubscribe</h4>
                            <p>If you do not want to receive marketing communications from us or would like to unsubscribe from our email database, communicate that with us at <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a> or call us at <a href="tel:+1 (888) 706-7013">+1 (888) 706-7013</a>. Another way to opt out is to use the unsubscribe link shared in any of the marketing emails we send you.</p>
                            
                            <h4>4.4. Access to Personal Information</h4>
                            <p>You have the right to request access to the personal information we hold or collect about you. However, the company has the right to charge a reasonable administrative fee to share this information. In certain situations, we have the legal allowance to refuse access to your information, and if this occurs, we will inform you of the reasons for our refusal. It’s needless to say that for our customers, we uphold the greatest regard for your privacy. That's why we may share information in an alternative format if possible.</p>
                            
                            <h4>4.5. Correction of Personal Information</h4>
                            <p>If for some reason you think that the personal information PTTR Loadboard collects, uses, and holds is inaccurate, incomplete, outdated, or misleading, please contact us using the details below. Our team will initiate reasonable steps to correct the information as appropriate. However, in certain cases, we may be legally permitted to decline your request for correction. If we cannot make the correction, we will inform you of the reasons and provide information about how you can challenge our decision.</p>
                            
                            <h3>5. Complaints</h3>
                            <p>If you want to lodge a complaint regarding how we handle your personal information, please contact us with full details of your complaint. Our team will investigate and respond in writing. At a certain time, you will be provided with the outcome of our investigation and will be asked to state the actions we will take in response to your complaint. If you are unsatisfied with our response, you have your due right to file a complaint with the Federal Trade Commission (FTC) in America.</p>
                            
                            <strong>Note:</strong> PTTR Loadboard does not discriminate against the users who use the site, personalized dashboards, customer service, or any of our related services, as per the applicable law, to enforce your liberties.
                            
                            <h3>6. Security</h3>
                            <p>PTTR Loadboard takes commercially reasonable precautions and follows the best data security measures to protect your Personal Data collected from our platform or through any of our mediums in our possession from loss, misapplication, unauthorized access, revelation, modification, or destruction. However, any type of information or data shared through personal or automated means stored with any method or transmitted is not 100% secure or error-free on the Internet.</p>
                            
                            <p>We are open to hearing from you more secure ways to share sensitive information. Please note that anywhere you input Your passwords, ID numbers, or other information on this site, it is your responsibility to protect them. We suggest withholding the Sensitive Information from yourself and the trusted people and logging out of any accounts you access after your sessions.</p>
                            
                            <h4>State Consumer Privacy Provisions for PTTR</h4>
                            <p>Compliance with State Laws: PTTR adheres to privacy requirements outlined in laws such as the California Consumer Privacy Act (CCPA).</p>
                            
                            <h4>Legal Disclosures at PTTR</h4>
                            <p>PTTR complies with legal requirements to disclose personal information under valid judicial or administrative orders such as subpoenas or warrants issued by U.S. law enforcement. When permitted, PTTR aims to notify individuals or customers before disclosure to allow objections, typically via email. Exceptions include cases with court-issued non-disclosure orders, where users are informed once the restriction expires.</p>
                            
                            <p>In emergencies involving imminent danger, PTTR may share data with law enforcement to prevent harm, evaluated case by case. Users should consult relevant account holders for additional policies on legal requests.</p>
                            
                            <h3>7. Personal Data Retention</h3>
                            <p>We retain your personal information for the time necessary to achieve the purposes outlined above, except where a longer period is required by law. This includes the need to store your information and data in order to fulfill your requests for products and services, interact with you, nurture our commercial relations, and improve our services. It is also retained in order to achieve compliance, safety, and security that are in line with our policies. When this relationship is terminated, we may retain personal data about you for these purposes in our systems: honoring residual duties of the contract, assisting in new recruiting, demonstrating our performance, and advising regarding useful products and services. If you want to learn more about the data retention duration or want to delete it, do contact us at <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>.</p>
                            
                            <h3>8. Children’s Policy</h3>
                            <p>Children under the age of sixteen should not use this website. No one under the age of sixteen shall use this website to submit any information to us without adult guidance. We don't intentionally gather personal information from minors younger than sixteen. Do not access, utilize, or divulge any information on the website or through any of its features if you are younger than sixteen. Should we find out that we have physically collected information from a user under the age of 16 we shall remove any personal data we discover we have obtained or collected without the agreement of the child's parents. We may also take appropriate measures, which may include closing accounts of users whom we believe are underage and restricting future access.</p>
                            
                            <p>We would appreciate it beyond measure if you could inform us by sending us an email at <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a> or giving us a call at <a href="tel:+1 (888) 706-7013">+1 (888) 706-7013</a> if you think we may have any information from or about a child under the age of sixteen.</p>
                            
                            <p><strong>Sources and Purposes:</strong> Data is sourced directly from consumers, service providers, social networks, and analytics platforms. Collected information is used to improve services and enhance user experiences.</p>
                            
                            <p><strong>California Eraser Law Compliance:</strong> California residents under 18 can request the removal of content they’ve posted. PTTR will anonymize or remove such content where feasible, though complete removal from all platforms cannot be guaranteed.</p>
                            
                            <h3>9. Disputes</h3>
                            <p>If you decide to visit the Sites, your visit and any privacy-related dispute will be exercised over this Privacy Statement that applies to each Site, including any clauses pertaining to governing law, jurisdiction, or venue, liability limitations, arbitration, and dispute resolution.</p>
                            
                            <h3>10. Amendments to the Privacy Policy</h3>
                            <p>We may amend this Privacy Policy to offer clarification or notification of changes to our practices. If any amendments are conducted, we will notify you by posting the information on the Site, sending you an email, or allowing you to access your account on the Site within 30 days of significant updates made. You acknowledge that this Privacy Policy, as updated, governs your use of our Sites and any privacy disputes that may arise from using them on or after the effective date of any such amendment.</p>
                            
                            <h3>11. Get in Touch with Us</h3>
                            <p>If you would like us to amend the information we have on you or your choices, or if you have any questions or feedback concerning the Privacy Policy stated on this web page, please send an email to <a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>, give us a call at <a href="tel:+1 (888) 706-7013">+1 (888) 706-7013</a>.</p>
                            
                            <h4>Writer’s Note:</h4>
                            <ul>
                              <li>The highlighted information is to be discussed and collected from the client to ensure accuracy.</li>
                            </ul>
                            
                            <h3>12. Advertising Data Use Policy</h3>
                            <p>PTTR Load Board values user privacy and transparency in advertising data use. Advertisers provide essential information, including business name, contact details, and ad content, solely for promotional purposes within the PTTR platform. PTTR does not share or use user data for third-party advertising beyond the platform’s ecosystem. Advertisers are responsible for the accuracy and legality of their ad content. This policy supports data protection and ensures that advertising on PTTR Load Board remains safe, user-focused, and compliant with privacy standards.</p>
                            
                            <h3>13. User Rights Policy</h3>
                            <p>PTTR Load Board is committed to respecting user rights regarding their personal data:</p>
                            <ul>
                              <li><strong>Access and Correction:</strong> Users can request access to their personal data and update or correct any inaccuracies as needed.</li>
                              <li><strong>Data Deletion:</strong> Users may request deletion of their data, subject to operational and legal requirements (e.g., retaining financial records for compliance).</li>
                              <li><strong>Opt-Out Options:</strong> Users have the flexibility to opt out of marketing communications and location-based services at any time.</li>
                            </ul>
                            <p>This policy empowers users with control over their data while ensuring compliance with regulatory standards.</p>
                            
                            <h3>14. Data Sharing Policy</h3>
                            <p>PTTR Load Board takes user privacy seriously while ensuring functionality across the platform. User data is shared in the following limited contexts:</p>
                            <ul>
                              <li><strong>Payment Processors:</strong> To facilitate invoicing, payments, and financial transactions securely.</li>
                              <li><strong>IT Service Providers:</strong> Trusted partners who support platform infrastructure and functionality.</li>
                              <li><strong>Legal Authorities:</strong> If required by law, PTTR may disclose data to comply with regulatory obligations or legal processes.</li>
                            </ul>
                            <p>For advertising purposes, any shared data is anonymized, ensuring that it is used exclusively within the platform and does not compromise user privacy.</p>
                            
                            <h4>California Privacy Rights: Shine the Light Law</h4>
                            <p>California residents who have shared personal information with PTTR have the right, under California Civil Code §1798.83, to request details about any personal information disclosed to third parties for direct marketing purposes during the prior calendar year. This includes categories of information shared and the names of the third parties.</p>
                            <p>To submit such a request, include “Your California Privacy Rights” in the subject line with your name and mailing address, and send it via email or postal mail to the contact information provided in PTTR’s Contact Us section.</p>
                            
                            <h3>15. Data Collection Policy for Tracking and Geolocation</h3>
                            <p>At PTTR, we prioritize transparency and efficiency in our services. To enhance functionality and deliver tailored user experiences, we collect geolocation data through GPS and IP-based technologies. This data is gathered when users interact with features such as Tracking, Nearby, or PTTR Map. The information enables us to provide precise location insights, optimize routes, and support location-based functionalities, ensuring seamless service delivery. Rest assured, all data collection adheres to strict privacy and security standards to protect user information and comply with relevant regulations.</p>
                            
                            <h3>16. Non-Discrimination Assurance:</h3>
                            <p>PTTR ensures no consumer will face discrimination for exercising their rights under state-specific privacy laws.</p>
                            
                            <p>This policy reflects PTTR's commitment to privacy and compliance with regional regulations.</p>

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
