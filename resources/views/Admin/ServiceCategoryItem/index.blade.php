@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 ">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Services Category Items</h2>
                <div class="rightBtn">
                    <a href="{{ route(auth()->user()->type . '.service_category_item.create') }}" class="themeBtn skyblue"><i
                            class="fa fa-plus" style="margin-right:5px;"></i> New Item</a>
                </div>
            </div>
            <div class="">
                <div class="card">
                    <div class="scrollHeightShip">
                        <table class="display csbody dataTable data-table shipTable scrollcustomsShip">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item Address</th>
                                    <th>Service</th>
                                    <th>Category</th>
                                    <th>Icon</th>
                                    <th>Location</th>
                                    <th>Status</th>
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

    $(document).ready( function(){
                $(".scrollHeightShip").mCustomScrollbar({theme:"inset-3-dark"});
             });
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('super-admin.service_category_item.list') }}",
                    data: function(d) {
                        d.name = $('#id').val(),
                        d.lat = $('#name').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'service',
                        name: 'service'
                    },
                    {
                        data: 'serviceCategory',
                        name: 'serviceCategory'
                    },
                    {
                        data: 'icon',
                        name: 'icon'
                    },
                    {
                        data: 'location',
                        name: 'location',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'status',
                        name: 'status'
                        
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            $('#page_name').change(function() {
                table.draw();
            });

        });
    </script>
@endpush
