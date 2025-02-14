<div class="panelBox widgets">
    <div class="logo">
        <a href="{{ route(auth()->user()->type . '.dashboard') }}" title="Company Logo">
            <small><img src="{{ asset('assets/images/logo.webp') }}" alt=""></small>
        </a>
    </div>
    <nav class="scrollcustom">
        <ul>
            <li>
                <a href="{{ route(auth()->user()->type . '.dashboard') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route(auth()->user()->type . '.trucks_list') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/truckicon.webp') }}" alt=""></small>
                    Trucks
                </a>
            </li>
            <li>
                <a href="{{ route(auth()->user()->type . '.shipments_list') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/shipmenticon.webp') }}" alt=""></small>
                    Shipments
                </a>
            </li>
            <li>
                <a href="{{ route(auth()->user()->type . '.users_list') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/usericon.webp') }}" alt=""></small>
                    Users
                </a>
            </li>
            
             <li>
                <a href="{{ route(auth()->user()->type . '.live_support') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/livesupporticon.webp') }}" alt=""></small>
                    Live Support
                </a>
            </li>
             
            <li>
                <a href="{{ route(auth()->user()->type . '.packages.list') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/termsicon.webp') }}" alt=""></small>
                    Packages
                </a>
            </li>
       
            <li>
                <a href="{{ route(auth()->user()->type . '.advertisements.list') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/livesupporticon.webp') }}" alt=""></small>
                    Advertisement
                </a>
            </li>
            <li>
                <a href="{{ route(auth()->user()->type . '.shops.list') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/livesupporticon.webp') }}" alt=""></small>
                    Shops
                </a>
            </li>
            
            <li>
                <a href="{{ route(auth()->user()->type . '.feedbacks_list') }}" title="">
                    <small><img src="{{ asset('assets/images/icons/feedbackicon.webp') }}" alt=""></small>
                    Feedbacks
                </a>
            </li>
             <li>
                <a id="notificationBtn" href="javascript:;" title="">
                    <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                    Notifications
                <div class="badge badge-danger ml-2" id="noti_count" ></div>
                </a>
            </li>
             <ul class="mt-5">
                <li class="has-child">
                    <a href="javascript:;" title="">
                        <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                        Services
                        <i class="fal fa-chevron-down chev"></i>
                    </a>
                    <div class="dropdown">
                        <ul>
                        <li>
                            <a href="{{ route(auth()->user()->type . '.service.list') }}" title="">
                                <small><img src="{{ asset('assets/images/icons/livesupporticon.webp') }}" alt=""></small>
                                Services and Categories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route(auth()->user()->type . '.service_category_item.list') }}" title="">
                                <small><img src="{{ asset('assets/images/icons/livesupporticon.webp') }}" alt=""></small>
                                Service Category Items
                            </a>
                        </li>
                        </ul>
                    </div>
                </li>
            </ul>
         </ul>
        <ul class="mt-5">
            <li class="has-child">
                <a href="javascript:;" title="">
                    <small><img src="{{ asset('assets/images/icons/dashboardicon.webp') }}" alt=""></small>
                    {{ auth()->user()->name }}
                    <i class="fal fa-chevron-down chev"></i>
                </a>
                <div class="dropdown">
                    <ul>
                        @if(auth()->user()->parent_id == null)
                        <li>
                            <a href="{{ route(auth()->user()->type . '.subadmin.list') }}" title="">
                                <small><img src="{{ asset('assets/images/icons/usericon.webp') }}"
                                        alt=""></small>
                                Sub Admins
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route(auth()->user()->type . '.user_profile') }}" title="">
                                <small><img src="{{ asset('assets/images/icons/usericon.webp') }}"
                                        alt=""></small>
                                Account Information
                            </a>
                        </li>
                        @if (auth()->user()->type == 'broker')
                            <li>
                                <a href="{{ route(auth()->user()->type . '.user_company_profile') }}" title="">
                                    <small><img src="{{ asset('assets/images/icons/usericon.webp') }}"
                                            alt=""></small>
                                    Company Profile
                                </a>
                            </li>
                        @endif
                       {{-- <li>
                            <a href="javascript:;" title="">
                                <small><img src="{{ asset('assets/images/icons/privacyicon.webp') }}"
                                        alt=""></small>
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" title="">
                                <small><img src="{{ asset('assets/images/icons/termsicon.webp') }}"
                                        alt=""></small>
                                Terms and Conditions
                            </a> 
                        </li> --}}

                        <li>
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
