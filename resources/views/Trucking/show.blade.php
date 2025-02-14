@extends('layouts.app')

@section('content')
    <div class="col-md-10 contBody">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Truck Post Detail</h2>
            </div>
            <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Origin : <span>{{ $truck_post->origin }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Destination : <span>{{ $truck_post->destination }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>From date : <span>{{ $truck_post->from_date }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>To date : <span>{{ $truck_post->to_date }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Equipment type : <span>{{ $truck_post->trucks ? $truck_post->trucks->equipment_type->name : null }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Equipment detail :
                                    <span>
                                        @if($truck_post->trucks)
                                            @if($truck_post->trucks->equipment_detail == "0")
                                                Full
                                            @else
                                                Partial
                                            @endif
                                        @endif

                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Length : <span>{{ $truck_post->trucks ?  $truck_post->trucks->length : '' }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Weight : <span>{{ $truck_post->trucks ? $truck_post->trucks->weight : '' }}</span></h5>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Rate : <span>${{ $truck_post->rate ? $truck_post->rate  : '0'}}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Phone :
                                    <span>
                                        @if($truck_post->status_phone == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Email :
                                    <span>
                                        @if($truck_post->status_email == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Is posted :
                                    <span>
                                        @if($truck_post->is_posted == 1)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Comment : <span>{{ $truck_post->comment }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Reference : <span>{{ $truck_post->trucks ? $truck_post->trucks->reference_id : ''}}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <a href="{{ route(auth()->user()->type . '.truck.index') }}" class="btn btn-outline-primary">Back</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
