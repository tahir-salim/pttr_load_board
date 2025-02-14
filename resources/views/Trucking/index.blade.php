@extends('layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Trucks</h2>
                <div class="rightBtn">
                    <a href="{{ route(auth()->user()->type . '.truck.create') }}" class="themeBtn skyblue"><i class="fa fa-plus" style="margin-right:5px;"></i>New Truck</a>

                </div>
            </div>
            <div class="">
                <div class="contBody">
                    <div class="card">
                        <table class="display csbody dataTable data-table invoicetableScroll">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>From/To (Date)</th>
                                     <th>Equipment type</th>
                                    <th>Equipment detail</th>
                                    <th>Length (ft)</th>
                                    <th>weight (lbs)</th>
                                    <th>Is posted</th>
                                    <th>Created at</th>
                                    <th>Action</th>
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
                ajax: {
                    url: "{{route(auth()->user()->type . '.truck.index') }}",
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
                        data: 'eq_type_id',
                        name: 'eq_type_id'
                    },

                    {
                        data: 'eq_detail',
                        name: 'eq_detail'
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
                        data: 'is_posted',
                        name: 'is_posted'
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
