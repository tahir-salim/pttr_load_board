@extends('layouts.app')
@section('content')
<div class="col-md-10">
    <div class="mainBody">
          <!-- Begin: Notification -->
          @include('layouts.notifications')
          <!-- END: Notification -->

        <div class="main-header">
            <h2>Create Contact</h2>
            <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.groups')}}" tile="">
                    +Groups
                </a>
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.private_network')}}" tile="">
                    All CONTACTS
                </a>
            </div>
        </div>
        @php
            $top_header1 = ads('edit_private_network','top_header1');
            $top_header2 = ads('edit_private_network','top_header2');
            $top_header3 = ads('edit_private_network','top_header3');
        @endphp
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
        <div class="contBody halfscroll">
               
            <div class="card privateNetcenter">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form  action="{{route(auth()->user()->type.'.contact_update',[$contact->id])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                          <label  for="email">Email address:</label>
                          <input type="email" class="form-control" required name="email" value="{{$contact->email ? $contact->email : '' }}" id="email">
                          <span id="email-error" style="color:red; display:none;">Invalid email address</span>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                          <label for="name">Contact Name:</label>
                          <input type="text" class="form-control" required name="name" id="name" value="{{$contact->name ? $contact->name : '' }}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="company_name">Company Name:</label>
                            <input type="text" class="form-control" name="company_name" id="company_name" value="{{$contact->company_name ? $contact->company_name : '' }}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" name="city" id="city" value="{{$contact->city ? $contact->city : '' }}">
                        </div>
                        <div class="col-sm-4">
                            <label for="state">State:</label>
                            {{-- <input type="text" class="form-control" name="state" id="state"> --}}
                            <select class="form-control" required name="state">
                                <option hidden value="">Select State*</option>
                                <option value="Alabama" {{$contact->state == 'Alabama' ? 'selected' : '' }}>Alabama</option>
                                <option value="Alaska" {{$contact->state == 'Alaska' ? 'selected' : '' }}>Alaska</option>
                                <option value="Arizona" {{$contact->state == 'Arizona' ? 'selected' : '' }}>Arizona</option>
                                <option value="Arkansas" {{$contact->state == 'Arkansas' ? 'selected' : '' }}>Arkansas</option>
                                <option value="California" {{$contact->state == 'California' ? 'selected' : '' }}>California</option>
                                <option value="Colorado" {{$contact->state == 'Colorado' ? 'selected' : '' }}>Colorado</option>
                                <option value="Connecticut" {{$contact->state == 'Connecticut' ? 'selected' : '' }}>Connecticut</option>
                                <option value="Delaware" {{$contact->state == 'Delaware' ? 'selected' : '' }}>Delaware</option>
                                <option value="District Of" {{$contact->state == 'District Of' ? 'selected' : '' }}>District Of Columbia</option>
                                <option value="Florida" {{$contact->state == 'Florida' ? 'selected' : '' }}>Florida</option>
                                <option value="Georgia" {{$contact->state == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                                <option value="Hawaii" {{$contact->state == 'Hawaii' ? 'selected' : '' }}>Hawaii</option>
                                <option value="Idaho" {{$contact->state == 'Idaho' ? 'selected' : '' }}>Idaho</option>
                                <option value="Illinois" {{$contact->state == 'Illinois' ? 'selected' : '' }}>Illinois</option>
                                <option value="Indiana" {{$contact->state == 'Indiana' ? 'selected' : '' }}>Indiana</option>
                                <option value="Iowa" {{$contact->state == 'Iowa' ? 'selected' : '' }}>Iowa</option>
                                <option value="Kansas" {{$contact->state == 'Kansas' ? 'selected' : '' }}>Kansas</option>
                                <option value="Kentucky" {{$contact->state == 'Kentucky' ? 'selected' : '' }}>Kentucky</option>
                                <option value="Louisiana" {{$contact->state == 'Louisiana' ? 'selected' : '' }}>Louisiana</option>
                                <option value="Maine" {{$contact->state == 'Maine' ? 'selected' : '' }}>Maine</option>
                                <option value="Maryland" {{$contact->state == 'Maryland' ? 'selected' : '' }}>Maryland</option>
                                <option value="Massachusetts" {{$contact->state == 'Massachusetts' ? 'selected' : '' }}>Massachusetts</option>
                                <option value="Michigan" {{$contact->state == 'Michigan' ? 'selected' : '' }}>Michigan</option>
                                <option value="Minnesota" {{$contact->state == 'Minnesota' ? 'selected' : '' }}>Minnesota</option>
                                <option value="Mississippi" {{$contact->state == 'Mississippi' ? 'selected' : '' }}>Mississippi</option>
                                <option value="Missouri" {{$contact->state == 'Missouri' ? 'selected' : '' }}>Missouri</option>
                                <option value="Montana" {{$contact->state == 'Montana' ? 'selected' : '' }}>Montana</option>
                                <option value="Nebraska" {{$contact->state == 'Nebraska' ? 'selected' : '' }}>Nebraska</option>
                                <option value="Nevada" {{$contact->state == 'Nevada' ? 'selected' : '' }}>Nevada</option>
                                <option value="New Hampshire" {{$contact->state == 'New Hampshire' ? 'selected' : '' }}>New Hampshire</option>
                                <option value="New Jersey" {{$contact->state == 'New Jersey' ? 'selected' : '' }}>New Jersey</option>
                                <option value="New Mexico" {{$contact->state == 'New Mexico' ? 'selected' : '' }}>New Mexico</option>
                                <option value="New York" {{$contact->state == 'New York' ? 'selected' : '' }}>New York</option>
                                <option value="North Carolina" {{$contact->state == 'North Carolina' ? 'selected' : '' }}>North Carolina</option>
                                <option value="North Dakota" {{$contact->state == 'North Dakota' ? 'selected' : '' }}>North Dakota</option>
                                <option value="Ohio" {{$contact->state == 'Ohio' ? 'selected' : '' }}>Ohio</option>
                                <option value="Oklahoma" {{$contact->state == 'Oklahoma' ? 'selected' : '' }}>Oklahoma</option>
                                <option value="Oregon" {{$contact->state == 'Oregon' ? 'selected' : '' }}>Oregon</option>
                                <option value="Pennsylvania" {{$contact->state == 'Pennsylvania' ? 'selected' : '' }}>Pennsylvania</option>
                                <option value="Rhode Island" {{$contact->state == 'Rhode Island' ? 'selected' : '' }}>Rhode Island</option>
                                <option value="South Carolina" {{$contact->state == 'South Carolina' ? 'selected' : '' }}>South Carolina</option>
                                <option value="South Dakota" {{$contact->state == 'South Dakota' ? 'selected' : '' }}>South Dakota</option>
                                <option value="Tennessee" {{$contact->state == 'Tennessee' ? 'selected' : '' }}>Tennessee</option>
                                <option value="Texas" {{$contact->state == 'Texas' ? 'selected' : '' }}>Texas</option>
                                <option value="Utah" {{$contact->state == 'Utah' ? 'selected' : '' }}>Utah</option>
                                <option value="Vermont" {{$contact->state == 'Vermont' ? 'selected' : '' }}>Vermont</option>
                                <option value="Virginia" {{$contact->state == 'Virginia' ? 'selected' : '' }}>Virginia</option>
                                <option value="Washington" {{$contact->state == 'Washington' ? 'selected' : '' }}>Washington</option>
                                <option value="West Virginia" {{$contact->state == 'West Virginia' ? 'selected' : '' }}>West Virginia</option>
                                <option value="Wisconsin" {{$contact->state == 'Wisconsin' ? 'selected' : '' }}>Wisconsin</option>
                                <option value="Wyoming" {{$contact->state == 'Wyoming' ? 'selected' : '' }}>Wyoming</option>
                            </select>
                            {{-- <input type="text" id="StateTextField"  class="form-control" required name="state"
                            placeholder="State*"> --}}
                        </div>
                        <div class="col-sm-4">
                            <label for="zip_code">Zip Code:</label>
                            <input type="text" class="form-control" name="zip_code" value="{{$contact->zip_code ? $contact->zip_code : '' }}" id="zip_code">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-8">
                            <label for="phone">Phone:</label>
                            <input type="tel" class="form-control" name="phone" id="phone" value="{{$contact->phone ? $contact->phone : '' }}">
                        </div>
                        <div class="col-sm-4">
                            <label for="ext">Ext:</label>
                            <input type="text" class="form-control" name="ext" id="ext" value="{{$contact->ext ? $contact->ext : ''}}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="affiliat">Affiliate:</label>
                            <input type="text" class="form-control" name="affiliat" id="affiliat" value="{{$contact->affiliat ? $contact->affiliat : ''}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Legal Information*</h2>
                            <p style="color: red"> *DOT is required </p>
                        </div>
                    </div>
                    <br/>
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_mc_number">MC Numner:</label>
                            <input type="text" class="form-control" name="legal_mc_number" id="legal_mc_number">
                        </div>
                    </div>
                    <br/> --}}
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_freight_forwading_number">Freight Forwarding Number:</label>
                            <input type="text" class="form-control" name="legal_freight_forwading_number" id="legal_freight_forwading_number">
                        </div>
                    </div>
                    <br/> --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_dot_number">Dot Number:</label>
                            <input type="text" class="form-control" name="legal_dot_number" value="{{$contact->legal_dot_number ? $contact->legal_dot_number : '' }}" {{$contact->legal_dot_number ? '' : 'required' }} id="legal_dot_number">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_us_state">US State:</label>
                            <select class="form-control" required name="legal_us_state" value="{{$contact->legal_us_state ? $contact->legal_us_state : ''}}"  id="legal_us_state">
                                <option hidden value="">Select State*</option>
                                <option {{$contact->legal_us_state == "Alabama" ? 'selected' : ''}} value="Alabama">Alabama</option>
                                <option {{$contact->legal_us_state == "Alaska" ? 'selected' : ''}} value="Alaska">Alaska</option>
                                <option {{$contact->legal_us_state == "Arizona" ? 'selected' : ''}} value="Arizona">Arizona</option>
                                <option {{$contact->legal_us_state == "Arkansas" ? 'selected' : ''}} value="Arkansas">Arkansas</option>
                                <option {{$contact->legal_us_state == "California" ? 'selected' : ''}} value="California">California</option>
                                <option {{$contact->legal_us_state == "Colorado" ? 'selected' : ''}} value="Colorado">Colorado</option>
                                <option {{$contact->legal_us_state == "Connecticut" ? 'selected' : ''}} value="Connecticut">Connecticut</option>
                                <option {{$contact->legal_us_state == "Delaware" ? 'selected' : ''}} value="Delaware">Delaware</option>
                                <option {{$contact->legal_us_state == "District" ? 'selected' : ''}} value="District">District Of Columbia</option>
                                <option {{$contact->legal_us_state == "Florida" ? 'selected' : ''}} value="Florida">Florida</option>
                                <option {{$contact->legal_us_state == "Georgia" ? 'selected' : ''}} value="Georgia">Georgia</option>
                                <option {{$contact->legal_us_state == "Hawaii" ? 'selected' : ''}} value="Hawaii">Hawaii</option>
                                <option {{$contact->legal_us_state == "Idaho" ? 'selected' : ''}} value="Idaho">Idaho</option>
                                <option {{$contact->legal_us_state == "Illinois" ? 'selected' : ''}} value="Illinois">Illinois</option>
                                <option {{$contact->legal_us_state == "Indiana" ? 'selected' : ''}} value="Indiana">Indiana</option>
                                <option {{$contact->legal_us_state == "Iowa" ? 'selected' : ''}} value="Iowa">Iowa</option>
                                <option {{$contact->legal_us_state == "Kansas" ? 'selected' : ''}} value="Kansas">Kansas</option>
                                <option {{$contact->legal_us_state == "Kentucky" ? 'selected' : ''}} value="Kentucky">Kentucky</option>
                                <option {{$contact->legal_us_state == "Louisiana" ? 'selected' : ''}} value="Louisiana">Louisiana</option>
                                <option {{$contact->legal_us_state == "Maine" ? 'selected' : ''}} value="Maine">Maine</option>
                                <option {{$contact->legal_us_state == "Maryland" ? 'selected' : ''}} value="Maryland">Maryland</option>
                                <option {{$contact->legal_us_state == "Massachusetts" ? 'selected' : ''}} value="Massachusetts">Massachusetts</option>
                                <option {{$contact->legal_us_state == "Michigan" ? 'selected' : ''}} value="Michigan">Michigan</option>
                                <option {{$contact->legal_us_state == "Minnesota" ? 'selected' : ''}} value="Minnesota">Minnesota</option>
                                <option {{$contact->legal_us_state == "Mississippi" ? 'selected' : ''}} value="Mississippi">Mississippi</option>
                                <option {{$contact->legal_us_state == "Missouri" ? 'selected' : ''}} value="Missouri">Missouri</option>
                                <option {{$contact->legal_us_state == "Montana" ? 'selected' : ''}} value="Montana">Montana</option>
                                <option {{$contact->legal_us_state == "Nebraska" ? 'selected' : ''}} value="Nebraska">Nebraska</option>
                                <option {{$contact->legal_us_state == "Nevada" ? 'selected' : ''}} value="Nevada">Nevada</option>
                                <option {{$contact->legal_us_state == "New" ? 'selected' : ''}} value="New">New Hampshire</option>
                                <option {{$contact->legal_us_state == "New" ? 'selected' : ''}} value="New">New Jersey</option>
                                <option {{$contact->legal_us_state == "New" ? 'selected' : ''}} value="New">New Mexico</option>
                                <option {{$contact->legal_us_state == "New" ? 'selected' : ''}} value="New">New York</option>
                                <option {{$contact->legal_us_state == "North" ? 'selected' : ''}} value="North">North Carolina</option>
                                <option {{$contact->legal_us_state == "North" ? 'selected' : ''}} value="North">North Dakota</option>
                                <option {{$contact->legal_us_state == "Ohio" ? 'selected' : ''}} value="Ohio">Ohio</option>
                                <option {{$contact->legal_us_state == "Oklahoma" ? 'selected' : ''}} value="Oklahoma">Oklahoma</option>
                                <option {{$contact->legal_us_state == "Oregon" ? 'selected' : ''}} value="Oregon">Oregon</option>
                                <option {{$contact->legal_us_state == "Pennsylvania" ? 'selected' : ''}} value="Pennsylvania">Pennsylvania</option>
                                <option {{$contact->legal_us_state == "Rhode" ? 'selected' : ''}} value="Rhode">Rhode Island</option>
                                <option {{$contact->legal_us_state == "South" ? 'selected' : ''}} value="South">South Carolina</option>
                                <option {{$contact->legal_us_state == "South" ? 'selected' : ''}} value="South">South Dakota</option>
                                <option {{$contact->legal_us_state == "Tennessee" ? 'selected' : ''}} value="Tennessee">Tennessee</option>
                                <option {{$contact->legal_us_state == "Texas" ? 'selected' : ''}} value="Texas">Texas</option>
                                <option {{$contact->legal_us_state == "Utah" ? 'selected' : ''}} value="Utah">Utah</option>
                                <option {{$contact->legal_us_state == "Vermont" ? 'selected' : ''}} value="Vermont">Vermont</option>
                                <option {{$contact->legal_us_state == "Virginia" ? 'selected' : ''}} value="Virginia">Virginia</option>
                                <option {{$contact->legal_us_state == "Washington" ? 'selected' : ''}} value="Washington">Washington</option>
                                <option {{$contact->legal_us_state == "West" ? 'selected' : ''}} value="West">West Virginia</option>
                                <option {{$contact->legal_us_state == "Wisconsin" ? 'selected' : ''}} value="Wisconsin">Wisconsin</option>
                                <option {{$contact->legal_us_state == "Wyoming" ? 'selected' : ''}} value="Wyoming">Wyoming</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_us_number">US Number:</label>
                            <input type="text" class="form-control" name="legal_us_number" value="{{$contact->legal_us_number ? $contact->legal_us_number : ''}}" id="legal_us_number">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_canadian_authority_number">Canadian Authority Number:</label>
                            <input type="text" class="form-control" name="legal_canadian_authority_number" value="{{$contact->legal_canadian_authority_number ? $contact->legal_canadian_authority_number : ''}}" id="legal_canadian_authority_number">
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                  </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $("#email").on('input', function() {
                var email = $(this).val();
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

                // Check if the email matches the regex
                if(emailPattern.test(email)) {
                    // Email is valid
                    $("#email-error").hide(); // Hide the error message
                    $(this).removeClass('input-error'); // Remove error class if present
                } else {
                    // Email is invalid
                    $("#email-error").show(); // Show the error message
                    $(this).addClass('input-error'); // Add error class to highlight the field
                }
            });
        });


        $("input[name='company_name']").on('input', function() {
            if($(this).val().length > 200) {
                $(this).val($(this).val().slice(0, 200));
            }
        });
        $("input[name='email']").on('input', function() {
            if($(this).val().length > 200) {
                $(this).val($(this).val().slice(0, 200));
            }
        });
        $("input[name='name']").on('input', function() {
            if($(this).val().length > 200) {
                $(this).val($(this).val().slice(0, 200));
            }
        });

        $("input[name='city']").on('input', function() {
            if($(this).val().length > 200) {
                $(this).val($(this).val().slice(0, 200));
            }
        });
        $("input[name='affiliat']").on('input', function() {
            if($(this).val().length > 200) {
                $(this).val($(this).val().slice(0, 200));
            }
        });

        $("input[name='legal_dot_number']").on('input', function() {
            if($(this).val().length > 25) {
                $(this).val($(this).val().slice(0, 25));
            }
        });

        $("input[name='legal_us_number']").on('input', function() {
            if($(this).val().length > 50) {
                $(this).val($(this).val().slice(0, 50));
            }
        });

        $("input[name='legal_canadian_authority_number']").on('input', function() {
            if($(this).val().length > 150) {
                $(this).val($(this).val().slice(0, 150));
            }
        });




    </script>
@endpush
@endsection
