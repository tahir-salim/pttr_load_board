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
                <h2>Update Truck</h2>
            </div>

            <div class="contBody">
                @php
                    $top_header1 = ads('edit_a_shipment','top_header1');
                    $top_header2 = ads('edit_a_shipment','top_header2');
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
                <div class="card">
                    <form id="SubmitFormSh" action="{{ route(auth()->user()->type . '.truck.update',$truck_post->id) }}" method="POST"
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
                        <div class="col-md-12">
                            <div class="card shipmentDetails">
                                <h3>Truck Details</h3>
                                <div class="radioBtns">
                                    <div class="radios">
                                        <input type="radio" id="full" name="equipment_detail" {{$truck_post->trucks->equipment_detail  == 0 ? 'checked' : ''  }} checked value="0" >
                                        <label for="full"> Full</label>
                                    </div>
                                    <div class="radios">
                                        <input type="radio" id="Partial" name="equipment_detail" {{$truck_post->trucks->equipment_detail  == 1 ? 'checked' : ''  }} value="1">
                                        <label for="Partial"> Partial</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select name="eq_type_id"  required class="{{ $errors->has('eq_type_id') ? 'input-error' : '' }}">
                                                <option hidden value="">Equipment Type*</option>
                                                @foreach ($equipment_types as $equipment_type)
                                                    <option value="{{ $equipment_type->id }}" {{$equipment_type->id == $truck_post->trucks->eq_type_id ? 'selected' : ''}}>{{ $equipment_type->name }}
                                                        {{-- <span>{{ $equipment_type->prefix }}</span> --}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            {{-- <input type="text" name="eq_type" placeholder="Equipment Type*"> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" name="length" required value="{{$truck_post->trucks->length ? $truck_post->trucks->length : '' }}" min="1" max="200" class="{{ $errors->has('length') ? 'input-error' : '' }}"
                                                        placeholder="Length (ft)*">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" name="weight"  value="{{$truck_post->trucks->weight ? $truck_post->trucks->weight : '' }}" min="1" class="{{ $errors->has('weight') ? 'input-error' : '' }}"
                                                        placeholder="Weight (Ibs.)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h3>Post Details</h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select class="origin-multiple" required  name="origin" ></select>
                                            @if($truck_post->origin_city_id != null)
                                                @push('js')
                                                    <script>
                                                        var id = "{{$truck_post->origin_city_id}}";
                                                        var text = "{{$truck_post->origin}}";
                                                            var newOption = new Option(text, id, true, true);
                                                            $('.origin-multiple').append(newOption).trigger('change');
                                                    </script>
                                                @endpush
                                            @else

                                                @push('js')
                                                    <script>
                                                        var id = "current";
                                                        var text = "{{$truck_post->origin}}";
                                                            var newOption = new Option(text, id, true, true);
                                                            $('.origin-multiple').append(newOption).trigger('change');
                                                    </script>
                                                @endpush
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select class="destination-multiple" name="destination[]" multiple="multiple"></select>.
                                            @if($truck_post->destination_city_id != null)
                                                @push('js')
                                                    <script>
                                                        var id = "city_"+"{{$truck_post->destination_city_id}}";
                                                        var text = "{{$truck_post->destination}}";
                                                            var newOption = new Option(text, id, true, true);
                                                            $('.destination-multiple').append(newOption).trigger('change');
                                                    </script>
                                                @endpush
                                                  @elseif($truck_post->truck_post_states)
                                                @push('js')
                                                    <script>
                                                        var da = {!! json_encode($truck_post->truck_post_states) !!};
                                                        $(da).each(function(index, value){
                                                            var id = 'state_' + value.state_id;
                                                        var text = value.code;
                                                            var newOption = new Option(text, id, true, true);
                                                            $('.destination-multiple').append(newOption)
                                                        }).trigger('change');
                                                    </script>
                                                @endpush
                                            @endif
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
                                                    <input type="date" name="from_date"
                                                        min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}"
                                                        value="{{$truck_post->from_date ? Carbon\Carbon::create($truck_post->from_date)->format('Y-m-d')  : $defaultDate }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="date" name="to_date" value="{{$truck_post->to_date ? Carbon\Carbon::create($truck_post->to_date)->format('Y-m-d')  : $defaultDate }}"
                                                        min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" name="reference_id" placeholder="Reference ID" value="{{$truck_post->trucks->reference_id ? $truck_post->trucks->reference_id : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="number" placeholder="Enter Rate" name="rate" value="{{$truck_post->rate ? $truck_post->rate : '' }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <textarea name="comment" id="" cols="10" rows="10" placeholder="Comment">{{$truck_post->comment ? $truck_post->comment : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select required name="is_posted">
                                                <option value="1" {{ $truck_post->is_posted == 1 ? 'selected' : '' }}>Posted</option>
                                                <option value="0" {{ $truck_post->is_posted == 0 ? 'selected' : '' }}>Un Posted</option>
                                            </select>
                                        </div>
                                    </div>
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
                                                <input type="checkbox" name="status_phone" value="1"
                                                           class="contact-checkbox"
                                                           {{ $truck_post->status_phone == 1 ? 'checked' : '' }}
                                                           id="primaryphone">
                                                <label for="primaryphone">{{auth()->user()->phone ? auth()->user()->phone : auth()->user()->alt_phone  }}
                                                    Phone</label>
                                            </div>
                                            <div class="check">
                                                <input type="checkbox" name="status_email" {{ $truck_post->status_email == 1 ? 'checked' : '' }}
                                                    class="contact-checkbox" id="email">
                                                <label for="email">{{auth()->user()->email}} Email</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="btnShipments">
                                    <a href="{{ route(auth()->user()->type . '.truck.index') }}" class="cancelBtn">Cancel</a>
                                    <input type="submit" class="postBtn" value="Update">
                                </div>
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

            $("input[name='length']").on('input', function() {
                 if($(this).val().length > 3) {
            $(this).val($(this).val().slice(0, 3));
                }
            });

            // Restrict weight input to 6 digits
            $("input[name='weight']").on('input', function() {
                if($(this).val().length > 6) {
                    $(this).val($(this).val().slice(0, 6));
                }
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
        // initialize();
    </script>
@endpush
