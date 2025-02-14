@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Users Management</h2>
                <div class="rightBtn">
                    <a href="{{ route(auth()->user()->type . '.user_management.create_user') }}" class="themeBtn skyblue"><i class="fa fa-plus" style="margin-right:5px;"></i>New User</a>
            
                </div>
            </div>
            <div class="contBody">
                {{-- <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Truck Status :</strong></label>
                            <select id='truck_status' class="form-control" style="width: 200px">
                                <option value="">All</option>
                                <option value="available">Available</option>
                                <option value="pending">Pending</option>
                                <option value="pickup">Pickup</option>
                                <option value="drop off">Drop off</option>
                                <option value="in transit">In transit</option>
                                <option value="delivered">Delivered</option>
                                <option value="decline">Decline</option>
                                <option value="accepted">Accepted</option>
                            </select>
                        </div>
                    </div>
                </div> --}}
                

            @php 
                $top_header1 = ads('user_management','top_header1');
                $top_header2 = ads('user_management','top_header2');
                $top_header3 = ads('user_management','top_header3');
            @endphp

                <div class="">
                    @if(isset($top_header1) && isset($top_header2) && isset($top_header3))
                    <div class="row">
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header1->url}}" target="_blank" title=""><img src="{{asset($top_header1->image)}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header2->url}}" target="_blank" title=""><img src="{{asset($top_header2->image)}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header3->url}}" target="_blank" title=""><img src="{{asset($top_header3->image)}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Company Name</th>
                                    <th>Package Name</th>
                                    <th>Created at</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                language: {
                    searchPlaceholder: "Search by Name, Package Name",
                },
                ajax: {
                    url: "{{route(auth()->user()->type . '.user_management.index') }}",
                },
                columns: [{
                        data: 'id',
                        name: 'id', orderable: true, searchable: true
                    },
                    {
                        data: 'name' ,
                        name: 'name', orderable: true, searchable: true 
                    },
                    {
                        data: 'email' ,
                        name: 'email', orderable: true, searchable: true 
                    },
                    {
                        data: 'company_name',
                        name: 'company_name', orderable: true, searchable: true
                    },
                    {
                        data: 'package_name',
                        name: 'package_name', orderable: true, searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at', orderable: false, searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status', orderable: false, searchable: false
                    },
                ]
            });

        });
    </script>
@endpush
