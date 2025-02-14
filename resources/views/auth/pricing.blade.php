@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="loginForms pricingMain">
            <div class="text-right">
                <a href="{{route('login')}}" title="">Already Signin Click Here</a>
            </div>
            <br>
            <div class="lgForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                </figure>
                <h2>Load Board Plans</h2>
                <div class="contBody">
                    <div class="row">
                   {{-- @foreach ($packages as $package) --}}
                
                        <div class="col-md-4">
                            <div class="Bxpricing">
                                <div class="headBx">
                                    <h2>Carrier Membership</h2>
                                </div>
                                <div class="midcont">
                                    <div class="text-center">
                                        <h3>Regular Price <span class="cutprice">$104.99</span></h3>
                                        <h5>Special Offer <br>For 6 Months <span>$34.99 / Month</span></h5>
                                    </div>
                                    <a class="themeBtn skyblue text-center" href="{{config('app_url')}}/signup-one/1"
                                    title="">Join Now</a>
                                     <ul>
                                        <li>Unlimited Load Search</li>
                                        <li>Unlimited Post Truck</li>
                                        <li>Instant Booking With PTTR Book Now</li>
                                        <li>Live Load Board</li>
                                        <li>Instant Invoicing <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>PTTR App</li>
                                        <li>PTTR Map</li>
                                        <li>Market Rate Lookup</li>
                                        <li>Truck services <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Explore Nearby <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>MCI Trucks In & Trucks Out <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Add Unlimited Additional Users Each User @ $19.99 <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                    </ul>
                                    <div class="text-center">
                                        <a class="simpleBtn" href="javascript:;"
                                        title="">See More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="Bxpricing">
                                <div class="headBx">
                                    <h2>Broker Membership</h2>
                                </div>
                                <div class="midcont">
                                    <div class="text-center">
                                        <h3>Regular Price <span class="cutprice">$54.99</span></h3>
                                        <h5>Special Offer <br>For 6 Months <span>$14.99 / Month</span></h5>
                                    </div>
                                    <a class="themeBtn skyblue text-center" href="{{config('app_url')}}/signup-one/2"
                                        title="">Join Now</a>
                                     <ul>
                                        <li>Unlimited Load Post</li>
                                        <li>Unlimited Truck Search </li>
                                        <li>Real Time Tracking <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>External Tracking <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Post To Private Network <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Quick Access to Carrier's Invoice <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>PTTR App</li>
                                        <li>PTTR Map</li>
                                        <li>Market Rate Lookup</li>
                                        <li>Post Loads For Bidding <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Manage / Update Shipments</li>
                                        <li>MCI Trucks In & Trucks Out <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Add Unlimited Additional Users Each User @ $9.99 <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                    </ul>
                                    <div class="text-center">
                                        <a class="simpleBtn" href="javascript:;"
                                        title="">See More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="Bxpricing">
                                <div class="headBx">
                                    <h2>Combo Membership </h2>
                                </div>
                                <div class="midcont">
                                    <div class="text-center">
                                        <h3>Regular Price <span class="cutprice">139.99</span></h3>
                                        <h5>Special Offer <br>For 6 Months <span>$44.99 / Month</span></h5>
                                    </div>
                                    <a class="themeBtn skyblue text-center" href="{{config('app_url')}}/signup-one/5"
                                        title="">Join Now</a>
                                     <ul>
                                        <li>Full Access to Broker Membership</li>
                                        <li>Unlimited Load Search</li>
                                        <li>Unlimited Post Truck</li>
                                        <li>Instant Booking With PTTR Book Now</li>
                                        <li>Bid On The Available Loads</li>
                                        <li>Live Load Board</li>
                                        <li>Instant Invoicing <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>PTTR App</li>
                                        <li>PTTR Map</li>
                                        <li>Market Rate Lookup</li>
                                        <li>Truck services <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Explore Nearby <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                        <li>Add Unlimited Additional Users Each User @ $29.99 <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></i></li>
                                    </ul>
                                    <div class="text-center">
                                        <a class="simpleBtn" href="javascript:;"
                                        title="">See More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                   {{--  @endforeach --}}

                    {{-- <div class="col-md-6">
                        <div class="Bxpricing">
                            <div class="headBx">
                                <h2>Carrier Membership</h2>
                            </div>
                            <div class="midcont">
                                <ul>
                                    <li>The carrier membership will start with a six-month promotional offer.</li>
                                    <li>The cost of membership is <strong>$29.99 per month</strong>, which includes one
                                        user. Each additional user will incur a fee of <strong>$19.99</strong>.</li>
                                    <li>Memberships provide access to both desktop and mobile devices.</li>
                                    <li>After the initial six months, the carrier membership will change to
                                        <strong>$99.99 per month</strong>, and each new user will have to pay an
                                        <strong>additional $39.99</strong>. They can add as many users as they require,
                                        but each time they must create a new credential.
                                    </li>
                                </ul>
                                <a class="themeBtn skyblue text-center" href="javascript:;" title="">Join Now</a>
                            </div>
                        </div>
                    </div> --}}
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
