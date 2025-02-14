@extends('layouts.app')
@section('content')
<style>
     .gmnoprint {
    display: none !important;
}

.gm-style-cc {
    display: none !important;
}

div#trackingMap div div a div img {
    display: none !important;
}
</style>
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
                    All Loads
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
            {{-- @php
                $top_header1 = ads('shipment_overview','top_header1');
                $top_header2 = ads('shipment_overview','top_header2');
                $top_header3 = ads('shipment_overview','top_header3');
                $center_header4 = ads('shipment_overview','center_header4');
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
        <div class="contBody halfscroll">
            
            <div class="tablescroll">
                
                <div class="row align-items-center mt-3">
                    <div class="col-md-6">
                        <div class="tabsShipment">

                            <a class="active" data-targetit="open" href="javascript:void(0)"title="">Overview</a>
        
                           
                            {{-- @if($shipment->is_tracking == 1)
                            <a data-targetit="tracking" href="{{route(auth()->user()->type.'.my_loads_tracking',[$id])}}"
                                title="">Tracking</a>
                            @endif --}}
                        </div>
                    </div>
                    <!--<div class="col-md-6">-->
                    <!--    <div class="advertisments">-->
                    <!--        <a href="javascript:;" target="_blank" title=""><img src="{{asset('assets/images/ad-08.jpg')}}" alt=""></a>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                <div class="card">
                    <div class="Bxtracking_details">
                        <div class="row">
                            <div class="col-md-8">
                                {{-- <div class="trackhead">
                                    <h3>Post details</h3>
                                    <div class="trackbtn">
                                        @php
                                        if($shipment->status != "WAITING"){
                                            $status = strtoupper($shipment->status);
                                        }else{
                                        if($shipment->is_post == 1){
                                            $status = strtoupper("POSTED");
                                        }else{
                                            $status = strtoupper("Un-POST");
                                            }
                                        }
                                        @endphp
                                        <a class="tackbtns" href="javascript:;" title="">{{$status}}</a>
                                    </div>
                                </div> --}}
                                <div class="tripPostDet">
                                    <p>{{$shipment->created_at->diffForHumans()}}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="overviewHead">
                                                <h3>Trip</h3>
                                            </div>
                                            <div class="tripPostInfo">
                                                @if($shipment->is_tracking == 1)
                                                <div class="hdBox">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    Tracking Required
                                                </div>
                                                @endif
                                                <div
                                                    class="d-flex align-items-center justify-content-between">
                                                    <div class="miles">
                                                        <h3>{{$shipment->miles ? $shipment->miles : '-'}} mi</h3>
                                                        <h3>{{$shipment->duration ? $shipment->duration : '-'}}</h3>
                                                    </div>
                                                    @if($shipment->is_tracking == 1)
                                                    <!--<a class="tackbtns" href="{{route(auth()->user()->type.'.my_loads_tracking',[$id])}}" title=""><i-->
                                                    <!--        class="fas fa-map-marked-alt"></i>-->
                                                    <!--    View Route</a>-->
                                                    @endif
                                                </div>
                                                <div class="listFullInfo">
                                                    <div class="Items">
                                                        <h3>{{$shipment->origin}}</h3>
                                                        <p>{{Carbon\Carbon::create($shipment->from_date)->format('F, j')}}
                                                        </p>
                                                    </div>
                                                    <div class="Items">
                                                        <h3>{{$shipment->destination}}</h3>
                                                         <p>{{Carbon\Carbon::create($shipment->to_date)->format('F, j')}}
                                                        </p>
                                                        <h4>Equipment</h4>
                                                        <ul class="listTables">
                                                            <li>
                                                                <span>Load</span>
                                                                <span>{{$shipment->equipment_details == "0" ? "Full" : "Partial"}}</span>
                                                            </li>
                                                            <li>
                                                                <span>Truck</span>
                                                                <span>{{$shipment->equipment_type ? $shipment->equipment_type->name : 'None'  }}</span>
                                                            </li>
                                                            <li>
                                                                <span>Length</span>
                                                                <span>{{$shipment->length }} ft</span>
                                                            </li>
                                                            <li>
                                                                <span>Weight</span>
                                                                <span>{{$shipment->weight}} lbs</span>
                                                            </li>
                                                            <li>
                                                                <span>Commodity</span>
                                                                <span>{{$shipment->commodity}}</span>
                                                            </li>
                                                            <li>
                                                                <span>Tracking</span>
                                                                    @if($shipment->is_tracking == 1)
                                                                        <span>Required</span>
                                                                    @else
                                                                        <span>Not Required</span>
                                                                    @endif
                                                                </li>
                                                        </ul>
                                                    </div>
                                                    <div class="Items">
                                                        <h4>Contact Information</h4>
                                                        @if($shipment->status_phone == "1")
                                                        <p>
                                                            <a href="tel:{{$shipment->user->phone}}"
                                                                title="">{{$shipment->user->phone}}</a>
                                                        </p>
                                                        @endif
                                                        @if($shipment->status_email == "1")
                                                        <p>
                                                            <a href="mailto:{{$shipment->user->email}}"
                                                                title="{{$shipment->user->email}}">{{$shipment->user->email}}</a>
                                                        </p>
                                                        @endif

                                                    </div>
                                                    <div class="Items">
                                                        <h4>Notes</h4>
                                                        <p>{{$shipment->eq_name}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="overviewHead">
                                                <h3>Rate</h3>
                                            </div>
                                            <div class="Items">
                                                <div class="doublecoulumns">
                                                    @if($shipment->is_private_network == 1)
                                                       @if($shipment->is_exist_private)
                                                       <ul class="listTables">
                                                            <li>
                                                                 <span>Private</span>
                                                                 <span><strong>${{$shipment->private_rate ? $shipment->private_rate : '-' }}</strong></span>
                                                            </li>
                                                            @if($shipment->private_rate)
                                                            <li>
                                                                 <span>Rate / mile</span>
                                                                 <span><strong>${{number_format($shipment->private_rate / $shipment->miles, 2, '.', ',')}}</strong></span>
                                                            </li>
                                                            @endif
                                                       </ul>
                                                       @endif
                                                    @endif
                                                    @if ($shipment->is_private_network == 1 && $shipment->is_allow_bids == 1 && $shipment->max_bid_rate != null)
                                                    @if($shipment->is_exist_private)
                                                    <ul class="listTables">

                                                        <li>
                                                            <span>Max Rate</span>
                                                            <span><strong>${{$shipment->max_bid_rate ? $shipment->max_bid_rate : null }}</strong></span>
                                                        </li>
                                                        @if($shipment->max_bid_rate)
                                                        <li>
                                                            <span>Rate / mile</span>
                                                            <span><strong>${{number_format($shipment->max_bid_rate / $shipment->miles, 2, '.', ',') }}</strong></span>
                                                        </li>
                                                       </ul>     
                                                       @endif
                                                  @endif
                                                    @endif
                                                    @if ($shipment->is_public_load == 1)
                                                    <ul class="listTables">
                                                        <li>
                                                            <span>Load Board</span>
                                                            <span><strong>${{$shipment->dat_rate}}</strong></span>
                                                        </li>
                                                        @if($shipment->dat_rate)
                                                        <li>
                                                            
                                                            <span>Rate / mile</span>
                                                            <span><strong>${{number_format($shipment->dat_rate / $shipment->miles, 2, '.', ',') }}</strong></span>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- <div class="overviewHead">
                                                <h3>Post Details</h3>
                                            </div>
                                            
                                            <div class="Items">
                                                <ul class="listTables">
                                                    <li>
                                                        <span>Post To</span>
                                                        <span><strong>{{$shipment->is_public_load == 1 ? 'PTTR Load Board ' : ''  }} {{$shipment->is_private_network == 1 ? 'Private Network' : ''  }}
                                                            </strong></span>
                                                    </li>
                                                </ul>
                                                <ul class="listTables">
                                                    <li>
                                                        @if($shipment->is_allow_bids == 1)
                                                        <span>BOOKING Bids</span>
                                                        @else
                                                        <span>BOOKING No Bids</span>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        @if($shipment->is_tracking == 1)
                                                        <span>Tracking required</span>
                                                        @else
                                                        <span>Tracking not required</span>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div> --}}
                                            {{-- <div class="overviewHead">
                                                <h3>Contact</h3>
                                            </div>
                                            <div class="Items">
                                                <p>
                                                    @php 
                                                    if($shipment->user){
                                                    
                                                    $company = null;
                                                        if($shipment->user->parent_id != null){
                                                                $company = App\Models\Company::where('user_id', $shipment->user->parent_id)->first();
                                                        }else{
                                                            $company = App\Models\Company::where('user_id', $shipment->user->id)->first();
                                                        }
                                                    }
                                                    @endphp
                                                    <strong>{{$company ? $company->name : '' }}</strong><br>
                                                    {{$company ? $company->phone : '' }}<br>
                                                    {{$company ? $company->address : '' }}
                                                </p>
                                            </div> --}}
                                            {{-- @if($carrier)
                                            <div class="overviewHead">
                                                <h3>Carrier Detail</h3>
                                            </div>
                                            <div class="Items">
                                                
                                                <p>
                                                    <strong><a href="{{route(auth()->user()->type.'.carrier_detail',[$carrier->id])}}">{{$carrier ? $carrier->name : '' }}</a></strong><br>
                                                    {{$carrier ? $carrier->phone : '' }}<br>
                                                    <strong>{{$carrier->company ? $carrier->company->name : '' }}</strong><br>
                                                    {{$carrier->company ? $carrier->company->address : '' }}
                                                </p>
                                            </div>
                                            @endif --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="trackMaps">
                                    <!-- <figure>
                                        <img class="img-fluid" src="assets/images/trackMaps.webp"
                                            alt="">
                                    </figure> -->

                                    <div id="trackingMap"></div>

                                </div>
                                @if(isset($center_header4))
                                <div class="advertisments mt-3">
                                    <a href="{{$center_header4->url}}" target="_blank" title=""><img src="{{asset($center_header4->image)}}" alt=""></a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')

<script>


    var map;
    var directionsService;
    var directionsDisplay;
    var carMarker;




    function initMap() {
      var mapCenter = { lat: 40.7128, lng: -74.0060 };
     var customMapStyle = [
          {
            "elementType": "geometry",
            "stylers": [{ "color": "#f5f5f5" }]
          },
          {
            "elementType": "labels.icon",
            "stylers": [{ "visibility": "off" }]
          },
          {
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#616161" }]
          },
          {
            "elementType": "labels.text.stroke",
            "stylers": [{ "color": "#f5f5f5" }]
          },
          {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#bdbdbd" }]
          },
          {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{ "color": "#eeeeee" }]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#757575" }]
          },
          {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{ "color": "#e5e5e5" }]
          },
          {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#9e9e9e" }]
          },
          {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{ "color": "#ffffff" }]
          },
          {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#757575" }]
          },
          {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{ "color": "#dadada" }]
          },
          {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#616161" }]
          },
          {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#9e9e9e" }]
          },
          {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{ "color": "#e5e5e5" }]
          },
          {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [{ "color": "#eeeeee" }]
          },
          {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{ "color": "#c9c9c9" }]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{ "color": "#9e9e9e" }]
          }
        ];
      map = new google.maps.Map(document.getElementById('trackingMap'), {
        zoom: 6,
        center: mapCenter,
         styles: customMapStyle,
         disableDefaultUI: true
      });


      directionsService = new google.maps.DirectionsService();
      directionsDisplay = new google.maps.DirectionsRenderer({
        map: map
      });



     var origin1 = "{{$shipment->origin}}";
    var destination1 = "{{$shipment->destination}}";




      var request = {
            origin: origin1,
            destination: destination1, // Destination
        travelMode: 'DRIVING'
      };


      // Request directions
      directionsService.route(request, function(result, status) {
        if (status == 'OK') {
          directionsDisplay.setDirections(result);
          var route = result.routes[0];
                    var totalDistance = 0;
                    var totalTime = 0;

                    $.each(route.legs, function(index, leg) {
                        totalDistance += leg.distance.value;
                        totalTime += leg.duration.value;
                    });

                    var distanceText = (totalDistance < 1000) ? totalDistance + ' meters' :  kmToMiles((totalDistance / 1000).toFixed(2)) + ' mi';
                    var timeText = (totalTime < 60) ? totalTime + ' seconds' : (totalTime < 3600) ? Math.ceil(totalTime / 60) + ' minutes' : Math.ceil(totalTime / 3600) + ' hours';



                    // $('.miles').append('<h3>'+ distanceText +'</h3><h3>'+ timeText +'</h3>')
                    console.log(distanceText);
                    console.log(timeText);
        } else {
          // Handle errors
          window.alert('Directions request failed due to ' + status);
        }
      });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC5ri3ptVu7v8KO3dg3lRv7-pTRjJy94w&callback=initMap" async defer></script>
@endpush
@endsection
