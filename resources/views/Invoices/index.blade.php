@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="mainBody ">


            <div class="">
                <!-- Begin: Notification -->
                @include('layouts.notifications')
                <!-- END: Notification -->

                <div class="main-header">
                    <h2>All Invoices</h2>
                    <div class="rightBtn">
                        <a href="{{ route(auth()->user()->type . '.invoice.create') }}" class="themeBtn skyblue"><i
                                class="fa fa-plus" style="margin-right:5px;"></i> New Invoice</a>
                    </div>

                </div>

                <div class="contBody">
                    <div class="card">
                        <table class="display csbody dataTable data-table invoicetableScroll">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Origin/Destination</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Invoice No</th>
                                    <th>P.O No</th>
                                    <th>Inovice Total Amount</th>
                                    <th>Total Miles</th>
                                    <th>PDF</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="">
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
                // scrollCollapse: true,
                //   scrollY: "560px",
                ajax: {
                    url: "{{ route(auth()->user()->type . '.invoice.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'origin_destination',
                        name: 'origin_destination'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'po_no',
                        name: 'po_no'
                    },
                    {
                        data: 'invoice_amount',
                        name: 'invoice_amount'
                    },
                    {
                        data: 'total_miles',
                        name: 'total_miles'
                    },
                    {
                        data: 'pdf',
                        name: 'pdf'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions'
                    },
                ]
            });

        });
        
        
    </script>
@endpush
