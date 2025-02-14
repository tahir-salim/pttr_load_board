@extends('layouts.app')
@section('content')

@push('css')
<style>
.loader {
    border: 16px solid #f3f3f3;
    /* Light grey */
    border-top: 16px solid #3498db;
    /* Blue */
    border-radius: 50%;
    width: 80px;
    height: 80px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
@endpush
<div class="col-md-10">
    <div class="mainBody">

        <!-- Begin: Notification -->
        @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>{{$shipment->origin}} → {{$shipment->destination}} </h2>

            <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.my_loads')}}" tile="">
                    <img src="{{asset('assets/images/icons/shipmenticon.webp')}}" alt="">
                    My Loads
                </a>
            </div>
            {{-- <div class="rightBtn bidactivitypgbtn">
                <a class="themeBtn gray" href="javascript:;" tile="">
                    Expired
                </a>
                <a class="themeBtn skyblue" href="javascript:;" tile="">
                    Duplicate
                </a>
                <div class="text-right menuicons">
                    <a href="javascript:;" title="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512">
                            <path
                                d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div> --}}
        </div>
        <div class="contBody">
            {{-- @php
                $top_header1 = ads('my_shipments_bid_activity','top_header1');
                $top_header2 = ads('my_shipments_bid_activity','top_header2');
                $top_header3 = ads('my_shipments_bid_activity','top_header3');
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
                
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="tabsShipment">

                            <a data-targetit="open" title=""
                                href="{{route(auth()->user()->type.'.my_loads_overview',[$id])}}">Overview</a>
                            <a class="active" data-targetit="bidactivity" href="javascript:void(0)" title="">
                                Bid Activity</a>
                            @if($shipment->is_tracking == 1)
                            <a data-targetit="tracking" href="{{route(auth()->user()->type.'.my_loads_tracking',[$id])}}"
                                title="">Tracking</a>
                            @endif
                        </div>
                        <div class="loadboardText">
                            <ul class="d-flex align-items-center">
        
                                @if ($shipment->is_public_load == 1)
                                <li>Load Board <strong>${{$shipment->dat_rate}}</strong> ($-/mi)</li>
                                @endif
                                @if($shipment->is_private_network == 1)
                                <li>Private Network <strong>${{$shipment->private_rate}}</strong> ($-/mi)</li>
                                @endif
                                @if($shipment->max_bid_rate != null)
                                <li>Max Rate <strong>${{$shipment->max_bid_rate}}</strong> ($/mi)</li>
                                @endif
                            </ul>
                            {{-- <h4>$ LANE RATE: $344-</h4> --}}
                        </div>
                    </div>
                    <!--<div class="col-md-6">-->
                    <!--    <div class="advertisments">-->
                    <!--        <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-08.jpg')}}" alt=""></a>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                
                
                
                <div class="card">
                    <div class="showfirst">
                        <div class="tableLayout">
                            <table id="ShipmentTable1" class="display">
                                <thead>
                                    <tr>
                                        <th>Age</th>
                                        <th>Contact</th>
                                        <th>Bids</th>
                                        <th>My Counter</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shipment->bids as $k => $bid )
                                    
                                    <tr>
                                        <td>{{$bid->created_at->diffForHumans()}}</td>
                                        {{-- <td>
                                            <h5><a href="{{route(auth()->user()->type.".carrier_detail",$bid->trucker_id)}}">{{$bid->carrier_user ? $bid->carrier_user->name : '-'}}</a></h5>
                                            {{$bid->carrier_user ? $bid->carrier_user->phone : '-'}}
                                        </td> --}}
                                        <td>
                                            <strong>${{$bid->amount}}</strong> posted rate
                                        </td>
                                        <td>{{Carbon\Carbon::create($bid->created_at)->format('F j Y h:m:s A') }} <br>
                                        </td>
                                        <td class="text-center">
                                            {{-- <a class="rej" href="javascript:;" title="">Reject</a> --}}

                                            @if($bid->status === null && $shipment->status == "WAITING")
                                            <a href="javascript:void(0)"
                                                onclick="status_accept_decline('bids',{{$bid->id}},'0')"
                                                class="rej">Reject</a>
                                            <a class="accept" href="javascript:;"
                                                onclick="status_accept_decline('bids',{{$bid->id}},'1')"
                                                title="">ACCEPT</a>
                                            @else
                                            @if($bid->status !== null)
                                            @if ($bid->status == 0)
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
    var url = "{{ config('app.url') }}/{{ auth()->user()->type }}/status-accept-decline/" + id + '/?value=' + value +
        '&type=' + type;

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
