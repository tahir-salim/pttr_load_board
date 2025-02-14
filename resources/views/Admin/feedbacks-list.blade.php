@extends('Admin.layouts.app')

@section('content')
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Feedbacks</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Role</th>
                            <th>Message</th>                            
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
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: "{{ route('super-admin.feedbacks_list') }}",
                    data: function(d) {
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
                        data: 'user_type',
                        name: 'user_type'
                    },
                    {
                        data: 'message',
                        name: 'message'
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
