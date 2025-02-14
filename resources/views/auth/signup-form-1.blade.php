@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="loginForms">
            <div class="lgForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                </figure>
                @php
                    $id = session('ownerPackage.package_id');
                    // dd($id);
                @endphp
                <form action="{{ route('signup-step1', $id) }}" method="GET">
                    <div class="d-flex justify-content-between">
                        <h2>SignUp</h2>
                        <p>Step 1</p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p>Already have an account? <a href="{{ route('login') }}" title="">Sign in</a></p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="fields">
                                <label>First Name</label>
                                <input type="text" placeholder="First Name" name="first_name" required value="{{old('first_name')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fields">
                                <label>Last Name</label>
                                <input type="text" placeholder="Last Name" name="last_name" required value="{{old('last_name')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Personal Email Address</label>
                                <input type="email" placeholder="Email Address" name="email" required value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Password</label>
                                <input type="password" placeholder="Password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Personal Mobile No</label>
                                <input type="tel" maxlength="25" placeholder="Mobile" name="phone" required value="{{old('phone')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Additional User if any.</label>
                                <input type="number" placeholder="Enter Additional User Quantity" name="seats" id="seats"  value="{{old('seats')}}" min="0">
                            </div>
                        </div>

                    </div>
                    <div class="btns submits">
                        <input class="themeBtn fullbtn" type="submit" value="Next">
                    </div>

                    {{-- <div class="agreeDv">
                    <div class="agreelabel">
                        <label><input type="checkbox"> I agree to the <a href="javascript:;" title="">Master
                                Subscription Agreement</a>.</label>
                    </div>
                </div> --}}

                     <!-- <div class="protected">
                            <p>By registering, you agree to the processing of your personal data by Salesforce as
                                described in the Privacy Statement.</p>
                        </div> -->
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')

<script>

// const input1 = document.getElementById('cardCvv');
// input1.addEventListener('input', function (e) {
//     // Remove all non-digit characters
//     let value = e.target.value.replace(/\D/g, '');

//     // Format the value with spaces after every 5 digits
//     let formattedValue = '';
//     for (let i = 0; i < value.length; i++) {
//         if (i > 0 && i % 5 === 0) {
//             formattedValue += ' ';
//         }
//         formattedValue += value[i];
//     }

//     // Limit the input to a maximum of 25 characters (including spaces)
//     if (formattedValue.length > 29) { // Since space is added after every 5 digits, 29 characters total
//         formattedValue = formattedValue.slice(0, 29); // Keep first 29 characters
//     }

//     e.target.value = formattedValue;  // Update the input field
// });
</script>
@endpush
