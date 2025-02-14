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
            <h2>Shipments Invoice</h2>
        </div>
        <div class="contBody">
            <div class="tablescroll">
                <div class="card">
                    <div class="box-open showfirst">
                        <div class="tableLayout">
                            <table id="ShipmentTable" class="display csbody dataTable data-table">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Broker</th>
                                        <th>Carrier</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Reference</th>
                                        <th>Equipment</th>
                                        <th>Weight (lbs)</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Price</th>
                                        <th>Created At</th>
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
            url: "{{ route(auth()->user()->type.'.shipment_invoice') }}",
        },
        columns: [
            {
                data: 'invoice_no',
                name: 'invoice_no'
            },
            {
                data: 'user',
                name: 'user'
            },
            {
                data: 'carrier',
                name: 'carrier'
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
                data: 'equipment_type_name',
                name: 'equipment_type_name'
            },
            {
                data: 'weight',
                name: 'weight'
            },
            {
                data: 'from_date',
                name: 'from_date'
            },
            {
                data: 'to_date',
                name: 'to_date'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'actions',
                name: 'actions',
            },
        ]
    });

    // $('input[type="checkbox"]').change(function() {
    //     table.draw();
    // });
});

// function status_accept_decline(type, id, value) {
//     Swal.fire({
//         title: "Are you sure do you really want to perform this action?",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonText: "Yes continue",
//         showLoaderOnConfirm: true,
//     }).then((result) => {
//         if (result.isConfirmed) {
//             type = '{{auth()->user()->type}}';
//             url = '{{config("app.url")}}/' + type + '/status-accept-decline/' + id + '?value=' + value +
//                 '&type=' + type;
//             $.get(url);
//             $(document).ajaxStop(function() {
//                 window.location.reload();
//             });
//         }
//     });
// }
</script>
@endpush
@endsection