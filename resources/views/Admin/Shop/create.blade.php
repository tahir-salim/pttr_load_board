@extends('Admin.layouts.app')
@section('content')
<div class="col-md-10">
    <div class="mainBody">
    <!-- Begin: Notification -->
    @include('layouts.notifications')
    <!-- END: Notification -->

    <div class="main-header">
        <h2>Create Shop</h2>
    </div>

        <div class="contBody">
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
                             <form action="{{ route(auth()->user()->type . '.shops.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required  name="name" value="{{old('name')}}" placeholder="Enter Shop Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required  name="address" value="{{old('address')}}" placeholder="Enter Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required  name="city" value="{{old('city')}}" placeholder="Enter City">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required  name="state" value="{{old('state')}}" placeholder="Enter State">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" name="zip_code" value="{{old('zip_code')}}" placeholder="Enter ZIP">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fields">
                                            <input type="number" required  name="lat" value="{{old('lat')}}" placeholder="Enter Longitude">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="fields">
                                            <input type="number" required  name="lng" value="{{old('lng')}}" placeholder="Enter Latitude">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <textarea class="form-control" id="content" placeholder="Enter the Description" rows="10" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <input type="file" required name="image" class="form-control" placeholder="image"  id="imageUploadWeb" accept=".png, .jpg, .jpeg, .gif" style="height: auto">
                                        </div>
                                        <div id="imagePreviewWeb" style="display:none">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="btnShipments halfbtn">
                                    <a href="{{ route('super-admin.shops.list') }}" type="button"
                                        class="cancelBtn">Cancel Shop</a>
                                    <input type="submit" class="postBtn" value="Create Shop">
                                </div>
                            </form>
                    </div>
                </div>
            </div>
            
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
            
        $('#imagePreviewWeb').hide();
        
        function readURLWeb(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(e.target.result );
                        $('#imagePreviewWeb').css('background-image', 'url('+e.target.result +')');
                        $('#imagePreviewWeb').show();
                        $('#imagePreviewWeb').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }else{
                    $('#imagePreviewWeb').hide();
                }
            }
            $("#imageUploadWeb").change(function() {
                readURLWeb(this);

            });
    </script>
@endpush
