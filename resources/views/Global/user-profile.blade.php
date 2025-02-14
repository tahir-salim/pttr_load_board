@extends('layouts.app')
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
        @php 
            $top_header1 = ads('user_profile','top_header1');
            $top_header2 = ads('user_profile','top_header2');
            $top_header3 = ads('user_profile','top_header3');
            $center_header4 = ads('user_profile','center_header4');
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
                          <div class="d-flex justify-content-end">
                                <a id="" class="" data-toggle="modal" data-target="#update_profile_modal"
                                    href="" title="">EDIT</a>
                            </div>
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
                                    <h5>Membership Expire at: <span>{{(Carbon\Carbon::create($user->expired_at)->format('F, j Y'))}}</span></h5>
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
                        <!--<p>Full Authority<br>-->
                        <!--    <span>View and update user data and pay invoices for your account-->
                        <!--        only.</span>-->
                        <!--</p>-->
                    </div>
                    <div class="advertisments mt-3">
                        <a href="{{$center_header4->url}}" target="_blank" title=""><img src="{{asset($center_header4->image)}}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
    <div class="modal fade" id="update_profile_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route(auth()->user()->type . '.update_profile') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" value="{{ $firstname }}"
                                name="firstname" placeholder="First Name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" value="{{ $lastname }}"
                                name="lastname" placeholder="Last Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Email" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Contact phone</label>
                            <input type="tel" value="{{ $user->phone }}" class="form-control" id="phone"
                                name="phone" placeholder="Phone Number" required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
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