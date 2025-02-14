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
.aligndivs{ display:flex; gap:1rem; align-items:center; }
.aligndivs input{ width:100%;  }
.aligndivs label{ margin: 0; margin-right:1rem; }

#trackingMap {
    width: 100%;
    height: 60vh !important;
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
                <h2>PTTR MAP</h2>
                <div class="rightBtn">
                    
                </div>
            </div>
         
            <div class="contBody">
            
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
                            <div class="col-md-12">
                                <form id="SubmitFormSearch" action="javascript:void(0)">
                                    <div class="row aligndivs">
                                        <div class="col-md-3 d-flex align-items-center">
                                           <label>Origin</label>            
                                           <input type="text" placeholder="Street Address" 
                                                    id="OriginTextField" name="pick_street_address" required="">
                                                <input type="hidden" id="pick_street_place_id" 
                                                    name="street_place_id">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-center">
                                           <label>Destination</label>            
                                           <input type="text" placeholder="Street Address"
                                                    id="DestinationTextField" name="drop_street_address" required="">
                                                <input type="hidden" id="drop_street_place_id" 
                                                    name="drop_street_place_id">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="themeBtn" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row aligndivs pt-3">
                            <div class="col-md-3 d-flex align-items-center miles">
                               
                            </div>
                            <div class="col-md-3 d-flex align-items-center timetext">
                            
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="trackMaps">
                                    <div id="trackingMap"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('js')
 
    <script type="text/javascript">
    
        function initialize() {
            
                const center = { lat: 50.064192, lng: -130.605469 };
                 const defaultBounds = {
                    north: center.lat + 0.1,
                    south: center.lat - 0.1,
                    east: center.lng + 0.1,
                    west: center.lng - 0.1,
                  };
              
              
                var options = {
                    // types: ['establishment'],
                    // componentRestrictions: {
                    //     country: ["us","cn","ca"]
                    // }
                    bounds: defaultBounds,
                    componentRestrictions: {country: ["us","cn","ca"]},
                    fields: ["address_components", "geometry", "icon", "name"],
                    strictBounds: false,  
                    types: ["address"]
                };
            
            var input = document.getElementById('OriginTextField');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            console.log('OriginTextField ' +input);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                document.getElementById('pick_street_place_id').value = place.place_id;
        
        
            });
            var input1 = document.getElementById('DestinationTextField');
            console.log('DestinationTextField ' +input1);
            var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
            google.maps.event.addListener(autocomplete1, 'place_changed', function() {
                var place1 = autocomplete1.getPlace();
        
                document.getElementById('drop_street_place_id').value = place1.place_id;
            
        
            });
        }
    </script>

    <script>
     
          $(document).on('submit','#SubmitFormSearch',function(e){
                e.preventDefault();
                     initMap();
            });
     
       
        var image_url = "{{asset('assets/images/truckicon.png')}}";
        var map;
        var directionsService;
        var directionsDisplay;
        var carMarker;
        var stepIndex = 0;
        var carPath = [];
        
        function initMap() {
            initialize();
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
                  
                  
               
                var start =  $('#OriginTextField').val();
                var end =  $('#DestinationTextField').val();
                var request = {
                    origin: start, // Starting point
                    destination: end, // Destination
                  
                    travelMode: 'DRIVING',
                     drivingOptions: {
                        departureTime: new Date() // Current time
                    }
                };
                // Request directions
                if(start != "" && end != "" ){
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
        
        
                            var hours = Math.floor(totalTime / 3600);
                            var minutes = Math.floor((totalTime % 3600) / 60);
                            var timeText = hours > 0 
                                ? hours + " hours " + (minutes > 0 ? minutes + " minutes" : "")
                                : minutes + " minutes";
                            
                            var distanceText = (totalDistance < 1000) ? totalDistance + ' meters' :  kmToMiles((totalDistance / 1000).toFixed(2)) + ' mi';
                            // var timeText = (totalTime < 60) ? totalTime + ' seconds' : (totalTime < 3600) ? Math.ceil(totalTime / 60) + ' minutes' : Math.ceil(totalTime / 3600) + ' hours';
        
        
        
                            $('.miles').html('<h4> Total Miles : '+ distanceText +'</h4>');
                            $('.timetext').html('<h4> Duration: ' + timeText + '</h4>');
                            // $('.timetext').html('<h4> Duration : '+ timeText +'</h3>');
                            
                        } else {
                            $('.miles').html('');
                            $('.timetext').html('');
                             Swal.fire({
                                  icon: "error",
                                  title: "Oops...",
                                  text: "Please Make sure to select the address using the suggestion dropdown! " + status,
                                });
                            // window.alert('Directions request failed due to ' );
                        }
                    });
                }
            
        }
  
     </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC5ri3ptVu7v8KO3dg3lRv7-pTRjJy94w&libraries=places&callback=initMap" async defer></script>
 
    @endpush
@endsection