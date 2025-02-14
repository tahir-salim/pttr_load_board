@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10 ">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Packages</h2>
                <div class="rightBtn">
                      {{--  <a href="{{ route(auth()->user()->type . '.packages.create') }}" class="themeBtn skyblue"><i
                                class="fa fa-plus" style="margin-right:5px;"></i> New Package</a> --}}
                    </div>
            </div>
            <div class="">
                
                <div class="card">
                    <!--<div class="card-body">-->
                    <!--    <div class="form-group">-->
                    <!--        <label><strong>Role :</strong></label>-->
                    <!--        <select id='type' class="form-control" style="width: 200px">-->
                    <!--            <option value="0">All</option>-->
                    <!--            <option value="1">Trucker</option>-->
                    <!--            <option value="2">Shipper</option>-->
                    <!--            <option value="3">Broker</option>-->

                    <!--        </select>-->
                    <!--    </div>-->
                    <!--</div>-->
                    
                
                    <div class="scrollHeightShip">
                        <table class="display csbody dataTable data-table shipTable scrollcustomsShip">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Promo Owner Amount</th>
                                    <th>Promo User Amount</th>
                                    <th>Regular Owner Amount</th>
                                    <th>Regular User Amount</th>
                                    <th>Created at</th>
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
    
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('super-admin.packages.list') }}",
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
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'promo_owner_amount',
                        name: 'promo_owner_amount'
                    },
                    {
                        data: 'promo_user_amount',
                        name: 'promo_user_amount'
                    },
                    {
                        data: 'regular_owner_amount',
                        name: 'regular_owner_amount'
                    },
                    {
                        data: 'regular_user_amount',
                        name: 'regular_user_amount'
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

            $('#type').change(function() {
                table.draw();
            });

        });
    </script>

    
@endpush
