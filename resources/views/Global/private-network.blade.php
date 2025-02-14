@extends('layouts.app')
@section('content')
<div class="col-md-10">
    <div class="mainBody">
          <!-- Begin: Notification -->
          @include('layouts.notifications')
          <!-- END: Notification -->

        <div class="main-header">
            <h2>Private Network</h2>
            <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.groups')}}" tile="">
                    +Groups
                </a>
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.create_contact')}}" tile="">
                    +ADD CONTACTS
                </a>
            </div>
        </div>
        <div class="privatescroll">
        @php 
            $top_header1 = ads('private_network','top_header1');
            $top_header2 = ads('private_network','top_header2');
            $top_header3 = ads('private_network','top_header3');
            $center_header4 = ads('private_network','center_header4');
            $center_header5 = ads('private_network','center_header5');
        @endphp
        
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
            <div class="contBody halfscroll">
             
            @if($contacts < 1)

            <div class="row align-items-center">
                @if(isset($center_header4))
                <div class="col-md-3">
                    <div class="advertisments height_auto">
                        <a href="{{$center_header4->url}}" target="_blank" title=""><img src="{{asset($center_header4->image)}}" alt=""></a>
                    </div>
                </div>
                @endif
                <div class="col-md-6">
                    <div class="card privateNetcenter">
                        <div class="text-center">
                            <h2>Post directly to your carriers <br>who are ready to work for you</h2>
                        </div>
                        <div class="listpostdire">
                            <h3>How it works</h3>
                            <p>Private Network hosts your contact lists and allow you to organize them into
                                group and post to specific people.</p>
                            <ul>
                                <li>
                                    Add your contacts to Private Network. You can either add individual entries
                                    or upload an entire list.
                                </li>
                                <li>
                                    Assign your various contacts to groups.
                                </li>
                                <li>
                                    Post to your groups and only those contacts will see that load and rate.
                                </li>
                            </ul>
                            <div class="btnShipments">
                                <a class="postBtn" href="{{route(auth()->user()->type.'.create_contact')}}" title="">
                                    +ADD CONTACTS
                                </a>
                            </div>
                            <div class="text-center">
                                <p>If you have any questions about booking private loads, <br>
                                    contact PTTR’s support team at  (888) 706-7013</p>
                            </div>
                        </div>
                    </div>
                </div>
                 @if(isset($center_header5))
                <div class="col-md-3">
                    <div class="advertisments height_auto">
                        <a href="{{$center_header5->url}}" target="_blank" title=""><img src="{{asset($center_header5->image)}}" alt=""></a>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="groupAddform">
                <form id="groupForm" action="{{route(auth()->user()->type.'.contact_assign_group')}}" method="POST">
                    @csrf
                    <div class="field">
                        <input type="hidden" id="contactField" name="contact" value="">
                        <label>Add to Group</label>
                        <select name="group_id" required>
                            @forelse ($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                            @empty
                            @endforelse
                        </select>
                        <input class="themeBtn" id="groupFormSubmit" type="button" value="Add to group">
                    </div>
                </form>
            </div>
            <div class="tableFormNew pvttable">
                <table class="display csbody dataTable data-table">
                    <thead>
                        <tr>
                            <th><input class="selectAll" type="checkbox" id="list1" name="contacts"></th>
                            <th>No</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            @endif
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
          ajax: "{{ route(auth()->user()->type.'.private_network') }}",
          columns: [
              {data: 'inp_chk', name: 'inp_chk' ,orderable: false, searchable: false},
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });


    $(".selectAll").click(function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        $(".groupAddform").show();
        if (!$(this).prop("checked")) {
            $(".groupAddform").hide();
        }
    });

    $(document).on('change','.checkboxCustom', function(){
        var anyChecked = false;
        $('.checkboxCustom').each(function(){
            if($(this).prop('checked')) {
                anyChecked = true;
                return false;
            }
        });
        if(anyChecked) {
            $('.selectAll').prop('checked', true);
            $('.groupAddform').show();
        } else {
            $('.selectAll').prop('checked', false);
            $('.groupAddform').hide();
        }
    });

        var form = document.getElementById("groupForm");
            $('#groupFormSubmit').click(function(){
                var searchIDs = $('.checkboxCustom').map(function(){
                    if ($(this).prop('checked')) {
                        return $(this).val();
                    }
                }).get();
                $('#contactField').val(searchIDs);
                form.submit();
            })

        // document.getElementById("groupFormSubmit").addEventListener("click", function () {
        // });


        $(document).ready(function(){



            });


  </script>
@endpush
@endsection
