@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <div class="main-header">
                <h2>Support</h2>
            </div>
            <div class="contBody helpcenterPg">
                <div class="row">
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-03.jpg')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-03.jpg')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-03.jpg')}}" alt=""></a>
                        </div>
                    </div>
                </div>
                <!--<div class="topSearchBox mt-3">-->
                <!--    <h2>How Can We Help?</h2>-->
                <!--    <div class="searchforms_mm">-->
                <!--        <input type="text" placeholder="Ask your question here">-->
                <!--        <button><i class="far fa-search"></i></button>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="content">
                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <h3>Welcome to PTTR Support</h3>
                            <p>PTTR stands as the single source for all things freight, revolutionizing the logistics industry with cutting-edge technology and a robust network. Our platform is 
                            designed to provide seamless access to the industry's largest and most trusted network of carriers, shippers, and freight professionals.</p>
                            <p>PTTR offers an all-in-one integrated platform that consolidates various logistics services, enabling you to manage your business operations efficiently and effectively. 
                            Leveraging the latest advancements in technology, PTTR provides real-time updates, ensuring you stay ahead of the curve in an ever-evolving industry. With our streamlined 
                            processes, you can run your business with unparalleled speed and reliability. Our platform is designed to enhance productivity, allowing you to focus on what matters 
                            most—growing your business.</p>
                            <p>Whether you are a carrier looking for loads or a shipper needing transportation, PTTR has everything you need to facilitate your logistics operations. Our extensive network 
                            connects you to reputable partners, ensuring your freight is handled with care and professionalism</p>
                        </div>
                    </div>
                    <p class="boxs-para">Experience the difference with PTTR and elevate your freight management to new heights. For more information, visit our website at 
                    <a href="https://pttrloadboard.com/" target="_blank" title="">PTTR Load Board.</a> You can reach us by phone at <a href="tel:+1 (888) 706-7013" title="">+1 (888) 706-7013</a> or via email at 
                    <a href="mailto:info@pttrloadboard.com" title="">info@pttrloadboard.com</a> If you need further assistance or live support, feel free to jump on our website to speak with a representative available 24/7.</p>
                    <p>Join PTTR today and discover how our innovative solutions can streamline your freight operations and drive success for your business!</p>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="tags">
                                
                                @if(auth()->user()->type == "trucker")
                                    <a href="https://pttrloadboard.com/startup-guides/#carrierstabs" target="_blank" title="">Start up guide for Carrier</a>
                                @elseif(auth()->user()->type == "broker")
                                     <a href="https://pttrloadboard.com/startup-guides/#brokerstabs" target="_blank" title="">Start up guide for broker</a>
                                     <a href="https://pttrloadboard.com/startup-guides/#videotabs" target="_blank" title="">Training videos for brokers</a>
                                @else
                                    <a href="https://pttrloadboard.com/startup-guides/#carrierstabs" target="_blank" title="">Start up guide for Carrier</a>
                                    <a href="https://pttrloadboard.com/startup-guides/#brokerstabs" target="_blank" title="">Start up guide for broker</a>
                                    <a href="https://pttrloadboard.com/startup-guides/#videotabs" target="_blank" title="">Training videos for brokers</a>
                                @endif
                                
                                <a href="https://pttrloadboard.com/startup-guides/#allBlogs" target="_blank" title="">Learn about PTTR BLOGS</a>
                                
                            </div>
                            <!--<div class="row">-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>PTTR Mobile</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    PTTR Mobile - Quick start guide-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    PTTR Mobile- Load board Overview-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Training videos for PTTR Mobile-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Dashboard & Tools</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Broker Dashboard-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Carrier Dashboard-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    PTTR Tools Menu-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>My Shipments</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Bid activity-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Find matching trucks to my shipment/load-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Manage your shipments-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Private Loads</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    How do I book private loads-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    How do I opt out of Priority Booking emails-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    If I am not a customer how will I see private loads sent to-->
                            <!--                    meet?-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Account & Billing</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Account management-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Customer Support - contact us-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Invoice nigher than subscription tee-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>My Loads</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Filter saved loads-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    How to use load activity performance metrics-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    save a load-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Private Network</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Add a contact to Private Network-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    confirm a carrier Is a DAl customer-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Export a Private Network-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Search Loads</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Enable an alarm on a search-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Prefer / Block an office-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Show similar results-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Search Trucks</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Create a shipment posting from a truck-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Search for trucks-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Hide postings with 'Anywhere' as a destination-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Tracking</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Video] Create a tracking request-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Can I see ETA's for shipments being tracked?-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Can I send a tracking request to a Canadian phone number?-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Company Search</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Company Search Overview-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>PTTR Directory</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Change company and contact information in the PTTR directory-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Collecting payment from broker or shipper-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Double brokering-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>My Trucks</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Add notes-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Create a search from your posting-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Deleting a truck posting-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Resources</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Benefits of multi-factor authentication (MFA)-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Best practices tor internet security brokers.-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Finding customers (shippers)-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--        <div class="Boxhelp">-->
                            <!--            <h3>Troubleshooting</h3>-->
                            <!--            <div class="contentdv">-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    'We could not process your request' error on login-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    [Internal] Incorrect Trip Miles-->
                            <!--                </a>-->
                            <!--                <a href="javascript:;" title="">-->
                            <!--                    Alarm not sounding on Safari Mac OS-->
                            <!--                </a>-->
                            <!--                <a class="simpleLinks" href="javascript:;" title="">-->
                            <!--                    See All Articles-->
                            <!--                </a>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->

                            <!--</div>-->
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-02.jpg')}}" alt=""></a>
                            </div>
                            <div class="advertisments mt-3">
                                <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-02.jpg')}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
