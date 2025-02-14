@extends('layouts.app')
@section('content')

<div class="col-md-10">
    <div class="mainBody">
        <!-- Begin: Notification -->
        @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>New Shipments</h2>
        </div>
        <div class="contBody">
            <form id="SubmitFormSh" action="{{ route(auth()->user()->type . '.store_a_shipment') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class=" col-md-12">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Please correct the errors in the following fields:<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                @if ($error == 'Phone')
                                <li>* Please select at least one method of contact to post</li>
                                @elseif ($error == 'Email')
                                @else
                                <li>* {{ $error }}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                @php
                    $top_header1 = ads('post_a_shipment','top_header1');
                    $top_header2 = ads('post_a_shipment','top_header2');
                @endphp
                @if(isset($top_header1) && isset($top_header2))
                <div class="row">
                    <div class="col-md-7">
                        <div class="advertisments">
                            <a href="{{$top_header1->url}}" target="_blank" title=""><img src="{{asset($top_header1->image)}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="advertisments">
                            <a href="{{$top_header2->url}}" target="_blank" title=""><img src="{{asset($top_header2->image)}}" alt=""></a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-7">
                        <div class="card shipmentDetails">
                            <h3>Shipment Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fields">
                                        <select name="origin" class="SelectFieldOrigin"></select>
                                        {{-- <input type="text" required name="origin" id="OriginTextField"
                                            placeholder="Origin (City, ST, ZIP)*">
                                        <input type="hidden" id="origin_id"  name="origin_place_id"
                                            placeholder="Origin (City, ST, ZIP)*">
                                        <input type="hidden" id="originLat"  name="origin_lat">
                                        <input type="hidden" id="originLng"  name="origin_lng"> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fields">
                                        <select  name="destination" class="SelectFieldDestination"></select>
                                        {{-- <input type="text" id="DestinationTextField" required name="destination"
                                            placeholder="Destination (City, ST, ZIP)*">
                                        <input type="hidden" id="destination_id"  name="destination_place_id"
                                            placeholder="Destination (City, ST, ZIP)*">
                                        <input type="hidden" id="destinationLat"  name="destination_lat">
                                        <input type="hidden" id="destinationLng"  name="destination_lng"> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="date" name="from_date"
                                                    min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{Carbon\Carbon::now()->format('Y-m-d') , old('from_date')}}"
                                                    max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="date" name="to_date" value="{{Carbon\Carbon::now()->format('Y-m-d'),old('to_date')}}"
                                                    min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="time" placeholder="Pickup Hours" name="from_time" value="{{Carbon\Carbon::now()->format('h:i') , old('from_time')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="time" name="to_time" placeholder="Drop Off Hours" value="{{Carbon\Carbon::now()->format('h:i') , old('to_time')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3>Equipment Details</h3>
                            <div class="radioBtns">
                                <div class="radios">
                                    <input type="radio" id="full" name="equipment_detail" checked value="0">
                                    <label for="full"> Full</label>
                                </div>
                                <div class="radios">
                                    <input type="radio" id="Partial" name="equipment_detail" value="1">
                                    <label for="Partial"> Partial</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fields">

                                        <select required name="eq_type_id">
                                            <option hidden value="">Equipment Type*</option>
                                            @foreach ($equipment_types as $equipment_type)
                                            <option value="{{ $equipment_type->id }}">{{ $equipment_type->name }}
                                                <span>{{ $equipment_type->prefix }}</span>
                                            </option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" name="eq_type" required placeholder="Equipment Type*"> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="number" required name="length" max="200" min="1"
                                                    placeholder="Length (ft)*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="number" required name="weight" max="50000" min="1"
                                                    placeholder="Weight (Ibs.) *">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fields">
                                        <textarea name="eq_name" id="" cols="10" rows="10"
                                            placeholder="Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fields">
                                        <input type="text" name="commodity" placeholder="Commodity">
                                    </div>
                                    <div class="fields">
                                        <input type="text" name="reference_id" placeholder="Reference ID">
                                    </div>
                                </div>
                            </div>

                            <h3>Contact Information</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <strong>Select at least one or more contact methods to share
                                            with
                                            carriers on your post.</strong>
                                        <br>contact into can be updated In your profile
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="contactchecks">
                                        <div class="check">
                                            <input type="checkbox" name="status_phone" required value="1"
                                                class="contact-checkbox" id="primaryphone">
                                            <label
                                                for="primaryphone">{{auth()->user()->phone ? auth()->user()->phone : auth()->user()->alt_phone  }}
                                                (Phone)</label>
                                        </div>
                                        <div class="check">
                                            <input type="checkbox" name="status_email" value="1" required
                                                class="contact-checkbox" id="email">
                                            <label for="email">{{auth()->user()->email}} (Email)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card requireTracking">
                                <h3>Require Tracking</h3>
                                <div class="requiredtrackField">
                                    <input type="checkbox" id="rqtrack">
                                    <label for="rqtrack">
                                        <strong>Select at least one or more contact methods to share with
                                            carriers on your post.
                                        </strong>
                                        contact into can be updated In your profile
                                    </label>
                                </div>
                            </div> --}}
                        <div class="card requireTracking">
                            <div class="requiredtrackField align-items-baseline">
                                <input type="checkbox" id="tracking" name="is_tracking" value="false">
                                <label for="Tracking">
                                    <h3>Require Tracking </h3>
                                    <strong>Select at least one or more contact methods to share with
                                        carriers on your post.
                                    </strong>
                                    contact into can be updated In your profile
                                </label>
                            </div>
                            <div class="card" id="shipment">
                                <div class="row align-items-center">
                                    <div class="col-lg-1">
                                        <i class="far fa-mobile text-primary fa-3x"></i>
                                    </div>
                                    <div class="col-lg-8">
                                        <label for=""><strong>Track Shipment with PTTR One</strong>
                                            (Optional)</label>
                                        <label for="">Once your driver accepts PTTR tracking, you'll have access
                                            to ETAs and real-time updates of where your shipment is along it's
                                            journey</label>
                                    </div>
                                    <!--<div class="col-lg-3">-->
                                    <!--    <a class="bdBtns d-inline" href="#" id="addDatTracking" title="">ADD PTTR-->
                                    <!--        TRACKING </a>-->
                                    <!--</div> -->
                                </div>
                                <div id="hiddenDatTracking">
                                    {{-- <div class="card shipmentDetails pick-field1" id="pick-field-1">
                                         <h3>Pick Up</h3>
                                         <div class="row">
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="Street Address" required="">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="date" placeholder="Appointment date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="No Dock Information Available" required="">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="fields">
                                                        <input type="time" placeholder="Start Time">
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="fields">
                                                        <input type="time" placeholder="End Time">
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="Location Name">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="Notes">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <select name="" id="">
                                                     <option value="">
                                                        Begin tracking 2 hours before Pick Up
                                                     </option>
                                                     <option value="">
                                                        Begin tracking 2 hours before Pick Up
                                                     </option>
                                                  </select>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                      <div class="row justify-content-end">
                                         <div class="col-md-4">
                                            <div class="fields">
                                               <a class="removeBtns" href="javascript:;" id="remove-pick"  title="">
                                               <i class="far fa-trash-alt"></i> REMOVE THIS WAYPOINT
                                               </a>
                                            </div>
                                         </div>
                                         <div class="col-md-4">
                                            <div class="fields">
                                               <a class="bdBtns" href="javascript:;"  title="" id="add-morepick" >
                                               +ADD ANOTHER PICK UP
                                               </a>
                                            </div>
                                         </div>
                                      </div> --}}
                                    <div class="card shipmentDetails pick-field1" id="pick-field-1">
                                        <h3>Pick Up</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Street Address"
                                                        class="PickStreetAddresstField" name="street_address[]">
                                                    <input type="hidden" class="pick_street_place_id"
                                                        name="street_place_id[]">
                                                    <input class="pick_street_addressLat"
                                                        name="street_addressLat[]" type="hidden" placeholder="Latitude">
                                                    <input class="pick_street_addressLng"
                                                        name="street_addressLng[]" type="hidden" placeholder="Longitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" placeholder="Appointment date"
                                                        name="appointment_date[]" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"   max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}" value="{{Carbon\Carbon::now()->format('Y-m-d') , old('appointment_date[]')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="No Dock Information Available"
                                                        name="dock_info[]">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="Start Time"
                                                                name="start_time[]" value="{{Carbon\Carbon::now()->format('h:i') , old('start_time[]')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="End Time" name="end_time[]" value="{{Carbon\Carbon::now()->format('h:i') , old('end_time[]')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Location Name"
                                                        name="lcoation_name[]">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Notes" name="notes[]">
                                                    <input type="text" hidden name="types[]" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select name="tracking_start_time[]" id="">
                                                        <option value="Begin at first appointment">
                                                            Begin at first appointment
                                                        </option>
                                                        <option value="Begin tracking 1 hours before Pick Up">
                                                            Begin tracking 1 hours before Pick Up
                                                        </option>
                                                        <option value="Begin tracking 2 hours before Pick Up">
                                                            Begin tracking 2 hours before Pick Up
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-md-4">
                                            <div class="fields">
                                                <a class="removeBtns" href="javascript:;" id="remove-pick" title="">
                                                    <i class="far fa-trash-alt"></i> REMOVE THIS WAYPOINT
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fields">
                                                <a class="bdBtns" href="javascript:;" title="" id="add-morepick">
                                                    +ADD ANOTHER PICK UP
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="card shipmentDetails drop-field2" id="drop-field">
                                         <h3>Drop Off</h3>
                                         <div class="row">
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="Street Address" required="">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="date" placeholder="Appointment date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="No Dock Information Available" required="">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="fields">
                                                        <input type="time" placeholder="Start Time">
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="fields">
                                                        <input type="time" placeholder="End Time">
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="Location Name">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <input type="text" placeholder="Notes">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="fields">
                                                  <select name="" id="">
                                                     <option value="">
                                                        Begin tracking 2 hours before Pick Up
                                                     </option>
                                                     <option value="">
                                                        Begin tracking 2 hours before Pick Up
                                                     </option>
                                                  </select>
                                               </div>
                                            </div>
                                         </div>
                                      </div> --}}
                                    <div class="card shipmentDetails drop-field2" id="drop-field">
                                        <h3>Drop Off</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Street Address"
                                                        class="DropStreetAddresstField" name="street_address[]">
                                                    <input type="hidden" class="drop_street_place_id"
                                                        name="street_place_id[]">
                                                    <input class="drop_street_addressLat"
                                                        name="street_addressLat[]" type="hidden" placeholder="Latitude">
                                                    <input class="drop_street_addressLng"
                                                        name="street_addressLng[]" type="hidden" placeholder="Longitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" placeholder="Appointment date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        name="appointment_date[]"
                                                        value="{{Carbon\Carbon::now()->format('Y-m-d') , old('appointment_date[]')}}"
                                                        max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="No Dock Information Available"
                                                        name="dock_info[]">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="Start Time"
                                                                value="{{Carbon\Carbon::now()->format('h:i') , old('start_time[]')}}"
                                                                name="start_time[]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="End Time" name="end_time[]"
                                                            value="{{Carbon\Carbon::now()->format('h:i') , old('end_time[]')}}">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Location Name"
                                                        name="lcoation_name[]">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Notes" name="notes[]">

                                                </div>
                                                <input type="text" hidden  name="types[]" value="1">
                                            </div>

                                            <!--<div class="col-md-6">-->
                                            <!--    <div class="fields">-->
                                            <!--        <select name="tracking_start_time[]" id="">-->
                                            <!--            <option value="Begin at first appointment">-->
                                            <!--                Begin at first appointment-->
                                            <!--            </option>-->
                                            <!--            <option value="Begin tracking 1 hours before Pick Up">-->
                                            <!--                Begin tracking 1 hours before Pick Up-->
                                            <!--            </option>-->
                                            <!--            <option value="Begin tracking 2 hours before Pick Up">-->
                                            <!--                Begin tracking 2 hours before Pick Up-->
                                            <!--            </option>-->
                                            <!--        </select>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-md-4">
                                            <div class="fields">
                                                <a class="removeBtns" href="javascript:;" id="remove-drop" title="">
                                                    <i class="far fa-trash-alt"></i> REMOVE THIS WAYPOINT
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fields">
                                                <a class="bdBtns" href="javascript:;" id="add-moredrop" title="">
                                                    +ADD ANOTHER DROP OFF
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">

                        <div class="card">
                            <div class="audienceDv">
                                <figure>
                                    <img src="{{asset('assets/images/audience-icons.webp')}}" alt="">
                                </figure>
                                <div class="cont">
                                    <h3>Select your Audience</h3>
                                    <p>Customize your audience for this shipment within the PTTR load
                                        board and your private Network
                                    </p>
                                    <a href="{{ route(auth()->user()->type . '.private_network') }}"
                                        class="themeBtn skyblue" href="javascript:;" title="">Customize
                                        your Audience</a>
                                </div>
                            </div>
                        </div>


                        <div class="card requireTracking">
                            <h3>Select your Audience</h3>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="requiredtrackField">
                                        <label for="booknow">
                                            Customize your audience for this shipment within the PTTR Load Board and
                                            your Private Network
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    {{-- <label for="booknow">
                                                Select at least one posting option:
                                            </label> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="selectYourAudience">
                                        <input type="checkbox" class="chkpostPrivateNetwork" name="is_private_network"
                                            id="privatenetworks" value="1" required>
                                        <label for="privatenetworks">
                                            Post to Private Network
                                        </label>
                                        <div class="chooseNetwork">
                                            <input type="radio" id="postPrivate1" name="postPrivate"
                                                value="entire_private_network_id" class="postPrivateNetwork" checked>
                                            <label for="postPrivate1">Entire Private Network</label>
                                            <input type="radio" id="postPrivate2" name="postPrivate"
                                                class="postPrivateNetwork" value="is_group">
                                            <label for="postPrivate2">Special Groups </label>
                                            <div class="groudHide">
                                                @if(count($groups) > 0)
                                                <select class="js-example-basic-multiple" name="groups[]"
                                                    multiple="multiple">
                                                    @foreach ($groups as $group)
                                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                                    @endforeach
                                                </select>
                                                @else
                                                <a href="{{route(auth()->user()->type.'.groups')}}">Create Group</a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <input type="checkbox" name="is_public_load" id="privatenetwork" required>
                                    <label for="privatenetwork">
                                        Post to PTTR Load Board
                                    </label>
                                    {{-- <div class="extNetwork">
                                                <input type="checkbox" id="extNetworkBoard">
                                                <label for="extNetworkBoard" class="mb-1">
                                                Post to Extended Network
                                                </label>
                                                <span class="text-danger">Estimated charge:</span><span>$2.00/day</span>
                                            </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card requireTracking">
                            <div id="bookingRateDiv" class="postPrivateNetwork">
                                <h3>Booking & Rate</h3>
                                <div class="requiredtrackField">
                                    <input type="checkbox" id="bookingRate" name="is_allow_carrier_to_book_now">
                                    <label for="bookingRate">
                                        <strong>Allow carriers to book instantly on PTTR (Book Now)
                                        </strong>
                                        You will receive notifications within PTTR One when a new booking
                                        request is received
                                    </label>
                                </div>
                                {{-- <div id="bookingRateRow" style="display: none">
                                     <h5 class="mt-3 mb-2">Who can request to book?</h5>
                                     <div class="row">
                                        <div class="col-lg-6">
                                           <input type="checkbox" id="requestnetwork">
                                           <label for="requestnetwork">
                                           Private Network
                                           </label>
                                        </div>
                                        <div class="col-lg-6">
                                           <input type="checkbox" id="datload">
                                           <label for="datload">
                                           DAT Load Board
                                           </label>
                                        </div>
                                     </div>
                                  </div> --}}
                            </div>
                            <div class="flatrateDv">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Flat Rate</h3>
                                        <h5>PTTR Load Board</h5>
                                        <div class="fields">
                                            <input type="number" placeholder="Rate / Trip" name="dat_rate">
                                        </div>
                                        <h5>Private Network</h5>
                                        <div class="fields">
                                            <input type="number" placeholder="Rate / Trip" name="private_rate">
                                            <span class="spanHide">Required. Rate for trip in USD</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Market Rates</h3>
                                        <figure>
                                            <img src="{{asset('assets/images/marketrates.png')}}" alt="">
                                        </figure>
                                        <p>
                                            <strong>Select an origin, destination,
                                                and equipment</strong>
                                            Type to view rates
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="privatenetwork mt-2">
                                            <input type="checkbox" id="privatenet" name="is_allow_bids">
                                            <label for="privatenet">Allow bids from Private
                                                Network</label>
                                        </div>
                                        <div class="privatenetwork mt-2" id="setMaxRate12">
                                            <input type="checkbox" id="setMaxRate">
                                            <label for="setMaxRate">Set a Maximum Rate and automatically reject birds
                                                over this amount </label>
                                        </div>
                                        <div class="fields mt-3" id="setMaxRate13">
                                            <input type="number" placeholder="Maximum Rate / Trip" name="max_bid_rate">
                                            <span>Maximum Rate should be greater than or equal to Private Network
                                                Rate</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btnShipments">
                            <input type="button" class="cancelBtn" value="Cancel">
                            <input type="submit" class="postBtn" value="Post">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI&libraries=places">
</script>
<script>
    $(document).on('submit','#SubmitFormSh',function(e){
        e.preventDefault();
        var IsValid = 0;
        $('#SubmitFormSh input[type="hidden"]').each(function(){
          if($(this).parent().is(":visible")){
              console.log($(this).val());
             if(!$(this).val()){ IsValid = 1; }
          }
        });
        if(IsValid == 1){
         Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Please Make sure to select the address using the suggestion dropdown!",
            });
        }else{
            e.currentTarget.submit();
        }
    });

</script>
<script type="text/javascript">
const phoneCheckbox = document.querySelector('input[name="status_phone"]');
const emailCheckbox = document.querySelector('input[name="status_email"]');


        $('.SelectFieldOrigin').select2({
            ajax: {
                url: "{{ route(auth()->user()->type . '.state_city') }}", // POST route
                type: 'POST',
                dataType: 'json',
                delay: 250,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for security
                },
                data: function (params) {
                    return {
                        q: params.term, // Send the search term
                        c: 'city'
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items // Use the data returned from the backend
                    };
                },
                cache: true
            },
            placeholder: 'Origin (City, ST, ZIP)*',
            minimumInputLength: 1
        });

        $('.SelectFieldDestination').select2({
            ajax: {
                url: "{{ route(auth()->user()->type . '.state_city') }}", // POST route
                type: 'POST',
                dataType: 'json',
                delay: 250,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for security
                },
                data: function (params) {
                    return {
                        q: params.term, // Send the search term
                        c: 'city'
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items // Use the data returned from the backend
                    };
                },
                cache: true
            },
            placeholder: 'Destination (City, ST, ZIP)*',
            minimumInputLength: 1
        });


function toggleCheckbox() {
    if (phoneCheckbox.checked) {
        emailCheckbox.removeAttribute("required");
    } else if (emailCheckbox.checked) {
        phoneCheckbox.removeAttribute("required");
    } else {
        emailCheckbox.required = true;
        phoneCheckbox.required = true;

    }
}

phoneCheckbox.addEventListener("change", toggleCheckbox);
emailCheckbox.addEventListener("change", toggleCheckbox);

$('.postPrivateNetwork').prop("disabled", true);
$('#bookingRate').prop("disabled", true);
$("#privatenet").prop("disabled", true);
$('input[name="private_rate"]').attr("disabled", true);
$('input[name="dat_rate"]').attr("disabled", true);

$('.spanHide').hide();


$('.chkpostPrivateNetwork:checkbox').click(function() {
    if ($(this).is(':checked')) {
        $('.postPrivateNetwork').prop("disabled", false);
        $('input[name="is_public_load"]').prop('required', false);
        $('#bookingRate').prop("disabled", false);
        $('#bookingRate').prop("checked", true).trigger('click');
        $('input[name="private_rate"]').attr("disabled", false);
        $('input[name="private_rate"]').attr("required", true);
        $('.spanHide').show();
    } else {
        if ($('.chk').filter(':checked').length < 1) {
            $('input[name="is_public_load"]').prop('required', true);
            $('#bookingRate').prop("disabled", true);
            $('#bookingRate').prop("checked", false);
            $('input[name="private_rate"]').attr("disabled", true);
            $('input[name="private_rate"]').val('');
            $('input[name="dat_rate"]').removeAttr("required");
            $('.spanHide').hide();
            $('#bookingRate').prop("checked", false).trigger('click');
            $('.postPrivateNetwork').attr('disabled', true);
            $('.js-example-basic-multiple').attr("required", false);
        }
    }

});

$('.groudHide').hide();
$('input[type=radio][name=postPrivate]').change(function() {
    if (this.value == 'entire_private_network_id') {
        $('input[name="max_bid_rate"]').removeAttr("required");
        $('.js-example-basic-multiple').removeAttr("required", false);
        $('.groudHide').hide();
    } else if (this.value == 'is_group') {
        $('.groudHide').show();
        $('.js-example-basic-multiple').select2();
        $('.js-example-basic-multiple').attr("required", true);
    }
});

$("#privatenetwork").click(function() {
    if ($(this).is(":checked")) {
        $('input[name="dat_rate"]').attr("disabled", false);
        $('input[name="dat_rate"]').attr("required", true);
        $('input[name="is_private_network"]').prop('required', false);
    } else {
        $('input[name="is_private_network"]').prop('required', true);
        $('input[name="dat_rate"]').attr("disabled", true);
        $('input[name="dat_rate"]').val('');
        $('input[name="dat_rate"]').removeAttr("required");
    }
});






$("#bookingRate").click(function() {
    if ($(this).is(":checked")) {
        $("#privatenet").prop("disabled", false);
        $('#privatenet').prop("checked", true).trigger('click');
    } else {
        $("#privatenet").prop("disabled", true);
        $('#privatenet').prop("checked", false).trigger('click');
    }
});



$('#setMaxRate12').hide();
$('#setMaxRate13').hide();
$("#privatenet").click(function() {
    if ($(this).is(':checked')) {
        $(this).attr('value', 'true');
        $('#setMaxRate12').show();
        $('#setMaxRate13').hide();
    } else {
        $(this).attr('value', 'false');
        $('#setMaxRate12').hide();
        $('#setMaxRate').prop('checked', false);
        $('#setMaxRate13').hide();
    }
});


$("#setMaxRate").click(function() {
    if ($(this).is(':checked')) {
        $('#setMaxRate13').show();
        $('input[name="max_bid_rate"]').attr("required", true);
    } else {
        $('#setMaxRate13').hide();
        $('input[name="max_bid_rate"]').removeAttr("required");
    }
});

function initializeStreet() {
    var options1 = {
        types: ['establishment'],
        componentRestrictions: {
            country: ["us","cn","ca","pk"]
        }
    };

    // Pickup
    $('.PickStreetAddresstField').each(function() {
        var autocomplete1 = new google.maps.places.Autocomplete(this, options1);
        var thisss = $(this);
        google.maps.event.addListener(autocomplete1, 'place_changed', function() {
            var place1 = autocomplete1.getPlace();
            $(this).val(place1.formatted_address);
            thisss.parent().find('input.pick_street_place_id').val(place1.place_id);
            thisss.parent().find('input.pick_street_addressLat').val(place1.geometry.location
                .lat());
            thisss.parent().find('input.pick_street_addressLng').val(place1.geometry.location
                .lng());
        });
    });

    // Drop-off
    $('.DropStreetAddresstField').each(function() {
        var autocomplete = new google.maps.places.Autocomplete(this, options1);
        var thiss = $(this);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            $(this).val(place.formatted_address);
            thiss.parent().find('input.drop_street_place_id').val(place.place_id);
            thiss.parent().find('input.drop_street_addressLat').val(place.geometry.location.lat());
            thiss.parent().find('input.drop_street_addressLng').val(place.geometry.location.lng());
        });
    });
}

initializeStreet();
</script>

<script type="text/javascript">
function initialize() {
    var options = {
        types: ['(cities)'],
        componentRestrictions: {
            country: "us"
        }
    };

    var input = document.getElementById('OriginTextField');
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();

        document.getElementById('origin_id').value = place.place_id;
        document.getElementById('originLat').value = place.geometry.location.lat();
        document.getElementById('originLng').value = place.geometry.location.lng();
        // var lat = place.geometry.location.lat();
        // var lng = place.geometry.location.lng();
        // initMap(lat,lng);

    });
    var input1 = document.getElementById('DestinationTextField');
    var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
    google.maps.event.addListener(autocomplete1, 'place_changed', function() {
        var place1 = autocomplete1.getPlace();

        document.getElementById('destination_id').value = place1.place_id;
        document.getElementById('destinationLat').value = place1.geometry.location.lat();
        document.getElementById('destinationLng').value = place1.geometry.location.lng();
        // var lat = place.geometry.location.lat();
        // var lng = place.geometry.location.lng();
        // initMap(lat,lng);

    });
}

// initialize();


// $('.pick-field1').each(function() {
//     $(this).find('input').removeAttr('required');
// });
// $('.drop-field2').each(function() {
//     $(this).find('input').removeAttr('required');
// });
$("#tracking").on('change', function() {

    if ($(this).is(':checked')) {
        $(this).attr('value', 'true');
        $('#shipment').show();
        // $('#addDatTracking').trigger('click');
        $('#hiddenDatTracking').show();
        $('input[name="street_address[]"]').attr("required", true);
        $('input[name="appointment_date[]"]').attr("required", true);
        $('input[name="start_time[]"]').attr("required", true);
        $('input[name="end_time[]"]').attr("required", true);
        // $('.pick-field1').each(function() {
        //     $(this).find('input').attr('required', true);
        // });
        // $('.drop-field2').each(function() {
        //     $(this).find('input').attr('required', true);
        // });
    } else {
        $(this).attr('value', 'false');
        $('input[name="street_address[]"]').removeAttr("required");
        $('input[name="appointment_date[]"]').removeAttr("required");
        $('input[name="start_time[]"]').removeAttr("required");
        $('input[name="end_time[]"]').removeAttr("required");
        $('#shipment').hide();
        // $('.pick-field1').each(function() {
        //     $(this).find('input').removeAttr('required');
        // });
        // $('.drop-field2').each(function() {
        //     $(this).find('input').removeAttr('required');
        // });
    }
});


$('#shipment').hide();


$(function() {
    $('#hiddenDatTracking').hide();
})






$(document).ready(function() {
    var buttonAdd = $("#add-morepick");
    var buttonRemove = $("#remove-pick");
    var className = ".pick-field1";
    var count = 0;
    var field = "";
    var maxFields = 50;

    function totalFields() {
        return $(className).length;
    }

    function addNewField() {
        count = totalFields() + 1;
        field = $("#pick-field-1").clone();
        field.attr("id", "pick-field1-" + count);
        field.children("label").text("Field " + count);
        field.find("input").val("");
     field.find("input[name='types[]']").val(0);
        $(className + ":last").after($(field));
    }

    function removeLastField() {
        if (totalFields() > 1) {
            $(className + ":last").remove();
        }
    }

    function enableButtonRemove() {
        if (totalFields() === 2) {
            buttonRemove.removeAttr("disabled");
            buttonRemove.addClass("shadow-sm");
        }
    }

    function disableButtonRemove() {
        if (totalFields() === 1) {
            buttonRemove.attr("disabled", "disabled");
            buttonRemove.removeClass("shadow-sm");
        }
    }

    function disableButtonAdd() {
        if (totalFields() === maxFields) {
            buttonAdd.attr("disabled", "disabled");
            buttonAdd.removeClass("shadow-sm");
        }
    }

    function enableButtonAdd() {
        if (totalFields() === (maxFields - 1)) {
            buttonAdd.removeAttr("disabled");
            buttonAdd.addClass("shadow-sm");
        }
    }

    buttonAdd.click(function() {
        addNewField();
        enableButtonRemove();
        disableButtonAdd();
        valid_format();
        initializeStreet();
    });

    buttonRemove.click(function() {
        removeLastField();
        disableButtonRemove();
        enableButtonAdd();
        valid_format();
        initializeStreet();
    });
});



$(document).ready(function() {
    var buttonAdd = $("#add-moredrop");
    var buttonRemove = $("#remove-drop");
    var className = ".drop-field2";
    var count = 0;
    var field = "";
    var maxFields = 50;

    function totalFields() {
        return $(className).length;
    }

    function addNewField() {
        count = totalFields() + 1;
        field = $("#drop-field").clone();
        field.attr("id", "drop-field2" + count);
        field.children("label").text("Field " + count);
        field.find("input").val("");
        field.find("input[name='types[]']").val(1); // Set default type value
        $(className + ":last").after($(field));
    }

    function removeLastField() {
        if (totalFields() > 1) {
            $(className + ":last").remove();
        }
    }

    function enableButtonRemove() {
        if (totalFields() === 2) {
            buttonRemove.removeAttr("disabled");
            buttonRemove.addClass("shadow-sm");
        }
    }

    function disableButtonRemove() {
        if (totalFields() === 1) {
            buttonRemove.attr("disabled", "disabled");
            buttonRemove.removeClass("shadow-sm");
        }
    }

    function disableButtonAdd() {
        if (totalFields() === maxFields) {
            buttonAdd.attr("disabled", "disabled");
            buttonAdd.removeClass("shadow-sm");
        }
    }

    function enableButtonAdd() {
        if (totalFields() === (maxFields - 1)) {
            buttonAdd.removeAttr("disabled");
            buttonAdd.addClass("shadow-sm");
        }
    }

    buttonAdd.click(function() {
        addNewField();
        enableButtonRemove();
        disableButtonAdd();
        initializeStreet();
    });

    buttonRemove.click(function() {
        removeLastField();
        disableButtonRemove();
        enableButtonAdd();
        initializeStreet();
    });
});

valid_format();

    function valid_format(){

        $("input[name='lcoation_name[]']").on('input', function() {
            if($(this).val().length > 254) {
                $(this).val($(this).val().slice(0, 254));
            }
        });

        $("input[name='notes[]']").on('input', function() {
            if($(this).val().length > 254) {
                $(this).val($(this).val().slice(0, 254));
            }
        });

        $("input[name='dock_info[]']").on('input', function() {
            if($(this).val().length > 254) {
                $(this).val($(this).val().slice(0, 254));
            }
        });
    }



</script>
@endpush
