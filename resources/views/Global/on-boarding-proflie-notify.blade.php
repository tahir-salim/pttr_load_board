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
                     <h4>please get the on boarding form filled through your main company account first before getting complete access to the board</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection