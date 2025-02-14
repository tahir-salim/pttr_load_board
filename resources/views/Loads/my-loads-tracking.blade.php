@extends('layouts.app')
@section('content')

@push('css')
<style>
.editForm {
    display: none;
}

.btnShipments .postBtn {
    width: 100%;
}

/* .editForm .fields input{
    width: 100%;
    border-radius: 8px;
    border: solid 1px #dbdbdb;
    background-color: var(--white);
    padding: 12px 15px;
 } */
 .gmnoprint {
    display: none !important;
}

.gm-style-cc {
    display: none !important;
}

div#trackingMap div div a div img {
    display: none !important;
}


.heighlight {
    background: #ffa700;
    padding: 1rem 1rem;
    border-radius: 15px;
}

ul.listscont li a {
    color: #000;
    font-weight: bold;
    text-decoration: underline !important;
}

.heighlight h6 {
    font-weight: bold;
}

ul.listscont li:before {
    content: '\f007';
    font-family: 'Font Awesome 5 Pro';
    font-weight: 900;
    display: inline-block;
    margin-right: 10px;
}

ul.listscont {
    padding-left: 0;
    display: flex;
    gap: 20px;
    color: #000;
}

</style>
@endpush

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
                $top_header1 = ads('my_shipments_tracking','top_header1');
                $top_header2 = ads('my_shipments_tracking','top_header2');
                $top_header3 = ads('my_shipments_tracking','top_header3');
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

                <div class="row align-items-center mt-3">
                    <div class="col-md-6">
                        <div class="tabsShipment">
                            <a data-targetit="open" title="" href="{{route(auth()->user()->type.'.my_loads_overview',[$id])}}" >Overview</a>
                            @if($shipment->is_allow_bids == 1)
                            <a   data-targetit="bidactivity"   href="{{route(auth()->user()->type.'.my_loads_bid_activity',[$id])}}" title="">
                            Bid Activity</a>
                            @endif
                            @if($shipment->is_tracking == 1)
                            <a  class="active" data-targetit="tracking"  href="javascript:void(0)"  title="">Tracking</a>
                            @endif
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
                            <div class="col-md-8 ">
                                @if(count($shipment->trackings) > 1)
                                <div class="heighlight"><h6>External Tracking</h6>
                                <p>For viewing truckers activity and ride statuses, please click on the external tracking tab under shipments</p>
                                    <ul class="listscont">
                                        @foreach($shipment->trackings as $key => $track)
                                        @if($key == 0)
                                            @continue
                                        @endif
                                        <li>
                                            <a href="{{ route(auth()->user()->type.'.tracking_details', [$track->id]) }}">{{ $track->name }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                </br>
                                <div class="trackhead">
                                    <h3>Tracking</h3>
                                    <div class="trackbtn">
                                         @if($shipment->status == "WAITING")
                                            @if($shipment->tracking->phone == null )
                                                <!--<a id="edit" class="normalbtn" href="javascript:;" title="">EDIT</a>-->
                                                 <a id="edit" class="tackbtns" href="javascript:;" title="">SEND TRACKING
                                                    REQUEST</a>
                                            @else
                                               <a class="tackbtns" href="javascript:;" title="">{{strtoupper($shipment->status)}}</a>
                                            @endif
                                           @else
                                           <a class="tackbtns" href="javascript:;" title="">{{strtoupper($shipment->status)}}</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="editForm">
                                    <form action="{{route(auth()->user()->type.'.my_loads_update_tracking',[$shipment->tracking->id])}}" method="POST">
                                        @csrf
                                        <div class="shipmentDetails">
                                            <h3>Driver Details</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="fields phoneusa">
                                                        <input type="text" placeholder="Driver Phone Number" name="phone" required="" value="{{$shipment->tracking ?  $shipment->tracking->phone : ''}}">
                                                        <input type="hidden"name="shipment_id" value="{{$shipment->id}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fields">
                                                        <input type="text" placeholder="Driver Name" name="name" required="" value="{{$shipment->tracking ?  $shipment->tracking->name : ''}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fields">
                                                        <input type="email" placeholder="Carrier Email" name="carrier_email" required="" value="{{$shipment->tracking ?  $shipment->tracking->carrier_email : ''}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="fields">
                                                        <input type="text" placeholder="Shipment Name or ID" name="Shipment_name_id" required="" value="{{$shipment->tracking ?  $shipment->tracking->Shipment_name_id : ''}}">
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="row justify-content-end">
                                            <div class="col-md-6">
                                                <div class="btnShipments text-right">
                                                    <input type="submit" value="Submit" class="postBtn">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                                @push('js')
                                <script>
                                    // Check if there's an error message in the session
                                    @if(session('swalerror'))
                                        // Display SweetAlert with error message
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: '{{ session('swalerror') }}',
                                            confirmButtonText: 'Ok'
                                        });
                                    @endif
                                </script>
                                @endpush
                                <div class="trackbody">
                                    <p><i class="far fa-dot-circle"></i> Tracking will begin <strong>
                                        {{isset($shipment->tracking->tracking_details[0]) ? $shipment->tracking->tracking_details[0]->tracking_start_time : 'at first appointment' }}</strong></p>
                                        <div class="miles">
                                            {{-- <h3>0 mi</h3> --}}
                                        </div>
                                </div>
                                @foreach ($shipment->tracking->tracking_details;  as $pickup)
                                <div class="trackItems">
                                    <div class="tcHds">
                                        @if($pickup->type == 0)
                                        <h3><i class="fas fa-upload"></i> PICK UP - {{$pickup->lcoation_name}}</h3>
                                        @else
                                        <h3><i class="fas fa-download"></i> DROP OFF - {{$pickup->lcoation_name}}</h3>

                                    @endif
                                </div>
                                <div class="trackbody">
                                    <div class="items">
                                        <div class="cont">
                                            <h3>{{$pickup->street_address}}</h3>
                                            <p>{{Carbon\Carbon::create($pickup->appointment_date)->format('F, j Y')}}
                                            </p>
                                            <p>{{$pickup->dock_info ?  $pickup->dock_info : ''}}</p>
                                        </div>
                                    </div>
                                    <div class="trackDates">
                                        <div class="items">
                                            <div class="icons">
                                                <i class="fal fa-clock"></i>
                                            </div>
                                            <div class="cont">
                                                <p>Start
                                                    <br>{{Carbon\Carbon::create($pickup->start_time)->format('g:i A');}}
                                                    CDT
                                                </p>
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="icons">
                                                <i class="fal fa-clock"></i>
                                            </div>
                                            <div class="cont">
                                                <p>End Time <br>
                                                    {{Carbon\Carbon::create($pickup->end_time)->format('g:i A')}} CDT
                                                </p>
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="icons">
                                                <i class="fal fa-comment-alt"></i>
                                            </div>
                                            <div class="cont">
                                                <p>{{$pickup->notes}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            {{-- <div class="trackItems">
                                    <div class="tcHds">
                                        <h3>Pick Up - test</h3>
                                    </div>
                                    <div class="trackbody">
                                        <div class="items">
                                            <div class="icons">
                                                <i class="fal fa-upload"></i>
                                            </div>
                                            <div class="cont">
                                                <h3>9540 Garland Road, Dallas, TX, 75218 test</h3>
                                                <p>Mar 15, 2024</p>
                                            </div>
                                        </div>
                                        <div class="trackDates">
                                            <div class="items">
                                                <div class="icons">
                                                    <i class="fal fa-clock"></i>
                                                </div>
                                                <div class="cont">
                                                    <p>Start <br>12:00 AM CDT</p>
                                                </div>
                                            </div>
                                            <div class="items">
                                                <div class="icons">
                                                    <i class="fal fa-clock"></i>
                                                </div>
                                                <div class="cont">
                                                    <p>End Time <br> 12:45 AM CDT</p>
                                                </div>
                                            </div>
                                            <div class="items">
                                                <div class="icons">
                                                    <i class="fal fa-comment-alt"></i>
                                                </div>
                                                <div class="cont">
                                                    <p>test</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="trackItems">
                                    <div class="tcHds">
                                        <h3>Drop Off - test</h3>
                                    </div>
                                    <div class="trackbody">
                                        <div class="items">
                                            <div class="icons">
                                                <i class="fal fa-upload"></i>
                                            </div>
                                            <div class="cont">
                                                <h3>850 Northwest Chipman Road, Lee's Summit, MO, 64063
                                                    test</h3>
                                                <p>Mar 15, 2024</p>
                                                <p>1250 NW Main St (powered by Dock411)</p>
                                            </div>
                                        </div>
                                        <div class="trackDates">
                                            <div class="items">
                                                <div class="icons">
                                                    <i class="fal fa-clock"></i>
                                                </div>
                                                <div class="cont">
                                                    <p>Start <br>12:00 AM CDT</p>
                                                </div>
                                            </div>
                                            <div class="items">
                                                <div class="icons">
                                                    <i class="fal fa-clock"></i>
                                                </div>
                                                <div class="cont">
                                                    <p>End Time <br> 12:45 AM CDT</p>
                                                </div>
                                            </div>
                                            <div class="items">
                                                <div class="icons">
                                                    <i class="fal fa-comment-alt"></i>
                                                </div>
                                                <div class="cont">
                                                    <p>test</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-md-4">
                                <div class="trackMaps">
                                    <figure>
                                      {{--  <img class="img-fluid" src="{{asset('assets/images/trackMaps.webp')}}"
                                            alt=""> --}}
                                    </figure>
                                    <div id="trackingMap"></div>
                                    <div class="trackContInfos">
                                        {{--<p>Share this link with your driver if they cannot receive SMS or email links. It will direct them to their DAT One Loads view, where they can track this shipment.</p>
                                         <div class="highlightcont" data-toggle="tooltip" data-placement="top" title="Click to Copy Link">
                                            <div class="icon"   onclick="copytext();"><i class="fas fa-copy"></i></div>
                                            <div class="cont">
                                                <p>Tracking Request Link <br>
                                                <a id="copyUrl" href="javscript:;" title="">https://mobile.dat.com/9S4czUMHyIb</a>
                                                </p>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
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
$("#edit").click(function() {
    $(".editForm").toggle('slow');
});
</script>

<script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-app.js"></script>
      <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-analytics.js"></script>

      <!-- Add Firebase products that you want to use -->
      <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-auth.js"></script>
      <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-database.js"></script>
      <script src="https://www.gstatic.com/firebasejs/7.13.1/firebase-firestore.js"></script>
      <script>

        const firebaseConfig = {
          apiKey: "AIzaSyDUxKPRi3ec_FQxDv33hOssPfx7b75yi4c",
          authDomain: "pttr-12c10.firebaseapp.com",
          databaseURL: "https://pttr-12c10-default-rtdb.firebaseio.com",
          projectId: "pttr-12c10",
          storageBucket: "pttr-12c10.appspot.com",
          messagingSenderId: "760302918794",
          appId: "1:760302918794:web:ddd0728da67dad0267a173",
          measurementId: "G-P01WSBPYRY"
        };

        firebase.initializeApp(firebaseConfig);
        firebase.analytics();


      </script>
<script>
    var tracking_details = {!! json_encode($shipment->tracking->tracking_details->toArray()) !!}
    var length = tracking_details.length - 1;
    var image_url = "{{asset('assets/images/truckicon.png')}}";
    var tracking_id = "{{$shipment->tracking->id}}";
     var tracking_status = "{{$shipment->status}}";

    var map;
    var directionsService;
    var directionsDisplay;
    var carMarker;
    var stepIndex = 0;
    var carPath = [];
    function initMap() {

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


      var mapCenter = { lat: 40.7128, lng: -74.0060 };

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

      carMarker = new google.maps.Marker({
                icon: {
                //   url: 'https://maps.google.com/mapfiles/kml/shapes/cabs.png', // Different car icon URL
                  url: image_url, // Different car icon URL
                  scaledSize: new google.maps.Size(64, 64)
                },
                map: map
            });


            if (tracking_status == 'WAITING' || tracking_status == 'BOOKED' || tracking_status == 'EXPIRED') {

                var MyList = [];
                if(length > 1){
                    jQuery.each( tracking_details, function( key, value ) {
                        if(key > 0 && key < length){
                            MyList.push({location: value.street_address});
                        }
                    });
                  }
                var request = {
                    origin: tracking_details[0].street_address, // Starting point
                    destination: tracking_details[length].street_address, // Destination
                    waypoints: MyList,
                    travelMode: 'DRIVING'
                };
                // Request directions
                directionsService.route(request, function(result, status) {
                    if (status == 'OK') {
                        directionsDisplay.setDirections(result);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            } else {


                  var newPosition =  new google.maps.LatLng(tracking_details[0].street_addressLat, tracking_details[0].street_addressLng);
            		carMarker.setPosition(newPosition);
                    map.setCenter(newPosition);



                  var reff = firebase.database().ref('tracking_id_' + tracking_id + '/track');
                    // Listen for changes in the last child entry and update the car marker position in real-time
                    reff.limitToLast(1).on('child_added', function(snapshot) {
                        var data = snapshot.val();
                        console.log(data);
                        console.log('start ' + data.latitude + ' end ' +  data.longitude);
                        var newPosition = new google.maps.LatLng(data.latitude, data.longitude);
                        carMarker.setPosition(newPosition);
                        map.setCenter(newPosition);
                    });

                 var MyList = [];
                    if(length > 1){
                        jQuery.each( tracking_details, function( key, value ) {
                            if(key > 0 && key < length){
                                MyList.push({location: value.street_address});
                            }
                        });
                      }
                    var request = {
                        // newPosition,
                        origin: new google.maps.LatLng(tracking_details[0].street_addressLat, tracking_details[0].street_addressLng),  // Starting point using coordinates
                        destination: new google.maps.LatLng(tracking_details[length].street_addressLat, tracking_details[length].street_addressLng), // Destination coordinates
                        waypoints: MyList,
                        travelMode: 'DRIVING' // Travel mode (DRIVING, WALKING, BICYCLING, or TRANSIT)
                    };
                    // Request directions and display the route
                    directionsService.route(request, function(result, status) {
                        if (status === 'OK') {
                            directionsDisplay.setDirections(result);
                        } else {
                            console.error('Directions request failed due to ' + status);
                            console.error('Request object:', request);
                        }
                    });


            }



    //   var MyList = [];
    //       if(length > 1){
    //         jQuery.each( tracking_details, function( key, value ) {
    //             if(key > 0 && key < length){
    //                 MyList.push({location: value.street_address});
    //             }
    //         });
    //       }

    //   console.log(MyList);


      var request = {
        // if(length > 0){
            origin: tracking_details[0].street_address,
            // Starting point
            destination: tracking_details[length].street_address, // Destination
            // if(length > 1){
            waypoints: MyList,
            // }

        // }
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



                    $('.miles').append('<h3>'+ distanceText +'</h3><h3>'+ timeText +'</h3>')
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
