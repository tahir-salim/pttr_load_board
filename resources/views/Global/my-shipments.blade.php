@extends('layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<style>
table.dataTable td a+a {
    margin-left: 2px;
}
</style>
@endpush

<div class="col-md-10">
    <div class="mainBody">

        <!-- Begin: Notification -->
        @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>My Shipments</h2>
            <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.post_a_shipment')}}" tile="">
                    <img src="{{ asset('assets/images/icons/shipmenticon.webp') }}" alt="">
                    NEW SHIPMENT
                </a>
            </div>
        </div>
            @php
                $top_header1 = ads('my_shipments','top_header1');
                $top_header2 = ads('my_shipments','top_header2');
                $top_header3 = ads('my_shipments','top_header3');
            @endphp
        <div class="contBody">
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
            <div class="tablescroll">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="tabsShipment">
                            <a class="active" data-targetit="open" href="javascript:;" title="">Open
                                ({{$shipment_open_count}})</a>
                            <a href="{{route(auth()->user()->type.'.my_shipments_active')}}" title="">Active
                                ({{$shipment_active_count}})</a>
                            <a data-targetit="history" href="{{route(auth()->user()->type.'.my_shipments_history')}}"
                                title="">History ({{$shipment_history_count}})</a>
                        </div>
                        <div class="filtersBtns">
                            <form action="">
                                <div class="d-flex align-items-center">
                                    <h3>Filter:</h3>
                                    <div class="chckboxs">
                                        <div class="items">
                                            <input type="checkbox" name="posted">
                                            <span class="checkmark">Posted</span>
                                        </div>
                                        <div class="items">
                                            <input type="checkbox" name="booked">
                                            <span class="checkmark">BOOKED</span>
                                        </div>
                                        <div class="items">
                                            <input type="checkbox" name="expired">
                                            <span class="checkmark">EXIPIRED</span>
                                        </div>
                                        <div class="items">
                                            <input type="checkbox" name="with_bids">
                                            <span class="checkmark">With Bids</span>
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
                                        <th>Carrier Name</th>
                                        <th>Available</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Reference</th>
                                        <th>Equipment</th>
                                        <th>Length (ft)</th>
                                        <th>Weight (lbs)</th>
                                        <th>Full/Partial</th>
                                        <th>LoabBoard Rate ($)</th>
                                        <th>Private Rate ($)</th>
                                        <th>Bids</th>
                                        <th>Shipment Requests</th>
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
                {{-- <div class="NoshipmentImage">
                            <figure>
                                <img class="img-fluid" src="{{asset('assets/images/Illustration-img.webp')}}" alt="">
                </figure>
                <p>
                    <strong>You don't have any shipments</strong>
                    Your posts, bids and booking requests will appear here.
                </p>
            </div> --}}
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
            url: "{{ route(auth()->user()->type.'.my_shipments') }}",
            data: function(d) {
                d.posted = $('input[name="posted"]').is(":checked") ? true : false,
                    d.with_bids = $('input[name="with_bids"]').is(":checked") ? true : false,
                    d.booked = $('input[name="booked"]').is(":checked") ? true : false,
                    d.expired = $('input[name="expired"]').is(":checked") ? true : false,
                    d.search = $('input[type="search"]').val()
            }
        },
        columns: [{
                data: 'age',
                name: 'age'
            },
             {
                data: 'carrier',
                name: 'carrier'
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
                data: 'private_rate',
                name: 'private_rate'
            },
            {
                data: 'bids',
                name: 'bids'
            },
            {
                data: 'ship_requests',
                name: 'ship_requests'
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

function status_accept_decline(type, id, value) {
    Swal.fire({
        title: "Are you sure do you really want to perform this action?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes continue",
        showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.isConfirmed) {
            type = '{{auth()->user()->type}}';
            url = '{{config("app.url")}}/' + type + '/status-accept-decline/' + id + '?value=' + value +
                '&type=' + type;
            $.get(url);
            $(document).ajaxStop(function() {
                window.location.reload();
            });
        }
    });
}
</script>
@endpush
@endsection