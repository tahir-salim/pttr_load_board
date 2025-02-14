@extends('layouts.app')

@section('content')
        @php
            $parentId = auth()->user()->parent_id;
            $user = App\Models\User::find($parentId);
        @endphp
        <div class="col-md-10">
            <div class="mainBody ">
                    <div class="main-header">
                        <div class="card">
                            <h2>Your Subscription Has Expired</h2>
                            <h2>Kindly Contact Your Owner</h2>
                            <h2>Email :</h2><span>{{ $user->email }}</span>
                            <h2>Phone : </h2><span>{{ $user->phone }}</span>    
                        </div>
                </div>
            </div>
        </div>
@endsection