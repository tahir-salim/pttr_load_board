@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>New Tracking Request</h2>
                <div class="rightBtn">
                    <a class="themeBtn skyblue" href="{{ route(auth()->user()->type . '.trackings') }}" tile="">
                        Tracking List
                    </a>
                </div>
            </div>
            @php
                $top_header1 = ads('new_tracking_request','top_header1');
                $top_header2 = ads('new_tracking_request','top_header2');
                $top_header3 = ads('new_tracking_request','top_header3');
            @endphp
            <div class="contBody">
                @if(isset($top_header1) && isset($top_header2) && isset($top_header3))
                    <div class="row">
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header1->url}}" target="_blank" title=""><img src="{{asset($top_header1->image)}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header2->url}}" target="_blank" title=""><img src="{{asset($top_header2->image)}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header3->url}}" target="_blank" title=""><img src="{{asset($top_header3->image)}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                @endif
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="">{{ $error }}</div>
                        @endforeach
                    @endif
                <form action="{{ route(auth()->user()->type . '.new_tracking_store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="card shipmentDetails">
                                <h3>Driver Details</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields phoneusa">
                                            <input type="number" placeholder="Driver Phone Number" name="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" placeholder="Driver Name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="email" placeholder="Carrier Email" name="carrier_email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" placeholder="Shipment Name or ID" name="Shipment_name_id"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shipmentDetails pick-field1" id="pick-field-1">
                                <h3>Pick Up * </h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" placeholder="Street Address"
                                                class="PickStreetAddresstField" name="street_address[]" required="">
                                            <input type="text" class="pick_street_place_id" hidden
                                                name="street_place_id[]">
                                            <input class="pick_street_addressLat" hidden name="street_addressLat[]"
                                                type="text" placeholder="Latitude">
                                            <input class="pick_street_addressLng" hidden name="street_addressLng[]"
                                                type="text" placeholder="Longitude">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="date" placeholder="Appointment date" name="appointment_date[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" placeholder="No Dock Information Available"
                                                name="dock_info[]" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="time" placeholder="Start Time" name="start_time[]">
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
                                            <input type="text" placeholder="Location Name" name="lcoation_name[]">
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
                        </div>
                        <div class="col-md-6">
                            <div class="card shipmentDetails drop-field2" id="drop-field">
                                <h3>Drop Off *</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" placeholder="Street Address"
                                                class="DropStreetAddresstField" name="street_address[]" required="">
                                            <input type="text" class="drop_street_place_id" hidden
                                                name="street_place_id[]">
                                            <input class="drop_street_addressLat" hidden name="street_addressLat[]"
                                                type="text" placeholder="Latitude">
                                            <input class="drop_street_addressLng" hidden name="street_addressLng[]"
                                                type="text" placeholder="Longitude">
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
                                                name="dock_info[]" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="time" placeholder="Start Time" name="start_time[]">
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
                                            <input type="text" placeholder="Location Name" name="lcoation_name[]">
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
                            <br />
                            <div class="btnShipments">
                                <input type="button" class="cancelBtn" value="Reset" reset>
                                <input type="submit" class="postBtn" value="Post">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI&libraries=places">
        </script>
        <script type="text/javascript">
    function initializeAutocomplete(element, options) {
        var autocomplete = new google.maps.places.Autocomplete(element, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            var parent = $(element).parent();
            $(element).val(place.formatted_address);
            parent.find('input.pick_street_place_id, input.drop_street_place_id').val(place.place_id);
            parent.find('input.pick_street_addressLat, input.drop_street_addressLat').val(place.geometry.location.lat());
            parent.find('input.pick_street_addressLng, input.drop_street_addressLng').val(place.geometry.location.lng());
            toggleSubmitButton();
        });
    }

    function toggleSubmitButton() {
        let allFilled = true;
        $('.PickStreetAddresstField, .DropStreetAddresstField').each(function() {
            var parent = $(this).parent();
            if (parent.find('input.pick_street_place_id, input.drop_street_place_id').val() === "" ||
                parent.find('input.pick_street_addressLat, input.drop_street_addressLat').val() === "" ||
                parent.find('input.pick_street_addressLng, input.drop_street_addressLng').val() === "") {
                allFilled = false;
                return false; // exit loop
            }
        });
        $('.postBtn').prop('disabled', !allFilled);
    }

    function initialize() {
        var options = {
            types: ['establishment'],
            componentRestrictions: {
                country: "us"
            }
        };

        $('.PickStreetAddresstField').each(function() {
            initializeAutocomplete(this, options);
        });

        $('.DropStreetAddresstField').each(function() {
            initializeAutocomplete(this, options);
        });

        toggleSubmitButton();
    }

    function addNewField(className, cloneId) {
        var count = $(className).length + 1;
        var field = $(cloneId).clone();
        field.attr("id", cloneId.replace('#', '') + "-" + count);
        field.find("input").val("");
        $(className + ":last").after($(field));
        initialize();
    }

    function setupFieldHandlers(buttonAdd, buttonRemove, className, cloneId, maxFields) {
        buttonRemove.hide();

        function totalFields() {
            return $(className).length;
        }

        function enableButtonRemove() {
            if (totalFields() === 2) {
                buttonRemove.show();
                buttonRemove.addClass("shadow-sm");
            }
        }

        function disableButtonRemove() {
            if (totalFields() === 1) {
                buttonRemove.hide();
                buttonRemove.removeClass("shadow-sm");
            }
        }

        function disableButtonAdd() {
            if (totalFields() === maxFields) {
                buttonAdd.hide();
                buttonAdd.removeClass("shadow-sm");
            }
        }

        function enableButtonAdd() {
            if (totalFields() === (maxFields - 1)) {
                buttonAdd.show();
                buttonAdd.addClass("shadow-sm");
            }
        }

        buttonAdd.click(function() {
            addNewField(className, cloneId);
            enableButtonRemove();
            disableButtonAdd();
            toggleSubmitButton();
        });

        buttonRemove.click(function() {
            if (totalFields() > 1) {
                $(className + ":last").remove();
                disableButtonRemove();
                enableButtonAdd();
                toggleSubmitButton();
            }
        });
    }

    $(document).ready(function() {
        initialize();

        setupFieldHandlers(
            $("#add-morepick"),
            $("#remove-pick"),
            ".pick-field1",
            "#pick-field-1",
            50
        );

        setupFieldHandlers(
            $("#add-moredrop"),
            $("#remove-drop"),
            ".drop-field2",
            "#drop-field",
            50
        );
    });
</script>
    @endpush
@endsection
