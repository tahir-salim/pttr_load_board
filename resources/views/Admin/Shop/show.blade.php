@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 contBody">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Shop Detail</h2>
            </div>
            @push('css')
                <style>
                #imagePreview {
                    background-position: center;
                    height: 200px;
                    background-repeat: no-repeat;
                    background-size: contain;
                    width: 300px;
                }
            </style>
            @endpush
            <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Shop Name : <span>{{ $shop->name }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Address : <span>{{ $shop->address }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>State : <span>{{ $shop->state }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>City : <span>{{ $shop->city }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>ZIP Code : <span>{{ $shop->zip_code }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                @if($shop->status == 1)
                                    <h5>Status : <span class="act badge bg-success">Active</span></h5>
                                @else
                                    <h5>Status : <span class="inact badge bg-danger">In Active</span></h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Latitude : <span>{{ $shop->lat }}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Longitutde : <span>{{ $shop->lng }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Description : <span>{!! $shop->description ? $shop->description : '' !!}</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Image : 
                                    <span>
                                     <div id="imagePreview" style="background-image: url({{asset($shop->image)}})"></div>
                                    </span>
                                </h5>
                            </div>
                        </div>
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

@push('js')
    <script>

        function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(e.target.result );
                        $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                        $('#imagePreview').show();
                        $('#imagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }else{
                    $('#imagePreview').hide();
                }
            }
            $("#imageUpload").change(function() {
                readURL(this);

            });


    </script>
@endpush
