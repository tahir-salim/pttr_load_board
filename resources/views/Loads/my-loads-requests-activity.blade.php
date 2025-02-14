@extends('layouts.app')
@section('content')


<div class="col-md-10">
    <div class="mainBody">

        <!-- Begin: Notification -->
        @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>{{$shipment->origin}} → {{$shipment->destination}}</h2>
            <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.my_loads')}}" tile="">
                    <img src="{{asset('assets/images/icons/shipmenticon.webp')}}" alt="">
                    My Loads
                </a>
            </div>
        </div>
        <div class="contBody">
            {{-- @php
                $top_header1 = ads('my_shipments_requests_activity','top_header1');
                $top_header2 = ads('my_shipments_requests_activity','top_header2');
                $top_header3 = ads('my_shipments_requests_activity','top_header3');
            @endphp --}}
            
            @if(isset($top_header1) && isset($top_header2) && isset($top_header3))
                <div class="row mb-3">
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
            <div class="tablescroll">
                <div class="tabsShipment">
                    <a class="active" data-targetit="bidactivity" href="javascript:void(0)" title="">
                        Requests Activity</a>

                </div>
                <div class="card">
                    <div class="showfirst">
                        <div class="tableLayout">
                            <table id="ShipmentTable1" class="display">
                                <thead>
                                    <tr>
                                        <th>Age</th>
                                        <th>Contact</th>
                                        <th>Amount</th>
                                        <th>My Counter</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shipment->shimpents_requests as $requests)
                                    
                                    <tr>
                                        <td>{{$requests->created_at->diffForHumans()}}</td>
                                        {{-- <td>
                                            <h5><a href="{{route(auth()->user()->type.".carrier_detail",$requests->trucker_id)}}">{{$requests->carrier_user ? $requests->carrier_user->name : '-'}}</a></h5>
                                            {{$requests->carrier_user ? $requests->carrier_user->phone : '-'}}
                                        </td> --}}
                                        <td>
                                            @if($requests->type == 0)
                                            <strong>${{$shipment->private_rate}}</strong>
                                            @else
                                            <strong>${{$shipment->dat_rate}}</strong>
                                            @endif
                                        </td>
                                        <td>{{Carbon\Carbon::create($requests->created_at)->format('F j Y h:m:s A') }}
                                            <br>
                                        </td>
                                        <td class="text-center">
                                            @if ($requests->status === null && $shipment->status == "WAITING")
                                            <a href="javascript:void(0)"
                                                onclick="status_accept_decline('requests',{{$requests->id}},'0')"
                                                class="rej">Reject</a>
                                            <a class="accept" href="javascript:;"
                                                onclick="status_accept_decline('requests',{{$requests->id}},'1')"
                                                title="">ACCEPT</a>
                                            @else
                                            @if ($requests->status !== null)
                                            @if ($requests->status == 0)
                                            <a class="rej" href="javascript:void(0)">REJECTED</a>
                                            @else
                                            <a class="accept" href="javascript:;" title="">ACCEPTED</a>
                                            @endif
                                            @endif

                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
let table = new DataTable('#ShipmentTable', {
    responsive: true,
    "bInfo": false,
    "paging": false,
    "bPaginate": false,
    "bFilter": false,
});

let table1 = new DataTable('#ShipmentTable1', {
    responsive: true,
});



function status_accept_decline(type, id, value) {
    var url = "{{ config('app.url') }}/{{ auth()->user()->type }}/status-accept-decline/" + id + '?value=' + value + '&type=' + type;

    // Show loader before sending AJAX request
    Swal.fire({
        title: "Are you sure you want to perform this action?",
        // html: '<div class="loader" id="loader" style="display:none;"></div>', // Add loader to modal
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, continue",
        showLoaderOnConfirm: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        preConfirm: () => {
            // document.getElementById('loader').style.display = "block"; // Show loader
            return fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id,
                        value: value
                    })
                })
                .then(response => {
                    // document.getElementById('loader').style.display = "none"; // Hide loader after response
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        }
    }).then(result => {
        if (result.isConfirmed) {
            window.location.reload();
        }
    });
}
</script>
@endpush
@endsection
