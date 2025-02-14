@extends('Admin.layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Update Shop</h2>
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
                <form action="{{ route('super-admin.shops.update',[$shop->id]) }}" method="POST"
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required  name="name" value="{{$shop->name ? $shop->name : old('name')}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required  name="address" value="{{$shop->address ? $shop->address : old('address')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required  name="city" value="{{$shop->city ? $shop->city : old('city')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fields">
                                            <input type="text" required  name="state" value="{{$shop->state ? $shop->state : old('state')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fields">
                                            <input type="text" name="zip_code" value="{{$shop->zip_code ? $shop->zip_code : old('zip_code')}}">
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            
                                            <select id='type' required name="status" class="form-control" style="height: auto">
                                                <option value="1" @if (old($shop->status) == "1") {{ 'selected' }} @endif>Active</option>
                                                <option value="0" @if (old($shop->status) == "0") {{ 'selected' }} @endif>In Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fields">
                                            <input type="number" required  name="lat" value="{{$shop->lat ? $shop->lat : old('lat')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fields">
                                            <input type="number" required  name="lng" value="{{$shop->lng ? $shop->lng : old('lng')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <textarea class="form-control" id="content" rows="10" name="description">{!!$shop->description!!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <input type="file"  name="image" class="form-control" placeholder="image" value="{{$shop->image ? $shop->image : old('image')}}"  {{$shop->image ? "" : "required"}} id="imageUpload" accept=".png, .jpg, .jpeg, .gif" style="height: auto">
                                        </div>
                                        <div id="imagePreview" style="background-image: url({{asset($shop->image)}})">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btnShipments halfbtn">
                        <a href="{{ route('super-admin.shops.list') }}" type="button"
                            class="cancelBtn">Cancel Shop</a>
                        <input type="submit" class="postBtn" value="Update Shop">
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
