@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 ">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Advertisement</h2>
                <div class="rightBtn">
                    <a href="{{ route(auth()->user()->type . '.advertisements.create') }}" class="themeBtn skyblue"><i
                            class="fa fa-plus" style="margin-right:5px;"></i> New Advertisement</a>
                </div>
            </div>
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong>Location Name :</strong></label>
                            <select id='page_name' name="page_name" class="form-control" style="width: 200px">
                                <option value="0"> All Location</option>
                                <option value="dashboard">{{strtoupper('dashboard')}}</option>
                                <option value="search_truck">{{strtoupper('search truck')}}</option>
                                <option value="search_loads">{{strtoupper('search loads')}}</option>
                                <option value="my_shipments">{{strtoupper('my shipments')}}</option>
                                <option value="shipment_details">{{strtoupper('shipment details')}}</option>
                                <option value="post_a_shipment">{{strtoupper('post a shipment')}}</option>
                                <option value="edit_a_shipment">{{strtoupper('edit a shipment')}}</option>
                                <option value="new_tracking_request">{{strtoupper('new tracking request')}}</option>
                                <option value="tracking_detail">{{strtoupper('tracking detail')}}</option>
                                <option value="create_tracking_request">{{strtoupper('create tracking request')}}</option>
                                <option value="edit_tracking_request">{{strtoupper('edit tracking request')}}</option>
                                <option value="live_support">{{strtoupper('live support')}}</option>
                                <option value="private_network">{{strtoupper('private network')}}</option>
                                <option value="private_network_detail">{{strtoupper('private network detail')}}</option>
                                <option value="create_private_network">{{strtoupper('createprivatenetwork')}}</option>
                                <option value="edit_private_network">{{strtoupper('edit private network')}}</option>
                                <option value="groups">{{strtoupper('groups')}}</option>
                                <option value="groups_details">{{strtoupper('groups details')}}</option>
                                <option value="tools">{{strtoupper('tools')}}</option>
                                <option value="feedbacks">{{strtoupper('feedbacks')}}</option>
                                <option value="view_notification">{{strtoupper('view notification')}}</option>
                                <option value="account_information">{{strtoupper('account information')}}</option>
                                <option value="compnay_profile">{{strtoupper('compnay profile')}}</option>
                                <option value="Billings">{{strtoupper('Billings')}}</option>
                                <option value="Billing_info">{{strtoupper('Billing info')}}</option>
                                <option value="privacy_policy">{{strtoupper('privacy policy')}}</option>
                                <option value="terms_and_condition">{{strtoupper('terms and condition')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="scrollHeightShip">
                        <table class="display csbody dataTable data-table shipTable scrollcustomsShip">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Location Name</th>
                                    <th>Position</th>
                                    <th>Image</th>
                                    <th>Url</th>
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
                    url: "{{ route('super-admin.advertisements.list') }}",
                    data: function(d) {
                        d.page_name = $('#page_name').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'page_name',
                        name: 'page_name'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'url',
                        name: 'url'
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
