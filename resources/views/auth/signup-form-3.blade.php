@extends('layouts.app')
@section('content')
    <div class="container ">
        <div class="loginForms ">
            <div class="lgForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                </figure>
                <div class="d-flex justify-content-between">
                    <h2>SignUp</h2>
                    <p>Step 3</p>
                </div>

                <div class="contBody">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        $userData = session('userData');
                    @endphp
                    <form action="{{ route('signup_step4') }}" method="GET" id="emailForm">
                        {{-- <p>Already have an account? <a href="{{ route('login') }}" title="">Sign in</a></p> --}}

                        {{-- {{$userData}} --}}
                        @for ($i = 1; $i <= $userData['seats']; $i++)
                            <h5>Additional User : {{ $i }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fields">
                                        <label>First Name</label>
                                        <input type="text" placeholder="First Name" name="user[{{ $i }}][first_name]" required value="{{ old('user.'.$i.'.first_name') }}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fields">
                                        <label>Last Name</label>
                                        <input type="text" placeholder="Last Name"
                                            name="user[{{ $i }}][last_name]" required value="{{ old('user.'.$i.'.last_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fields">
                                        <label>Email Address</label>
                                        <input type="email" placeholder="Email Address" class="email"
                                            name="user[{{ $i }}][email]" required value="{{ old('user.'.$i.'.email') }}">
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="fields">
                                        <label>Password</label>
                                        <input type="password" placeholder="Password" name="user[{{ $i }}][password]" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fields">
                                        <label>Mobile</label>
                                        <input type="tel" placeholder="Mobile" name="user[{{ $i }}][phone]"
                                            class="phone" id="phone" required value="{{ old('user.'.$i.'.phone') }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endfor
                        <div class="btns submits">
                            <input class="themeBtn fullbtn" type="button" value="Next" id="submitBtn">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Function to check if emails are unique
            function areEmailsUnique() {
                var emails = $('.email'); // Get all email inputs

                // Check if any pair of emails match
                for (var i = 0; i < emails.length; i++) {
                    var email1 = $(emails[i]).val();
                    for (var j = i + 1; j < emails.length; j++) {
                        var email2 = $(emails[j]).val();
                        if (email1 === email2) {
                            return false; // Emails are not unique
                        }
                    }
                }
                return true; // Emails are unique
            }

            function arePhonesUnique() {
                var phones = $('.phone'); // Get all phone inputs
                // Check if any pair of phones match
                for (var i = 0; i < phones.length; i++) {
                    var phone1 = $(phones[i]).val();
                    for (var j = i + 1; j < phones.length; j++) {
                        var phone2 = $(phones[j]).val();
                        if (phone1 === phone2) {
                            return false; // Emails are not unique
                        }
                    }
                }
                return true; // Emails are unique
            }

            // Validate emails when the submit button is clicked
            $('#submitBtn').click(function() {
                var uniqueEmail = areEmailsUnique();
                var uniquePhone = arePhonesUnique();

                var error = 'Email and phone must be unique';

                // Display error message if emails are not unique
                if (uniqueEmail == false || uniquePhone == false) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.error(error);
                } else {
                    $('#emailForm').submit();
                }
            });
        });
    </script>
@endpush
