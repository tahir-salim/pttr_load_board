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
            <form action="{{ route(auth()->user()->type . '.update_a_shipment',[$shipment->id]) }}" method="POST"
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

                <div class="row">
                    <div class="col-md-7">

                        <div class="card shipmentDetails">
                            <h3>Shipment Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fields">
                                        <input type="text" required name="origin" id="OriginTextField"
                                            value="{{$shipment->origin ? $shipment->origin : '' }}"
                                            placeholder="Origin (City, ST, ZIP)*">
                                        <input type="text" id="origin_id" hidden name="origin_place_id"
                                            value="{{$shipment->origin_place_id ? $shipment->origin_place_id : '' }}"
                                            placeholder="Origin (City, ST, ZIP)*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fields">
                                        <input type="text" id="DestinationTextField" required name="destination"
                                            value="{{$shipment->destination ? $shipment->destination : '' }}"
                                            placeholder="Destination (City, ST, ZIP)*">
                                        <input type="text" id="destination_id" hidden name="destination_place_id"
                                            value="{{$shipment->destination_place_id ? $shipment->destination_place_id : '' }}"
                                            placeholder="Destination (City, ST, ZIP)*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="date" name="from_date"
                                                    min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{$shipment->from_date ? Carbon\Carbon::create($shipment->from_date)->format('Y-m-d')  : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="date" name="to_date"
                                                    value="{{$shipment->to_date ? Carbon\Carbon::create($shipment->to_date)->format('Y-m-d')  : '' }}"
                                                    min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fields">

                                                <input type="time" placeholder="Pickup Hours" name="from_time"
                                                    value="{{$shipment->from_time ? $shipment->from_time  : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="time" name="to_time" placeholder="Drop Off Hours"
                                                    value="{{$shipment->to_time ? $shipment->to_time  : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3>Equipment Details</h3>
                            <div class="radioBtns">
                                <div class="radios">
                                    <input type="radio" id="full" name="equipment_detail"
                                        {{$shipment->equipment_detail  == 0 ? 'checked' : ''  }} checked value="0">
                                    <label for="full"> Full</label>
                                </div>
                                <div class="radios">
                                    <input type="radio" id="Partial" name="equipment_detail"
                                        {{$shipment->equipment_detail  == 1 ? 'checked' : ''  }} value="1">
                                    <label for="Partial"> Partial</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fields">

                                        <select required name="eq_type_id">
                                            <option hidden value="">Equipment Type*</option>
                                            @foreach ($equipment_types as $equipment_type)
                                            <option value="{{ $equipment_type->id }}"
                                                {{$equipment_type->id == $shipment->eq_type_id ? 'selected' : ''}}>
                                                {{ $equipment_type->name }}
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
                                                <input type="number" required name="length"
                                                    value="{{$shipment->length ? $shipment->length : '' }}"
                                                    placeholder="Length (ft)*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="number" required name="weight"
                                                    value="{{$shipment->weight ? $shipment->weight : '' }}"
                                                    placeholder="Weight (Ibs.) *">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fields">
                                        <textarea name="eq_name" id="" cols="10" rows="10"
                                            placeholder="Comment">{{$shipment->eq_name ? $shipment->eq_name : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fields">
                                        <input type="text" name="commodity" placeholder="Commodity"
                                            value="{{$shipment->commodity ? $shipment->commodity : '' }}">
                                    </div>
                                    <div class="fields">
                                        <input type="text" name="reference_id" placeholder="Reference ID"
                                            value="{{$shipment->reference_id ? $shipment->reference_id : '' }}">
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
                                            <input type="checkbox" name="status_phone" value="1"
                                                {{$shipment->status_phone == 1 ? 'checked' : '' }}
                                                class="contact-checkbox" id="primaryphone">
                                            <label
                                                for="primaryphone">{{$shipment->user ? $shipment->user->phone :  '' }}
                                                (Phone)</label>
                                        </div>
                                        <div class="check">
                                            <input type="checkbox" name="status_email" value="1"
                                                {{$shipment->status_email == 1 ? 'checked' : '' }}
                                                class="contact-checkbox" id="email">
                                            <label for="email">{{$shipment->user ? $shipment->user->email :  '' }}
                                                (Email)</label>
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
                                        <label for=""><strong>Track Shipment with DAT One</strong>
                                            (Optional)</label>
                                        <label for="">Once your driver accepts DAT tracking, you'll have access
                                            to ETAs and real-time updates of where your shipment is along it's
                                            journey</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <a class="bdBtns d-inline" href="#" id="addDatTracking" title="">ADD DAT
                                            TRACKING </a>
                                    </div>
                                </div>
                                <div id="hiddenDatTracking">


                                    @if($shipment->tracking)
                                    @foreach ($shipment->tracking->tracking_details->where('type', 0) as $k => $pickup)
                                    <div class="card shipmentDetails pick-field1" id="pick-field-1">
                                        <h3>Pick Up</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Street Address"
                                                        class="PickStreetAddresstField"
                                                        value="{{$pickup->street_address}}" name="street_address[]"
                                                        required="">
                                                    <input type="text" class="pick_street_place_id" hidden
                                                        value="{{$pickup->street_place_id}}" name="street_place_id[]">
                                                    <input class="pick_street_addressLat" hidden
                                                        name="street_addressLat[]"
                                                        value="{{$pickup->street_addressLat}}" type="text"
                                                        placeholder="Latitude">
                                                    <input class="pick_street_addressLng" hidden
                                                        name="street_addressLng[]"
                                                        value="{{$pickup->street_addressLng}}" type="text"
                                                        placeholder="Longitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" placeholder="Appointment date"
                                                        name="appointment_date[]" value="{{$pickup->appointment_date}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="No Dock Information Available"
                                                        name="dock_info[]" required="" value="{{$pickup->dock_info}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="Start Time"
                                                                name="start_time[]" value="{{$pickup->start_time}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="End Time" name="end_time[]"
                                                                value="{{$pickup->end_time}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Location Name"
                                                        name="lcoation_name[]" value="{{$pickup->lcoation_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Notes" name="notes[]"
                                                        value="{{$pickup->notes}}">

                                                </div>
                                                <input type="hidden" name="types[]"
                                                    value="{{$pickup->type ? $pickup->type : 0}}">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select name="tracking_start_time[]" id="">
                                                        <option value="Begin at first appointment"
                                                            {{$pickup->tracking_start_time == "Begin at first appointment" ? 'selected': ''}}>
                                                            Begin at first appointment
                                                        </option>
                                                        <option value="Begin tracking 1 hours before Pick Up"
                                                            {{$pickup->tracking_start_time == "Begin tracking 1 hours before Pick Up" ? 'selected': ''}}>
                                                            Begin tracking 1 hours before Pick Up
                                                        </option>
                                                        <option value="Begin tracking 2 hours before Pick Up"
                                                            {{$pickup->tracking_start_time == "Begin tracking 2 hours before Pick Up" ? 'selected': ''}}>
                                                            Begin tracking 2 hours before Pick Up
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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


                                    @foreach ($shipment->tracking->tracking_details->where('type', 1) as $k => $dropoff)
                                    <div class="card shipmentDetails drop-field2" id="drop-field">
                                        <h3>Drop Off</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Street Address"
                                                        class="DropStreetAddresstField" name="street_address[]"
                                                        required="" value="{{$dropoff->street_address}}">
                                                    <input type="text" class="drop_street_place_id" hidden
                                                        value="{{$dropoff->street_place_id}}" name="street_place_id[]">
                                                    <input class="drop_street_addressLat" hidden
                                                        name="street_addressLat[]" type="text" placeholder="Latitude"
                                                        value="{{$dropoff->street_addressLat}}">
                                                    <input class="drop_street_addressLng" hidden
                                                        name="street_addressLng[]"
                                                        value="{{$dropoff->street_addressLng}}" type="text"
                                                        placeholder="Longitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" placeholder="Appointment date"
                                                        value="{{$dropoff->appointment_date}}"
                                                        name="appointment_date[]">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="No Dock Information Available"
                                                        value="{{$dropoff->dock_info}}" name="dock_info[]" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="Start Time"
                                                                name="start_time[]" value="{{$dropoff->start_time}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="End Time" name="end_time[]"
                                                                value="{{$dropoff->end_time}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Location Name"
                                                        name="lcoation_name[]" value="{{$dropoff->lcoation_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Notes" name="notes[]"
                                                        value="{{$dropoff->notes}}">
                                                </div>
                                                <input type="hidden" name="types[]"
                                                    value="{{$dropoff->type ?  $dropoff->type : 1}}">
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select name="tracking_start_time[]" id="">
                                                        <option value="Begin at first appointment"
                                                            {{$dropoff->tracking_start_time == "Begin at first appointment" ? 'selected': ''}}>
                                                            Begin at first appointment
                                                        </option>
                                                        <option value="Begin tracking 1 hours before Pick Up"
                                                            {{$dropoff->tracking_start_time == "Begin tracking 1 hours before Pick Up" ? 'selected': ''}}>
                                                            Begin tracking 1 hours before Pick Up
                                                        </option>
                                                        <option value="Begin tracking 2 hours before Pick Up"
                                                            {{$dropoff->tracking_start_time == "Begin tracking 2 hours before Pick Up" ? 'selected': ''}}>
                                                            Begin tracking 2 hours before Pick Up
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                                    @else
                                    <div class="card shipmentDetails pick-field1" id="pick-field-1">
                                        <h3>Pick Up</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Street Address"
                                                        class="PickStreetAddresstField" name="street_address[]">
                                                    <input type="text" class="pick_street_place_id" hidden
                                                        name="street_place_id[]">
                                                    <input class="pick_street_addressLat" hidden
                                                        name="street_addressLat[]" type="text" placeholder="Latitude">
                                                    <input class="pick_street_addressLng" hidden
                                                        name="street_addressLng[]" type="text" placeholder="Longitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" placeholder="Appointment date"
                                                        name="appointment_date[]">
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
                                                                name="start_time[]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="End Time" name="end_time[]">
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
                                                <input type="hidden" name="types[]" value="0">
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
                                    <div class="card shipmentDetails drop-field2" id="drop-field">
                                        <h3>Drop Off</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Street Address"
                                                        class="DropStreetAddresstField" name="street_address[]">
                                                    <input type="text" class="drop_street_place_id" hidden
                                                        name="street_place_id[]">
                                                    <input class="drop_street_addressLat" hidden
                                                        name="street_addressLat[]" type="text" placeholder="Latitude">
                                                    <input class="drop_street_addressLng" hidden
                                                        name="street_addressLng[]" type="text" placeholder="Longitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" placeholder="Appointment date"
                                                        name="appointment_date[]">
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
                                                                name="start_time[]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="time" placeholder="End Time" name="end_time[]">
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
                                                <input type="hidden" name="types[]" value="1">
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        {{-- @if ($contact < 1) --}}
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
                        {{-- @endif
                            @if ($contact > 0) --}}
                        <div class="card requireTracking">
                            <h3>Select your Audience</h3>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="requiredtrackField">
                                        <label for="booknow">
                                            Customize your audience for this shipment within the DAT Load Board and
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
                                                {{-- @dd($shipment->group_id); --}}
                                                <select class="js-example-basic-multiple" id="grpReq" name="groups[]"
                                                    required multiple="multiple">
                                                    @php $selected = $shipment->group_id ?
                                                    unserialize($shipment->group_id) : []; @endphp

                                                    @foreach ($groups as $group)
                                                    <option value="{{$group->id}}"
                                                        {{ (in_array($group->id, $selected)) ? 'selected' : '' }}>
                                                        {{$group->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <input type="checkbox" name="is_public_load" id="privatenetwork" required>
                                    <label for="privatenetwork">
                                        Post to DAT Load Board
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
                        {{-- @endif --}}
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
                                            <input type="text" placeholder="Rate / Trip" name="dat_rate"
                                                value="{{$shipment->dat_rate ? $shipment->dat_rate : '' }}">
                                        </div>
                                        <h5>Private Network</h5>
                                        <div class="fields">
                                            <input type="text" placeholder="Rate / Trip" name="private_rate"
                                                value="{{$shipment->private_rate ? $shipment->private_rate : '' }}">
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
                                            <input type="text" placeholder="Maximum Rate / Trip" name="max_bid_rate"
                                                value="{{$shipment->max_bid_rate ? $shipment->max_bid_rate : '' }}">
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
<script type="text/javascript">
$('.postPrivateNetwork').prop("disabled", true);
$('#bookingRate').prop("disabled", true);
$("#privatenet").prop("disabled", true);
$('input[name="private_rate"]').attr("disabled", true);
$('input[name="dat_rate"]').attr("disabled", true);

$('.spanHide').hide();

//public load
$(document).on("click", "#privatenetwork", function() {
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

// public load


// $('.groudHide').hide();

// Groups
$('.groudHide').hide();
$(document).on("change", 'input[type=radio][name=postPrivate]', function() {
    if (this.value == 'entire_private_network_id') {
        $('#grpReq').removeAttr("required");
        $('.groudHide').hide();
    } else if (this.value == 'is_group') {
        $('.groudHide').show();
        $('.js-example-basic-multiple').select2();
        $('#grpReq').attr("required", true);

    }
});
// Groups

//is private networl
$(document).on("click", ".chkpostPrivateNetwork:checkbox", function() {
    if ($(this).is(':checked')) {
        $('.postPrivateNetwork').prop("disabled", false);
        $('input[name="is_public_load"]').prop('required', false);
        $('#bookingRate').prop("checked", false).trigger('click');
        $('#bookingRate').prop("disabled", false);
        $('input[name="private_rate"]').attr("disabled", false);
        $('input[name="private_rate"]').attr("required", true);
        $('.spanHide').show();
        if ($('input[type=radio][name=postPrivate][value="is_group"]').is(":checked")) {
            $('.groudHide').show();
        }

        console.log('is private networl check');
    } else {
        if ($('.chk').filter(':checked').length < 1) {
            $('input[name="is_public_load"]').prop('required', true);
            $('#bookingRate').prop("checked", true).trigger('click');
            $('#bookingRate').prop("checked", false);
            $('#privatenet').prop("checked", false);
            $('#bookingRate').prop("disabled", true);
            $('input[name="private_rate"]').attr("disabled", true);
            $('input[name="private_rate"]').val('');
            $('input[name="dat_rate"]').removeAttr("required");
            $('input[name="postPrivate"][value="entire_private_network_id"]').attr('checked', true);
            $('.groudHide').hide();
            $('.spanHide').hide();
            $('.postPrivateNetwork').attr('disabled', true);
            console.log('is private networl un check');
        }
    }
});

//is private network


//is booking networl
$(document).on("click", "#bookingRate", function() {

    if ($(this).is(":checked")) {
        $('#privatenet').prop("checked", false).trigger('click');
        $("#privatenet").prop("disabled", false);
        console.log('booking check');
    } else {
        $('#privatenet').prop("checked", true).trigger('click');
        $("#privatenet").prop("disabled", true);
        console.log('booking uncheck');
    }
});
//is booking networl



$('#setMaxRate12').hide();
$('#setMaxRate13').hide();
// its Allow bids
$(document).on("click", "#privatenet", function() {
    if ($(this).is(':checked')) {
        $(this).attr('value', 'true');
        $('#setMaxRate12').show();
        $('#setMaxRate13').hide();
        console.log('its Allow bids check');
    } else {
        $(this).attr('value', 'false');
        $('#setMaxRate12').hide();
        $('#setMaxRate').prop('checked', false);
        $('#setMaxRate13').hide();
        console.log('its Allow bids uncheck');
    }
});
// its Allow bids


// its max_bid_rate
$(document).on("click", "#setMaxRate", function() {
    if ($(this).is(':checked')) {
        $('#setMaxRate13').show();
        $('input[name="max_bid_rate"]').attr("required", true);
    } else {
        $('#setMaxRate13').hide();
        $('input[name="max_bid_rate"]').removeAttr("required");
    }
});
//its  max_bid_rate

function initializeStreet() {
    var options1 = {
        types: ['establishment'],
        componentRestrictions: {
            country: "us"
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
        types: ['(regions)'],
        componentRestrictions: {
            country: "us"
        }
    };

    var input = document.getElementById('OriginTextField');
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();

        document.getElementById('origin_id').value = place.place_id;
        // document.getElementById('cityLat').value = place.geometry.location.lat();
        // document.getElementById('cityLng').value = place.geometry.location.lng();
        // var lat = place.geometry.location.lat();
        // var lng = place.geometry.location.lng();
        // initMap(lat,lng);

    });
    var input1 = document.getElementById('DestinationTextField');
    var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
    google.maps.event.addListener(autocomplete1, 'place_changed', function() {
        var place1 = autocomplete1.getPlace();

        document.getElementById('destination_id').value = place1.place_id;
        // document.getElementById('cityLat').value = place.geometry.location.lat();
        // document.getElementById('cityLng').value = place.geometry.location.lng();
        // var lat = place.geometry.location.lat();
        // var lng = place.geometry.location.lng();
        // initMap(lat,lng);

    });
}

initialize();

$(document).on("click", "#tracking", function() {
    if ($(this).is(':checked')) {
        $(this).attr('value', 'true');
        $('#shipment').show();
        $('#addDatTracking').trigger('click');
        $('input[name="street_address[]"]').attr("required", true);
        $('input[name="appointment_date[]"]').attr("required", true);
        $('input[name="start_time[]"]').attr("required", true);
        $('input[name="end_time[]"]').attr("required", true);
    } else {
        $(this).attr('value', 'false');
        $('input[name="street_address[]"]').removeAttr("required");
        $('input[name="appointment_date[]"]').removeAttr("required");
        $('input[name="start_time[]"]').removeAttr("required");
        $('input[name="end_time[]"]').removeAttr("required");
        $('#shipment').hide();
    }
});


$('#shipment').hide();


$(document).on("click", "#addDatTracking", function() {
    $('#hiddenDatTracking').show();
});







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


var is_tracking = {
    {
        $shipment - > is_tracking
    }
};
if (is_tracking == 1) {
    $('#tracking').prop('checked', false).trigger("click");
}

var is_private_network = {
    {
        $shipment - > is_private_network
    }
};
if (is_private_network == 1) {
    $('.chkpostPrivateNetwork:checkbox').prop('checked', false).trigger("click");
}

var is_group = {
    {
        $shipment - > is_group == 1 ? 1 : 0
    }
};

if (is_group == 1) {
    $('#postPrivate2').trigger("click");
}



var is_public_load = {
    {
        $shipment - > is_public_load
    }
};
if (is_public_load == 1) {
    $('#privatenetwork').trigger("click");
}

var is_allow_carrier_to_book_now = {
    {
        $shipment - > is_allow_carrier_to_book_now
    }
};
if (is_allow_carrier_to_book_now == 1) {
    $('#bookingRate').prop('checked', false).trigger("click");
}

var is_allow_bids = {
    {
        $shipment - > is_allow_bids
    }
};
if (is_allow_bids == 1) {
    $('#privatenet').prop('checked', false).trigger("click");


    var max_bid_rate = {
        {
            $shipment - > max_bid_rate ? $shipment - > max_bid_rate : 0
        }
    };
    if (max_bid_rate != 0 || max_bid_rate != null || is_allow_bids != 0) {
        $('#setMaxRate').prop('checked', false).trigger("click");
    }

}


if ($('input[type=radio][name=postPrivate][value="is_group"]').is(":checked")) {
    $('#grpReq').attr("required", true);
} else {
    $('#grpReq').removeAttr("required");
}
// is_allow_bids
</script>
@endpush