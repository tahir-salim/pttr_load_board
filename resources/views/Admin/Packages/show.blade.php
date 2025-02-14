@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 contBody">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Package Detail</h2>
            </div>
            <div class="card">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Name : <span>{{ $package->name }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Description : <span>{!! $package->description ? $package->description : '' !!}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Owner Promo Amount : <span>${{ $package->promo_owner_amount }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>User Promo Amount : <span>${{ $package->promo_user_amount }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Owner Regular Amount : <span>${{ $package->regular_owner_amount }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>User Regular Amount : <span>${{ $package->regular_user_amount }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">Back</a>
                        </div>
                        
                        
                    </div>


                
            </div>
        </div>
    </div>
@endsection
