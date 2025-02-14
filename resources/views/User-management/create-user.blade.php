@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Create New User</h2>
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
                    <form id="emailForm" action="{{ route(auth()->user()->type . '.user_management.user_payment') }}">
                        <div class="row createUsers">
                            <div class="col-sm-6">
                                <div class="fields">
                                    <label for="name">Full Name:</label>
                                    <input type="text" class="form-control" required name="name" id="name" value="{{old('name')}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fields">
                                    <label for="email">Email address:</label>
                                    <input type="email" class="form-control" required name="email" id="email" value="{{old('email')}}">
                                    <div id="emailError" style="color: red;"></div>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="fields">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" required name="password" id="password" value="{{old('password')}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fields">
                                    <label for="phone">Phone No:</label>
                                    {{-- <input type="number" class="form-control" name="phone" id="phone"> --}}
                                    <input type="tel" maxlength="25" class="form-control" placeholder="Mobile" name="phone" required value="{{old('phone')}}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="fields">
                                    <label for="alt_phone">Extension:</label>
                                    <input type="number" class="form-control" name="alt_phone" id="alt_phone" value="{{old('alt_phone')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="btnShipments">
                                {{-- <button type="submit" class="postBtn">Submit</button> --}}
                                <input type="submit" class="postBtn" value="Submit">
                                <a href="{{ url()->previous() }}" class="cancelBtn">Cancel</a>
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
<script>
$(document).ready(function () {
    $('#emailForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        let email = $('#email').val(); // Get email value from the form
        $('#emailError').text(''); // Clear previous error message

        // AJAX request to validate and submit the form
        $.ajax({
            url: "{{ route(auth()->user()->type . '.user_management.email_validation') }}", // The Laravel route to handle email validation
            type: 'POST',
            data: {
                email: email,
                _token: '{{ csrf_token() }}' // Add CSRF token for security
            },
            success: function (response) {
                if (response.exists) {
                    $('#emailError').text('This email is already registered.');
                } else {
                    e.currentTarget.submit();
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ', error);
            }
        });
    });
});
</script>
@endpush
