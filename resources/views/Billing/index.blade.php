@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            
             
            <div class="main-header">
                <h2>Billing</h2>
            </div>
            
            <div class="contBody">
                @php 
                    $top_header1 = ads('Billings','top_header1');
                    $top_header2 = ads('Billings','top_header2');
                    $top_header3 = ads('Billings','top_header3');
                @endphp
            
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
                <div class="">
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
               
                    <div class="">
                       
                        <div class="card">
                            <table class="display csbody dataTable data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Invoice No</th>
                                        <th>Amount ($)</th>
                                        <th>Expired at</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                 language: {
                            searchPlaceholder: "Search by ID, User, Invoice and Amount",
                        },
                ajax: {
                    url: "{{route(auth()->user()->type . '.billing.index') }}",
                },
                   columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user_name', name: 'user_name', searchable: true },
                    { data: 'invoice_no', name: 'invoice_no', searchable: true },
                    { data: 'amount', name: 'amount', searchable: true },
                    { data: 'expired_at', name: 'expired_at', searchable: true },
                    { data: 'is_active', name: 'is_active', searchable: true },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
                // columns: [{
                //         data: 'id',
                //         name: 'id'
                //     },
                //     {
                //         data: 'user_name',
                //         name: 'user_name'
                //     },
                //     {
                //         data: 'invoice_no',
                //         name: 'invoice_no'
                //     },
                    
                //     {
                //         data: 'amount',
                //         name: 'amount'
                //     },
                //     {
                //         data: 'expired_at',
                //         name: 'expired_at'
                //     },
                //     {
                //         data: 'is_active',
                //         name: 'is_active'
                //     },
                //     {
                //         data: 'actions',
                //         name: 'actions'
                //     },
                // ]
            });

        });
    </script>
@endpush
