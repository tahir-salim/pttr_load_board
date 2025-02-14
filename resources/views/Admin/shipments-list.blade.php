@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="mainBody ">

           
            <div class="">
                 <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

                <div class="main-header">
                    <h2>All Shipments</h2>
                </div>
                <div class="contBody">
                    <div class="card">
                    <div class="card-body">
                        <div class="form-group">

                            {{-- if (strtoupper($request->get('shipment_status')) == 'WAITING'
                            || strtoupper($request->get('shipment_status')) == 'AT-PICK-UP'
                            || strtoupper($request->get('shipment_status')) == 'AT-DROP-OFF'
                            || strtoupper($request->get('shipment_status')) == 'DISPATCHED'
                            || strtoupper($request->get('shipment_status')) == 'IN-TRANSIT'
                            || strtoupper($request->get('shipment_status')) == 'DELIVERED'
                            || strtoupper($request->get('shipment_status')) == 'COMPLETE'
                            || strtoupper($request->get('shipment_status')) == 'CANCELED') { --}}


                            <label><strong>Shipment Status :</strong></label>
                            <select id='shipment_status' class="form-control" style="width: 200px">
                                <option value="">All</option>
                                <option value="WAITING">PENDING</option>
                                <option value="EXPIRED">EXPIRED</option>
                                <option value="BOOKED">BOOKED</option>
                                <option value="AT-PICK-UP">AT PICK UP</option>
                                <option value="PICK-UP-2">PICK UP 2</option>
                                <option value="PICK-UP-3">PICK UP 3</option>
                                <option value="PICK-UP-4">PICK UP 4</option>
                                <option value="IN-TRANSIT">IN TRANSIT</option>
                                <option value="DISPATCHED">DISPATCHED</option>
                                <option value="AT-DROP-OFF">AT DROP OFF</option>
                                <option value="DROP-OFF-2">DROP OFF 2</option>
                                <option value="DROP-OFF-3">DROP OFF 3</option>
                                <option value="DROP-OFF-4">DROP OFF 4</option>
                                <option value="DELIVERED">DELIVERED</option>
                                <option value="COMPLETE">COMPLETE</option>
                                <option value="CANCELED">CANCELED</option>
                            </select>
                        </div>
                    </div>
                    <div class="scrollHeightShip scrollcustomss">
                        
                    <div class="tablescroll">
                    
                        <table class="display csbody dataTable data-table shipTable scrollcustomsShip invoicetableScroll">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>From/To (Date)</th>
                                    <th>From/To (Time)</th>
                                    <th>Eqp detail</th>
                                    <th>Length</th>
                                    <th>weight</th>
                                    <th>PTTR Rates ($)</th>
                                    <th>Private Rates ($)</th>
                                    <th>Booking Rates ($)</th>
                                    <th>User</th>
                                    <th>Is posted</th>
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
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
    
            
            
            $(document).ready( function(){
                $(".scrollHeightShip").mCustomScrollbar({theme:"inset-3-dark"});
                
                // $(".scrollcustomss table").mCustomScrollbar({
                //     theme: "inset-3-dark",
                //     axis: "both",
                //     scrollbarPosition: "outside",
                //     advanced: {
                //         autoExpandHorizontalScroll: true
                //     }
                // });
             });
    
        $(function() {
             
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('super-admin.shipments_list') }}",
                    data: function(d) {
                        d.shipment_status = $('#shipment_status').val(),
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
                        data: 'from_to_time',
                        name: 'from_to_time'
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
                        data: 'dat_rate',
                        name: 'dat_rate'
                    },
                    {
                        data: 'private_rate',
                        name: 'private_rate'
                    },
                    {
                        data: 'booking_rate',
                        name: 'booking_rate'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'is_post',
                        name: 'is_post'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'shipment_status',
                        name: 'shipment_status'
                    },
                ]
            });

            $('#shipment_status').change(function() {
                table.draw();
                
            });
            
           
            
            

        });
    </script>
@endpush
