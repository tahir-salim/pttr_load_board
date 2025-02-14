@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>All Notifications</h2>
            </div>
             @php 
                $top_header1 = ads('all_notifications','top_header1');
                $top_header2 = ads('all_notifications','top_header2');
                $top_header3 = ads('all_notifications','top_header3');
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
                <div class="card">
                    <div class="tableFormNew">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Notification By</th>
                                    <th>Title</th>
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
                  {data: 'from_user_id', name: 'from_user_id'},
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
