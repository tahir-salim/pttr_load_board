@extends('Admin.layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Notifications</h2>
            </div>
            <div class="contBody">
                <div class="tableFormNew">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Notification By</th>
                                <th>Body</th>
                                <th>Status</th>
                                <th>Recieve Date</th>
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


@push('js')
    <script type="text/javascript">
        $(function () {
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route(auth()->user()->type.'.all_notifications') }}",
              columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                  {data: 'title', name: 'title'},
                  {data: 'body', name: 'body'},
                  {data: 'status', name: 'status'},
                  {data: 'created_at', name: 'created_at'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
        });
    </script>

@endpush

@endsection
