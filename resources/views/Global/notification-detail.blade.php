@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Hello {{auth()->user()->name}}</h2>
            </div>
            <div class="contBody">
                <div class="card">
                    <div>
                        Title : {{$notification->title}}
                    </div>
                    <div>
                        Body : {{$notification->body}}
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection