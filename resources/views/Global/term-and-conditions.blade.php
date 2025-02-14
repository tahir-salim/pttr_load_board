@extends('layouts.app')
@section('content')
    @if(!auth()->check())
    <div class="col-md-1">
    </div>
    @endif
    <div class="col-md-10">
        <div class="mainBody termscont">
            @if(auth()->check())
                @include('layouts.notifications')
            @endif
            <div class="main-header globalcustom">
                <h2>Term and conditions</h2>
                @if(!auth()->check())
                    <a class="themeBtn" href="{{route('login')}}" title="">Back to Login</a>
                @endif
            </div>
            <div class="contBody helpcenterPg">
                <div class="row">
                    <div class="col-md-12">  
                        <div class="Content">
                            <!--<p>These terms and conditions (“Agreement”) govern your use of the PTTR products (“Products”) and establish an agreement between you or the entity you represent (“You”) and PTTR-->
                            <!--    Loadboard (“PTTR,” “We,” “Us,” or “Our”). This Agreement becomes effective upon your acceptance by clicking an “I Accept” button or checkbox, or upon your initial use of any -->
                            <!--    Product (“Effective Date”).</p>-->
                            
                            <!--<p>1. Authority to Enter into the Agreement: By entering into this Agreement, you affirm that you have the legal capacity to do so, such as being of legal age. If you’re -->
                            <!--    representing an entity, like your employer, you affirm that you have the authority to bind that entity.</p>-->
                            
                            <!--<h3>2.	Use of the Products:</h3>-->
                            <!--<ul>-->
                            <!--    <li>Generally: You may access and utilize the Products according to this Agreement and any applicable Product and Delivery Schedule. Your usage must comply with this Agreement.</li>-->
                            <!--    <li>Acceptable Use: You must adhere to the Acceptable Use Policy, which may be updated reasonably by us.</li>-->
                            <!--    <li>Your Account: Access to the Products requires an account linked to a valid email address. Except where explicitly permitted by the Product and Delivery Schedule, only one account per email address is allowed.</li>-->
                            <!--    <li>Automation: You may not copy or retrieve any Product Data in an automated manner without our prior written consent.</li>-->
                            <!--    <li>Directory: By subscribing to any Product, you authorize us to include your Contact Data in Our Directory, which can be viewed by our active subscribers.</li>-->
                            <!--</ul>-->
                            <!--<h3>3.	Orders, Fees, and Payment</h3>-->
                            <!--<ul>-->
                            <!--    <li>Placing Orders: Products can be ordered by completing an Order Form.</li>-->
                            <!--    <li>Payment Terms: Fees are payable within twenty (20) days from the invoice date unless otherwise specified on the Order Form.</li>-->
                            <!--    <li>Late Payments: You agree to pay all amounts due without deductions or setoffs. In case of late payments, we reserve the right to charge interest at 1.5% per month (or the maximum rate allowed by law, if lower). You’ll also be responsible for reasonable collection costs, including collection agency and attorney fees.</li>-->
                            <!--    <li>Disputes on Invoices: Any disputed bills must be formally presented within thirty (30) days of receiving the invoice.</li>-->
                            <!--    <li>Taxation: Quoted prices do not include taxes. You’re responsible for any applicable sales, use, excise, or other taxes. If you provide a valid tax exemption certificate, we’ll deduct applicable taxes. However, you’ll reimburse us for any taxes we incur if the exemption certificate is insufficient.</li>-->
                            <!--</ul>-->
                            <!--<h3>4. Changes to the Products</h3>-->
                            <!--<p>We reserve the right to modify the Products at our discretion, including enhancements, modifications, and new versions. We’ll provide at least one (1) month’s notice before -->
                            <!--    discontinuing significant functionality, unless:</p>-->
                            <!--<ul>-->
                            <!--    <li>Providing notice would pose security or intellectual property concerns.</li>-->
                            <!--    <li>It’s economically or technically burdensome.</li>-->
                            <!--    <li>It would cause us to violate legal requirements.</li>-->
                            <!--</ul>-->
                            <!--<h3>5. Security and Data Privacy</h3>-->
                            <!--<p>By using our Products, you agree to abide by our Privacy Policy, which may be updated periodically. </p>-->
                            <!--<h3>6. Term and Termination</h3>-->
                            <!--<ul>-->
                            <!--    <li>Duration: This Agreement is effective from the Effective Date and continues until the expiry or non-renewal of all active Order Forms. Please note that it may take up to two (2) business-->
                            <!--        days to process an Order Form and grant you access to the Products.</li>-->
                            <!--    <li>Renewal: Each Order Form’s term is specified within it. Unless otherwise stated, OrderForms automatically renew for periods equal to the expiring term or one year (whichever is-->
                            <!--        shorter), unless either party provides notice of non-renewal at least 30 days before the end of the term.</li>-->
                            <!--    <li>Termination for Cause: This Agreement may be terminated immediately if:-->
                            <!--        <ul>-->
                            <!--            <li>You violate Section 2.2 or Section 8.2 (as reasonably believed by us).</li>-->
                            <!--            <li>Either party breaches the Agreement (other than the above) and fails to remedy the breach within 10 days of written notice.</li>-->
                            <!--            <li>Either party becomes insolvent, files for insolvency, makes an assignment for the benefit of creditors, or has a receiver appointed.</li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <li>Effects of Termination: Upon termination or expiration, your access to the Products ends, and the license described in Section 8.1 expires immediately. Termination or expiration does-->
                            <!--        not release you from any accrued payment obligations.-->
                            <!--        </li>-->
                            <!--</ul>-->
                            
                            <!--<h3>7.	Shared Data</h3>-->
                            <!--<ul>-->
                            <!--    <li><strong>License:</strong> Unless otherwise stated in the Product and Delivery Schedule, you grant us a royalty-free, perpetual, irrevocable, non-exclusive right and license to use, reproduce,-->
                            <!--        modify, sell, publish, distribute, and display any Shared Data without geographical limitations and without further consent from you.-->
                            <!--    </li>-->
                            <!--    <li><strong>Ownership:</strong> You warrant that you, your Authorized Users, or your licensors own all rights to the Shared Data. You must have obtained all necessary consents and provided privacy-->
                            <!--        notices as required by law.-->
                            <!--    </li>-->
                            <!--    <li><strong>Restrictions:</strong> You and your Authorized Users agree to use the Products only as permitted by this Agreement. Reverse engineering, disassembling, or circumventing usage limits is-->
                            <!--        prohibited. You may not imply any relationship with us beyond what is expressly permitted.-->
                            <!--    </li>-->
                            <!--    <li><strong>Suggestions:</strong> If you provide suggestions, we have the right to use them without restriction. You assign all rights to the suggestions to us and agree to assist us in documenting and-->
                            <!--        maintaining these rights.-->
                            <!--    </li>-->
                            <!--</ul>-->
                            <!--<h3>8.	PTTR Data and Non-Compete</h3>-->
                            <!--<ul>-->
                            <!--    <li>Product Access: Upon complete payment for access to our Products, we provide you with a royalty-free, term-limited, non-exclusive, non-transferable, non-assignable, nonsublicensable-->
                            <!--        license to use the Products and associated Product Data.-->
                            <!--    </li>-->
                            <!--    <li>Assurances and Obligations: You assure and agree that:-->
                            <!--        <ol>-->
                            <!--            <li>You will not develop, sell, or offer products or services that compete with our Products.</li>-->
                            <!--            <li>You will solely utilize the Products and Product Data for internal business purposes.</li>-->
                            <!--            <li>You won’t reproduce, republish, resell, or distribute the Products or Product Data to third parties.</li>-->
                            <!--            <li>You won’t use the Products, Product Data, or any information obtained from us to compete against us, including actions such as aggregating other brokers’ loads, doublebrokering freight or trucks, transferring Product Data to other load boards, or-->
                            <!--            developing competitive rate products using Product Data.</li>-->
                            <!--        </ol>-->
                            <!--    </li>-->
                            <!--    <li>Auditing: You grant us and our authorized representatives access to your premises and relevant documents for auditing compliance with Section 8.2. You agree to cooperate fully-->
                            <!--        and provide prompt access upon request.-->
                            <!--    </li>-->
                            <!--    <li>Injunctive Relief: You acknowledge that breaching any provision of this Section 8 will cause us irreparable harm, for which we may seek immediate injunctive relief without posting a-->
                            <!--        bond.-->
                            <!--    </li>-->
                            <!--</ul>-->
                            <!--<h3>9. Warranty</h3>-->
                            <!--<ul>-->
                            <!--    <li>-->
                            <!--        Our Assurances to You: We assure you that:-->
                            <!--        <ol>-->
                            <!--            <li>We have the necessary rights and authority to enter into this Agreement.</li>-->
                            <!--            <li>Our Products do not and will not violate the intellectual property rights of any third party.</li>-->
                            <!--            <li>We will adhere to all relevant laws and regulations.</li>-->
                            <!--            <li>We will exert commercially reasonable efforts to protect you and your Authorized Users from any malicious software or security vulnerabilities. Your sole recourse -->
                            <!--                for breaches under Section 9.1(b) is outlined in Section 11.1.</li>-->
                            <!--        </ol>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        Your Commitments to Us: On behalf of your Authorized Users, you agree that:-->
                            <!--        <ol>-->
                            <!--            <li>You are responsible for the proper use of our Products.</li>-->
                            <!--            <li>You will promptly notify us of any unauthorized usage.</li>-->
                            <!--            <li>Your use of the Products will comply with the law and the terms of this Agreement.</li>-->
                            <!--            <li>The data you share with us is accurate, and you’ll update it as needed.</li>-->
                            <!--            <li>You’ll make reasonable efforts to safeguard our systems from malware and security threats.</li>-->
                            <!--            <li>You won’t attempt unauthorized access to our systems or the Products through hacking or other illicit means.</li>-->
                            <!--        </ol>-->
                            <!--    </li>-->
                            <!--    <li>Information Disclaimer: While we strive for accuracy, we cannot guarantee the completeness or reliability of the information in our Products. We present data as is, sourced from government-->
                            <!--        records. Your reliance on our Products is at your own discretion. Additionally, while we provide a platform for transactions, we are not involved in these transactions and do not assure their-->
                            <!--        safety or legality.</li>-->
                            <!--    <li>Disclaimer of Warranties: To the fullest extent permitted by law, we disclaim all warranties regarding the Products, whether express or implied, including merchantability, fitness for a-->
                            <!--        particular purpose, and accuracy. We make no guarantees regarding results or compatibility with other systems.-->
                            <!--    </li>-->
                            <!--</ul>-->
                            <!--<p>10.	Limitation of Liability: In no event shall our liability to you extend to indirect, incidental, or consequential damages. Our total liability for all causes is limited to the price paid under the-->
                            <!--    current Order Form. </p>-->
                            <!--<h3>11.	Indemnification</h3>-->
                            <!--<ul>-->
                            <!--    <li>Our Protection of You: We will defend you, your employees, officers, and directors against any third-party claims alleging that our Products infringe on their intellectual-->
                            <!--        property rights. We will cover any adverse final judgments or settlements resulting from such claims. However, we hold no responsibility for infringement caused by combining our-->
                            <!--        Products with others or for your continued use of the Products after we’ve advised against it. The remedies provided herein are exclusive for claims related to intellectual property-->
                            <!--        infringement and the warranty claims specified in Section 9.1(b).-->
                            <!--    </li>-->
                            <!--    <li>Your Protection of Us: You agree to defend, indemnify, and hold us and our affiliates harmless from any losses arising from misuse of the Product, whether authorized by you or-->
                            <!--        not. This includes fraud, legal violations, breaches of this Agreement, or disputes with other PTTR users. You will reimburse our reasonable legal fees and costs incurred in enforcing-->
                            <!--        Section 8 and its terms.-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        Process: The indemnification obligations apply if the party seeking defense or indemnity:-->
                            <!--        <ol>-->
                            <!--            <li>Provides prompt written notice of the claim.</li>-->
                            <!--            <li>Allows the other party to control the defense and settlement.</li>-->
                            <!--            <li>Cooperates reasonably (at the other party’s expense) in the defense and settlement.-->
                            <!--                Neither party will settle any claim without the other party’s written consent if it involves commitments other than monetary payments.-->
                            <!--            </li>-->
                            <!--        </ol>-->
                            <!--    </li>-->
                            <!--</ul>-->
                            <!--<p>12.	Confidentiality: You may only use our Confidential Information in connection with your use of the Products as permitted under this Agreement. You must not disclose our Confidential-->
                            <!--    Information during the Term or for five (5) years afterward. You must take reasonable measures to prevent disclosure or unauthorized use of our Confidential Information, similar to those you-->
                            <!--    use to protect your own confidential information.-->
                            <!--</p>-->
                            
                            <!--<p>13.	Transfer of Rights: You may not assign or transfer this Agreement or any of your rights and responsibilities under it without our prior written consent. Any such unauthorized-->
                            <!--    assignment or transfer will be considered void. We reserve the right to assign this Agreement without your consent under certain circumstances, such as mergers, acquisitions, or corporate reorganizations. In such cases, the assignee will assume our role-->
                            <!--    in this Agreement, releasing us from all obligations. This Agreement binds both parties and their successors and assigns, except as specified otherwise.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    14.	Entire Agreement: This Agreement, along with the referenced Policies, constitutes the entire understanding between you and us concerning its subject matter. It supersedes any-->
                            <!--    prior agreements, whether written or verbal. We do not accept any additional terms or conditions beyond those outlined in this Agreement, including any submitted by you in -->
                            <!--    various documents or processes.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    15.	Precedence: In case of any conflict between this Agreement and any attached schedule, policy, or exhibit, this Agreement takes precedence unless explicitly stated otherwise-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    16.	Force Majeure: Neither we nor our affiliates are liable for any delay or failure in fulfilling obligations under this Agreement due to circumstances beyond our reasonable control,-->
                            <!--    including natural disasters, governmental actions, or acts of terrorism.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    17.	Governing Law: This Agreement and the rights and obligations of both parties are governed by the laws of the State of Delaware, excluding the United Nations Convention for-->
                            <!--    the International Sale of Goods.-->
                            <!--</p>-->
                            <!--<ul>-->
                            <!--    <li>-->
                            <!--        Dispute Resolution: In the event of any disagreement or assertion arising from or associated with this Agreement, including breaches thereof, resolution will be-->
                            <!--        pursued through arbitration conducted by the Arbitrator in accordance with the established Rules. Any resulting judgment by the Arbitrator may be entered in a court with competent jurisdiction. The applicability of the Federal Arbitration Act-->
                            <!--        and federal arbitration laws extends to this Agreement. To initiate arbitration proceedings, it is required that a letter detailing the claim be sent to Our registered agent, (COMPANY NAME OF REGISTERED AGENT), located at (COMPANY ADDRESS-->
                            <!--        OF REGISTERED AGENT)-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        Payment and Procedure: The handling of filing, administrative, and arbitrator fees shall be guided by the Rules. You are afforded the option to conduct arbitration via-->
                            <!--        video conferencing, telecommunication, written submissions, or in-person sessions in Denver, Colorado. Both parties mutually agree that any dispute resolution proceedings will be conducted solely on an individual basis and will not involve class-->
                            <!--        actions, consolidations, or representative actions.-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        Court Proceedings: Notwithstanding the above, if a claim is pursued in court instead of arbitration, (a) both parties hereby consent and submit to the exclusive-->
                            <!--        jurisdiction of the state and federal courts of Denver County, Colorado; (b) both parties waive any entitlement to a trial by jury; and (c) both parties reserve the right to file a lawsuit in court to prevent infringement or misuse of intellectual property-->
                            <!--        rights, as delineated in Section 8.4.-->
                            <!--    </li>-->
                            <!--</ul>-->
                            <!--<p>18.	Trade Compliance: Each party pledges to adhere to all relevant import, re-import, sanctions, anti-boycott, export, and re-export control laws and regulations, including those pertinent-->
                            <!--    to U.S. entities such as the Export Administration Regulations, the International Traffic in Arms Regulations, and economic sanctions programs administered by the Office of Foreign-->
                            <!--    Assets Control. Products shall not be utilized in prohibited locations, including North Korea, Cuba, Syria, Iran, Crimea, and Donbas Regions of Ukraine. It is clarified that You bear sole-->
                            <!--    responsibility for ensuring compliance with Product usage. You affirm and guarantee that neither You nor Your Authorized Users are subject to sanctions or listed on any prohibited-->
                            <!--    or restricted parties’ registers, including but not limited to those maintained by the United Nations Security Council, the U.S. Government (e.g., the Specially Designated Nationals List-->
                            <!--    and Foreign Sanctions Evaders List of the U.S. Department of Treasury, and the Entity List of the U.S. Department of Commerce), the European Union or its Member States, or any other-->
                            <!--    relevant governmental authority-->
                            <!--</p>-->
                            <!--<p>19.	Autonomy and Binding Authority: We and You operate as independent entities under this Agreement, with no intention of establishing a partnership, joint venture, agency, or-->
                            <!--    employment affiliation. Neither Party, nor any of their associated affiliates, acts as an agent for the other, nor possesses the power to legally obligate the other.-->
                            <!--</p>-->
                            <!--<h3>20.	Notification:</h3>-->
                            <!--<ul>-->
                            <!--    <li>Regarding communication directed to You under this Agreement, We have the option to deliver notices through the following means: (a) posting notices on the-->
                            <!--        Site or Apps; or (b) transmitting messages to the email address currently linked to Your account. Notices posted on the Site or Apps become effective immediately upon posting, while email notifications become effective upon dispatch. Regardless-->
                            <!--        of actual receipt, You are considered to have received any email dispatched to the email address linked to Your account at the time of dispatch.-->
                            <!--    </li>-->
                            <!--    <li>For notifications directed to us as stipulated or allowed within this Agreement, the prescribed method involves providing written communication, adhering to the-->
                            <!--        following protocol:-->
                            <!--    </li>-->
                            <!--</ul>-->
                            <!--<div class="scrolltable">-->
                            <!--    <table class="tblcustom">-->
                            <!--        <thead>-->
                            <!--            <tr>-->
                            <!--                <td>Content</td>-->
                            <!--                <td>Method</td>-->
                            <!--            </tr>-->
                            <!--        </thead>-->
                            <!--        <tbody>-->
                            <!--            <tr>-->
                            <!--                <td>Notice of Billing Errors</td>-->
                            <!--                <td>By utilizing a nationally recognized overnight courier service, correspondence should be directed to PTTR LOADBOARD, (1850 S El Dorado St, Stockton, CA 95206), Attention: Customer Financial Services-->
                            <!--                Department. Alternatively, you may choose send the documents via email to (<a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>)</td>-->
                            <!--            </tr>-->
                            <!--            <tr>-->
                            <!--                <td>Notice of Non-Renewal</td>-->
                            <!--                <td>For month-to-month Order Forms, exclusively utilize (your link). For all other Order Forms, please send them via email to Your designated account representative.</td>-->
                            <!--            </tr>-->
                            <!--            <tr>-->
                            <!--                <td>Notice of Breach</td>-->
                            <!--                <td>You can dispatch via a nationally recognized overnight carrier to PTTR LOADBOARD, (1850 S El Dorado St, Stockton, CA 95206), Attention: Contract Administration, and additionally, you can send it via email to-->
                            <!--                (<a href="mailto:info@pttrloadboard.com">info@pttrloadboard.com</a>).</td>-->
                            <!--            </tr>-->
                            <!--            <tr>-->
                            <!--                <td>All other notices required or permitted under this-->
                            <!--                Agreement</td>-->
                            <!--                <td>By utilizing a nationally recognized overnight courier service, please address correspondence to PTTR LOADBOARD at (1850 S El Dorado St, Stockton, CA 95206), Attention: Customer Financial Services-->
                            <!--                Department. Alternatively, you may transmit through email to (1850 S El Dorado St, Stockton, CA 95206).</td>-->
                            <!--            </tr>-->
                            <!--        </tbody>-->
                            <!--    </table>-->
                            <!--</div>-->
                            <!--<p>21.	Non-Waiver:<br>-->
                            <!--    Our failure to enforce any provision of this Agreement shall not be deemed as a waiver of such-->
                            <!--    provision, nor shall it impede Our right to enforce it in the future. Any waivers by Us must be-->
                            <!--    documented in writing to be valid.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    22.	Severability:<br>-->
                            <!--    In the event that any part of this Agreement is declared invalid or unenforceable, the remaining sections shall continue to be in effect. The invalid or unenforceable portion shall be construed to reflect the-->
                            <!--    original intent of the provision as much as legally possible. If such interpretation is not feasible, the invalid or unenforceable part shall be severed from the Agreement, while the remainder shall remain-->
                            <!--    fully enforceable.-->
                            <!--</p>-->
                            <!--<p>-->
                            <!--    23.	Survival:Section 8.1(a) shall persist and be effective for a period of three (3) years following the termination or expiration of this Agreement. All other provisions in Section 8, as well as Sections 7, 10, 11.2, 12, 13.5,-->
                            <!--    13.6, 13.7, and 13.9, along with any other provision necessary for the fulfillment of its purpose, shall survive the expiration or termination of this Agreement. However, all other provisions of this Agreement-->
                            <!--    shall not survive its expiration or earlier termination.-->
                            <!--</p>-->
                            <!--<p><strong>Definitions:</strong></p>-->
                            <!--<ul>-->
                            <!--    <li>Apps refer to downloadable software, encompassing mobile device applications.</li>-->
                            <!--    <li>Arbitrator denotes a singular arbitrator affiliated with the Judicial Arbiter Group, Inc., located at 1601 Blake St #400, Denver, CO 80202.</li>-->
                            <!--    <li>Authorized Users encompass, and shall be restricted to, Your employees, agents, and contractors (for whom You have remitted all pertinent fees for Product-->
                            <!--    usage), who have received initial usernames and passwords from Us regarding the Product. Where applicable, the quantity of Authorized Users for a particular Product may be -->
                            <!--    outlined in the relevant Order Form.</li>-->
                            <!--    <li>Confidential Information encompasses all nonpublic information disclosed by Us, Our affiliates, business associates, or Our or their respective employees,-->
                            <!--    contractors, or agents, which is classified as confidential or should reasonably be acknowledged as such, given the nature of the information or the circumstances surrounding its disclosure. Our Confidential Information includes: (a) nonpublic-->
                            <!--    information concerning Us or Our affiliates or business associates’ technology, customers, business strategies, promotional and marketing activities, financial status, and other business operations; (b) third-party information that We are-->
                            <!--    obligated to maintain as confidential; and (c) the Product Data. Our Confidential Information excludes any information that: (i) becomes publicly accessible without violating this Agreement; (ii) can be demonstrated, through documentation, to have-->
                            <!--    been already known to You at the time of receipt from Us; (iii) is received from a third party who did not acquire or disclose it through wrongful or tortious means; or-->
                            <!--    (iv) can be evidenced, through documentation, to have been independently developed by You without reference to Our Confidential Information.</li>-->
                            
                            <!--    <li>Contact Data comprises company name, company mailing address, company email address, company telephone number, and Department of Transportation data.</li>-->
                            <!--    <li>Losses encompass any assertions, damages, losses, liabilities, expenses, and costs (including reasonable legal fees).</li>-->
                            <!--    <li>Order Form pertains to either the (a) ordering document or (b) ordering webpage prepared by Us and executed or click-accepted by You, which delineates-->
                            <!--    the Products, number of Authorized Users (unless unrestricted), pricing, renewal terms, and subscription duration.</li>-->
                            <!--    <li>Products embody the Site, software, and documentation as detailed in Order Forms, Statement(s) of Work, and Our support for those items made accessible-->
                            <!--    through the Site or Apps.</li>-->
                            <!--    <li>Product Data signifies all data dispensed on a non-exclusive basis by Us to You via the Products, comprising but not limited to usage data, statistics, and-->
                            <!--    aggregated and deidentified Shared Data.</li>-->
                            <!--    <li>Policies encompass the Acceptable Use Policy and the Privacy Policy, both subject to periodic amendments.</li>-->
                            <!--    <li>Rules denote the Commercial Arbitration Rules promulgated by the American Arbitration Association.</li>-->
                            <!--    <li>Site refers to pttrloadboard.com and its subsidiary directories</li>-->
                            <!--    <li>Shared Data encompasses any data and information uploaded, transmitted, or submitted to Us by You or Your Authorized Users, including Contact Data but-->
                            <!--    expressly excluding Personal Data as defined in the Privacy Policy.</li>-->
                            <!--    <li>Suggestions denote all suggested enhancements to the Products furnished by You to Us.</li>-->
                            <!--</ul>-->
                            
                            <p>Welcome to PTTR Loadboards! Now before you get to using our load board services (hereafter referred to as “PTTR,” “Us,” “Our,” or the “Company), you (hereafter collectively referred to as “Customer,” “You,” or “Users”) agree to follow and accept these Terms and Conditions. </p>
                            <p>We request you to please read these terms and conditions carefully. After reviewing, if You do not agree with any section or point mentioned in the Terms and Conditions, please severely refrain from using Our website and products. </p>
                            
                            <h3>1.	Acceptance of Terms</h3>
                            <p>By being on our website and Platform, and subsequently using it, Users confirm that they have read, and completely understood the contents; as a result have accepted these Terms, along with our Privacy Policy. Note: These terms are fully applicable to all Users, including carriers, brokers, shippers, and others who access or use the Platform.</p>
                            <h3>2.	Definitions</h3>
                            <p>For the purposes of these Terms and Conditions, the following definitions apply:</p>
                            <ul>
                                <li>Load Board: Connects brokers and carriers for posting and booking loads.</li>
                                <li>Tracking: Offers real-time shipment location and status updates.</li>
                                <li>PTTR Map: Mapping tool designed for route optimization.</li>
                                <li>Nearby Feature: Suggests nearby services like fuel stations and repair shops.</li>
                                <li>Instant Invoicing: Allows carriers to generate and manage invoices post-delivery.</li>
                                <li>MCI (Market Condition Index): is a metric that analyzes freight market supply and demand while forecasting future trends.</li>
                                <li>Advertising: Enables targeted ad placements for small businesses.</li>
                                <li>Mobile Apps: Full platform access via iOS and Android.</li>
                            </ul>
                            <h3>3.	Use of Platform</h3>
                            <p>You can access and use our Platform/Dashboard in accordance with this Agreement. To access our Platform, you must have an account with Us. For that, Users must provide a valid email address. You are allowed to create one account per email address. </p>
                            <p>By signing up with PTTR Loadboard, you authorize the Company to include your personal data, such as contact information, in Our directory. </p>
                            <h3>4.	Eligibility</h3>
                            <p>The age requirement to use our Platform is at least 16. By registering with Us, you will first of all have to accept the Terms and Conditions, and for that You confirm that You meet or have already met this age requirement and are legally allowed and able to enter into this Agreement. </p>
                            <h3>5.	Changes to our Platform </h3>
                            <p>We reserve the right to make changes whenever we deem it necessary and might make modifications to the website and PTTR Dashboard when required. This includes issuing enhancements, modifications, deploying new versions, or making changes to the format. The content on our website, which includes information, graphics, products, features, and links, may be changed, updated, or removed. We may also provide You with one month’s prior notice if the Company decides to discontinue any service. However, notice may not be served if:</p>
                            <ol>
                                <li>There is a security or intellectual property threat to Us.</li>
                                <li>The service is economically burdensome.</li>
                            </ol>
                            <h3>6.	Payments </h3>
                            <p><strong>6.1 Fees</strong> When pressing the “I Accept” button, you will be agreeing to pay all the fees within the time period of five (5) days of receiving the invoice. </p>
                            <p><strong>6.2 Refunds:</strong> PTTR Loadboard will offer refunds to its customers in the case of billing errors, double charges, or service outages. </p>
                            <p><strong>6.3 Interruptions and Cancellations:</strong> If our customers face any interruption in services for reasons within the Company’s control PTTR loadboard will on first basis look for a resolution, if not possible immediately the company will take responsibility and be liable to refund the specific amount. Upon intentional cancellation the customer will not be liable for a refund. </p>
                            <p><strong>6.4 Disputing Invoices:</strong> If a User finds or comes across any error in the invoice, they must notify the Company. The notification must be in writing, having been in clear words and should be submitted within thirty (30) days of the invoice date.</p>
                            <p><strong>6.6 User Responsibilities:</strong> PTTR Load Board outlines clear responsibilities for each user group to maintain platform integrity and transparency. Carriers must offer accurate, real-time shipment tracking and adhere to industry standards for safety, licensing, and insurance. Brokers are required to provide complete and accurate load details, including dimensions, weight, and delivery deadlines, and must also manage payment commitments and resolve disputes with carriers independently. Advertisers are responsible for ensuring compliance with advertising standards, avoiding misleading content, and meeting all legal requirements.</p>
                            <p><strong>6.7: Advertising Standards:</strong> PTTR Load Board enforces advertising standards to ensure that ads meet legal and ethical guidelines. PTTR reserves the right to remove ads that violate these standards or contain offensive content, maintaining a professional environment for all users.</p>
                            <p><strong>6.8: Updates to Terms:</strong> PTTR Load Board may update its terms and policies, providing prior notice (typically 30 days) for significant changes. Continued use of the platform after updates implies the user’s acceptance of these revised terms, ensuring transparency and user awareness of any modifications.</p>
                            <p><strong>Payments and Refunds:</strong> Subscription fees on PTTR Load Board are billed as per the agreed cycle, either monthly or annually. Late payments may lead to temporary suspension of services, emphasizing the need for timely payment. Generally, subscription fees are non-refundable; however, exceptions may be made in cases of billing errors or platform malfunctions.</p>
                            <h3>7.	Privacy and Data Protection</h3>
                            <p><strong>7.1 Data Collection:</strong> PTTR Loadboards collects and processes personal data from its Users. This includes all such information that is contact details, load details, and payment information.</p>
                            <p><strong>7.2 Data Security:</strong> Your privacy and security matter the most to us. This is why we go to lengths to implement vigorous security measures to protect your personal data. </p>
                            <p><strong>7.3 Privacy Policy:</strong> For more information on how your personal data is collected, used, and protected, please review our Privacy Policy (which may be changed from time to time.)</p>
                            <h3>8.	Terms of Termination </h3>
                            <p><strong>8.1 By You:</strong> As a customer or client, you can terminate your account at any given time by notifying or even alerting PTTR Loadboard. However, the termination will not provide you any exemption from payment obligations and responsibilities that were incurred before termination. </p>
                            <p><strong>8.2 By PTTR Loadboard:</strong> The Company has the right to suspend and also terminate access of Users at any given time, with or without any notice. </p>
                            <p><strong>8.3 Term Length:</strong> The agreement begins on the date on which the Users signs it and will continue until it is expired. </p>
                            <p><strong>8.4 Warning and Notice Procedure:</strong> Users will receive a warning notice for violations before the termination of accounts. The warning will include written details about the violation and necessary corrective action. </p>
                            <p>In case Users are found engaging in fraudulent activities, their account will be immediately terminated without warning, and they may also face legal action.</p>
                            <p>8.5 Grounds for Immediate Termination</p>
                            <ol>
                                <li>Breach of Agreement: If either party, i.e., Company and Customer, breaches the agreement and fails to find a common ground or solution within (7) days of written notice after receipt.</li>
                                <li>Involvement in Fraudulent Activities: If Users (carriers and brokers) are involved in fraudulent activities mentioned in Sections 13, 14, and 15. </li>
                                <li>Failure to Meet Payment Terms: Users' accounts will be terminated if they don't fulfill the payment requirements outlined in Section 6.</li>
                                <li>Inaccurate Information: Providing false, inaccurate, or misleading information will lead to account being terminated.  </li>
                            </ol>
                            <p><strong>8.6 Prohibited Activities:</strong> PTTR Load Board maintains strict rules against activities that may compromise platform integrity. This includes double brokering, posting fraudulent load details, misusing tracking data, introducing malware or bots, and scraping data such as PTTR Map or MCI information. These restrictions are in place to protect users and maintain a secure environment.</p>
                            <p><strong>Liability Disclaimer:</strong> PTTR Load Board limits its liability for indirect damages, including lost profits, revenue, or freight damages caused by user actions. Services are provided on an “as is” basis, without guarantees on uninterrupted functionality. Users should manage their operations with an understanding of these limitations.</p>
                            <p><strong>Termination Policies:</strong> PTTR reserves the right to suspend or terminate accounts under specific conditions, including non-payment of fees, repeated violations of platform terms, and breaches of advertising or data-use policies. This ensures that users adhere to platform standards and supports a trustworthy community.</p>
                            <p><strong>Dispute Resolution:</strong> All disputes are resolved through arbitration. PTTR remains neutral and makes the binding decision. Users also agree to independently resolve conflicts with other users, such as those between brokers and carriers, with PTTR acting solely as a platform to connect parties.</p>
                            <p><strong>8.7 Effect of Termination:</strong> When the agreement is terminated, the access of Users will immediately expire. However, even in this case, you will not be exempt from any payment made before termination.</p>
                            <h3>9. Services and Membership Plans by PTTR Loadboard </h3>
                            <p><strong>9.1 Service Scope:</strong> Our Company provides a digital platform that helps shippers, carriers, and also brokers to connect in a single place. Our outstanding services include real-time tracking, and invoicing.</p>
                            <p><strong>9.2 Membership Plans:</strong> PTTR Loadboard also offers a vast number of membership plans with unique and various features. Each membership plan is governed by these Terms that are quite openly laid out for you. PTTR Loadboard even has the right to change, end, or update the membership plans at any given time. To learn more about our membership and fees, visit <a href="https://pttrloadboard.com/" title="">https://pttrloadboard.com/</a></p>
                            <p><strong>9.3 Fees and Payment:</strong> By accepting these Terms, every Customer agrees to pay all applicable fees as outlined at the time of signing up. Fees are non-refundable, except as required by applicable law. </p>
                            <h3>10.	Responsibilities of Users</h3>
                            <p><strong>10.1 Accuracy of Information:</strong> All Customers have the duty to provide accurate and complete and true information. This includes load details, shipping requirements, and carrier qualifications.</p>
                            <p><strong>10.2 Compliance with Laws and Regulations:</strong> All Customers have to anyhow agree to comply with any and all applicable local, state, federal, and international laws governing transportation, and freight logistics, and vehicle operations. </p>
                            <p>This includes having valid licenses, insurance, permits, and complying with environmental, safety, and operational standards.</p>
                            <p><strong>10.3 Insurance and Licensing:</strong> If You are signing up as a carrier, you must have appropriate commercial insurance and licenses as required by law. This is to ensure the safety and legal compliance of the vehicles that are used for transportation.</p>
                            
                            <h3>11.	User Insurance Requirement </h3>
                            <p>Users who are signing up as carriers are required to maintain appropriate insurance coverage. Carriers must maintain the following coverage: </p>
                            <ul>
                                <li>General Liability Insurance: This insurance must have at least $() coverage for each incident and $() total. It protects against injuries to people, damage to property, and other liabilities that may arise from the business operations of the carrier.</li>
                                <li>Cargo Insurance: A minimum of $() coverage is needed to protect goods. This insurance ensures that the carrier can compensate for any lost, missing, or damaged items during transportation.</li>
                                <li>Automobile Liability Insurance: This requires at least $() in coverage. This insurance protects against costs from injuries and damage to property in case of an accident involving the carrier's vehicle while transporting goods. </li>
                                <li>Workers' Compensation Insurance (if applicable): This insurance is only applicable if the carrier hires employees, such as drivers or warehouse workers. Carriers must obtain workers' compensation insurance as required by law. This insurance covers injuries that occurred during work.</li>
                            </ul>
                            <p><strong>11.1 Proof of Insurance:</strong> Upon registering with PTTR Load boards, Users who are signing up as carriers are required to submit proof of their insurance. This includes insurance certificates and policy declarations from a licensed insurance provider. </p>
                            <p><strong>11.2 Penalties for Non-Compliances:</strong> user who does not maintain the necessary coverage or produce proof to PTTR Loadboard shall be subject to:</p>
                            <ol class="alphalist">
                                <li><strong>Account Suspension:</strong> Until the required insurance is presented to the PTTR Loadboard, the carriers' access to the PTTR Loadboard Platform will be blocked.</li>
                                <li><strong>Termination:</strong> If the noncompliance persists, PTTR Loadboard has the right to permanently remove the carrier's access to the platform.</li>
                                <li><strong>Liable for Damages:</strong> If the necessary and important insurance is not kept up to date, the carrier will be responsible for any losses or damages.</li>
                            </ol>
                            <p><strong>11.3 Notify PTTR Loadboard of Changes in Insurance Coverage:</strong> It is the responsibility of the carrier to notify the Company immediately if any changes are made to their insurance coverage. 
                                This includes reductions, modifications, and cancellations. Carriers must maintain valid insurance coverage at all times while using PTTR Loadboard’s Platform. </p>
                            <h3>12.	Load Posting and Booking</h3>
                            <p><strong>12.1 Load Posting by Broker:</strong> If you’re signing up as a Broker, you are advised to add your loads so carriers can see them without trouble on the PTTR Loadboard. This includes: </p>
                            <ol class="alphalist">
                                <li>Load Description</li>
                                <li>Destination</li>
                                <li>Weight</li>
                                <li>Dimensions</li>
                                <li>Pickup/Delivery times</li>
                            </ol>
                            <p><strong>12.2 Load Booking by Carriers:</strong> Carriers can browse any sort of posted loads and accept loads that match their requirements. Once a load is accepted by a carrier, both parties are bound by the 
                                terms of the booking, including payment, delivery, and performance requirements.</p>
                            <p><strong>12.3 Booking Confirmation:</strong> All load bookings are subject to confirmation. Both parties must confirm their agreement to the terms of the booking.</p>
                            <h3>13.	Prohibited Activities</h3>
                            <p>Upon signing and accepting the Terms and Conditions, You firmly agree that You will not and won't even attempt to engage in any of the following activities or these actions mentioned below: </p>
                            <p><strong>13.1 Fraudulent Activity:</strong> You will not post anything false, or incomplete, and even misleading information about loads, carriers, or services that could needlessly raise unwarranted questions about our business.</p>
                            <p><strong>13.2 Illegal Activity:</strong> Users can not use PTTR Loadboards to engage in illegal activities. This includes transporting illegal goods or violating transportation laws. </p>
                            <p><strong>13.3 Violating Intellectual Property:</strong> You cannot steal or even have an intent regarding stealing or robbing the intellectual property rights of others. This includes unauthorized use of trademarks, logos, or proprietary content.</p>
                            <p><strong>13.4 Harassment or Abuse:</strong> Users cannot harass, abuse, use harmful language, or threaten others on the platform or through this platform elsewhere.</p>
                            <p><strong>13.5 Disruption:</strong> Users can not intentionally or even unintentionally so to say disrupt or interfere with the proper functioning of the PTTR Loadboard's platform. This includes introducing viruses or malware.</p>
                            <p><strong>13.6 Bypassing Security Features:</strong> PTTR Loadboard strictly prohibits Users from engaging in activities such as unauthorized access or manipulating account details.  </p>
                            <p><strong>13.7 Misuse of PTTR Loadboard’s Data:</strong> Users should not scrape and even export PTTR Loadboard's data. </p>
                            
                            <h3>14.	Double Brokering Protection</h3>
                            <p>PTTR Loadboard prohibits users from engaging in or practicing double brokering in order to preserve the integrity of Our platform. The act of brokering a load without the original shipper's or carrier's consent (authorization) is known as double brokering.</p>
                            <p><strong>14.1 Penalties for Violating Double Brokering Rule:</strong> Any User that is found to be involved in double brokering will face a number of penalties that will result in quite a lot of trouble, some of them are:</p>
                            <ol class="alphalist">
                                <li>PTTR Loadboard can impose monetary fines </li>
                                <li>Immediate termination and suspension of account</li>
                                <li>Possible legal action</li>
                            </ol>
                            <p><strong>14.2 Detection and Monitoring:</strong> PTTR Loadboard actively monitors all load transactions—without any rest. This includes reviewing histories of transactions, communication logs, and other relevant data. This monitoring helps PTTR to detect and prevent double-brokering. </p>
                            <p><strong>14.3 Reporting Violations:</strong> PTTR Loadboard encourages its Customers to come forward and report if they suspect or come across any unauthorized activity or double brokering on the PTTR Loadboard Platform. All reports will be investigated thoroughly. </p>
                            
                            <h3>15.	Restrictions on Competitive Use</h3>
                            <p>Once the User provides full payment for access to the Products, the Company will grant You a royalty-free, term-limited, non-exclusive, non-transferable, non-assignable, non-sublicensable license to use the Company’s Products or Platform. </p>
                            <p><strong>User’s Promise:</strong> Users may only use the products and product data for internal operations and are restricted from creating, selling, or offering products or services that compete with the PTTR Loadboard. You can also not compete with the Company in other ways like: </p>
                            <ol class="alphalist">
                                <li>Combining the Company’s data with data from other brokers.</li>
                                <li>Double-brokering freight or trucks.</li>
                                <li>Sharing the Company’s data with other freight matching or load board services.</li>
                                <li>Use the Company’s data, including rates, to develop a competing pricing or lane rate product.</li>
                                <li>Double-brokering freights.</li>
                            </ol>
                            <h3>16.	Dispute Resolution </h3>
                            <p>The dispute resolution process applies to all the disputes that may happen between Users (i.e., carriers and brokers) and between Users and PTTR Loadboard, including but not limited to disagreements over payment terms, service issues, or use of the platform </p>
                            <h4>16.1 Resolution Process:</h4>
                            <p><strong>Mediation:</strong> If any dispute arises, the involved parties agree to attempt to find a resolution through good-faith negotiation. If Users fail to reach an agreement, the parties agree to submit to mediation to a third party that will act as a neutral mediator. The mediation will be conducted online or in a mutually agreed location.</p> 
                            <p><strong>Arbitration:</strong> If the dispute between Users or Users and the Company remains unsolved for thirty (30) days, the matter shall be moved to arbitration. This process shall be governed by the rules of the American Arbitration Association, as agreed upon by the parties. By accepting all these Terms and Conditions, Users agree that the arbitrator(s) will solely have the authority to make binding decisions related to the dispute.</p> 
                            <p>The arbitrator will issue a decision in written, which will be final, and all parties will be forced to follow it. </p>
                            <p><strong>16.2 Cost:</strong> Each party shall bear its own costs and expenses for the arbitration process. This will include but is not limited to attorney’s fees, witness fees, and other related costs. The cost of arbitration and mediation will be shared equally by all the parties involved. </p>
                            <h3>17.	Confidentiality </h3>
                            <p>Users can use our confidential information only when needed to use the Company’s platform. The phrase "Confidential Information" describes any private or non-public information that Users communicate or that the platform provides. This includes, but is not limited to, business plans, user information, and transaction details.</p>
                            <p><strong>User Responsibilities:</strong> When clicking on the “I Accept” Button of Terms and Conditions, it signifies that Users agree to protect and not share confidential information during the term of this agreement. Users must take reasonable steps to prevent any disclosure and must also be highly cautious not to share or give away unauthorized use of our confidential information. Users must: </p>
                            <ol class="alphalist">
                                <li>Do not disclose any information without explicit written consent from PTTR Loadboard. </li>
                                <li>Use and implement encryption methods such as TLS for data transit and to protect confidential information when storing or transmitting it electronically. </li>
                                <li>Users (both Brokers and Carriers) have to sign a Non-Disclosure Agreement (NDA) with PTTR Loadboard. This is to protect highly sensitive information. </li>
                            </ol>
                            <h3>18.	Warranty Disclaimer</h3>
                            <p>As allowed by the law and upon implicit permission, PTTR Loadboard operates without any guarantee. This means that our Company does not make any promises about the products, quality, accuracy, and completeness or how well they meet your specific requirements—since all requirements are subjective. </p>
                            <p>Our Company does not guarantee that products will produce specific results or function effectively in combination with other components or as part of an integrated system.</p>
                            <h3>19.	Limitation of Liability</h3>
                            <p>PTTR Loadboard is not responsible for any indirect or special damages, such as lost profits, revenue, customers, opportunities, goodwill, data, or similar losses, even if we were made aware of these potential losses. </p>
                            <p><strong>19.1 Freight-Specific Risks:</strong> Any problems associated with freight are not the responsibility of the PTTR Loadboard. This includes: </p>
                            <ol class="alphalist">
                                <li>Cargo Loss</li>
                                <li>Damage </li>
                                <li>Delays </li>
                                <li>Misinterpretation by Users</li>
                            </ol>
                            <p>By accepting all these Terms and Conditions, Users agree to take full responsibility for these risks. Without agreeing, you should not even try to be on-board.</p>
                            <p><strong>19.2 Maximum Liability:</strong> In any situation, PTTR Loadboard’s total liability will not exceed the amount the User actually paid for the order in question. This limitation is fully applicable 
                                regardless of the cause or nature of the claim. </p>
                            <h4>Indemnification</h4>
                            <p><strong>20.1 Our Protection for Users:</strong> PTTR Loadboard will defend its Users, their employees, officers, and directors against any claims from third parties saying that Our products infringe on their intellectual property. However, we are not responsible if the claim arises from combining our products with other products, services, or software, as mentioned in Section 13. If the user still continues to use the items after being told or instructed to stop using them, our company will not be held liable for any damages that may occur. </p>
                            <p><strong>20.2 Users Indemnification of Us:</strong> By clicking the "I Accept" button, Users agree to defend, indemnify, and hold Us safe from any losses that come because of any misuse of our products – by You or your authorized Users. This includes any fraud, law violations, misconduct, breaches of this agreement, or disputes you may have with other users.</p>
                            <h3>20.	Intellectual Property Rights</h3>
                            <p>Every kind of content and material, including images, text, graphics, logo, and software, are the property of PTTR Loadboard. Users are strictly and severely prohibited from reproducing, creating, or modifying derivative works from the content.</p>
                            <p><strong>21.1 Penalties of Intellectual Property Rights:</strong> In case of Users breach, violate, or steal any of PTTR Loadboard’s intellectual property, they will be subjected to penalties, such as: </p>
                            <ol class="alphalist">
                                <li>Account suspension: If users are found violating these rights, PTTR Loadboard has the right to suspend User's access to the platform immediately.</li>
                                <li>Termination of Account: If the violation by the User is dangerous or severe, the Company has the right to pause, or suspend or permanently terminate the User's account. </li>
                                <li>Legal Action: PTTR Loadboard has the right to pursue legal action. This includes seeking monetary damages and injunctive relief available under applicable law.</li>
                            </ol>
                            <h3>21.	Monitoring and Compliance </h3>
                            <p>PTTR Loadboard has the right to monitor what its Users are doing on the platform. This is to ensure that every user abides by the terms and conditions. The company uses technologies like AI-based fraud detection systems to identify any suspicious or non-compliant behavior from Users. </p>
                            <p>If suspicious activity is detected, such as fraudulent transactions or violation of platform rules or activities mentioned in Sections 13, 14, and 15, PTTR Loadboard has the right to take necessary steps such as: </p>
                            <ol class="alphalist">
                                <li>Immediate Termination: The company has the right to instantly terminate the user's account if the behavior is serious and causing harm to the PTTR Loadboard. </li>
                                <li>Suspension: Temporarily denying the user access while the inquiry is being conducted.</li>
                                <li>Increased Monitoring: Until the problem is fixed, user activity—including login attempts, data exports, and transaction patterns—will be continuously monitored. </li>
                                <li>Account Audit: In order to detect and identify any questionable or malevolent activities, the company will do a thorough audit of the user's account activity. </li>
                                <li>Apply Fines and Penalties: Users who are found to be breaching the terms and conditions and endangering both PTTR Loadboard and other users may be subject to fines and legal penalties from PTTR Loadboard.</li>
                            </ol>
                            <h3>22.	Notices</h3>
                            <p>PTTR Loadboard will notify its Users in two ways:</p>
                            <ol class="alphalist">
                                <li>By posting a notice on the website.  </li>
                                <li>By emailing the notice.</li>
                            </ol>
                            <p>Both notices are deemed effective as soon as they are posted or emailed, regardless of whether you see or receive them. </p>
                            <p>If Users wish to send a notice to our company, it must be submitted in writing and emailed to Us at (<a href="mailto:info@pttrloadboard.com" title="">info@pttrloadboard.com</a>).</p>
                            <h3>23.	Force Majeure</h3>
                            <p>PTTR Loadboard shall not be liable for any delays or failure to fulfill our obligations under this agreement if such delays or failures are caused by events beyond Our control. These events include, but are not limited to, natural disasters, labor disputes, power outages, telecommunications failures, severe weather conditions, blockades, governmental restrictions, civil unrest, terrorism, or acts of war.</p>
                            <h3>24.	Modifications to Terms and Platform</h3>
                            <p>PTTR Loadboard has the right to modify these Terms at any time without prior notice. Any changes shall take effect immediately upon their publication. The customer’s ongoing use of the website and products signifies acceptance of the revised Terms.</p>

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
