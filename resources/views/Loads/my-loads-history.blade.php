@extends('layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
@endpush

<div class="col-md-10">
    <div class="mainBody">

        <!-- Begin: Notification -->
        @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>My Loads</h2>
            {{-- <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.post_a_shipment')}}" tile="">
                    <img src="{{asset('assets/images/icons/shipmenticon.webp')}}" alt="">
                    NEW SHIPMENT
                </a>
            </div> --}}
        </div>

        <div class="contBody">
            {{-- @php
                $top_header1 = ads('my_shipments_history','top_header1');
                $top_header2 = ads('my_shipments_history','top_header2');
                $top_header3 = ads('my_shipments_history','top_header3');
            @endphp --}}
            
            @if(isset($top_header1) && isset($top_header2) && isset($top_header3))
            <div class="row mb-3">
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
            <div class="tablescroll">
                
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="tabsShipment">
                            <a data-targetit="open" href="{{route(auth()->user()->type.'.my_loads')}}" title="">Open
                                ({{$shipment_open_count}})</a>
                            <a href="{{route(auth()->user()->type.'.my_loads_active')}}" title="">Active
                                ({{$shipment_active_count}})</a>
                            <a class="active" data-targetit="history" href="javascript:;" title="">History
                                ({{$shipment_history_count}})</a>
                        </div>
                        <div class="filtersBtns">
                            <form action="">
                                <div class="d-flex align-items-center">
                                    <h3>Filter:</h3>
                                    <div class="chckboxs">
                                        <div class="items">
                                            <input type="checkbox" name="completed">
                                            <span class="checkmark">COMPLETE</span>
                                        </div>
                                        <div class="items">
                                            <input type="checkbox" name="canceled">
                                            <span class="checkmark">CANCELED</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--<div class="col-md-6">-->
                    <!--    <div class="advertisments">-->
                    <!--        <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-08.jpg')}}" alt=""></a>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                
                
                <div class="card">
                    <div class="box-open showfirst">
                        <div class="tableLayout">
                            <table id="ShipmentTable" class="display csbody dataTable data-table">
                                <thead>
                                    <tr>
                                        <th>Age</th>
                                        <th>Availibilty</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Reference</th>
                                        <th>Equipment</th>
                                        <th>Length (ft)</th>
                                        <th>Weight (lbs)</th>
                                        <th>Full/Partial</th>
                                        <th>Rate ($)</th>
                                        {{-- <th>Bids</th>
                                                <th>Shipment Requests</th> --}}
                                        <th>Status</th>
                                        <th width="100px">Action</th>
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
@push('js')

<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>



<script type="text/javascript">
$(function() {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: {
            url: "{{ route(auth()->user()->type.'.my_loads_history')}}",
            data: function(d) {
                d.completed = $('input[name="completed"]').is(":checked") ? true : false,
                    d.canceled = $('input[name="canceled"]').is(":checked") ? true : false,
                    d.search = $('input[type="search"]').val()
            }
        },
        columns: [{
                data: 'age',
                name: 'age'
            },
            {
                data: 'available',
                name: 'available'
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
                data: 'reference_id',
                name: 'reference_id'
            },
            {
                data: 'equipment',
                name: 'equipment'
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
                data: 'equipment_detail',
                name: 'equipment_detail'
            },
            {
                data: 'dat_rate',
                name: 'dat_rate'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('input[type="checkbox"]').change(function() {
        table.draw();
    });
});
</script>
@endpush
@endsection