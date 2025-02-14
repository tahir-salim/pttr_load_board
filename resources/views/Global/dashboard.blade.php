@extends('layouts.app')

@section('content')

<div class="col-md-10">
    <div class="mainBody">

        <!-- Begin: Notification -->
         @include('layouts.notifications')
        <!-- END: Notification -->

        <div class="main-header">
            <h2>Dashboard Overview</h2>
        </div>
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
        @php 
            // if(ads_get('dashboard','top_header1')){
                $top_header1 = ads_get('dashboard','top_header1');
                $top_header2 = ads_get('dashboard','top_header2');
                $center_header3 = ads_get('dashboard','center_header3');
                $center_header4 = ads_get('dashboard','center_header4');
            // } 
        @endphp
        <div class="contBody">
            @if(isset($top_header1) || isset($top_header2))  
                <div class="row">
                    <div class="col-md-8">
                        <div class="addvertismentSlide swiper">
                            <div class="swiper-wrapper">
                                @if(isset($top_header1) && @ count($top_header1) > 0)
                                    @foreach($top_header1 as $top_header)                                
                                        <div class="swiper-slide">
                                            <div class="advertisments">
                                                <a href="{{$top_header->url}}" target="_blank" title=""><img src="{{asset($top_header->image)}}" alt=""></a>
                                            </div>
                                        </div>
                                   @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="addvertismentSlide swiper">
                            <div class="swiper-wrapper">
                                @if(isset($top_header2) && @ count($top_header1) > 0)
                                    @foreach($top_header2 as $top_header)                                
                                        <div class="swiper-slide">
                                            <div class="advertisments">
                                                <a href="{{$top_header->url}}" target="_blank" title=""><img src="{{asset($top_header->image)}}" alt=""></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
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
                                      <option value="all_type" {{ in_array('all_type', $selectedTypes) ? 'selected' : '' }}>All Type</option>
                                         @foreach($equipment_types as $equipment_type)
                                            <option value="{{ $equipment_type->id }}" {{ in_array($equipment_type->id, $selectedTypes) ? 'selected' : '' }}>
                                                {{ $equipment_type->name }}
                                            </option>
                                         @endforeach
                                    </select>
                                </div>
                             </form>
                            <!--<div class="lists-tcount">-->
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
                                <!--<tr>-->
                                <!--    <td>1</td>-->
                                <!--    <td>SOUTH DAKOTA</td>-->
                                <!--    <td>2.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--<tr>-->
                                <!--    <td>1</td>-->
                                <!--    <td>SOUTH DAKOTA</td>-->
                                <!--    <td>2.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>3</td>-->
                                <!--    <td>VERMONT</td>-->
                                <!--    <td>2.1</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>4</td>-->
                                <!--    <td>NEBRASKA</td>-->
                                <!--    <td>2.5</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>4</td>-->
                                <!--    <td>NEW HAMPSHIRE</td>-->
                                <!--    <td>2.5</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>6</td>-->
                                <!--    <td>MARYLAND</td>-->
                                <!--    <td>2.7</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>6</td>-->
                                <!--    <td>VIRGINIA</td>-->
                                <!--    <td>2.7</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>8</td>-->
                                <!--    <td>IOWA</td>-->
                                <!--    <td>2.8</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>8</td>-->
                                <!--    <td>MINNESOTA</td>-->
                                <!--    <td>2.8</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>8</td>-->
                                <!--    <td>MISSISSIPPI</td>-->
                                <!--    <td>2.8</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>11</td>-->
                                <!--    <td>KANSAS</td>-->
                                <!--    <td>2.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>11</td>-->
                                <!--    <td>UTAH</td>-->
                                <!--    <td>2.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>11</td>-->
                                <!--    <td>WISCONSIN</td>-->
                                <!--    <td>2.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>11</td>-->
                                <!--    <td>WYOMING</td>-->
                                <!--    <td>2.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>15</td>-->
                                <!--    <td>ALABAMA</td>-->
                                <!--    <td>3.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>15</td>-->
                                <!--    <td>HAWAII</td>-->
                                <!--    <td>3.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>15</td>-->
                                <!--    <td>MAINE</td>-->
                                <!--    <td>3.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>15</td>-->
                                <!--    <td>MASSACHUSETTS</td>-->
                                <!--    <td>3.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>15</td>-->
                                <!--    <td>TENNESSEE</td>-->
                                <!--    <td>3.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>20</td>-->
                                <!--    <td>MONTANA</td>-->
                                <!--    <td>3.1</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>21</td>-->
                                <!--    <td>GEORGIA</td>-->
                                <!--    <td>3.2</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>22</td>-->
                                <!--    <td>FLORIDA</td>-->
                                <!--    <td>3.3</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>22</td>-->
                                <!--    <td>IDAHO</td>-->
                                <!--    <td>3.3</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>24</td>-->
                                <!--    <td>ARIZONA</td>-->
                                <!--    <td>3.4</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>24</td>-->
                                <!--    <td>ARKANSAS</td>-->
                                <!--    <td>3.4</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>24</td>-->
                                <!--    <td>PENNSYLVANIA</td>-->
                                <!--    <td>3.4</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>24</td>-->
                                <!--    <td>SOUTH CAROLINA</td>-->
                                <!--    <td>3.4</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>28</td>-->
                                <!--    <td>MISSOURI</td>-->
                                <!--    <td>3.5</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>28</td>-->
                                <!--    <td>OKLAHOMA</td>-->
                                <!--    <td>3.5</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>30</td>-->
                                <!--    <td>NORTH CAROLINA</td>-->
                                <!--    <td>3.6</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>31</td>-->
                                <!--    <td>INDIANA</td>-->
                                <!--    <td>3.7</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>32</td>-->
                                <!--    <td>COLORADO</td>-->
                                <!--    <td>3.8</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>32</td>-->
                                <!--    <td>NEW MEXICO</td>-->
                                <!--    <td>3.8</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>34</td>-->
                                <!--    <td>DELAWARE</td>-->
                                <!--    <td>3.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>34</td>-->
                                <!--    <td>MICHIGAN</td>-->
                                <!--    <td>3.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>36</td>-->
                                <!--    <td>TEXAS</td>-->
                                <!--    <td>4.0</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>37</td>-->
                                <!--    <td>LOUISIANA</td>-->
                                <!--    <td>4.1</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>38</td>-->
                                <!--    <td>NEW YORK</td>-->
                                <!--    <td>4.2</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>38</td>-->
                                <!--    <td>OHIO</td>-->
                                <!--    <td>4.2</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>38</td>-->
                                <!--    <td>OREGON</td>-->
                                <!--    <td>4.2</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>38</td>-->
                                <!--    <td>WEST VIRGINIA</td>-->
                                <!--    <td>4.2</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>42</td>-->
                                <!--    <td>CONNECTICUT</td>-->
                                <!--    <td>4.3</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>42</td>-->
                                <!--    <td>RHODE ISLAND</td>-->
                                <!--    <td>4.3</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>44</td>-->
                                <!--    <td>ALASKA</td>-->
                                <!--    <td>4.5</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>45</td>-->
                                <!--    <td>KENTUCKY</td>-->
                                <!--    <td>4.6</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>45</td>-->
                                <!--    <td>NEW JERSEY</td>-->
                                <!--    <td>4.6</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>47</td>-->
                                <!--    <td>ILLINOIS</td>-->
                                <!--    <td>4.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>47</td>-->
                                <!--    <td>WASHINGTON</td>-->
                                <!--    <td>4.9</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>49</td>-->
                                <!--    <td>NEVADA</td>-->
                                <!--    <td>5.1</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>50</td>-->
                                <!--    <td>CALIFORNIA</td>-->
                                <!--    <td>5.2</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>51</td>-->
                                <!--    <td>DISTRICT OF COLUMBIA</td>-->
                                <!--    <td>5.3</td>-->
                                <!--</tr>-->
                                </tbody>
                            </table>
                        </div> 
                    </div>
                    @if(isset($center_header3))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="addvertismentSlide swiper">
                                    <div class="swiper-wrapper">
                                         @if(isset($center_header3) && @ count($top_header1) > 0)
                                            @foreach($center_header3 as $center_header)                                
                                                <div class="swiper-slide">
                                                    <div class="advertisments">
                                                        <a href="{{$center_header->url}}" target="_blank" title=""><img src="{{asset($center_header->image)}}" alt=""></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                     </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3>Support</h3>
                                <p>contact Information, trouble shooting and training Videos.
                                </p>
                            </div>
                            <div class="btn">
                                <a class="themeBtn skyblue" href="{{ route(auth()->user()->type . '.help-center') }}" title="">Support</a>
                            </div>
                        </div>
                    </div>
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
                        
                        <div class="Btnmultiple pb-5" style="flex-flow:column;">
                         @if(auth()->user()->type != "broker")
                            <a class="themeBtn" href="{{ route(auth()->user()->type . '.truck.create') }}" title="">
                                <img src="{{asset('assets/images/icons/shipmenticon-bt.webp')}}" alt="">
                                POST A TRUCK
                            </a>
                            <a class="themeBtn" href="{{ route(auth()->user()->type . '.search_loads') }}" title="">
                                <img  src="{{asset('assets/images/icons/searchloadsicon-bt.webp')}}" alt="">
                                SEARCH LOADS
                            </a>
                            @endif
                            @if(auth()->user()->type != "trucker")
                            <a class="themeBtn" href="{{ route(auth()->user()->type . '.search_trucks') }}" title="">
                                <img src="{{asset('assets/images/icons/truckicon-bt.webp')}}" alt="">
                                SEARCH TRUCKS
                            </a>
                            <a class="themeBtn" href="{{ route(auth()->user()->type . '.post_a_shipment') }}" title="">
                                <img  src="{{asset('assets/images/icons/searchloadsicon-bt.webp')}}"  alt="">
                                POST A SHIPMENT
                            </a>
                            @endif
                            
                           
                        </div>
                        @push('css')
                            <style>
                                /*.customscroll {*/
                                /*    height: 315px;*/
                                /*    overflow-y: scroll;*/
                                /*}*/
                            </style>
                        @endpush
                        <h3>Get Started</h3>
                        <div class="row boxvideos customscroll">
                            <div class="col-md-12">
                                <div class="items">
                                    <div class="img">
                                        <figure>
                                            <img src="{{asset('assets/images/videoposter1.jpg')}}" alt="">
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
                                            <img src="{{asset('assets/images/videoposter2.jpg')}}" alt="">
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
                                            <img src="{{asset('assets/images/videoposter3.jpg')}}" alt="">
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
