{{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->

            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest
        </ul>
    </div>
</nav> --}}


<div class="panelBox widgets">
    <div class="logo">
        <a href="{{ route(auth()->user()->type.'.dashboard') }}" title="Company Logo">
            <small><img src="{{ asset('assets/images/logo.webp') }}" alt=""></small>
        </a>
        <div class="menu-Bar">
            <span></span>
            <span></span>
            <span></span>
        </div>
       <!--<div class="menu-Bar">-->
       <!--     <span></span>-->
       <!--     <span></span>-->
       <!--     <span></span>-->
       <!-- </div>-->
    </div>
    <nav class="scrollcustom menuWrap">
        <ul>
            <li>
                <a href="{{ route(auth()->user()->type.'.dashboard') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                    Dashboard
                </a>
            </li>
            @if (auth()->user()->type != 'trucker' || auth()->user()->type == 'combo' )
                <li>
                    <a href="{{ route(auth()->user()->type . '.search_trucks') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/truckicon.webp') }}" alt=""></small>
                        Search Trucks
                    </a>
                </li>
             
                <li>
                    <a href="{{ route(auth()->user()->type . '.map') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/truckicon.webp') }}" alt=""></small>
                        PTTR Map
                    </a>
                </li>
            @endif
           @if (auth()->user()->type != 'broker')
                <li>
                    <a href="{{ route(auth()->user()->type . '.search_loads') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/searchloadsicon.webp') }}"
                                alt=""></small>
                        Search Loads
                    </a>
                </li>
                <li>
                    <a href="{{ route(auth()->user()->type . '.my_loads') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/searchloadsicon.webp') }}"
                                alt=""></small>
                        My Loads
                    </a>
                </li>
                <li>
                    <a href="{{ route(auth()->user()->type . '.private_leads') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/searchloadsicon.webp') }}"
                                alt=""></small>
                        Private Loads
                    </a>
                </li>
            @endif
            @if (auth()->user()->type == 'shipper' || auth()->user()->type == 'broker' || auth()->user()->type == 'combo')
                <li class="has-child">
                    <a href="javascript:;" title="">
                        <small><img src="{{ asset('assets/images/icons/shipmenticon.webp') }}" alt=""></small>
                        Shipments
                        <i class="fal fa-chevron-down chev"></i>
                    </a>
                    <div class="dropdown">
                        <ul>
                            <li>
                                <a href="{{ route(auth()->user()->type . '.my_shipments') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/shipmenticon.webp') }}"
                                            alt=""></small>
                                    My Shipments
                                </a>
                            </li>
                            <li>
                                <a href="{{ route(auth()->user()->type . '.post_a_shipment') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/shipmenticon.webp') }}"
                                            alt=""></small>
                                    Post a Shipment
                                </a>
                            </li>
                            <li>
                                <a href="{{ route(auth()->user()->type . '.trackings') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/trackingicon.webp') }}"
                                            alt=""></small>
                                    Send Trackings
                                </a>
                            </li>
                            <!--<li>-->
                            <!--    <a href="{{ route(auth()->user()->type . '.trackings') }}" title="">-->
                            <!--        <small><img src="{{ asset('assets/images/icons/shipmenticon.webp') }}"-->
                            <!--                alt=""></small>-->
                            <!--        Shipment Invoice-->
                            <!--    </a>-->
                            <!--</li>-->
                        </ul>
                    </div>
                </li>
                
            @endif
            @if (auth()->user()->type == 'trucker' || auth()->user()->type == 'combo')
               {{-- @if (auth()->user()->type != 'broker')
                <li>
                    <a href="{{ route(auth()->user()->type . '.search_loads') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/searchloadsicon.webp') }}"
                                alt=""></small>
                        Search Loads
                    </a>
                </li>
                @endif--}}
                <li>
                    <a href="{{ route(auth()->user()->type . '.truck.index') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/termsicon.webp') }}" alt=""></small>
                        Post Trucks
                    </a>
                </li>
                <li>
                    <a href="{{ route(auth()->user()->type . '.invoice.index') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/termsicon.webp') }}" alt=""></small>
                        Invoices
                    </a>
                </li>
            @endif 
            @if(auth()->user()->parent_id == null)
                @php
                    $superAdmin = App\Models\User::where('type', 0)->first();
                    $id = $superAdmin->id;
                @endphp 
                    <li>
                        <a href="{{ route(auth()->user()->type . '.live_support', $id) }}" title="">
                            <small><img src="{{ asset('assets/images/icons/livesupporticon.webp') }}" alt=""></small>
                            Live Support
                        </a>
                    </li>
            @endif
            @if (auth()->user()->type != 'trucker')
                <li>
                    <a href="{{ route(auth()->user()->type . '.private_network') }}" title="">
                        <small><img src="{{ asset('assets/images/icons/privateicon.webp') }}" alt=""></small>
                        Private Network
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ route(auth()->user()->type . '.tools') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/toolicon.webp') }}" alt=""></small> Tools
                </a>
            </li>
        </ul>
        <ul class="mt-5">
            <li>
                <a href="{{ route(auth()->user()->type . '.feedback_foam') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                    Send Feedback
                </a>
            </li>
            <li>
                <a id="notificationBtn" href="javascript:;" title="">
                    <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                    Notifications
                     <div class="badge badge-danger ml-2" id="noti_count" ></div>
                </a>
            </li>


            <li class="has-child">
                <a href="javascript:;" title="">
                    <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                    {{ auth()->user()->name }}
                    <i class="fal fa-chevron-down chev"></i>
                </a>
                <div class="dropdown">
                    <ul>

                        <li>
                            <a href="{{ route(auth()->user()->type . '.user_profile') }}" title="">
                                <small><img src="{{ asset('assets/images/icons/usericon.webp') }}"
                                        alt=""></small>
                                Account Information
                            </a>
                        </li>
                        @if (auth()->user()->parent_id == null && (auth()->user()->type == 'trucker' || auth()->user()->type == 'broker' || auth()->user()->type == 'combo'))
                            <li>
                                <a href="{{ route(auth()->user()->type . '.user_management.index') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/usericon.webp') }}"
                                            alt=""></small>
                                    User Management
                                </a>
                            </li>
                            <li>
                                <a href="{{ route(auth()->user()->type . '.add_card') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/termsicon.webp') }}"
                                            alt=""></small>
                                    Payment Plan
                                </a>
                            </li>
                        @endif
                      
                            <li>
                                <a href="{{ route(auth()->user()->type . '.billing.index') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/termsicon.webp') }}"
                                            alt=""></small>
                                    Billing
                                </a>
                            </li>
                       
                            <li>
                                <a href="{{ route(auth()->user()->type . '.user_company_profile') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/usericon.webp') }}"
                                            alt=""></small>
                                    Company Profile
                                </a>
                            </li>
                            @if(auth()->user()->type != 'broker')
                                @if(auth()->user()->parent_id == null)
                                    <li>
                                        <a href="{{ route(auth()->user()->type . '.show_onboarding_profile') }}" title="">
                                            <small><img src="{{ asset('assets/images/icons/usericon.webp') }}"
                                                    alt=""></small>
                                            OnBoarding Profile
                                        </a>
                                    </li>
                                @endif
                            @endif
                        <li>
                            <a href="{{route('privacy_policy')}}" title="">
                                <small><img src="{{ asset('assets/images/icons/privacyicon.webp') }}"
                                        alt=""></small>
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="{{route('terms_and_conditions')}}" title="">
                                <small><img src="{{ asset('assets/images/icons/termsicon.webp') }}"
                                        alt=""></small>
                                Terms and Conditions
                            </a>
                        </li>

                        <li>
                            {{-- <a href="javascript:;" title="">
                                 <small><img src="{{asset('assets/images/icons/sginouticon.webp')}}" alt=""></small>
                                Sign Out
                            </a> --}}
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <small><img src="{{ asset('assets/images/icons/sginouticon.webp') }}"
                                        alt=""></small>
                                {{ __('Sign Out') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>
