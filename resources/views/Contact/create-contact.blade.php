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
            $top_header1 = ads('create_contact','top_header1');
            $top_header2 = ads('create_contact','top_header2');
            $top_header3 = ads('create_contact','top_header3');
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
            <div class="card privateNetcenter">
                <form  action="{{route(auth()->user()->type.'.create_contact_store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                        @if(count($errors) > 0 )
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul class="p-0 m-0" style="list-style: none;">
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                          <label  for="email">Email address:</label>
                          <input type="email" class="form-control" required name="email" id="email" value="{{old('email')}}">
                          <span id="email-error" style="color:red; display:none;">Invalid email address</span>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                          <label for="name">Contact Name:</label>
                          <input type="text" class="form-control" required name="name" id="name" value="{{old('name')}}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="company_name">Company Name:</label>
                            <input type="text" class="form-control" name="company_name" id="company_name" value="{{old('company_name')}}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" name="city" id="city" value="{{old('city')}}">
                        </div>
                        <div class="col-sm-4">
                            <label for="state">State:</label>
                            {{-- <input type="text" class="form-control" name="state" id="state"> --}}
                            <select class="form-control" required name="state">
                                                              <option {{old('Alabama') ? 'selected' : '' }} value="Alabama">Alabama</option>
                                <option {{old('Alaska') ? 'selected' : '' }} value="Alaska">Alaska</option>
                                <option {{old('Arizona') ? 'selected' : '' }} value="Arizona">Arizona</option>
                                <option {{old('Arkansas') ? 'selected' : '' }} value="Arkansas">Arkansas</option>
                                <option {{old('California') ? 'selected' : '' }} value="California">California</option>
                                <option {{old('Colorado') ? 'selected' : '' }} value="Colorado">Colorado</option>
                                <option {{old('Connecticut') ? 'selected' : '' }} value="Connecticut">Connecticut</option>
                                <option {{old('Delaware') ? 'selected' : '' }} value="Delaware">Delaware</option>
                                <option {{old('District Of Columbia') ? 'selected' : '' }} value="District Of Columbia">District Of Columbia</option>
                                <option {{old('Florida') ? 'selected' : '' }} value="Florida">Florida</option>
                                <option {{old('Georgia') ? 'selected' : '' }} value="Georgia">Georgia</option>
                                <option {{old('Hawaii') ? 'selected' : '' }} value="Hawaii">Hawaii</option>
                                <option {{old('Idaho') ? 'selected' : '' }} value="Idaho">Idaho</option>
                                <option {{old('Illinois') ? 'selected' : '' }} value="Illinois">Illinois</option>
                                <option {{old('Indiana') ? 'selected' : '' }} value="Indiana">Indiana</option>
                                <option {{old('Iowa') ? 'selected' : '' }} value="Iowa">Iowa</option>
                                <option {{old('Kansas') ? 'selected' : '' }} value="Kansas">Kansas</option>
                                <option {{old('Kentucky') ? 'selected' : '' }} value="Kentucky">Kentucky</option>
                                <option {{old('Louisiana') ? 'selected' : '' }} value="Louisiana">Louisiana</option>
                                <option {{old('Maine') ? 'selected' : '' }} value="Maine">Maine</option>
                                <option {{old('Maryland') ? 'selected' : '' }} value="Maryland">Maryland</option>
                                <option {{old('Massachusetts') ? 'selected' : '' }} value="Massachusetts">Massachusetts</option>
                                <option {{old('Michigan') ? 'selected' : '' }} value="Michigan">Michigan</option>
                                <option {{old('Minnesota') ? 'selected' : '' }} value="Minnesota">Minnesota</option>
                                <option {{old('Mississippi') ? 'selected' : '' }} value="Mississippi">Mississippi</option>
                                <option {{old('Missouri') ? 'selected' : '' }} value="Missouri">Missouri</option>
                                <option {{old('Montana') ? 'selected' : '' }} value="Montana">Montana</option>
                                <option {{old('Nebraska') ? 'selected' : '' }} value="Nebraska">Nebraska</option>
                                <option {{old('Nevada') ? 'selected' : '' }} value="Nevada">Nevada</option>
                                <option {{old('New Hampshire') ? 'selected' : '' }} value="New Hampshire">New Hampshire</option>
                                <option {{old('New Jersey') ? 'selected' : '' }} value="New Jersey">New Jersey</option>
                                <option {{old('New Mexico') ? 'selected' : '' }} value="New Mexico">New Mexico</option>
                                <option {{old('New York') ? 'selected' : '' }} value="New York">New York</option>
                                <option {{old('North Carolina') ? 'selected' : '' }} value="North Carolina">North Carolina</option>
                                <option {{old('North Dakota') ? 'selected' : '' }} value="North Dakota">North Dakota</option>
                                <option {{old('Ohio') ? 'selected' : '' }} value="Ohio">Ohio</option>
                                <option {{old('Oklahoma') ? 'selected' : '' }} value="Oklahoma">Oklahoma</option>
                                <option {{old('Oregon') ? 'selected' : '' }} value="Oregon">Oregon</option>
                                <option {{old('Pennsylvania') ? 'selected' : '' }} value="Pennsylvania">Pennsylvania</option>
                                <option {{old('Rhode Island') ? 'selected' : '' }} value="Rhode Island">Rhode Island</option>
                                <option {{old('South Carolina') ? 'selected' : '' }} value="South Carolina">South Carolina</option>
                                <option {{old('South Dakota') ? 'selected' : '' }} value="South Dakota">South Dakota</option>
                                <option {{old('Tennessee') ? 'selected' : '' }} value="Tennessee">Tennessee</option>
                                <option {{old('Texas') ? 'selected' : '' }} value="Texas">Texas</option>
                                <option {{old('Utah') ? 'selected' : '' }} value="Utah">Utah</option>
                                <option {{old('Vermont') ? 'selected' : '' }} value="Vermont">Vermont</option>
                                <option {{old('Virginia') ? 'selected' : '' }} value="Virginia">Virginia</option>
                                <option {{old('Washington') ? 'selected' : '' }} value="Washington">Washington</option>
                                <option {{old('West Virginia') ? 'selected' : '' }} value="West Virginia">West Virginia</option>
                                <option {{old('Wisconsin') ? 'selected' : '' }} value="Wisconsin">Wisconsin</option>
                                <option {{old('Wyoming') ? 'selected' : '' }} value="Wyoming">Wyoming</option>
                            </select>
                            {{-- <input type="text" id="StateTextField"  class="form-control" required name="state"
                            placeholder="State*"> --}}
                        </div>
                        <div class="col-sm-4">
                            <label for="zip_code">Zip Code:</label>
                            <input type="text" class="form-control" name="zip_code" id="zip_code" value="{{old('zip_code')}}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-8">
                            <label for="phone">Phone:</label>
                            <input type="tel" class="form-control" name="phone" id="phone" value="{{old('phone')}}">
                        </div>
                        <div class="col-sm-4">
                            <label for="ext">Ext:</label>
                            <input type="text" class="form-control" name="ext" id="ext" value="{{old('ext')}}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="affiliat">Affiliate:</label>
                            <input type="text" class="form-control" name="affiliat" id="affiliat" value="{{old('affiliat')}}" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Legal Information*</h2>
                            <p> *At least one operating authority of MC or DOT is required </p>
                        </div>
                    </div>
                    <br/>
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_mc_number">MC Numner:</label>
                            <input type="text" class="form-control" name="legal_mc_number" id="legal_mc_number">
                        </div>
                    </div> --}}
                    <br/>
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_freight_forwading_number">Freight Forwarding Number:</label>
                            <input type="text" class="form-control" name="legal_freight_forwading_number" id="legal_freight_forwading_number" value="{{old('legal_freight_forwading_number')}}">
                        </div>
                    </div>
                    <br/> --}}
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_dot_number">Dot Number:</label>
                            <input type="text" class="form-control" name="legal_dot_number" id="legal_dot_number" value="{{old('legal_dot_number')}}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_us_state">US State:</label>
                            <select class="form-control" required name="legal_us_state" id="legal_us_state">
                                                               <option {{old('Alabama') ? 'selected' : '' }} value="Alabama">Alabama</option>
                                <option {{old('Alaska') ? 'selected' : '' }} value="Alaska">Alaska</option>
                                <option {{old('Arizona') ? 'selected' : '' }} value="Arizona">Arizona</option>
                                <option {{old('Arkansas') ? 'selected' : '' }} value="Arkansas">Arkansas</option>
                                <option {{old('California') ? 'selected' : '' }} value="California">California</option>
                                <option {{old('Colorado') ? 'selected' : '' }} value="Colorado">Colorado</option>
                                <option {{old('Connecticut') ? 'selected' : '' }} value="Connecticut">Connecticut</option>
                                <option {{old('Delaware') ? 'selected' : '' }} value="Delaware">Delaware</option>
                                <option {{old('District Of Columbia') ? 'selected' : '' }} value="District Of Columbia">District Of Columbia</option>
                                <option {{old('Florida') ? 'selected' : '' }} value="Florida">Florida</option>
                                <option {{old('Georgia') ? 'selected' : '' }} value="Georgia">Georgia</option>
                                <option {{old('Hawaii') ? 'selected' : '' }} value="Hawaii">Hawaii</option>
                                <option {{old('Idaho') ? 'selected' : '' }} value="Idaho">Idaho</option>
                                <option {{old('Illinois') ? 'selected' : '' }} value="Illinois">Illinois</option>
                                <option {{old('Indiana') ? 'selected' : '' }} value="Indiana">Indiana</option>
                                <option {{old('Iowa') ? 'selected' : '' }} value="Iowa">Iowa</option>
                                <option {{old('Kansas') ? 'selected' : '' }} value="Kansas">Kansas</option>
                                <option {{old('Kentucky') ? 'selected' : '' }} value="Kentucky">Kentucky</option>
                                <option {{old('Louisiana') ? 'selected' : '' }} value="Louisiana">Louisiana</option>
                                <option {{old('Maine') ? 'selected' : '' }} value="Maine">Maine</option>
                                <option {{old('Maryland') ? 'selected' : '' }} value="Maryland">Maryland</option>
                                <option {{old('Massachusetts') ? 'selected' : '' }} value="Massachusetts">Massachusetts</option>
                                <option {{old('Michigan') ? 'selected' : '' }} value="Michigan">Michigan</option>
                                <option {{old('Minnesota') ? 'selected' : '' }} value="Minnesota">Minnesota</option>
                                <option {{old('Mississippi') ? 'selected' : '' }} value="Mississippi">Mississippi</option>
                                <option {{old('Missouri') ? 'selected' : '' }} value="Missouri">Missouri</option>
                                <option {{old('Montana') ? 'selected' : '' }} value="Montana">Montana</option>
                                <option {{old('Nebraska') ? 'selected' : '' }} value="Nebraska">Nebraska</option>
                                <option {{old('Nevada') ? 'selected' : '' }} value="Nevada">Nevada</option>
                                <option {{old('New Hampshire') ? 'selected' : '' }} value="New Hampshire">New Hampshire</option>
                                <option {{old('New Jersey') ? 'selected' : '' }} value="New Jersey">New Jersey</option>
                                <option {{old('New Mexico') ? 'selected' : '' }} value="New Mexico">New Mexico</option>
                                <option {{old('New York') ? 'selected' : '' }} value="New York">New York</option>
                                <option {{old('North Carolina') ? 'selected' : '' }} value="North Carolina">North Carolina</option>
                                <option {{old('North Dakota') ? 'selected' : '' }} value="North Dakota">North Dakota</option>
                                <option {{old('Ohio') ? 'selected' : '' }} value="Ohio">Ohio</option>
                                <option {{old('Oklahoma') ? 'selected' : '' }} value="Oklahoma">Oklahoma</option>
                                <option {{old('Oregon') ? 'selected' : '' }} value="Oregon">Oregon</option>
                                <option {{old('Pennsylvania') ? 'selected' : '' }} value="Pennsylvania">Pennsylvania</option>
                                <option {{old('Rhode Island') ? 'selected' : '' }} value="Rhode Island">Rhode Island</option>
                                <option {{old('South Carolina') ? 'selected' : '' }} value="South Carolina">South Carolina</option>
                                <option {{old('South Dakota') ? 'selected' : '' }} value="South Dakota">South Dakota</option>
                                <option {{old('Tennessee') ? 'selected' : '' }} value="Tennessee">Tennessee</option>
                                <option {{old('Texas') ? 'selected' : '' }} value="Texas">Texas</option>
                                <option {{old('Utah') ? 'selected' : '' }} value="Utah">Utah</option>
                                <option {{old('Vermont') ? 'selected' : '' }} value="Vermont">Vermont</option>
                                <option {{old('Virginia') ? 'selected' : '' }} value="Virginia">Virginia</option>
                                <option {{old('Washington') ? 'selected' : '' }} value="Washington">Washington</option>
                                <option {{old('West Virginia') ? 'selected' : '' }} value="West Virginia">West Virginia</option>
                                <option {{old('Wisconsin') ? 'selected' : '' }} value="Wisconsin">Wisconsin</option>
                                <option {{old('Wyoming') ? 'selected' : '' }} value="Wyoming">Wyoming</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_us_number">US Number:</label>
                            <input type="text" class="form-control" name="legal_us_number" id="legal_us_number" value="{{old('legal_us_number')}}">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="legal_canadian_authority_number">Canadian Authority Number:</label>
                            <input type="text" class="form-control" name="legal_canadian_authority_number" id="legal_canadian_authority_number" value="{{old('legal_canadian_authority_number')}}">
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary themeBtn">Submit</button>
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
