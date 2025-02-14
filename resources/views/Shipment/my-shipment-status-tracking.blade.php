@extends('layouts.app')
@section('content')


<div class="col-md-10">
    <div class="mainBody">

        <!-- Begin: Notification -->
        @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>
            @if($shipment_status->first())
                {{$shipment_status->first()->shipment->origin}} → {{$shipment_status->first()->shipment->destination}}
            @endif
                </h2>
            <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.my_shipments')}}" tile="">
                    <img src="{{asset('assets/images/icons/shipmenticon.webp')}}" alt="">
                    All Shipments
                </a>
            </div>
        </div>
        <div class="contBody">
            @php
                $top_header1 = ads('my_shipment_status_tracking','top_header1');
                $top_header2 = ads('my_shipment_status_tracking','top_header2');
                $top_header3 = ads('my_shipment_status_tracking','top_header3');
            @endphp
            
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
                        Status Detail</a>

                </div>
                <div class="card">
                    <div class="showfirst">
                        <div class="tableLayout">
                            <table id="ShipmentTable1" class="display">
                                <thead>
                                    <tr>
                                        <th>Date - time</th>
                                        <th>Origin</th>
                                        <th>Destionation</th>
                                        <th>Status</th>
                                        <th>location</th>
                                    </tr>
                                </thead>
                                <tbody>
									@if($shipment_status)
                                    @foreach ($shipment_status as $ship_status)
                                    <tr>
                                        <td>{{Carbon\Carbon::create($ship_status->created_at)->format('F j, Y - h:i:s A')}}</td>
                                        <td>
                                            {{$ship_status->shipment ? $ship_status->shipment->origin : '-'}}
                                        </td>
										<td>
                                            {{$ship_status->shipment ? $ship_status->shipment->destination : '-'}}
                                        </td>
                                        <td>
                                            <h5>{{strtoupper($ship_status->status)}}</h5>
                                        </td>
                                        <td>
                                            @if($ship_status->lat != null && $ship_status->lng != null)
                                            <a href="https://www.google.com/maps/place/{{$ship_status->lat}},{{$ship_status->lng}}" target="_blank">View Location on Map</a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
									@else
									 <tr>
											No Record Found
									</tr>
									@endif
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

let table1 = new DataTable('#ShipmentTable1', {
    responsive: true,
    ordering:  false
});

</script>
@endpush
@endsection
