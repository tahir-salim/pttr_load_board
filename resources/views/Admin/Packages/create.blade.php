@extends('Admin.layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>New Package</h2>
            </div>
            <div class="contBody">
                <form action="{{ route(auth()->user()->type . '.packages.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class=" col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> Please correct the errors in the following fields:<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            @if ($error == 'Phone')
                                                <li>* Please select at least one method of contact to post</li>
                                            @elseif ($error == 'Email')
                                            @else
                                                <li>* {{ $error }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="card shipmentDetails">
                                <h3>Package Form</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required name="name" id="name" value=""
                                                placeholder="Enter Package Name">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select name="type" required>
                                                @foreach($packages as $package)
                                                    @if($package->type == 1)
                                                        <option value="{{$package->type}}">Carrier</option>
                                                    @elseif($package->type == 3)
                                                        <option value="{{$package->type}}">Broker</option>
                                                    @else
                                                        <option value="{{$package->type}}">Combo</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" id="promo_owner_amount" required name="promo_owner_amount" value=""
                                                        placeholder="Enter Owner Promo Amount">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" id="promo_user_amount" required name="promo_user_amount" value=""
                                                        placeholder="Enter User Promo Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" id="regular_owner_amount" required name="regular_owner_amount" value=""
                                                        placeholder="Enter Owner Regular Amount">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" id="regular_user_amount" required name="regular_user_amount" value=""
                                                        placeholder="Enter User Regular Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <textarea class="form-control" id="content" placeholder="Enter the Description" rows="10" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btnShipments halfbtn">
                        <a href="{{ url()->previous() }}" type="button"
                            class="cancelBtn">Cancel Package</a>
                        <input type="submit" class="postBtn" value="Create Package">
                        

                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        ClassicEditor.create( document.querySelector( '#content' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush
