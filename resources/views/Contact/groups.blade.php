@extends('layouts.app')
@section('content')
    {{--  Search Loads --}}
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            @push('css')
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            @endpush()

            <div class="main-header">
                <h2>Groups</h2>
                <div class="rightBtn">

                    <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.private_network')}}" tile="">
                        All CONTACTS
                    </a>
                </div>
            </div>
            @php 
                $top_header1 = ads('groups','top_header1');
                $top_header2 = ads('groups','top_header2');
                $top_header3 = ads('groups','top_header3');
                $center_header4 = ads('groups','center_header4');
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
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <form id="loadFilterform" action="{{ route(auth()->user()->type.'.groups_store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card groupForms">
                                <div>
                                    <h3>Create Group</h3>
                                </div>
                                <br>
                                <div class="formFilters">
                                    <div class="left">
                                        <div class="fields">
                                            <label>Group Name</label>
                                            <input type="text" required name="name" id="OriginTextField"
                                                value="{{ app('request')->input('name') }}" placeholder="Group Name*">
                                                @error('name')
                                                    <p class="text-danger" id="al">{{$message}}</p>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div class="submitbtns">
                                            <input type="submit" class="btnSubmit skyblue" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(isset($center_header4))
                    <div class="col-md-7">
                        <div class="advertisments">
                            <a href="{{$center_header4->url}}" target="_blank" title=""><img src="{{asset($center_header4->image)}}" alt=""></a>
                        </div>
                    </div>
                    @endif
                </div>
                <br/>
                <div class="card">
                    <table class="display csbody dataTable data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contacts</th>
                                <th width="200px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <input class="modalTextInput form-control" name="name1" placeholder="Enter your Group Name" />
                        <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="saveEdit btn btn-primary themeBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('js')

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
    
            $('#exampleModal').on('show.bs.modal', function(e){
                let btn = $(e.relatedTarget); // e.related here is the element that opened the modal, specifically the row button
                let id = btn.data('id');
                let name = btn.data('name');
                $('.modalTextInput').val(name);
                $('.saveEdit').data('id', id);
            })

            $('.saveEdit').on('click', function() {
                let id = $(this).data('id'); // assuming you have data-id attribute set on the button
                let name = $('.modalTextInput').val();
                let token = '{{ csrf_token() }}';
                var data = {"_token": token, "name": name};
                var url = "{{ route(auth()->user()->type.'.groups_update', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                var res = AjaxRequest(url,data);
                console.log(res);
                if (res.status == 1) {
                    toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.success(res.success);
                setTimeout(() => {
                    location.reload();
                }, 2000);
                } else {
                    $('.modalTextInput').removeClass('is-invalid');
                    $('#nameError').text('');
                    if (res.error) {
                        $('.modalTextInput').addClass('is-invalid');
                        $('#nameError').text(res.error);
                    }
                }
            });



        $(function () {
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route(auth()->user()->type.'.groups') }}",
              columns: [
                  {data: 'name', name: 'name'},
                  {data: 'contact', name: 'contact'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });

        });
      </script>
    @endpush
@endsection
