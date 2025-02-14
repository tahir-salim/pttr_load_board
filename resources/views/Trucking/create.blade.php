@extends('layouts.app')
@push('css')
<style>
.input-error {
  border: none;
  outline: 1px solid red;
  border-radius: 5px;
}
</style>
@endpush
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Create New Truck</h2>
            </div>
            @php
                $top_header1 = ads('user_management_create','top_header1');
                $top_header2 = ads('user_management_create','top_header2');
                $top_header3 = ads('user_management_create','top_header3');
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
                <div class="card">
                    <form id="SubmitFormSh" action="{{ route(auth()->user()->type . '.truck.store') }}" method="POST">
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
                        <div class="row createUsers">
                            <div class="card shipmentDetails col-md-12">
                                <h3>Truck Post</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select class="origin-multiple" required name="origin" ></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select class="destination-multiple" name="destination[]" multiple="multiple"></select>

                                        </div>
                                    </div>
                                    @php
                                        $defaultDate = Carbon\Carbon::now()->format('Y-m-d');
                                        $defaultTime = Carbon\Carbon::now()->format('H:i');
                                    @endphp
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" required name="from_date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"  value="{{old('from_date', $defaultDate)}}"
                                                    max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date"  required name="to_date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" value="{{old('to_date', $defaultDate)}}"
                                                    max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">

                                                    <input type="time" name="from_time" value="{{old('from_time', $defaultTime)}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="time" name="to_time" value="{{old('to_time', $defaultTime)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
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
                                            <select name="eq_type_id" required class="{{ $errors->has('eq_type_id') ? 'input-error' : '' }}">
                                                <option hidden value="">Equipment Type*</option>
                                                @foreach ($equipment_types as $equipment_type)
                                                    <option value="{{ $equipment_type->id }}" {{$equipment_type->id == old('eq_type_id') ? "selected" : "" }}>{{ $equipment_type->name }}
                                                        {{-- <span>{{ $equipment_type->prefix }}</span> --}}
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
                                                    <input type="number" name="length" min="1" max="200" required class="{{ $errors->has('length') ? 'input-error' : '' }}"
                                                        placeholder="Length (ft)*" value="{{old('length')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" name="weight" min="1" class="{{ $errors->has('weight') ? 'input-error' : '' }}" 
                                                        placeholder="Weight (Ibs.)" value="{{old('weight')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <textarea name="comment" id="" cols="10" rows="10" placeholder="Comment">{{old('comment')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <div class="fields">
                                            <input type="text" name="commodity" placeholder="Commodity" value="{{old('commodity')}}">
                                        </div> --}}
                                        <div class="fields">
                                            <input type="number" name="rate" placeholder="Enter Rates" value="{{old('rate')}}" >
                                        </div>
                                        <div class="fields">
                                            <input type="text" name="reference_id" placeholder="Reference ID" value="{{old('reference_id')}}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="fields">
                                            <input type="number" name="rate" placeholder="Enter Rates" value="{{old('rate')}}">
                                        </div>
                                    </div> --}}
                                </div>

                                <h3>Contact Information</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                    <p>
                                        <strong>Select at least one or more contact methods to share
                                            with
                                            broker on your post.</strong>
                                        <br>contact info can be updated In your profile
                                    </p>
                                </div>
                                    <div class="col-md-6">
                                        <div class="contactchecks">
                                            <div class="check">
                                                <input type="checkbox" name="status_phone" value="1" {{old('status_phone') == "1" ? "checked" : "" }}
                                                    class="contact-checkbox" checked id="primaryphone">
                                                <label for="primaryphone" >{{auth()->user()->phone ? auth()->user()->phone : auth()->user()->alt_phone  }}
                                                     Phone</label>
                                            </div>
                                            <div class="check">
                                                <input type="checkbox" name="status_email" value="1" {{old('status_email') == "1" ? "checked" : "" }}
                                                    class="contact-checkbox" id="email">
                                                <label for="email">{{auth()->user()->email}} Email</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="btnShipments">
                                {{-- <button type="submit" class="postBtn">Submit</button> --}}
                                <input type="submit" class="postBtn" value="Submit">
                                <a href="{{ route(auth()->user()->type . '.truck.index') }}" class="cancelBtn">Cancel</a>
                               </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI&libraries=places">
    </script>

    <script type="text/javascript">

    const phoneCheckbox = document.querySelector('input[name="status_phone"]');
    const emailCheckbox = document.querySelector('input[name="status_email"]');

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

    $(document).on('submit','#SubmitFormSh',function(e){
        e.preventDefault();
        var IsValid = 0;
        $('#SubmitFormSh input[type="hidden"]').each(function(){
          if($(this).parent().is(":visible")){
             if(!$(this).val()){ IsValid = 1; }
          }
        });
        if(IsValid == 1){
         Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Please Make sure to select the Origin using the suggestion dropdown!",
            });
        }else{
            e.currentTarget.submit();
        }
    });



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
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                initMap(lat,lng);

            });
            var input1 = document.getElementById('DestinationTextField');
            var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
            google.maps.event.addListener(autocomplete1, 'place_changed', function() {
                var place1 = autocomplete1.getPlace();

                document.getElementById('destination_id').value = place1.place_id;
                document.getElementById('destinationLat').value = place1.geometry.location.lat();
                document.getElementById('destinationLng').value = place1.geometry.location.lng();
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                initMap(lat,lng);

            });
        }

        // initialize();

        $(document).on("click", "#tracking", function(){
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


        $(document).on("click", "#addDatTracking", function(){
            $('#hiddenDatTracking').show();
        });



            var originSelect = $('.origin-multiple').select2({
                placeholder: "Origin (City, ST)*",
                ajax: getAjaxOnlyCity(),
                closeOnSelect: true
            });

            var destinationSelect = $('.destination-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Destination (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            });

            destinationSelect.on('select2:select', function (e) {
                var selectedOption = e.params.data.id;
                var selectedOptions = destinationSelect.val() || [];

                // Check if the selected option is a city or a state
                if (selectedOption.startsWith('city_')) {
                    selectedOptions = selectedOptions.filter(function (item) {
                        return item.startsWith('city_') === false && item.startsWith('state_') === false;
                    });
                    selectedOptions.push(selectedOption); // Keep the newly selected city
                } else if (selectedOption.startsWith('state_')) {
                    selectedOptions = selectedOptions.filter(function (item) {
                        return item.startsWith('city_') === false;
                    });
                    selectedOptions.push(selectedOption); // Add the newly selected state
                }
                destinationSelect.val(selectedOptions).trigger('change');
            });



            // Restrict rate input to 6 digits
            $("input[name='rate']").on('input', function() {
                if($(this).val().length > 11) {
                    $(this).val($(this).val().slice(0, 11));
                }
            });

            // Restrict reference_id input to 75 characters
            $("input[name='reference_id']").on('input', function() {
                    if($(this).val().length > 75) {
                        $(this).val($(this).val().slice(0, 75));
                    }
                });


    </script>
@endpush
