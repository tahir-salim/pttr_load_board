@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 ">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All User</h2>
            </div>
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Role :</strong></label>
                            <select id='type' class="form-control" style="width: 200px">
                                <option value="0">All</option>
                                <option value="1">Trucker</option>
                                <option value="2">Shipper</option>
                                <option value="3">Broker</option>
                                <option value="4">Combo</option>

                            </select>
                        </div>
                    </div>
                    
                    
                    
                    <div class="scrollHeightShip">
                        
                    
                    
                        <table class="display csbody dataTable data-table shipTable scrollcustomsShip">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Has Parent</th>
                                    <th>Created at</th>
                                    <th>Role</th>
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
                    url: "{{ route('super-admin.users_list') }}",
                    data: function(d) {
                        d.type = $('#type').val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'has_parent',
                        name: 'has_parent'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions'
                    },
                ]
            });

            $('#type').change(function() {
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
              {data: 'has_parent', name: 'has_parent'},
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
