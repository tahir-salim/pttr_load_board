@extends('layouts.app')
@section('content')
    {{--  Search Loads --}}
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            @push('css')
                <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
                <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
                <style>
                table.dataTable td a+a {
                    margin-left: 0.5rem;
                }
                </style>
            @endpush()

            <div class="main-header">
                <h2>Send Trackings</h2>
                <div class="rightBtn">
                    <a class="themeBtn skyblue" href="{{ route(auth()->user()->type . '.new_tracking_request') }}"
                        tile="">
                        Send Tracking
                    </a>
                </div>
            </div>
            @php
                $top_header1 = ads('create_tracking_request','top_header1');
                $top_header2 = ads('create_tracking_request','top_header2');
                $top_header3 = ads('create_tracking_request','top_header3');
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
                <div class="card" style="min-height:400px">
                    <table class="display csbody dataTable data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Carrier Email</th>
                                <th>Phone</th>
                                <th>Shipment</th>
                                <th>Status</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        @push('js')
            <script type="text/javascript">
                $(function() {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route(auth()->user()->type . '.trackings') }}",
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'carrier_email',
                                name: 'carrier_email'
                            },
                            {
                                data: 'phone',
                                name: 'phone'
                            },
                            {
                                data: 'shipment',
                                name: 'shipment'
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

                });
            </script>
        @endpush
    @endsection
