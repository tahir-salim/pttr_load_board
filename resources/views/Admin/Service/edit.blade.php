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
                            <form action="{{ route('super-admin.service.update',[$service->id]) }}" method="POST" enctype="multipart/form-data">
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
                                        <div class="fields">
                                            <input type="text" required  name="service_name" value="{{$service->name}}" placeholder="Enter Service Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select id='' required name="list_name" class="form-control" style="height: auto">
                                                <!-- <option hidden value=""> Select List Name</option> -->
                                                    @foreach($list_items as $list_item)
                                                    <option value="{{$list_item->list_name}}" {{$service->list_name == $list_item->list_name ? "selected" : ""}}>{{$list_item->list_name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="file" name="icon" class="form-control" placeholder="Service icon"  id="imageUpload" accept=".png, .jpg, .jpeg, .gif"
                                             style="height: auto" value="{{asset($service->icon)}}" {{$service->icon ? $service->icon : "required"}}>
                                             <input type="hidden" name="old_icon" value="{{ $service->icon }}">
                                        </div>
                                        <div id="imagePreview" style="background-image: url({{asset($service->icon)}})">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                   
                                </div>
                                @if(count($service->serviceCategories)>0)
                                <div class="card shipmentDetails drop-field2" >
                                    <h3>Service Category</h3>
                                    <div class="row">
                                        @foreach($service->serviceCategories as $item)
                                        <div class="col-md-12" >
                                            <div class="fields drop-field2" id="drop-field">
                                                <input type="text" name="category_name[]" value="{{ $item->name }}" placeholder="Enter Category Name">
                                                <input type="hidden" value="{{$item->id}}" name="ids[]">
                                                <!-- <input type="hidden" name="old_category_name[]" value="{{ $item->name }}"> -->
                                            </div>
                                        </div>
                                        @endforeach                                        
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-md-4">
                                        <div class="fields">
                                            <a class="removeBtns" href="javascript:;" id="remove-drop" title="">
                                                <i class="far fa-trash-alt"></i> REMOVE Category
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fields">
                                            <a class="bdBtns" href="javascript:;" id="add-moredrop" title="">
                                                +ADD Category
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
    
                                <div class="btnShipments halfbtn">
                                    <a href="{{ route('super-admin.service.list') }}" type="button"
                                        class="cancelBtn removeBtns">Cancel Service</a>
                                    <input type="submit" class="postBtn" value="UPDATE SERVICE">
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
                    if (totalFields() > 2) {
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
    </script>
@endpush
