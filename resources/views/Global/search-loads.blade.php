@extends('layouts.app')
@section('content')
    {{--  Search Loads --}}
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            @push('css')
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <style>
                    td:first-child.details-control {
                        background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
                        cursor: pointer;
                    }

                    tr.shown td:first-child.details-control {
                        background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
                    }

                    .modal {
                        position: fixed;
                        z-index: 1000;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.6);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        transition: all 0.3s ease;
                    }

                    .modal-content {
                        background-color: #ffffff;
                        border-radius: 8px;
                        padding: 20px 30px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                        width: 400px;
                        max-width: 90%;
                        position: relative;
                    }

                    .modal-content h2 {
                        margin-top: 0;
                        color: #333;
                        font-size: 1.5rem;
                        font-weight: 600;
                    }

                    .modal-content label {
                        display: block;
                        margin-top: 15px;
                        font-size: 0.9rem;
                        color: #666;
                    }

                    .modal-content input[type="text"] {
                        width: 100%;
                        padding: 8px 10px;
                        margin-top: 5px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        font-size: 0.9rem;
                    }

                    .submit-btn {
                        margin-top: 20px;
                        padding: 10px 15px;
                        background-color: #009edd;
                        border: none;
                        color: #fff;
                        font-size: 1rem;
                        font-weight: 600;
                        border-radius: 4px;
                        cursor: pointer;
                        width: 100%;
                        transition: background-color 0.3s ease;
                    }

                    .submit-btn:hover {
                        background-color: #0080c4;
                    }

                    .close {
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        font-size: 1.5rem;
                        cursor: pointer;
                        color: #666;
                        transition: color 0.3s ease;
                    }

                    .close:hover {
                        color: #333;
                    }

                    .modal-content select {
                        width: 100%;
                        padding: 8px 10px;
                        margin-top: 5px;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        font-size: 0.9rem;
                        background-color: #fff;
                    }
                </style>

            @endpush()

            @php

                $top_header1 = ads('search_loads','top_header1');

                $top_header2 = ads('search_loads','top_header2');

                $top_header3 = ads('search_loads','top_header3');

                $center_header4 = ads('search_loads','center_header4');

            @endphp

            <div class="main-header">
                <h2>Search Loads</h2>
            </div>
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
                {{-- <div class="searchfilteropt">
                <div class="searchitems">
                    <span>Denver, CO</span>
                    <div class="searchdir">
                        <i></i>
                        <div class="bar"></div>
                        <i class="fill"></i>
                    </div>
                    <span>Phoenix, AZ</span>
                    <div class="iconsfilters">
                        <i class="fal fa-bell-slash"></i>
                        <i class="far fa-times-circle"></i>
                    </div>
                </div>
               </div> --}}

                <form id="loadFilterform" action="{{ route(auth()->user()->type .'.search_loads') }}" method="GET" name="loadFilterform"
                    enctype="multipart/form-data">
                    <div class="card">
                        <div class="formFilters">
                            <div class="left">
                                <div class="fields width-200">
                                    {{-- @dd(app('request')->input('origin') , app('request')->input('destination') ); --}}
                                    <label>Origin</label>
                                    {{-- <input type="text" name="origin" id="OriginTextField" value="" hidden placeholder="Origin (City, ST, ZIP)*" autocomplete="off" class="pac-target-input"> --}}
                                    <select class="origin-multiple" name="origin[]" multiple="multiple"></select>

                                    {{-- <input type="text" name="origin" id="OriginTextField"
                                        value="{{ app('request')->input('origin') }}" placeholder="Origin (City, ST, ZIP)*">
                                    <input type="hidden" name="origin_lat" id="originLat" value="{{ app('request')->input('origin_lat') }}">
                                    <input type="hidden" name="origin_lng" id="originLng" value="{{ app('request')->input('origin_lng') }}">
                                    <input type="hidden" name="origin_id" id="origin_id"  value="{{ app('request')->input('origin_id') }}"> --}}

                                    {{-- <select name="" id="">
                                        <option value="">Select City</option>
                                        <option value="">Select City</option>
                                    </select> --}}
                                </div>
                                <div class="fields width-60" id="dho">
                                    <label>DH-O</label>
                                    <input type="text" name="dho" value="{{ app('request')->input('dho') ?? 150 }}">
                                </div>
                                <div class="leftright_direc">
                                    <i class="fal fa-long-arrow-right"></i>
                                    <i class="fal fa-long-arrow-left"></i>
                                </div>
                                <div class="fields width-200">
                                    <label>Destination</label>
                                    <select class="destination-multiple" name="destination[]" multiple="multiple"></select>
                                    {{-- <input type="text" id="DestinationTextField" required name="destination"
                                        value="{{ app('request')->input('destination') }}"
                                        placeholder="Destination (City, ST, ZIP)*">
                                    <input type="hidden" name="destination_lat" id="destinationLat" value="{{ app('request')->input('destination_lat') }}">
                                    <input type="hidden" name="destination_lng" id="destinationLng" value="{{ app('request')->input('destination_lng') }}">
                                    <input type="hidden" name="destination_id" id="destination_id" value="{{ app('request')->input('destination_id') }}"> --}}
                                    {{-- <select name="" id="">
                                        <option value="">Select City</option>
                                        <option value="">Select City</option>
                                    </select> --}}
                                </div>
                                <div class="fields width-60" id="dhd">
                                    <label>DH-D</label>
                                    <input type="text" name="dhd" value="{{ app('request')->input('dhd') ?? 150 }}">
                                </div>
                            </div>
                            <div class="right">
                                <div class="fields width-210">
                                    <label>Equipment Type*</label>
                                    <select class="js-example-basic-multiple" placeholder="Select Type" required
                                        name="eq_type_id[]" multiple="multiple">
                                        @foreach ($equipment_types as $equipment_type)
                                            <option value="{{ $equipment_type->id }}" 
                                                {{ app('request')->input('eq_type_id') ? (in_array($equipment_type->id, app('request')->input('eq_type_id')) ? 'selected="selected"' : '') : '' }} data-prefix="{{ $equipment_type->prefix }}">
                                                {{ $equipment_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="fields loadselect">
                                    <label>Load Type*</label>
                                    <select name="equipment_details" id="">
                                        <option value="2"
                                            {{ app('request')->input('equipment_details') == 2 ? 'selected' : '' }}>Full &
                                            Partial</option>
                                        <option value="0"
                                            {{ app('request')->input('equipment_details') == 0 ? 'selected' : '' }}>Full
                                        </option>
                                        <option value="1"
                                            {{ app('request')->input('equipment_details') == 1 ? 'selected' : '' }}>Partial
                                        </option>
                                    </select>
                                </div>
                                <div class="fields width-30">
                                    <label>Length</label>
                                    <input type="number" name="length" value="{{ app('request')->input('length') }}">
                                </div>
                                <div class="fields width-120">
                                    <label>Weight(lbs)</label>
                                    <input type="number" name="weight" value="{{ app('request')->input('weight') }}">
                                </div>
                                <div class="fields">
                                    <label>Date Range</label>
                                    <div class="daterange">
                                        <input type="date" name="from_date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ app('request')->input('from_date') ?? Carbon\Carbon::now()->format('Y-m-d')}}" required
                                            max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                        <input type="date" name="to_date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ app('request')->input('to_date') ??  Carbon\Carbon::now()->format('Y-m-d') }}" required
                                            max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="submitbtns">
                                 <a href="{{ route(auth()->user()->type . '.search_loads') }}" type="button"
                                    class="redoIco"><i class="fal fa-redo"></i></a>
                                    <input type="submit" id="loadFilterSubmit" class="btnSubmit skyblue" value="Search">



                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="selectfilters">
                                <div class="truckdet">
                                    <select name="load_requirements" onchange="myFunction()" id="">
                                            <option value="2" {{ app('request')->input('load_requirements') == null || app('request')->input('load_requirements') == "2" ? 'selected' : '' }}>Both</option>
                                            <option value="1" {{ app('request')->input('load_requirements') == "1" ? 'selected' : '' }}>Tracking Required</option>
                                            <option value="0" {{ app('request')->input('load_requirements') == "0" ? 'selected' : '' }}>Tracking not Required</option>
                                        </select>

                                </div>
                                <div class="fields searchback width-120">
                                    <label>Search Back - </label>
                                    <input type="number" name="searchback"
                                        value="{{ app('request')->input('searchback') ? app('request')->input('searchback') : '24' }}">
                                    <label>Hrs. </label>
                                </div>
                                {{-- <div class="searchback">
                                <select name="searchback" id="">
                                    <option value="24">Search Back - 24 HRS</option>
                                    <option value="">Search Back - 24 HRS</option>
                                </select>
                            </div> --}}
                                {{-- <div class="companyselect">
                                <select name="companyselect" id="">
                                    <option value="">Company</option>
                                    <option value="">Company</option>
                                </select>
                            </div> --}}
                                <div class="companyselect">
                                    <select name="bid" id="" onchange="myFunction()">
                                        <option value="0" {{ app('request')->input('bid') == 0 ? 'selected' : '' }}>All
                                        </option>
                                        <option value="1" {{ app('request')->input('bid') == 1 ? 'selected' : '' }}>Only Bid
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(isset($center_header4))
                            <div class="col-md-4">
                                <div class="advertisments">
                                    <a href="{{$center_header4->url}}" target="_blank" title=""><img src="{{asset($center_header4->image)}}" alt=""></a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="searchresultMain">
                        <div class="left">
                            <div class="resultsCount">
                                <a href="javascript:void(0)" class="refresh-img" onclick="refreshPage()"><img src="{{asset('/assets/images/icons/arrows-rotate-solid.png')}}" alt="Refresh Icon"/></a>
                                <div class="countCont">
                                    <h3>{{ count($shipments) }} Results</h3>
                                    {{-- <p>Similar Results</p> --}}
                                </div>
                            </div>
                            {{-- <p>Sort by <span>Age - Newest</span></p> --}}
                        </div>

                        {{-- <div class="right">
                        <div class="similarResults">
                            <p>Include Similar Results</p>
                            <input type="checkbox">
                        </div>
                    </div> --}}
                    </div>
                </form>

                @push('css')
                    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
                    <style>
                        td:first-child.details-control {
                            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
                            cursor: pointer;
                        }
                        tr.shown  td:first-child.details-control {
                            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
                        }
                </style>
                @endpush

                <table id="example" class="display nowrap csbody" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="age">Age <i class="fal fa-arrow-up"></i></th>
                            <th class="rate">Rate <i class="fal fa-arrow-up"></i></th>
                            <th class="available">Available <i class="fal fa-arrow-up"></i></th>
                            <th class="trip">Trip <i class="fal fa-arrow-up"></i></th>
                            <th class="origin">Origin <i class="fal fa-arrow-up"></i></th>
                            <th class="dh">DH-0 <i class="fal fa-arrow-up"></i></th>
                            <th class="destination">Destination <i class="fal fa-arrow-up"></i></th>
                            <th class="dh">DH-D <i class="fal fa-arrow-up"></i></th>
                            <th class="equipment">Equipment</th>
                            <th class="company">Company</th>
                            <th class="company">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipments as $k => $shipment)
                            <tr data-child-value="{{ $shipment }}">
                                <td class="details-control"></td>
                                <td class="age details-control"><strong>{{ $shipment->created_at->diffForHumans() }}</strong></td>
                                <td class="rate details-control">${{$shipment->dat_rate ?? '0' }}</td>
                                <td class="available details-control">
                                    {{ Carbon\Carbon::create($shipment->from_date)->format('m/d') }}
                                    {{ $shipment->from_date != null ? '- ' . Carbon\Carbon::create($shipment->to_date)->format('m/d') : '' }}
                                </td>
                                <td class="trip details-control">{{$shipment->miles ?? '0' }} mi</td>
                                <td class="origin details-control">{{ $shipment->origin }}</td>
                                <td class="dh details-control">{{$shipment->dho != null || $shipment->dho == 0  ? $shipment->dho : '-'}} </td>
                                <td class="destination details-control">{{ $shipment->destination }}</i></td>
                                <td class="dh details-control">{{$shipment->dhd != null || $shipment->dhd == 0 ? $shipment->dhd : '-'}} </td>
                                {{--<td class="dh details-control">-</td>--}}
                                <td class="equipment details-control">
                                    <p>{{ $shipment->eq_type }}<br>{{ $shipment->weight }} lbs.
                                        {{ $shipment->length }} ft -
                                        {{ $shipment->equipment_detail == 0 ? 'Full' : 'Partial' }}</p>
                                </td>
                                <td class="company details-control">
                                    <p class="bluecols">{{ $shipment['company_name'] }} <br>
                                        {{ $shipment['company_phone'] }} - {{$shipment['company_mc'] != null ?  $shipment['company_mc'] : $shipment['company_dot']}}
                                    </p>
                                </td>

                                <td>
                                    <a href="#" class="btn btn-outline-success"
                                        onclick="confirmAction(event, {{ $shipment->id }})">Book Now</a>
                                </td>
                            </tr>
                            <div id="myModal" class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <h2>Create Bid</h2>
                                    <form id="bidForm" onsubmit="submitBidForm(event)">
                                        <label for="amount">Bid Amount:</label>
                                        <input type="number" id="amount" name="amount" required
                                            placeholder="Enter bid amount">

                                        <button type="submit" class="submit-btn">Submit</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {!! $shipments->appends(request()->query())->links() !!}
                <hr>
                @if(isset($included_ships) != false)
                  @php
                        $include_shipments = $included_ships->paginate(25,['*'], 'includePagination');

                        $include_shipments->getCollection()->transform(function ($include_shipment) use ($org_lat ,  $org_lng , $des_lng , $des_lat) {

                            $include_shipment['status'] = $include_shipment->status == "WAITING" ? "PENDING" : $include_shipment->status;
                             if($include_shipment->user->parent_id != null){
                                    $company = \App\Models\Company::where('user_id', $include_shipment->user->parent_id)->first();
                            }else{
                                $company = \App\Models\Company::where('user_id', $include_shipment->user->id)->first();
                            }
                            $include_shipment['company_name'] = $company ? $company->name : '';
                            $include_shipment['company_phone'] = $company ?  $company->phone : '';
                            $include_shipment['status_phone'] = $include_shipment->status_phone == 1 ? $include_shipment->user ? $include_shipment->user->phone : null : null;
                            $include_shipment['status_email'] = $include_shipment->status_email == 1 ? $include_shipment->user ? $include_shipment->user->email : null : null;
                            $include_shipment['company_mc'] =  $company ? $company->mc : null;
                            $include_shipment['company_dot'] =  $company ? $company->dot : null;
                            $include_shipment['reference_id'] = $include_shipment->reference_id != null ? $include_shipment->reference_id : '-';
                            $include_shipment['commodity'] =  $include_shipment->commodity != null ? $include_shipment->commodity : '-' ;
                            $include_shipment['eq_name'] =  $include_shipment->eq_name != null ? $include_shipment->eq_name : '-' ;
                            $include_shipment['company_address'] =   $company ? $company->address : '';
                            $include_shipment['equipment_name'] =   $include_shipment->equipment_type ? $include_shipment->equipment_type->name : '';
                            $include_shipment['dho'] = $org_lat != null && $org_lat != null ?  (int)get_meters_between_points($include_shipment->origin_lat, $include_shipment->origin_lng, $org_lat, $org_lng) : null;
                            $include_shipment['dhd'] = $des_lat != null && $des_lat != null ?  (int)get_meters_between_points($include_shipment->destination_lat, $include_shipment->destination_lng, $des_lat, $des_lng) : null;
          
                          return $include_shipment;
                        });
                    @endphp


                    <div class="searchresultMain">
                        <div class="left">
                            <div class="resultsCount">
                                <a href="javascript:void(0)" class="refresh-img" onclick="refreshPage()"><img src="{{asset('/assets/images/icons/arrows-rotate-solid.png')}}" alt="Refresh Icon"/></a>
                                
                                <div class="countCont">
                                    <h3>{{ isset($include_shipments) ? count($include_shipments) : 0 }} Included Results</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                <table id="example1" class="display nowrap csbody" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="age">Age <i class="fal fa-arrow-up"></i></th>
                            <th class="rate">Rate <i class="fal fa-arrow-up"></i></th>
                            <th class="available">Available <i class="fal fa-arrow-up"></i></th>
                            <th class="trip">Trip <i class="fal fa-arrow-up"></i></th>
                            <th class="origin">Origin <i class="fal fa-arrow-up"></i></th>
                            <th class="dh">DH-0 <i class="fal fa-arrow-up"></i></th>
                            <th class="destination">Destination <i class="fal fa-arrow-up"></i></th>
                            <th class="dh">DH-D <i class="fal fa-arrow-up"></i></th>
                            <th class="equipment">Equipment</th>
                            <th class="company">Company</th>
                            <th class="company">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        @if(isset($included_ships) != false)
                            @foreach ($include_shipments as $k => $included_ship)
                                <tr data-child-value="{{ $included_ship }}">
                                    <td class="details-control"></td>
                                    <td class="age details-control"><strong>{{ $included_ship->created_at->diffForHumans() }}</strong></td>
                                     <td class="trip details-control">${{$included_ship->dat_rate ?? '0' }}</td>
                                    <td class="available details-control">
                                        {{ Carbon\Carbon::create($included_ship->from_date)->format('m/d') }}
                                        {{ $included_ship->from_date != null ? '- ' . Carbon\Carbon::create($included_ship->to_date)->format('m/d') : '' }}
                                    </td>
                                    <td class="trip details-control">{{$included_ship->miles ?? '0' }} mi</td>
                                    <td class="origin details-control">{{ $included_ship->origin }}</td>
                                    <td class="dh details-control">{{ $included_ship->dho != null ? $included_ship->dho : '-' }} </td>
                                    <td class="destination details-control">{{ $included_ship->destination }}</i></td>
                                    <td class="dh details-control">{{ $included_ship->dhd != null ? $included_ship->dhd : '-' }} </td>
                                    <td class="equipment details-control">
                                        <p>{{ $included_ship->eq_type }}<br>{{ $included_ship->weight }} lbs.
                                            {{ $included_ship->length }} ft -
                                            {{ $included_ship->equipment_detail == 0 ? 'Full' : 'Partial' }}</p>
                                    </td>
                                    <td class="company details-control">
                                        <p class="bluecols">{{ $included_ship['company_name'] }} <br>
                                            {{ $included_ship['company_phone'] }} - {{ $included_ship['company_mc'] != null ? $included_ship['company_mc'] : $included_ship['company_dot'] }}
                                        </p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-outline-success"
                                            onclick="confirmAction(event, {{ $included_ship->id }})">Book Now</a>
                                    </td>
                                </tr>
                                <div id="myModal" class="modal" style="display: none;">
                                    <div class="modal-content">
                                        <span class="close" onclick="closeModal()">&times;</span>
                                        <h2>Create Bid</h2>
                                        <form id="bidForm" onsubmit="submitBidForm(event)">
                                            <label for="amount">Bid Amount:</label>
                                            <input type="number" id="amount" name="amount" required
                                                placeholder="Enter bid amount">

                                            <button type="submit" class="submit-btn">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @endif
                @if(isset($included_ships) != false)
                    {!! $include_shipments->appends(request()->query())->links() !!}
                @endif
                @push('js')
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                    <script>
                        function format(value) {
                            var eq_detail = value.equipment_detail == 0 ? 'Full' : 'Partial';
                            console.log(value.status_phone + " -------- " +value.status_email)
                            var ht =
                                `<div class="itemsDetails">
                                        <div class="headSearchs">
                                            <h3>` + value.origin + `</h3>
                                            <div class="searchdir">
                                                <i></i>
                                                <div class="bar"></div>
                                                <i class="fill"></i>
                                            </div>
                                            <h3>` + value.destination + `</h3>
                                        </div>
                                        <div class="tableData">
                                            <div class="thead">
                                                <div>Trip</div>
                                                <div>Minimum Rate</div>
                                                <div>Company</div>
                                            </div>
                                            <div class="tbody">
                                                <div class="searchdir leftside">
                                                    <i></i>
                                                    <div class="bar"></div>
                                                    <i class="fill"></i>
                                                </div>
                                                <div class="Inneritems">
                                                    <div class="innlist">
                                                        <h4>` + value.origin + `</h4>
                                                        <p>` + value.from_date + `
                                                            -
                                                            ` + value.to_date + `
                                                        </p>
                                                    </div>
                                                    <div class="innlist">
                                                        <div class="minimumrate_det">
                                                            <span>Total</span>
                                                            <span>$`+ value.dat_rate +`</span>
                                                        </div>
                                                        <div class="minimumrate_det">
                                                            <span>Trip</span>
                                                            <span>`+ value.miles +` mi</span>
                                                        </div>
                                                        <div class="minimumrate_det">
                                                            <span>Rate/mile</span>
                                                            <span>$` + (value.dat_rate / value.miles).toFixed(2) + `</span>
                                                        </div>
                                                        <div class="minimumrate_det">
                                                            <span>Status</span>
                                                            <span>` + value.status + `</span>
                                                        </div>
                                                    </div>
                                                    <div class="innlist">
                                                        <p>` + value.company_name + ` <br>
                                                            <a href="tel:` + value.company_phone + `"
                                                                title="">` + value.company_phone + `</a>
                                                                <br>`;
                                                                if(value.company_mc != null){
                                                                      ht += `MC# ` + value.company_mc + `/<br>`;
                                                                }else{
                                                                     ht += `DOT# ` + value.company_dot + `/<br>`;
                                                                }
                                                                
                                                                 ht +=  value.company_address + `<br>
                                                                <span>
                                                                <div class="stars">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                                （0）
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="Inneritems">
                                                    <div class="innlist">
                                                        <h4>` + value.destination + `</h4>
                                                        <p>` + value.from_date + `
                                                            -
                                                            ` + value.to_date + `
                                                        </p>
                                                        <div class="equipmentsDv">
                                                            <h5>Equipment</h5>
                                                            <ul>
                                                                <li>
                                                                    <span>Load</span>
                                                                    <span>` + eq_detail + ` </span>
                                                                </li>
                                                                <li>
                                                                    <span>Truck</span>
                                                                    <span>` + value.equipment_name + `</span>
                                                                </li>
                                                                <li>
                                                                    <span>Length</span>
                                                                    <span> ` + value.length + ` ft. </span>
                                                                </li>
                                                                <li>
                                                                    <span>Weight</span>
                                                                    <span> ` + value.weight + `  lbs.</span>
                                                                </li>
                                                                <li>
                                                                    <span>Reference ID</span>
                                                                    <span>` + value.reference_id + ` </span>
                                                                </li>
                                                                <li>
                                                                    <span>Commodity</span>
                                                                    <span>` + value.commodity + ` </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        
                                                        <div class="comments">
                                                            <h5>Comments</h5>
                                                            <p>` + value.eq_name + `</p>
                                                        </div>
                                                    </div>
                                                    <div class="innlist">
                                                        <h4> Contact Information </h4>
                                                        <div class="equipmentsDv">
                                                            <ul>`;
                                                                if(value.status_phone != null){
                                                                    ht += `<li>
                                                                            <span>Phone</span>
                                                                            <span>` + value.status_phone + ` </span>
                                                                        </li>`;
                                                                }
                                                                if(value.status_email != null){
                                                                     ht += `<li>
                                                                                <span>Email</span>
                                                                                <span>` + value.status_email + `</span>
                                                                            </li>`;
                                                                }     
                                                    ht += `</ul>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

                            return ht;
                        }
                        $(document).ready(function() {
                            var table = $('#example').DataTable({
                                info: false,
                                ordering: true,
                                paging: false,
                                searching: false
                            });

                            // Add event listener for opening and closing details
                            $('#example').on('click', 'td.details-control', function() {
                                var tr = $(this).closest('tr');
                                var row = table.row(tr);

                                if (row.child.isShown()) {
                                    // This row is already open - close it
                                    row.child.hide();
                                    tr.removeClass('shown');
                                } else {
                                    // Open this row
                                    row.child(format(tr.data('child-value'))).show();
                                    tr.addClass('shown');
                                }
                            });
                        });

                        $(document).ready(function() {
                            var table = $('#example1').DataTable({
                                info: false,
                                ordering: true,
                                paging: false,
                                searching: false
                            });

                            // Add event listener for opening and closing details
                            $('#example1').on('click', 'td.details-control', function() {
                                var tr = $(this).closest('tr');
                                var row = table.row(tr);

                                if (row.child.isShown()) {
                                    // This row is already open - close it
                                    row.child.hide();
                                    tr.removeClass('shown');
                                } else {
                                    // Open this row
                                    row.child(format(tr.data('child-value'))).show();
                                    tr.addClass('shown');
                                }
                            });
                        });

                        // $('.dt-layout-row').hide();
                        // $('.dataTables_paginate').hide();
                    </script>
                @endpush

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI&libraries=places">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- // Origin Dropdown --}}
    <script>
        $(document).ready(function() {


            var preselectedOrigin = {!! json_encode(app('request')->input('origin')) !!};
            var preselectedDestination = {!! json_encode(app('request')->input('destination')) !!};


            $('input[name="searchback"]').blur(function(){
                var inputValue = $(this).val();
                if (inputValue === null || inputValue === '') {
                    $(this).val(24);
                }
            });

            $('input[name="searchback"]').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\D/g, '');
                if (inputValue.length > 2) {
                    inputValue = inputValue.slice(0, 2);
                }
                $(this).val(inputValue);
            });


            $('input[name="dho"]').blur(function(){
                var inputValue = $(this).val();
                if (inputValue === null || inputValue === '') {
                    $(this).val(150);
                }
            });

            $('input[name="dho"]').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\D/g, '');
                if (inputValue.length > 3) {
                    inputValue = inputValue.slice(0, 3);
                }
                $(this).val(inputValue);
            });


            $('input[name="dhd"]').blur(function(){
                var inputValue = $(this).val();
                if (inputValue === null || inputValue === '') {
                    $(this).val(150);
                }
            });

            $('input[name="dhd"]').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\D/g, '');
                if (inputValue.length > 3) {
                    inputValue = inputValue.slice(0, 3);
                }
                $(this).val(inputValue);
            });

            function getAjaxStateAndCity() {
                return {
                    url: "{{ route(auth()->user()->type . '.state_city') }}",
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.items, function (item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                };
                            })
                        };
                    },
                    cache: true
                };
            }

            function populateSelect2WithPreselected(selectElement, preselectedValues) {
                if (preselectedValues && preselectedValues.length > 0) {
                    $.ajax({
                        url: "{{ route(auth()->user()->type . '.state_city') }}", // same endpoint as used for AJAX search
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            sel: preselectedValues
                        },
                        success: function(data) {
                            console.log(data.items);
                            $.each(data.items, function(index, item) {
                                console.log('id '+item.id + 'text '+ item.text );
                                var newOption = new Option(item.text, item.id, true, true);
                                selectElement.append(newOption);
                            });
                            selectElement.trigger('change')
                        }
                    });
                }
            }

            var originSelect = $('.origin-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Origin (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            });

            originSelect.on('select2:select', function (e) {
                var selectedOption = e.params.data.id;
                var selectedOptions = originSelect.val() || [];
                $('input[name="dho"]').val(150);
                $('input[name="dho"]').removeAttr('disabled');
                // Check if the selected option is a city or a state
                if (selectedOption.startsWith('city_')) {
                    $('input[name="dho"]').val(150);
                    $('input[name="dho"]').removeAttr('disabled');
                    selectedOptions = selectedOptions.filter(function (item) {
                        return item.startsWith('city_') === false && item.startsWith('state_') === false;
                    });
                    selectedOptions.push(selectedOption); // Keep the newly selected city
                } else if (selectedOption.startsWith('state_')) {
                    $('input[name="dho"]').val('');
                    $('input[name="dho"]').attr('disabled','disabled');
                    selectedOptions = selectedOptions.filter(function (item) {
                        return item.startsWith('city_') === false;
                    });
                    selectedOptions.push(selectedOption); // Add the newly selected state
                }
                originSelect.val(selectedOptions).trigger('change');
            });
            populateSelect2WithPreselected(originSelect,preselectedOrigin);


            // $('.origin-multiple').on('change', function() {
            //     var selectedValues = $(this).val();
            //     if (!Array.isArray(selectedValues)) {
            //         selectedValues = [selectedValues];
            //     }

            //     var isCitySelected = false;
            //     $.each(selectedValues, function(index, value) {
            //         if (value.startsWith('city_')) {
            //             isCitySelected = true;
            //         }
            //     });
            //     var isStateSelected = false;
            //     $.each(selectedValues, function(index, value) {
            //         if (value.startsWith('state_')) {
            //             isStateSelected = true;
            //         }
            //     });

            //     if (isCitySelected) {
            //          $('input[name="dho"]').val(150);
            //         $('input[name="dho"]').removeAttr('disabled');
            //         var cityValue = selectedValues.filter(function(value) {
            //             return value.startsWith('city_');
            //         });
            //         $(this).val(cityValue).select2({
            //             maximumSelectionLength: 1,
            //             ajax: getAjaxStateAndCity()
            //         });

            //     } else if(isStateSelected) {
            //         $('input[name="dho"]').val('');
            //         $('input[name="dho"]').attr('disabled','disabled');
            //         $(this).select2({
            //             placeholder: "Origin (City, ST)*",
            //             maximumSelectionLength: 0,
            //             ajax: getAjaxStateAndCity()
            //         });
            //     }
            //     else{
            //          $('input[name="dho"]').val(150);
            //         $('input[name="dho"]').removeAttr('disabled');
            //         $(this).select2({
            //             placeholder: "Origin (City, ST)*",
            //             maximumSelectionLength: 0,
            //             ajax: getAjaxStateAndCity()
            //         });

            //     }
            // });


            // var destinationSelect = $('.destination-multiple').select2({
            //     maximumSelectionLength: 0,
            //     placeholder: "Destination (City, ST)*",
            //     ajax: getAjaxStateAndCity()
            // });


            var destinationSelect = $('.destination-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Destination (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            });

            destinationSelect.on('select2:select', function (e) {
                var selectedOption = e.params.data.id;
                var selectedOptions = destinationSelect.val() || [];
                $('input[name="dhd"]').val(150);
                $('input[name="dhd"]').removeAttr('disabled');
                // Check if the selected option is a city or a state
                if (selectedOption.startsWith('city_')) {
                    $('input[name="dhd"]').val(150);
                    $('input[name="dhd"]').removeAttr('disabled');
                    selectedOptions = selectedOptions.filter(function (item) {
                        return item.startsWith('city_') === false && item.startsWith('state_') === false;
                    });
                    selectedOptions.push(selectedOption); // Keep the newly selected city
                } else if (selectedOption.startsWith('state_')) {
                    $('input[name="dhd"]').val('');
                    $('input[name="dhd"]').attr('disabled','disabled');
                    selectedOptions = selectedOptions.filter(function (item) {
                        return item.startsWith('city_') === false;
                    });
                    selectedOptions.push(selectedOption); // Add the newly selected state
                }
                destinationSelect.val(selectedOptions).trigger('change');
            });

            // $('.destination-multiple').on('change', function() {
            //     var selectedValues = $(this).val();
            //     if (!Array.isArray(selectedValues)) {
            //         selectedValues = [selectedValues];
            //     }

            //     var isCitySelected = false;
            //     $.each(selectedValues, function(index, value) {
            //         if (value.startsWith('city_')) {
            //             isCitySelected = true;
            //         }
            //     });

            //     var isStateSelected = false;
            //     $.each(selectedValues, function(index, value) {
            //         if (value.startsWith('state_')) {
            //             isStateSelected = true;
            //         }
            //     });

            //     if (isCitySelected) {
            //         $('input[name="dhd"]').val(150);
            //         $('input[name="dhd"]').removeAttr('disabled');
            //         var cityValue = selectedValues.filter(function(value) {
            //             return value.startsWith('city_');
            //         });
            //         $(this).val(cityValue).select2({
            //             maximumSelectionLength: 1,
            //             ajax: getAjaxStateAndCity()
            //         });

            //     } else if(isStateSelected) {
            //         $('input[name="dhd"]').val('');
            //         $('input[name="dhd"]').attr('disabled','disabled');
            //         $(this).select2({
            //             placeholder: "Destination (City, ST)*",
            //             maximumSelectionLength: 0,
            //             ajax: getAjaxStateAndCity()
            //         });
            //     }else{
            //         $('input[name="dhd"]').val(150);
            //         $('input[name="dhd"]').removeAttr('disabled');
            //         $(this).select2({
            //             placeholder: "Destination (City, ST)*",
            //             maximumSelectionLength: 0,
            //             ajax: getAjaxStateAndCity()
            //         });

            //     }
            // });

            populateSelect2WithPreselected(destinationSelect, preselectedDestination);

        });
</script>


    <script type="text/javascript">
     $(function() {
        $("form[name='loadFilterform']").validate({
            rules: {
                eq_type_id: {
                    required: true
                },
                "origin[]": {
                    required: function() {
                        // Check if all destination[] fields are empty
                        var isDestinationEmpty = $('select[name="destination[]"] option:selected').length === 0;

                        // Origin is required only if destination[] has no selected options
                        return isDestinationEmpty;
                    }
                },
                "destination[]": {
                    required: function() {
                        // Check if all origin[] fields are empty
                        var isOriginEmpty = $('select[name="origin[]"] option:selected').length === 0;

                        // Destination is required only if origin[] has no selected options
                        return isOriginEmpty;
                    }
                }
            },
            messages: {
                "origin[]": "Please select at least one Origin or Destination.",
                "destination[]": "Please select at least one Origin or Destination.",
                eq_type_id: "Equipment Type is required."
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    });

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "Select Type",
                templateResult: formatOption, // For dropdown items
                templateSelection: formatSelection,
                 escapeMarkup: function(markup) { return markup; }
            });
        });

        function myFunction() {
            $("#loadFilterSubmit").trigger("click");
        }


        function initialize() {
            var options = {
                types: ['(cities)'],
                componentRestrictions: {
                    country: "us"
                }
            };


            var input = document.getElementById('OriginTextField');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                document.getElementById('origin_id').value = place.place_id;
                $('#originLat').val(place.geometry.location.lat());
                $('#originLng').val(place.geometry.location.lng());
                // var lat = place.geometry.location.lat();
                // var lng = place.geometry.location.lng();
                // initMap(lat,lng);
            });
            var input1 = document.getElementById('DestinationTextField');
            var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
            google.maps.event.addListener(autocomplete1, 'place_changed', function() {
                var place1 = autocomplete1.getPlace();
                // console.log(place1.geometry.location.lat());
                document.getElementById('destination_id').value = place1.place_id;
                $('#destinationLat').val(place1.geometry.location.lat());
                $('#destinationLng').val(place1.geometry.location.lng());
                // document.getElementById('destinationLat').value = place.geometry.location.lat();
                // document.getElementById('destinationLng').value = place.geometry.location.lng();
                // var lat = place.geometry.location.lat();
                // var lng = place.geometry.location.lng();
                // initMap(lat,lng);
            });
        }

        // initialize();
        function confirmAction(event, id) {
            event.preventDefault(); // Prevent the default action temporarily

            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to proceed with this action?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#009edd', // Set your preferred confirm button color
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a loader element
                    const loader = document.createElement('span');
                    loader.classList.add('loader');

                    // Create a loading message
                    const loadingMessage = 'Processing...';
                    Swal.fire({
                        title: loadingMessage,
                        text: "Please wait while we process your request.",
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Redirect to the specified route after a short delay (optional)
                    setTimeout(() => {
                        window.location.href = `{{ url(auth()->user()->type . '/book-loads') }}/${id}`;
                    }, 1000); // Adjust the delay as needed
                }
            });
        }


        // let shipmentId;
        // let maxBidRate;

        // function confirmActionBid(event, id, maxRate) {
        //     event.preventDefault(); // Prevent default link behavior
        //     shipmentId = id; // Store shipment ID for later use
        //     maxBidRate = maxRate; // Store max bid rate for later use

        //     // Set the max attribute and oninput function for the bid amount field
        //     const amountInput = document.getElementById("amount");
        //     amountInput.max = maxBidRate;
        //     amountInput.setAttribute('oninput', `limitInputLength(this, ${maxRate.toString().length})`);

        //     openModal(); // Open the modal popup
        // }

        // function openModal() {
        //     document.getElementById("myModal").style.display = "flex";
        // }

        // function closeModal() {
        //     document.getElementById("myModal").style.display = "none";
        // }

        // function submitBidForm(event) {
        //     event.preventDefault(); // Prevent form from submitting immediately

        //     // SweetAlert confirmation
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "Do you want to submit your bid?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#009edd', // Set to your preferred color
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, submit it!',
        //         cancelButtonText: 'No, cancel'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             const amount = document.getElementById("amount").value;

        //             if (!amount || amount > maxBidRate) {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Invalid Amount',
        //                     text: `Please enter a valid bid amount within the allowed range (${maxBidRate}).`
        //                 });
        //                 return;
        //             }

        //             // Redirecting to the desired URL
        //             window.location.href = `{{ url('/trucker/bid-loads') }}/${shipmentId}?amount=${amount}`;
        //         }
        //     });
        // }

        // function limitInputLength(element, maxLength) {
        //     if (element.value.length > maxLength) {
        //         element.value = element.value.slice(0, maxLength);
        //     }
        // }





        
    </script>
@endpush
