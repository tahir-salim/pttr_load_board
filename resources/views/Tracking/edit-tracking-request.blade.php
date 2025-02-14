@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Update Send Tracking</h2>
                <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{ route(auth()->user()->type . '.trackings') }}" tile="">
                    Send Tracking List
                </a>
                </div>
            </div>
            @php
                $top_header1 = ads('edit_tracking_request','top_header1');
                $top_header2 = ads('edit_tracking_request','top_header2');
                $top_header3 = ads('edit_tracking_request','top_header3');
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
                <form id="SubmitFormTr" action="{{ route(auth()->user()->type . '.new_tracking_update',[$tracking->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shipmentDetails">
                                <h3>Driver Details</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields phoneusa">
                                            <input type="tel" placeholder="Driver Phone Number" min="8" name="phone" value="{{$tracking->phone ? $tracking->phone : null}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" placeholder="Driver Name" name="name" required value="{{$tracking->name ? $tracking->name : null}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="email" placeholder="Carrier Email" name="carrier_email" required value="{{$tracking->carrier_email ? $tracking->carrier_email : null}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" value="{{ $tracking->shipments->origin }} / {{$tracking->shipments->destination}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row btnShipments">
                        <div class="col-md-12">
                             <input type="submit" class="postBtn" value="Update External Tracking">
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
        
        $('.dropdown_validate').on('input', function() {
                if($(this).parent().is(":visible")){
                   jQuery(this).parent().find('input[type="hidden"]').val('');
                }
              });
              
              
              $(document).on('submit','#SubmitFormTr',function(e){
                e.preventDefault();
                var IsValid = 0;
                $('#SubmitFormTr input[type="hidden"]').each(function(){
                  if($(this).parent().is(":visible")){
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
            
            
            
            function initialize() {
                var options = {
                    types: ['establishment'],
                    componentRestrictions: {
                        country: "us"
                    }
                };

                // Pickup
                $('.PickStreetAddresstField').each(function() {
                    var autocomplete1 = new google.maps.places.Autocomplete(this, options);
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
                    var autocomplete = new google.maps.places.Autocomplete(this, options);
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

            initialize();
        </script>
        <script>
            $(document).ready(function() {

                var buttonAdd = $("#add-morepick");
                var buttonRemove = $("#remove-pick");
                var className = ".pick-field1";
                var count = 0;
                var field = "";
                var maxFields = 50;
                // buttonRemove.hide();

                function totalFields() {
                    return $(className).length;
                }

                function addNewField() {
                    count = totalFields() + 1;
                    field = $("#pick-field-1").clone();
                    field.attr("id", "pick-field1-" + count);
                    field.children("label").text("Field " + count);

                    var hiddenvalue = field.find('input[name="types[]"]').val();
                    var hiddenvalue1 = field.find('input[name="street_place_id[]"]').val();
                    var hiddenvalue2 = field.find('input[name="street_addressLat[]"]').val();
                    var hiddenvalue3 = field.find('input[name="street_addressLng[]"]').val();
                    field.find("input").val("");
                    field.find('input[name="types[]"]').val(hiddenvalue);
                    field.find('input[name="street_place_id[]"]').val(hiddenvalue1);
                    field.find('input[name="street_addressLat[]"]').val(hiddenvalue2);
                    field.find('input[name="street_addressLng[]"]').val(hiddenvalue3);

                    $(className + ":last").after($(field));
                }

                function removeLastField() {
                    if (totalFields() > 1) {
                        $(className + ":last").remove();
                    }
                }

                function enableButtonRemove() {
                    if (totalFields() === 2) {
                        //   buttonRemove.removeAttr("disabled");
                        buttonRemove.show();
                        buttonRemove.addClass("shadow-sm");
                    }
                }

                function disableButtonRemove() {

                    if (totalFields() === 1) {
                        //   buttonRemove.attr("disabled", "disabled");
                        buttonRemove.hide();
                        buttonRemove.removeClass("shadow-sm");
                    }
                }

                function disableButtonAdd() {
                    if (totalFields() === maxFields) {
                        //   buttonAdd.attr("disabled", "disabled");
                        buttonRemove.hide();
                        buttonAdd.removeClass("shadow-sm");
                    }
                }

                function enableButtonAdd() {
                    if (totalFields() === (maxFields - 1)) {
                        //   buttonAdd.removeAttr("disabled");
                        buttonRemove.show();
                        buttonAdd.addClass("shadow-sm");
                    }
                }

                buttonAdd.click(function() {
                    addNewField();
                    enableButtonRemove();
                    disableButtonAdd();
                    initialize();
                });

                buttonRemove.click(function() {
                    removeLastField();
                    disableButtonRemove();
                    enableButtonAdd();
                    initialize();
                });
            });



            $(document).ready(function() {
                var buttonAdd = $("#add-moredrop");
                var buttonRemoveDrop = $("#remove-drop");
                var className = ".drop-field2";
                var count = 0;
                var field = "";
                var maxFields = 50;
                // buttonRemoveDrop.hide();

                function totalFields() {
                    return $(className).length;
                }

                function addNewField() {
                    count = totalFields() + 1;
                    field = $("#drop-field").clone();
                    field.attr("id", "drop-field2" + count);
                    field.children("label").text("Field " + count);
                    var hiddenvalue = field.find('input[name="types[]"]').val();
                    var hiddenvalue1 = field.find('input[name="street_place_id[]"]').val();
                    var hiddenvalue2 = field.find('input[name="street_addressLat[]"]').val();
                    var hiddenvalue3 = field.find('input[name="street_addressLng[]"]').val();
                    field.find("input").val("");
                    field.find('input[name="types[]"]').val(hiddenvalue);
                    field.find('input[name="street_place_id[]"]').val(hiddenvalue1);
                    field.find('input[name="street_addressLat[]"]').val(hiddenvalue2);
                    field.find('input[name="street_addressLng[]"]').val(hiddenvalue3);
                    $(className + ":last").after($(field));
                }

                function removeLastField() {
                    if (totalFields() > 1) {
                        $(className + ":last").remove();
                    }
                }

                function enableButtonRemoveDrop() {
                    if (totalFields() === 2) {
                        //   buttonRemoveDrop.removeAttr("disabled");
                        buttonRemoveDrop.show();
                        buttonRemoveDrop.addClass("shadow-sm");
                    }
                }

                function disableButtonRemoveDrop() {
                    if (totalFields() === 1) {
                        //   buttonRemoveDrop.attr("disabled", "disabled");
                        buttonRemoveDrop.hide();
                        buttonRemoveDrop.removeClass("shadow-sm");
                    }
                }

                function disableButtonAdd() {
                    if (totalFields() === maxFields) {
                        //   buttonAdd.attr("disabled", "disabled");
                        buttonRemoveDrop.hide();
                        buttonAdd.removeClass("shadow-sm");
                    }
                }

                function enableButtonAdd() {
                    if (totalFields() === (maxFields - 1)) {
                        //   buttonAdd.removeAttr("disabled");
                        buttonRemoveDrop.show();
                        buttonAdd.addClass("shadow-sm");
                    }
                }

                buttonAdd.click(function() {
                    addNewField();
                    enableButtonRemoveDrop();
                    disableButtonAdd();
                    initialize();
                });

                buttonRemoveDrop.click(function() {
                    removeLastField();
                    disableButtonRemoveDrop();
                    enableButtonAdd();
                    initialize();
                });
            });
        </script>
    @endpush
@endsection
