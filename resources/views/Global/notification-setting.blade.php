@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Notification Setting</h2>
            </div>
            <div class="contBody">
                <div class="card">
                    <form action="{{route(auth()->user()->type.'.notification_setting_store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="name">Bid Created</label>
                                <input type="checkbox" class="form-control" name="create_notify" value="1">
                                <input type="checkbox" class="form-control" name="create_email" value="2">
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="name">Bid Rejected</label>
                                <input type="checkbox" class="form-control" name="reject_notify" value="1">
                                <input type="checkbox" class="form-control" name="reject_email" value="2">
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="name">Bid Withdrawn</label>
                                <input type="checkbox" class="form-control" name="withdrawn_notify" value="1">
                                <input type="checkbox" class="form-control" name="withdrawn_email" value="2">
                            </div>
                        </div>
                        <br />
                        <br />

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="btnShipments">
                                    {{-- <button type="submit" class="postBtn">Submit</button> --}}
                                    <input type="submit" class="postBtn" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
