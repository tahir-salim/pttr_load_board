@extends('Admin.layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Update Service</h2>
            </div>
            @push('css')
                <style>
                .image-container {
                    display: flex;
                    gap: 10px; /* Add space between images if needed */
                    flex-wrap: wrap; /* Wrap images to the next line if there are too many */
                }
                #imagePreview {
                    width: 100px; /* Adjust the size of the preview */
                    height: 100px;
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    border: 1px solid #ccc;
                    margin-right: 10px;
                }
            </style>
            @endpush
            <div class="contBody">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shipmentDetails">
                            <form id="SubmitFormSh" action="{{ route('super-admin.service_category_item.update',[$serviceCategoryItem->id]) }}" method="POST" enctype="multipart/form-data">
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
                                    <div class="col-md-6">
                                    <h3>Service</h3>
                                        <div class="fields">
                                            <select id="parent-select" name="service_id" required>
                                                <option hidden value="">Select Service Name</option>
                                                @foreach($services as $service)
                                                
                                                    <option value="{{$service->id}}" {{$service->name == $serviceCategoryItem->service->name ? "selected" : ""}}>{{$service->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <h3> Category</h3>
                                        <div class="fields">
                                           {{-- <select id="child-select" name="category_id">
                                            </select>--}}
                                            <select id="child-select" name="category_id">
                                                <option hidden value="">Select Service Name</option>
                                                
                                                @if($serviceCategoryItem->serviceCategory != null)
                                                    @foreach($serviceCategories as $serviceCategory)
                                                        <option value="{{$serviceCategory->id}}" {{$serviceCategory->name == $serviceCategoryItem->serviceCategory->name ? "selected" : ""}}>{{$serviceCategory->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shipmentDetails drop-field2" id="drop-field">
                                    <h3>Items</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="text" placeholder="Enter Item location" class="DropStreetAddresstField" name="street_address" required value="{{$serviceCategoryItem->street_address}}" id="street_address">
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="fields">
                                                <input class="drop_street_addressLat" name="street_addressLat" type="text" placeholder="Latitude" value="{{$serviceCategoryItem->lat}}" id="lat">
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="fields">
                                                <input class="drop_street_addressLng" name="street_addressLng" type="text" placeholder="Longitude" value="{{$serviceCategoryItem->lng}}" id="lng">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="file" name="image" class="form-control" placeholder="image"  id="imagePreviewWeb" accept=".png, .jpg, .jpeg, .gif" style="height: auto">
                                                <input type="hidden" name="old_icon" value="{{$serviceCategoryItem->icon}}">
                                            </div>
                                            <div id="imagePreview" style="background-image: url({{asset($serviceCategoryItem->icon)}})">
                                            </div>
                                        </div>
                                    </div>
                                </div>    
    
                                <div class="btnShipments halfbtn">
                                    <a href="{{ route('super-admin.service_category_item.list') }}" type="button"
                                        class="cancelBtn removeBtns">Cancel Item</a>
                                    <input type="submit" class="postBtn" value="UPDATE ITEM">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
          
                e.currentTarget.submit();
        });

        ClassicEditor.create( document.querySelector( '#content' ) )
            .catch( error => {
                console.error( error );
            } );

            function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    console.log(e.target.result );
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').show();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }else{
                $('#imagePreview').hide();
            }
            }
            $("#imageUpload").change(function() {
            readURL(this);

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

            function initializeStreet() {
                var options1 = {
                    types: ['establishment'],
                    componentRestrictions: {
                        country: ["us","cn","ca"]
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

            $(document).ready(function() {
                $('#parent-select').change(function() {
                    var parentValue = $(this).val();
                    console.log(parentValue);

                    $.ajax({
                        url: "{{ route('super-admin.service_category') }}",
                        type: "GET",
                        data: { parent_value: parentValue },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            $('#child-select').empty(); // Child select ko empty karna

                            // Ek default option add karna
                            $('#child-select').append('<option value="">Select a Category</option>');

                            // AJAX se aaye hue data ko child select me append karna
                            $.each(response, function(index, value) {
                                $('#child-select').append('<option value="'+value.id+'">'+value.name+'</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("Error occurred: " + error);
                        }
                    });
                });
            });            
    </script>
@endpush
