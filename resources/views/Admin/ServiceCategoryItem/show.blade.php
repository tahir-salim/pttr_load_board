@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 contBody">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Service Category Item Detail</h2>
            </div>
            @push('css')
                <style>
                

                .image-container {
                    display: flex;
                    gap: 10px; /* Add space between images if needed */
                    flex-wrap: wrap; /* Wrap images to the next line if there are too many */
                }
                #imagePreview {
                    width: 100px; /* Adjust the size of the preview */
                    height: 100px;
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    border: 1px solid #ccc;
                    margin-right: 10px;
                }
            </style>

            @endpush
            <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Service Name : <span>{{ $serviceCategoryItem->service ? $serviceCategoryItem->service->name : '' }}</span></h5>
                             
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                    <h5>Category  Name: <span>{{ $serviceCategoryItem->serviceCategory ?  $serviceCategoryItem->serviceCategory->name : 'N/A' }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Item Address : <span>{{ $serviceCategoryItem->street_address }}</span></h5>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Item Icon :
                                    <span>
                                            <div id="imagePreview" style="background-image: url({{asset($serviceCategoryItem->icon)}})" width="10%"></div>
                                    </span>
                                </h5>
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Item Status :  
                                    @if($serviceCategoryItem->is_active == 1)
                                        <span class="act badge bg-success">Active</span>
                                    @else
                                        <span class="inact badge bg-danger">In Active</span>
                                    @endif</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="userdet_info2">
                                <h5>Created At : <span>{{ $serviceCategoryItem->created_at->diffForHumans() }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <a href="{{ route('super-admin.service_category_item.list') }}" class="btn btn-outline-primary">Back</a>
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
