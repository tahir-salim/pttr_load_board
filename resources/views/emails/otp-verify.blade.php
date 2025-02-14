@extends('layouts.app')
@section('content')



<div class="container">
        <div class="loginForms">

            <div class="lgForm otpForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                </figure>
                <div class="card-header">
                    <h3>{{ __('OTP Verify') }}</h3>
                    <p>Enter your OTP(One Time Password) for verification</p>
                    <p>(otp expire in 15 minutes)</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('otp_verify') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="otp" class="col-md-4 col-form-label text-md-end">{{ __('OTP') }}</label>

                            <div class="col-md-6">
                                <input id="" type="number" class="form-control" name="otp"  required>
                                <input id="" type="text" hidden class="form-control" name="pass" value="{{$pass}}">
                                <input id="" type="text" hidden class="form-control" name="id" value="{{$user->id}}">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="themeBtn">
                                    {{ __('Verify') }}
                                </button>
                                <a href="{{ route('resend_otp',[$user_id,$pass]) }}" class="themeBtn skyblue">
                                    {{ __('Resend Code') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('OTP Verify') }}</h3>
                    <p>Enter your OTP(One Time Password) for verification</p>
                    <p>(otp expire in 15 minutes)</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('otp_verify') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="otp" class="col-md-4 col-form-label text-md-end">{{ __('OTP') }}</label>

                            <div class="col-md-6">
                                <input id="" type="number" class="form-control" name="otp"  required>
                                <input id="" type="text" hidden class="form-control" name="pass" value="{{$pass}}">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Verify') }}
                                </button>
                                <a href="{{ route('resend_otp',[$user_id,$pass]) }}" class="btn btn-primary">
                                    {{ __('Resend Code') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
