@extends('Admin.layouts.app')
@section('content')

<div class="col-md-10">
    <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
        <div class="main-header">
            <h2>User Profile
            </h2>
                 {{-- <span>Last Updated: Jan 24, 2024, by PTTR</span> --}}

        </div>
        <div class="contBody">
            <div class="row">
                <div class="col-md-8">
                    <div class="card userdetails">
                        <h3>User Details</h3>
                        <p class="notific">
                            <i class="fal fa-info-circle"></i>
                            To request changes to this
                            section, contact PTTR Support at
                            (888) 706-7013.
                        </p>
                        <div class="row pt-3">
                            <div class="col-md-4">
                                <div class="userdet_info">
                                    <h5>First Name: <span>{{$firstname}}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="userdet_info">
                                    <h5>Last Name: <span>{{$lastname}}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="userdet_info">
                                    <h5>Login Email: <span>{{$user->email}}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="userdet_info">
                                    <h5>Contact Phone: <span>{{$user->phone}}</span></h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="userdet_info">
                                    <h5>Acount Status:</h5> <span>
                                        @if ($user->status == 1)
                                            <span class="badge badge-success" tile="" >Active</span>
                                        @else
                                           <span class="badge badge-success" tile="" >InActive</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="userdet_info">
                                    <h5>Contact Email: <i class="fal fa-info-circle"></i>
                                        <span>{{$user->email}}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="changePasswords">
                            <a id="edit" class="postBtn" href="javascript:;" title="">CHANGE PASSWORD</a>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="editForm" style="display: block;">
                                <form action="{{route(auth()->user()->type.'.change_password')}}" method="POST">
                                    @csrf
                                    <div class="shipmentDetails">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="fields">
                                                        <input type="password" placeholder="Old Password" name="old_password" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fields">
                                                        <input type="password" placeholder="New Password" name="new_password" required="" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fields">
                                                        <input type="password" placeholder="Confirm Password" name="confirm_password" required="" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="btnShipments text-right">
                                                        <input type="submit" value="Submit" class="postBtn">
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="row justify-content-end">
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card authorityLevel">
                        <h3>Authority Level</h3>
                        <p>To change Authority Level, contact Customer Support at (888) 706-7013.</p>
                        <p>Full Authority<br>
                            <span>View and update user data and pay invoices for your account
                                only.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('js')
    <script>
    $(".editForm").hide();
        $("#edit").click(function() {
            $(".editForm").toggle('slow');
        });
        
    </script>
@endpush