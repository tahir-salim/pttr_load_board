@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 ">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Shops</h2>
                <div class="rightBtn">
                    <a href="{{ route(auth()->user()->type . '.shops.create') }}" class="themeBtn skyblue"><i
                            class="fa fa-plus" style="margin-right:5px;"></i> New Shop</a>
                </div>
            </div>
            <div class="">
                <div class="card">
                    <div class="scrollHeightShip">
                        <table class="display csbody dataTable data-table shipTable scrollcustomsShip">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Shop Name</th>
                                    <th>Image</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
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
                    url: "{{ route('super-admin.shops.list') }}",
                    data: function(d) {
                        d.name = $('#name').val(),
                        d.lat = $('#lat').val(),
                        d.lng = $('#lng').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'lat',
                        name: 'lat'
                    },
                    {
                        data: 'lng',
                        name: 'lng'
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

    {{-- <script type="text/javascript">
    $(function () {
        var type =  $('#type').val();
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('super-admin.users_list')}}",
          columns: [
            {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'phone', name: 'phone'},
              {data: 'alt_phone', name: 'alt_phone'},
              {data: 'created_at', name: 'created_at'},
              {data: 'type', name: 'type'},
          ]
      });


      $('#type').change(function(){
        table.draw();
    });
    });
  </script> --}}
@endpush
