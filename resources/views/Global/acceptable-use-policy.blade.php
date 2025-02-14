@extends('layouts.app')
@section('content')
    @if(!auth()->check())
    <div class="col-md-1">
    </div>
    @endif
    <div class="col-md-10">
        <div class="mainBody">
            <div class="main-header globalcustom">
                <h2>Acceptable Use Policy</h2>
                @if(!auth()->check())
                    <a class="themeBtn" href="{{route('login')}}" title="">Back to Login</a>
                @endif
            </div>
            <div class="contBody helpcenterPg">
                <div class="row">
                    <div class="col-md-12">  
                        <div class="Content">
                            <h3>Acceptable Use Policy</h3>
                            <p>This document outlines the guidelines for the use of the Products, the App, the APIs, and the Site collectively referred to as the “Platform,” provided by PTTR LOADBOARD and its affiliates, hereinafter referred to as “PTTR”,”PTTR LOADBOARD”, “We,” “Us,” or “Our.” Any modifications to this Policy will be posted on the Site, and by accessing the Platform, you agree to abide by the latest version of this Policy. Failure to agree with this Policy implies refraining from accessing or utilizing the Platform.</p>
                            <h3>Prohibited Actions</h3>
                            <p>Users are prohibited from engaging in or facilitating the following activities on the Platform:</p>
                            <ol>
                            <li>Violation of Laws and Export Controls: Any actions that contravene federal, state, or local laws, including regulations related to data or software exportation, and laws pertaining to the sale or transportation of illegal substances, are strictly forbidden.</li>
                            <li>Harm to Minors: Users must not engage in any behavior that may harm minors, such as exposing them to inappropriate content or soliciting personally identifiable information.</li>
                            <li>Spamming: Transmitting unsolicited advertising materials, including junk mail or chain letters, is not permitted. Additionally, posting load information in bad faith is prohibited.</li>
                            <li>Repetitive Posting: Users must refrain from repeatedly posting load information in a manner that seeks to manipulate the Platform.</li>
                            <li>Impersonation: Any attempts to impersonate PTTR or PTTR LOADBOARD, its employees, or other users are strictly prohibited.</li>
                            <li>Providing False Information: Users must provide accurate and complete information about themselves and their companies.</li>
                            <li>Double Brokering: Acting as an intermediary in a freight transaction without proper authorization from the relevant parties is forbidden.</li>
                            <li>Failure to Pay: Users must not withhold payment from carriers without valid justification.</li>
                            <li>Lack of U.S. and Canada Presence: Companies must maintain a physical presence and a valid address withinUnited States and Canada.</li>
                            <li>Sharing of Credentials: Users are not allowed to share their login credentials with unauthorized individuals.</li>
                            </ol>
                            <h3>Content Guidelines</h3>
                            <p>When using the Platform, you agree not to transmit, upload, receive, download, use, or re-use any material that:</p>
                            <ol>
                            <li>Contains defamatory, obscene, indecent, abusive, offensive, harassing, violent, hateful, or inflammatory content.</li>
                            <li>Promotes sexually explicit or pornographic material, violence, or discrimination based on race, sex, religion, nationality, disability, sexual orientation, or age.</li>
                            <li>Infringes upon the patent, trademark, trade secret, copyright, or any other intellectual property rights of any other person.</li>
                            <li>Is likely to deceive any individual.</li>
                            <li>Promotes illegal activities, or encourages, advocates, or aids in unlawful acts.</li>
                            <li>Impersonates any person or falsely represents your identity or association with any individual or organization.</li>
                            </ol>
                            <h3>Monitoring and Enforcement</h3>
                            <p>We reserve the right to monitor your Platform usage to ensure compliance. If we determine that your conduct violates this Policy, poses a threat to the personal safety of Platform users or the public, or could result in liability for us, we may take appropriate action at our discretion. This may involve legal action or referral of violations to law enforcement. We may withhold details and methods of our investigations and have the authority to suspend or terminate your access to part or all of the Platform for Policy violations.</p>
                            <p>Utilizing alternative corporate entities to evade Policy compliance constitutes a violation, and we reserve the right to remove affiliated parties found to be non-compliant at our discretion.</p>
                            <p>Notwithstanding any confidentiality agreements between you and us, we retain the right to cooperate fully with law enforcement authorities seeking disclosure of the identity or other information pertaining to any individual using the Network.</p>
                            <p>In addition, we comply with court orders and administrative directives in accordance with valid bankruptcy proceedings.</p>
                            <h3>Reporting Violations</h3>
                            <p>To report Policy violations, please send an email to (Your Compliance Email). We investigate all reports received in their entirety.</p>
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
