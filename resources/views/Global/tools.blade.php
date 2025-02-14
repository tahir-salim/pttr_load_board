@extends('layouts.app')
@section('content')
<div class="col-md-10">
@push('css')
<style>
    #cf-response-message {
    padding: 20px;
    max-width: 500px; /* Adjust according to your needs */
    margin: 0 auto; /* Center align */
    font-family: Arial, sans-serif;
}

#cf-response-message .card {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

#cf-response-message .highlight {
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
    font-size: 18px;
}

#cf-response-message .ng-star-inserted {
    margin-bottom: 15px;
}

#cf-response-message .card div {
    margin-bottom: 5px;
    font-size: 16px;
}

#cf-response-message .card .highlight {
    color: #007BFF; /* Custom color for highlight */
}

#cf-response-message .card .rates {
    font-weight: bold;
    color: #28a745;
}

#cf-response-message .card .range {
    color: #dc3545;
    font-style: italic;
}

#cf-response-message .card .data {
    color: #6c757d;
    font-size: 14px;
}
</style>
@endpush    
<div class="mainBody">
          <!-- Begin: Notification -->
          @include('layouts.notifications')
          <!-- END: Notification -->
    

        <div class="main-header">
            <h2>Tools</h2>
        </div>
        @php 
            $top_header1 = ads('tools','top_header1');
            $top_header2 = ads('tools','top_header2');
            $top_header3 = ads('tools','top_header3');
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
            <h2>QUICK TOOLS</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="Bxtools">
                        <h3>Market Rate</h3>
                        <form id="cf-form">
                            <div class="fields">
                            <select class="origin-multiple" required name="origin" value="{{old('origin')}}" ></select>
                            </div>
                            <div class="fields">
                            <select class="destination-multiple" required name="destination" value="{{old('destination')}}"></select>
                            </div>
                            <div class="fields">
                                <select name="eq_type_id" id="" required>
                                    <option value="" hidden >Select Equipment Type</option>
                                    @forelse($equipment_types as $equipment)
                                    <option value="{{$equipment->id}}">{{$equipment->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="searchBtn">
                                <input type="submit" value="SEARCH">
                            </div>
                        </form>
                        <div id="cf-response-message" class="rate-lookup"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="Bxtools">
                        <h3>Support</h3>
                        <p>Feel free to reach out to our support team.</p>
                        <div class="text-right">
                            <a class="simplebtn" href="{{ route(auth()->user()->type . '.help-center') }}" title="">Support<i class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>PTTR Database</h3>
                        <p>Anything you need to know about a broker, carrier or shipper that subscribes
                            to PTTR</p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">PTTR Database<i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>Report User Issues</h3>
                        <p>Report a broker, carrier or shipper for bad behavior</p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">Report User Issues<i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <h2>PTTR TOOLS</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>Market Map</h3>
                        <p>Map view of market areas with a favourable load- to - truck ratio or Market
                            Conditions Index (MCI)</p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">Market Map <i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>Load Rate</h3>
                        <p>Real-time lane rate tool for Supply Chain and Logistics Analysis.</p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">Load Rate <i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <!--<div class="col-md-3">-->
                <!--    <div class="Bxtools disabled">-->
                <!--        <h3>Trendlines </h3>-->
                <!--        <p>Most current trends for things like Van Rated and Fuel Prices at a glance and-->
                <!--            is routinely updated</p>-->
                <!--        <div class="text-right">-->
                <!--            <a class="simplebtn" href="javascript:;" title="">Trendlines <i-->
                <!--                    class="fal fa-chevron-right"></i></a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>PTTR Map </h3>
                        <p>Find capacity in specific lanes, even when a carrier’s never posted a truck
                        </p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">PTTR Map <i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <!--<div class="col-md-3">-->
                <!--    <div class="Bxtools disabled">-->
                <!--        <h3>CarrierWatch </h3>-->
                <!--        <p>Monitor and receive alerts immediately to changes in safety. authority or-->
                <!--            insurance status.-->
                <!--        </p>-->
                <!--        <div class="text-right">-->
                <!--            <a class="simplebtn" href="javascript:;" title="">Lanemakers <i-->
                <!--                    class="fal fa-chevron-right"></i></a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>PTTR Carrier Information </h3>
                        <p>Allow carriers to complete an online profile. and view. print and sign a
                            broker's contract electronically
                        </p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">PTTR Carrier Information <i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <h2>ROAD SERVICES</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>Nearby</h3>
                        <p>Find services for bia rigs around the U.S
                            that accommodate your truck size</p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">Nearby <i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <!--<div class="col-md-3">-->
                <!--    <div class="Bxtools disabled">-->
                <!--        <h3>Fuel Optimization</h3>-->
                <!--        <p>Find and locate the most cost-effective fuel route, while taking into-->
                <!--            consideration fuel tank size.</p>-->
                <!--        <div class="text-right">-->
                <!--            <a class="simplebtn" href="javascript:;" title="">Fuel Optimization <i-->
                <!--                    class="fal fa-chevron-right"></i></a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="col-md-3">-->
                <!--    <div class="Bxtools disabled">-->
                <!--        <h3>Fuel Tax </h3>-->
                <!--        <p>Manage all of your fuel tax reports and applications with ProMilesOnline.-->
                <!--        </p>-->
                <!--        <div class="text-right">-->
                <!--            <a class="simplebtn" href="javascript:;" title="">Trendlines <i-->
                <!--                    class="fal fa-chevron-right"></i></a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-md-3">
                    <div class="Bxtools disabled">
                        <h3>PTTR Invoicing </h3>
                        <p>Find capacity in specific lanes, even when a carrier’s never posted a truck
                        </p>
                        <div class="text-right">
                            <a class="simplebtn" href="javascript:;" title="">PTTR Invoicing <i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="Bxtools">
                        <h3>Promote Your Business with us PTTR Advertisement </h3>
                        <p>Streamline your cross-border shipments. Pass through the border with no
                            delays
                        </p>
                        <div class="text-right">
                            <a class="simplebtn" href="{{ route(auth()->user()->type . '.help-center-detail') }}" title="">PTTR Advertisement<i
                                    class="fal fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI&libraries=places"></script>
<script>   
    
      $(document).ready(function() {
        $('#cf-form').submit(function(e) {
            e.preventDefault();
    
            // Get the form element
            const form = document.getElementById('cf-form');
    
            // Create FormData from the form
            const formData = new FormData(form);
            
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            // console.log(formData);
    
            $.ajax({
                type: 'POST',
                url: "{!! route(auth()->user()->type.'.form_tools') !!}",
                data: formData,
                dataType: 'json',
                processData: false, // Important: Prevents jQuery from automatically transforming the data into a query string
                contentType: false, // Important: Tells jQuery not to set the Content-Type header
                success: function(response) {
                    if(response.message != null){
                        $('#cf-response-message').html('<div class="ng-star-inserted"><div class="card"><div class="highlight">' + response.message.origin + '</br> -> </br>'  + response.message.destination + '(' + response.message.miles + '/mi)</div><div>Rates: ' + response.message.average_rate + '($' + response.message.average_mile + '/mi)</div><div>Range: $' + response.message.range_min_rate + ' -  $' + response.message.range_max_rate + ' ($' + response.message.range_min_mile + ' - $' + response.message.range_max_mile + '/mi)</div><div>DATA: -</div><div>' + response.message.fuel_surcharge + '</div></div></div>');
                    }else{
                        $('#cf-response-message').html('<div class="ng-star-inserted"><div class="card"><div class="highlight">No Rate Found</div></div></div>');
                    }
                    // Handle the response message
                },
                error: function(xhr, status, error) {
                    // Handle errors if needed
                    console.error(xhr.responseText);
                }
            });
        });
    });

    var originSelect = $('.origin-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Origin (City, ST)*",
                ajax: getAjaxOnlyCity(),
                closeOnSelect: true
            });

    var destinationSelect = $('.destination-multiple').select2({
        maximumSelectionLength: 0,
        placeholder: "Destination (City, ST)*",
        ajax: getAjaxOnlyCity(),
        closeOnSelect: true
    });

    
    
</script>
@endpush