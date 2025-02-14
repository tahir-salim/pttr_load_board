@extends('Admin.layouts.app')
@section('content')
<div class="col-md-10">
   <div class="mainBody">
      <!-- Begin: Notification -->
      @include('layouts.notifications')
      <!-- END: Notification -->
          <div class="main-header">
             <h2>All Sub Admins</h2>
             <div class="rightBtn">
                    <a href="{{ route(auth()->user()->type . '.subadmin.add') }}" class="themeBtn skyblue"><i
                            class="fa fa-plus" style="margin-right:5px;"></i>Create New SubAdmin</a>
                </div>
          </div>
          <div class="contBody">
             <div class="card">
                 <div class="card-body">
                     <div class="scrollHeightShip">
                        <table class="display csbody dataTable data-table shipTable scrollcustomsShip"> 
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Account Status</th> 
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
                    url: "{{ route('super-admin.subadmin.list') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'account_status',
                        name: 'account_status'
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

        });
    </script>
@endpush