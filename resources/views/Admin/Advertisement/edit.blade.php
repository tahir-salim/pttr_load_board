@extends('Admin.layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Update Advertisement</h2>
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
            <div class="contBody">
                <form action="{{ route('super-admin.advertisements.update',[$advertisement->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class=" col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>*{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shipmentDetails">
                                <h3>Update Advertisement</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <select id='type' required name="page_name" class="form-control" style="height: auto">
                                            @if($advertisement->position != "mobile_app")
                                                <option value="{{$advertisement->page_name}}" >{{strtoupper($advertisement->page_name)}}</option>
                                                
                                            @else
                                                <option value="app1" {{$advertisement->page_name == "app1" ? "selected" : ""}}>{{strtoupper('app1')}}</option>
                                                <option value="app2" {{$advertisement->page_name == "app2" ? "selected" : ""}}>{{strtoupper('app2')}}</option>
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select id='type' required name="position" class="form-control" style="height: auto">
                                                        @if($advertisement->position != "mobile_app")
                                                        <option value="{{$advertisement->position}}">{{strtoupper($advertisement->position)}}</option>
                                                        
                                                    @else
                                                    <option value="mobile_app" {{$advertisement->position == "mobile_app" ? "selected" : ""}}>{{strtoupper('mobile app')}}</option>
                                                    @endif
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">

                                                    <input type="url" required  name="url" value="{{$advertisement->url ? $advertisement->url : old('url')}}"
                                                        placeholder="https://www.example.com/">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <input type="file" name="image" class="form-control" placeholder="image" value="{{$advertisement->image ? $advertisement->image : old('image')}}"  {{$advertisement->image ? "" : "required"}} id="imageUpload" accept=".png, .jpg, .jpeg, .gif" style="height: auto">
                                        </div>
                                        <div id="imagePreview" style="background-image: url({{asset($advertisement->image)}})">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btnShipments halfbtn">
                        <a href="{{ route('super-admin.advertisements.list') }}" type="button"
                            class="cancelBtn">Cancel Advertisement</a>
                        <input type="submit" class="postBtn" value="Update Advertisement">
                    </div>
                </form>
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
