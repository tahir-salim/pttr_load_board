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
                <h2>Send Trackings</h2>
                <div class="rightBtn">
                    <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.trackings')}}" tile="">
                        Send Tracking List
                    </a>
                </div>
            </div>
            @php
                $top_header1 = ads('tracking_detail','top_header1');
                $top_header2 = ads('tracking_detail','top_header2');
                $top_header3 = ads('tracking_detail','top_header3');
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
                <div class="tabsShipment">
                    {{-- <a data-targetit="open" href="shipment-overview.php" title="">Overview</a>
                    <a data-targetit="bidactivity" href="bid-activity.php" title="">
                        Bid Activity</a> --}}
                    {{-- <a class="active" data-targetit="tracking" href="shipment-tracking.php"
                        title="">Tracking</a> --}}
                </div>
                <div class="card">
                    <div class="Bxtracking_details">
                        <div class="row">
                            <div class="col-md-8">
                                  @php $status = strtoupper($tracking->shipments ? $tracking->shipments->status : ''); @endphp
                                <div class="trackhead">
                                    <h3>Tracking</h3>
                                    <div class="trackbtn">
                                        @if($status == "WAITING")
                                         <a class="normalbtn" href="{{route(auth()->user()->type.'.edit_tracking_request', [$tracking->id])}}" title="">EDIT</a>
                                        <!--<a class="tackbtns" href="javascript:;" title="">SEND TRACKING-->
                                        <!--    REQUEST</a>-->
                                        @else
                                          <a class="tackbtns" href="javascript:;" title="">{{strtoupper($tracking->shipments ? $tracking->shipments->status : '')}}</a>
                                        @endif
                                        
                                    </div>
                                </div>
                              
                                <div class="trackItems">
                                    <div class="tcHds">
                                        @if($status == "ACCEPTED")
                                        <h3><i class="fas fa-check-circle"></i> {{$status}}</h3>
                                        @elseif($status == "DELIVERED" || $status == "COMPLETE" || $status == "CANCELED" )
                                           <h3><i class="fas fa-calendar-check"></i> {{$status}}</h3>
                                       @else
                                            <h3><i class="fas fa-map-marker-alt"></i>  {{$status}}</h3>
                                        @endif
                                    </div>
                                    {{-- <div class="trackbody">
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
                                    </div> --}}
                                </div>
                                <div class="trackItems">
                                    {{-- <div class="tcHds">
                                        <h3><i class="fas fa-map-marker-alt"></i> DISPATCHED</h3>
                                    </div> --}}
                                    {{-- <div class="trackbody">
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
                                    </div> --}}
                                </div>
                                @if($tracking->tracking_details != null)
                                    @foreach($tracking->tracking_details as $pickup)
                                    
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
                                                    <p>{{$pickup->appointment_date ? Carbon\Carbon::create($pickup->appointment_date)->format('F, j Y') : ''}}</p>
                                                </div>
                                            </div>
                                            <div class="trackDates">
                                                <div class="items">
                                                    <div class="icons">
                                                        <i class="fal fa-clock"></i>
                                                    </div>
                                                    <div class="cont">
                                                        <p>Start <br>{{$pickup->start_time ? Carbon\Carbon::create($pickup->start_time)->format('g:i A') : ''}} CDT</p>
                                                    </div>
                                                </div>
                                                <div class="items">
                                                    <div class="icons">
                                                        <i class="fal fa-clock"></i>
                                                    </div>
                                                    <div class="cont">
                                                        <p>End Time <br> {{$pickup->end_time ? Carbon\Carbon::create($pickup->end_time)->format('g:i A') : ''}} CDT</p>
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
                                @endif
                                <div class="trackItems">
                                   {{-- <div class="tcHds">
                                        <h3><i class="fas fa-calendar-check"></i> DELIVERED</h3>
                                    </div> --}}
                                    <div class="trackbody">
                                        <div class="items">
                                            <div class="cont">
                                                <p>{{$tracking->tracking_details->last() ? Carbon\Carbon::create($tracking->tracking_details->last()->end_time)->format('g:i A') : ''}} at 01:00 AM CDT on {{$tracking->tracking_details->last() ? Carbon\Carbon::create($tracking->tracking_details->last()->appointment_date)->format('F, j Y') : ''}}</p>
                                            </div>
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
                                    <div class="trackContInfos">
                                        <p>Share this link with your driver if they cannot receive SMS or email links. It will direct them to their PTTR One Loads view, where they can track this shipment.</p>
                                        {{-- <div class="highlightcont" data-toggle="tooltip" data-placement="top" title="Click to Copy Link">
                                            <div class="icon"   onclick="copytext();"><i class="fas fa-copy"></i></div>
                                            <div class="cont">
                                                <p>Tracking Request Link <br>
                                                <a id="copyUrl" href="javscript:;" title="">https://mobile.dat.com/9S4czUMHyIb</a>
                                                </p>
                                            </div>
                                        </div> --}}
                                        <div class="contactInfos">
                                            <div class="hd"><h3>CONTACT INFORMATION</h3></div>
                                            <p>
                                                Carrier <br>
                                                <strong>{{$tracking->name}}</strong><br>
                                                <a href="mailto:{{$tracking->carrier_email}}">{{$tracking->carrier_email}}</a><br>

                                                @php
                                                 $carrier_user = App\Models\User::where('email',$tracking->carrier_email)->first();
                                                @endphp
                                                @if( $carrier_user)
                                                
                                                @php
                                                $company = null;
                                                    if(auth()->user()->parent_id != null){
                                                        $company = App\Models\Company::where('user_id',auth()->user()->parent_id)->first();
                                                    }else{
                                                        $company = App\Models\Company::where('user_id', auth()->user()->id)->first();
                                                    }
                                                @endphp
                                                <strong>{{$company ? $company->name : ''}}</strong>
                                                <br>
                                                {{$company ? $company->address : ''}}
                                                <br>
                                                DOT# {{$company ? $company->dot : ''}}
                                                @endif
                                            </p>
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
        var tracking_status = "{{$tracking->shipments->status}}";
        var tracking_id = "{{$tracking->id}}";
        var image_url = "{{asset('assets/images/truckicon.png')}}";
        var tracking_details = {!! json_encode($tracking->tracking_details->toArray()) !!};
        var length = tracking_details.length - 1;
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
                zoom: 8,
                center: mapCenter,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
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
                if (length > 1) {
                    jQuery.each(tracking_details, function(key, value) {
                        if (key > 0 && key < length) {
                            MyList.push({ location: value.street_address });
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
            }
            else if (tracking_status == 'DELIVERED' || tracking_status == 'COMPLETE' || tracking_status == 'CANCELED' ) {
               
                var MyList = [];
                var MyList1 = [];
                if(length > 0){
                    jQuery.each( tracking_details, function( key, value ) {
                        if(key >= 0 && key <= length){
                            MyList.push({latitude: value.street_addressLat, longitude: value.street_addressLng});
                        }
                    });
                  }
                if(length > 0){
                    jQuery.each( tracking_details, function( key, value ) {
                        if(key > 0 && key < length){
                            MyList1.push({location: value.street_address});
                        }
                    });
                  }
                  
                  var newPosition = new google.maps.LatLng(MyList[length].latitude, MyList[length].longitude);
                    carMarker.setPosition(newPosition);
                    map.setCenter(newPosition);
                    
                 var request = {
                    origin: tracking_details[0].street_address,
                    destination: tracking_details[length].street_address,
                    waypoints: MyList1,
                    travelMode: 'DRIVING'
                };
                 directionsService.route(request, function(result, status) {
                    if (status == 'OK') {
                        directionsDisplay.setDirections(result);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });    
                    
            }
            else {
               
                 
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
                    if (length > 0) {
                        jQuery.each(tracking_details, function(key, value) {
                            if (key > 0 && key < length) {
                                MyList.push({ location: new google.maps.LatLng(value.street_addressLat, value.street_addressLng) });
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
        }
  
     </script>
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC5ri3ptVu7v8KO3dg3lRv7-pTRjJy94w&callback=initMap" async defer></script>
    @endpush
@endsection
