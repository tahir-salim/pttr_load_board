@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 ">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Trucks</h2>
            </div>
            <div class="">
                <div class="card">
                    {{--<div class="card-body">
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
                    </div>--}}
                    
                    <div class="scrollHeightShip">
                    <table class="display csbody dataTable data-table shipTable scrollcustomsShip">
    
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>From/To (Date)</th>
                                <th>Eqp detail</th>
                                <th>Length</th>
                                <th>weight</th>
                                <th>Trucker</th>
                                <th>Is posted</th>
                                {{--<th>Status</th>--}}
                                <th>Created at</th>
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
    $(document).ready( function(){
                $(".scrollHeightShip").mCustomScrollbar({theme:"inset-3-dark"});
             });
    
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('super-admin.trucks_list') }}",
                    data: function(d) {
                        d.truck_status = $('#truck_status').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'origin',
                        name: 'origin'
                    },
                    {
                        data: 'destination',
                        name: 'destination'
                    },
                    {
                        data: 'from_to_date',
                        name: 'from_to_date'
                    },
                    {
                        data: 'equipment_detail',
                        name: 'equipment_detail'
                    },
                    {
                        data: 'length',
                        name: 'length'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'is_posted',
                        name: 'is_posted'
                    },
                    // {
                    //     data: 'truck_status',
                    //     name: 'truck_status'
                    // },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                ]
            });

            $('#truck_status').change(function() {
                table.draw();
            });

        });
    </script>
@endpush
