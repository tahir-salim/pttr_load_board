

@extends('Admin.layouts.app')

@section('content')

<div class="col-md-10">
    <div class="mainBody">

        <!-- Begin: Notification -->
         @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>Dashboard Overview</h2>
        </div>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        @push('css')
            <style>
                .listMain-truck .select2-container { width:100% !important; display:block; }
            </style>
        @endpush
        {{-- <div class="col-md-8">
            <center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
            </center>
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route( auth()->user()->type.'.send_notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body"></textarea>
                          </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>

                </div>
            </div>
        </div> --}}
     <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
     @if(auth()->user()->parent_id == null)
        <script>

            var firebaseConfig = {
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

            const messaging = firebase.messaging();

            //     console.log(old_token);
            this.initFirebaseMessagingRegistration();
            function initFirebaseMessagingRegistration() {
                    messaging.requestPermission().then(function () {
                        messaging.getToken().then(function (currentToken) {
                            console.log('==>' + currentToken);
                            let oldToken;
                                messaging.getToken().then(function (oldTokenResult) {
                                    oldToken = oldTokenResult;
                                    console.log('-->' + oldToken);
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        url: "{{config('app.url')}}/{{auth()->user()->type}}/save-token",
                                        type: 'POST',
                                        data: {
                                            token: currentToken,
                                            oldToken: oldToken,
                                        },
                                        dataType: 'JSON',
                                        success: function (response) {
                                            console.log('Token saved successfully.');
                                        },
                                        error: function (err) {
                                            console.log('User Chat Token Error before Ajax ' + err);
                                        },
                                    });

                                }).catch(function (err) {
                                    console.log('Error getting current token: ' + err);
                                });
                            }).catch(function (err) {
                            console.log('Error getting old token: ' + err);
                        });
                    }).catch(function (err) {
                        console.log('Error requesting permission: ' + err);
                    });

            }

            messaging.onMessage(function(payload) {
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });

        </script> 
     @endif
        @php 
            if(ads('dashboard','top_header1')){
                $top_header1 = ads('dashboard','top_header1');
                $top_header2 = ads('dashboard','top_header2');
                $center_header3 = ads('dashboard','center_header3');
                $center_header4 = ads('dashboard','center_header4');
            }
        @endphp
        <div class="contBody">
            @if(isset($top_header1) && isset($top_header2))  
            <div class="row">
                <div class="col-md-8">
                    <div class="advertisments">
                        <a href="{{$top_header1->url}}" target="_blank" title=""><img src="{{asset($top_header1->image)}}" alt=""></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="advertisments">
                        <a href="{{$top_header2->url}}" target="_blank" title=""><img src="{{asset($top_header2->image)}}" alt=""></a>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="listMain-truck">
                             <form id="SeachFormIn" action="{{ route(auth()->user()->type . '.dashboard') }}" method="GET">
                                <div class="search">
                                    <select class="js-example-basic-multiple" name="types[]" multiple="multiple">
                                      <option value="all_type" {{ in_array('all_type', $selectedTypes) ? 'selected' : '' }}>All Equipment Type</option>
                                         @foreach($equipment_types as $equipment_type)
                                            <option value="{{ $equipment_type->id }}" {{ in_array($equipment_type->id, $selectedTypes) ? 'selected' : '' }}>
                                                {{ $equipment_type->name }}
                                            </option>
                                         @endforeach
                                    </select>
                                </div>
                             </form>
                         </div>
                        <div id="mapdata"></div>
                        <div id="table-div" style="display:none">
                            <table id="data">
                                <tbody>
                                @foreach($shipments as $key => $shipment)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{strtoupper($shipment['name'])}}</td>
                                       <td>{{(int)$shipment['in'] . ' - ' . (int)$shipment['out'] }}</td>
                                    </tr>
                                 @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    @if(isset($center_header3))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="advertisments">
                                    <a href="{{$center_header3->url}}" target="_blank" title=""><img src="{{asset($center_header3->image)}}" alt=""></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--<div class="card">-->
                    <!--    <div class="d-flex justify-content-between">-->
                    <!--        <div>-->
                    <!--            <h3>Support</h3>-->
                    <!--            <p>contact Information, trouble shooting and training Videos.-->
                    <!--            </p>-->
                    <!--        </div>-->
                    <!--        <div class="btn">-->
                    <!--            <a class="themeBtn skyblue" href="{{ route(auth()->user()->type . '.help-center') }}" title="">Support</a>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="card">
                        <h3>What's New</h3>
                        <div class="contwhats_new">
                            <h4>NEW January 11th, 2024</h4>
                            <div class="scrollcustom">
                                <ul class="">
                                    <li>Brokers with 1,920px size screens or larger can now:</li>
                                    <li>View more columns on their My Shipments page that relate to the
                                        equioment
                                        detalis needed to move their Trelanu</li>
                                    <li>The My Shipments page will shift from a single "Equipment"
                                        column
                                        that
                                        displays the required equipment type, length, weight, and
                                        capacity
                                        to
                                        having
                                        unique columns for each of these</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card truckcount">
                        <!--<div class="head">-->
                        <!--    <img src="{{asset('assets/images/prime-logo.web')}}p" alt="">-->
                        <!--    <h3>National Trucks Count</h3>-->
                        <!--    <p>Where the trucks are</p>-->
                        <!--</div>-->
                       {{-- @if(isset($center_header4))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="advertisments">
                                    <a href="{{$center_header4->url}}" target="_blank" title=""><img src="{{asset($center_header4->image)}}" alt=""></a>
                                </div>
                            </div>
                        </div>
                        @endif --}}
                        
                        
                       
                        <h3>Get Started</h3>
                        <div class="row boxvideos">
                            <div class="col-md-12">
                                <div class="items">
                                    <div class="img">
                                        <figure>
                                            <img src="{{asset('assets/images/video1.png')}}" alt="">
                                        </figure>
                                        <a data-fancybox="video" href="{{asset('assets/videos/pttr-Invoice.mp4')}}">
                                            <i class="far fa-play-circle"></i>
                                        </a>
                                    </div>
                                    <h4>PTTR Invoice</h4>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="items">
                                    <div class="img">
                                        <figure>
                                            <img src="{{asset('assets/images/video1.png')}}" alt="">
                                        </figure>
                                        <a data-fancybox="video" href="{{asset('assets/videos/pttr-complete-load-board.mp4')}}">
                                            <i class="far fa-play-circle"></i>
                                        </a>
                                    </div>
                                    <h4>PTTR Complete Load Board</h4>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="items">
                                    <div class="img">
                                        <figure>
                                            <img src="{{asset('assets/images/video1.png')}}" alt="">
                                        </figure>
                                        <a data-fancybox="video" href="{{asset('assets/videos/pttr-4.mp4')}}">
                                            <i class="far fa-play-circle"></i>
                                        </a>
                                    </div>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')


<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

 (async () => {

    const topology = await fetch(
        'https://code.highcharts.com/mapdata/countries/us/custom/us-small.topo.json'
    ).then(response => response.json());

    // Load the data from the HTML table and tag it with an upper case name used
    // for joining
    const data = [];

    Highcharts.data({
        table: document.getElementById('data'),
        startColumn: 1,
        firstRowAsNames: false,
        complete: function (options) {
            console.log(options);
            options.series[0].data.forEach(function (p) {
                console.log(p);
                data.push({
                    ucName: p[0],
                    value: randomIntFromInterval(1,6),
                    value1: p[1]
                });
            });
        }
    });
        function randomIntFromInterval(min, max) { // min and max included 
          return Math.floor(Math.random() * (max - min + 1) + min);
        }
    // Prepare map data for joining
    topology.objects.default.geometries.forEach(function (g) {
        if (g.properties && g.properties.name) {
            g.properties.ucName = g.properties.name.toUpperCase();
        }
    });

    // Initialize the chart
    Highcharts.mapChart('mapdata', {

        title: {
            text: '',
            align: 'left'
        },

        

        mapNavigation: {
            enabled: true,
            enableButtons: false
        },

        xAxis: {
            labels: {
                enabled: false
            }
        },

       colorAxis: {
            labels: {
                format: '{value}%'
            },
            stops: [
                [0.2, '#188e2a'], // Green
                [0.6, '#fee401'], // Yellow
                [1, '#df1309'] // Red
            ],
            min: 0,
            max: 6
        },

        series: [{
            mapData: topology,
            data,
            joinBy: 'ucName',
            name: 'Truck In & Out',
            dataLabels: {
                enabled: true,
                format: '{point.properties.hc-a2}',
                style: {
                    fontSize: '10px'
                }
            },
            tooltip: {
                pointFormat: '{point.properties.name}: {point.value1}' // Display value1 in tooltip
            }
        }, {
        // The connector lines
            type: 'mapline',
            data: Highcharts.geojson(topology, 'mapline'),
            color: 'silver',
            accessibility: {
                enabled: false
            }
        }],
        
         credits: {
            enabled: false // This line hides the Highcharts branding
        },
        legend: {
            enabled: false // Disable the legend
        }
        
    });

})();



</script>
    
<script>
    $(document).ready(function() {
        
        
        
       var typeSelect = $('.js-example-basic-multiple').select2({
              placeholder: "Select a Equipment Type",
        });
        
        
         typeSelect.on('select2:select', function (e) {
              $("#SeachFormIn").submit();
         });
            
            
            
            
    });
</script>
@endpush

@endsection