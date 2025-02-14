@extends('layouts.app')
@section('content') 
    <style>
        .custom_tag{
            color:black;
        }
    </style>
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            @push('css')
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            @endpush()

            @php
                $top_header1 = ads('search_truck','top_header1');
                $top_header2 = ads('search_truck','top_header2');
                $top_header3 = ads('search_truck','top_header3');
                $top_header4 = ads('search_truck','top_header4');
                $top_header5 = ads('search_truck','top_header5');
            @endphp

            <div class="main-header">
                <h2>Search Trucks</h2>
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

            <form id="truckFilterform"  action="{{route(auth()->user()->type.'.search_trucks')}}" method="GET" name="truckFilterform" enctype="multipart/form-data">
                <div class="card">
                        <div class="formFilters">
                        </br>
                        {{-- <select class="js-data-example-ajax"></select> --}}
                            <div class="left">
                                <div class="fields width-200 selectffs">
                                    <label>Origin</label>
                                    <select class="origin-multiple" name="origin[]" multiple="multiple"></select>
                                    {{-- <input type="text" name="origin" id="OriginTextField" value="{{ app('request')->input('origin') }}"
                                    placeholder="Origin (City, ST, ZIP)*">
                                    <input type="hidden" name="origin_lat" id="originLat" value="{{ app('request')->input('origin_lat') }}" >
                                    <input type="hidden" name="origin_lng" id="originLng" value="{{ app('request')->input('origin_lng') }}">
                                    <input type="hidden" name="origin_id" id="origin_id" value="{{ app('request')->input('origin_id') }}"> --}}
                                </div>
                                <div class="fields width-60">
                                    <label>DH-O</label>
                                    <input type="text" name="dho" value="{{ app('request')->input('dho') ?? 150 }}">
                                </div>
                                <div class="leftright_direc">
                                    <i class="fal fa-long-arrow-right"></i>
                                    <i class="fal fa-long-arrow-left"></i>
                                </div>
                                <div class="fields width-200 selectffs">
                                    <label>Destination</label>
                                    <select class="destination-multiple" name="destination[]" multiple="multiple"></select>
                                    {{-- <input type="text" id="DestinationTextField"  name="destination" value="{{ app('request')->input('destination') }}"
                                    placeholder="Destination (City, ST, ZIP)*">
                                    <input type="hidden" name="destination_lat" id="destinationLat"  value="{{ app('request')->input('destination_lat') }}">
                                    <input type="hidden" name="destination_lng" id="destinationLng"  value="{{ app('request')->input('destination_lng') }}">
                                    <input type="hidden" name="destination_id" id="destination_id"  value="{{ app('request')->input('destination_id') }}"> --}}
                                </div>
                                <div class="fields width-60">
                                    <label>DH-D</label>
                                    <input type="text" name="dhd" value="{{ app('request')->input('dhd') ?? 150 }}">
                                </div>
                            </div>
                            <div class="right">
                                <div class="fields width-210 selectffs">
                                    <label>Equipment Type*</label>
                                    <select class="js-example-basic-multiple" placeholder="Select Type" required name="eq_type_id[]" multiple="multiple">
                                        @foreach ($equipment_types as $equipment_type)
                                        <option value="{{$equipment_type->id}}" {{ app('request')->input('eq_type_id') ?  in_array($equipment_type->id, app('request')->input('eq_type_id') ) ? 'selected="selected"' : ''  :  ''}}  data-prefix="{{ $equipment_type->prefix }}" >{{$equipment_type->name}}</option>
                                        @endforeach
                                      </select>
                                </div>
                                <div class="fields loadselect">
                                    <label>Load Type*</label>
                                    <select name="equipment_details" id="">
                                        <option value="2" {{app('request')->input('equipment_details') == 2 ? 'selected' : '' }} >Full & Partial</option>
                                        <option value="0" {{app('request')->input('equipment_details') == 0 ? 'selected' : '' }}>Full</option>
                                        <option value="1" {{app('request')->input('equipment_details') == 1 ? 'selected' : '' }}>Partial</option>
                                    </select>
                                </div>
                                <div class="fields width-30">
                                    <label>Length</label>
                                    <input type="number" name="length" value="{{app('request')->input('length') }}">
                                </div>
                                <div class="fields width-120">
                                    <label>Weight(lbs)</label>
                                    <input type="number" name="weight" value="{{app('request')->input('weight') }}">
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
                                    <a href="{{route(auth()->user()->type.'.search_trucks')}}" type="button" class="redoIco"><i class="fal fa-redo"></i></a>
                                    <input type="submit" id="loadFilterSubmit"  class="btnSubmit skyblue" value="Search">
                                </div>
                            </div>
                        </div>

                </div>
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="selectfilters">
                            {{-- <div class="truckdet">
                                <select name="load_requirements" onchange="myFunction()" id="">
                                    <option value="0"  {{app('request')->input('load_requirements') == 0 ? 'selected' : '' }}>Both</option>
                                    <option value="1"  {{app('request')->input('load_requirements') == 1 ? 'selected' : '' }}>Trucking Required</option>
                                    <option value="2"  {{app('request')->input('load_requirements') == 2 ? 'selected' : '' }}>Trucking not Required</option>
                                </select>

                            </div> --}}
                            <div class="fields searchback width-120">
                                <label>Search Back - </label>
                                <input type="number" name="searchback" value="{{app('request')->input('searchback') ? app('request')->input('searchback') : '24' }}">
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
                            {{-- <div class="companyselect">
                                <select name="bid" id="" onchange="myFunction()" >
                                    <option value="0" {{app('request')->input('bid') == 0 ? 'selected' : '' }}>All</option>
                                    <option value="1" {{app('request')->input('bid') == 1 ? 'selected' : '' }}>Only Bid</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-8">
                        @if(isset($top_header4) && isset($top_header5))
                        <div class="row">
                            <div class="col-md-6">
                                <div class="advertisments">
                                    <a href="{{$top_header4->url}}" target="_blank" title=""><img src="{{asset($top_header4->image)}}" alt=""></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="advertisments">
                                    <a href="{{$top_header5->url}}" target="_blank" title=""><img src="{{asset($top_header5->image)}}" alt=""></a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="searchresultMain">
                    <div class="left">
                        <div class="resultsCount">
                             <a href="javascript:void(0)" class="refresh-img" onclick="refreshPage()"><img src="{{asset('/assets/images/icons/arrows-rotate-solid.png')}}" alt="Refresh Icon"/></a>
                            <div class="countCont">
                                <h3>{{count($trucks)}} Results</h3>
                                {{-- <p>Similar Results</p> --}}
                            </div>
                        </div>
                        {{-- <p>Sort by <span>Age - Newest</span></p> --}}
                    </div>
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
                            {{-- <th class="trip">Trip <i class="fal fa-arrow-up"></i></th> --}}
                            <th class="origin">Origin <i class="fal fa-arrow-up"></i></th>
                             <th class="dh">DH-0 <i class="fal fa-arrow-up"></i></th> 
                            <th class="destination">Destination <i class="fal fa-arrow-up"></i></th>
                             <th class="dh">DH-D <i class="fal fa-arrow-up"></i></th>
                            <th class="equipment">Equipment</th>
                            <th class="company">Company</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trucks as $k => $truck)
                        <tr data-child-value="{{$truck}}">
                            <td class="details-control"></td>
                            <td class="age details-control"><strong>{{$truck->created_at->diffForHumans()}}</strong></td>
                            <td class="rate details-control">{{$truck->rate ? '$'.$truck->rate : '-' }}</i></td>
                            <td class="available details-control">
                                {{ Carbon\Carbon::create($truck->from_date)->format('m/d') }}
                                {{ $truck->from_date != null ? '- ' . Carbon\Carbon::create($truck->to_date)->format('m/d') : '' }}</td>
                            {{-- <td class="trip details-control">-</td> --}}
                            <td class="origin details-control">{{ $truck->origin }}</td>
                            <td class="dh details-control">{{ $truck->dho != null || $truck->dho == 0   ? $truck->dho : '-'}} </td>
                            <td class="destination details-control">{{ $truck->destination }}</i></td>
                            <td class="dh details-control">{{$truck->dhd != null || $truck->dhd == 0 ? $truck->dhd : '-'}} </td> 
                            <td class="equipment details-control"> <p>{{ $truck->equipment_name }}<br>{{ $truck->weight }} lbs.
                                {{ $truck->length }} ft -
                                {{ $truck->equipment_detail}}</p></td>

                                @php
                                     $company = null;
                                    if($truck->user){
                                        if($truck->user->parent_id != null){
                                            $company = App\Models\Company::where('user_id',$truck->user->parent_id)->first();
                                        }else{
                                            $company = App\Models\Company::where('user_id', $truck->user->id)->first();
                                        }
                                    }

                                @endphp

                            <td class="company details-control"><p class="bluecols">{{ $company ? $company->name : '-' }} <br>
                                {{ $company ?  $company->phone : '-' }} - {{$company->mc != null ?  $company->mc : $company->dot}}
                            </p></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $trucks->appends(request()->query())->links() !!}
                <hr>
                @if(isset($include_trucks) != false)
                  @php
                        $includ_trucks = $include_trucks->paginate(25,['*'], 'includePagination');

                        $includ_trucks->getCollection()->transform(function ($includ_truck) use ($org_lat ,  $org_lng , $des_lng , $des_lat) {

                            $includ_truck['status'] = $includ_truck->status == "WAITING" ? "PENDING" : $includ_truck->status;
                             if($includ_truck->user->parent_id != null){
                                    $company = \App\Models\Company::where('user_id', $includ_truck->user->parent_id)->first();
                            }else{
                                $company = \App\Models\Company::where('user_id', $includ_truck->user->id)->first();
                            }
                            $includ_truck['company_name'] = $company ? $company->name : '';
                            $includ_truck['company_phone'] = $company ?  $company->phone : '';
                            $includ_truck['company_mc'] =  $company ? $company->mc : null;
                            $includ_truck['company_dot'] =  $company ? $company->dot : null;
                            $includ_truck['status_phone'] = $includ_truck->status_phone == 1 ? $includ_truck->user ? $includ_truck->user->phone : null : null;
                            $includ_truck['status_email'] = $includ_truck->status_email == 1 ? $includ_truck->user ? $includ_truck->user->email : null : null;
                            $includ_truck['company_address'] =   $company ? $company->address : '';
                            $includ_truck['equipment_name'] = $includ_truck->trucks->equipment_type ?   $includ_truck->trucks->equipment_type->name : '';
                            $includ_truck['weight'] = $includ_truck->trucks ?   $includ_truck->trucks->weight : '';
                            $includ_truck['length'] = $includ_truck->trucks ?   $includ_truck->trucks->length : '';
                            $includ_truck['equipment_detail'] = $includ_truck->trucks->equipment_detail ==  "0" ?  'Full' : 'Partial';
                            $includ_truck['reference_id'] = $includ_truck->trucks ?   $includ_truck->trucks->reference_id != null ? $includ_truck->trucks->reference_id != null : '-' : '-';
                            $includ_truck['comment'] =  $includ_truck->comment != null ? $includ_truck->comment : '-' ;
                            $includ_truck['dho'] = $org_lat != null && $org_lat != null ?  (int)get_meters_between_points($includ_truck->origin_lat, $includ_truck->origin_lng, $org_lat, $org_lng) : null;
                            $includ_truck['dhd'] = $des_lat != null && $des_lat != null ?  (int)get_meters_between_points($includ_truck->destination_lat, $includ_truck->destination_lng, $des_lat, $des_lng) : null;


                            return $includ_truck;
                        });
                    @endphp
                @endif
                <div class="searchresultMain">
                    <div class="left">
                        <div class="resultsCount">
                            <a href="javascript:void(0)" class="refresh-img" onclick="refreshPage()"><img src="{{asset('/assets/images/icons/arrows-rotate-solid.png')}}" alt="Refresh Icon"/></a>
                                
                            <div class="countCont">
                                <h3>{{ isset($includ_trucks) ? count($includ_trucks) : 0 }} Included Results</h3>
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
                            {{-- <th class="trip">Trip <i class="fal fa-arrow-up"></i></th> --}}
                            <th class="origin">Origin <i class="fal fa-arrow-up"></i></th>
                            <th class="dh">DH-0 <i class="fal fa-arrow-up"></i></th>
                            <th class="destination">Destination <i class="fal fa-arrow-up"></i></th>
                            <th class="dh">DH-D <i class="fal fa-arrow-up"></i></th>
                            <th class="equipment">Equipment</th>
                            <th class="company">Company</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($include_trucks) != false)
                            @foreach ($includ_trucks as $k => $includ_truck)
                                <tr data-child-value="{{ $includ_truck }}">
                                    <td class="details-control"></td>
                                    <td class="age details-control"><strong>{{ $includ_truck->created_at->diffForHumans() }}</strong></td>
                                    <td class="rate details-control">{{$includ_truck->rate ? '$'.$includ_truck->rate : '-'}}</i></td>
                                    <td class="available details-control">
                                        {{ Carbon\Carbon::create($includ_truck->from_date)->format('m/d') }}
                                        {{ $includ_truck->from_date != null ? '- ' . Carbon\Carbon::create($includ_truck->to_date)->format('m/d') : '' }}
                                    </td>
                                    {{-- <td class="trip details-control">-</td> --}}
                                    <td class="origin details-control">{{ $includ_truck->origin }}</td>
                                    
                                     <td class="dh details-control">{{$includ_truck->dho != null || $includ_truck->dho == 0 ? $includ_truck->dho : '-'}} </td>
                                    <td class="destination details-control">{{ $includ_truck->destination }}</i></td>
                                     <td class="dh details-control">{{$includ_truck->dhd != null || $includ_truck->dhd == 0   ? $includ_truck->dhd : '-'}} </td>
                                    <td class="equipment details-control">
                                        <p>{{ $includ_truck->equipment_name }}<br>{{ $includ_truck->weight }} lbs.
                                            {{ $includ_truck->length }} ft -
                                            {{ $includ_truck->equipment_detail}}</p>
                                    </td>
                                    <td class="company details-control">
                                        <p class="bluecols">{{ $includ_truck['company_name'] }} <br>
                                            {{ $includ_truck['company_phone'] }} - {{ $includ_truck['company_mc'] != null ? $includ_truck['company_mc'] : $includ_truck['company_dot']  }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @if(isset($include_trucks) != false)
                    {!! $includ_trucks->appends(request()->query())->links() !!}
                @endif
                @push('js')
                <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                <script>
                    function format(value) {
                        console.log(value);
                            var eq_detail = value.equipment_detail;
                             var ht =
                                    `<div class="itemsDetails">
                                        <div class="headSearchs">
                                            <h3>`+ value.origin +`</h3>
                                            <div class="searchdir">
                                                <i></i>
                                                <div class="bar"></div>
                                                <i class="fill"></i>
                                            </div>
                                            <h3>`+ value.destination +`</h3>
                                        </div>
                                        <div class="tableData">
                                            <div class="thead">
                                              <div></div>
                                                <div></div>
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
                                                        <h4>`+ value.origin +`</h4>
                                                        <p>`+ value.from_date +`
                                                            -
                                                            `+ value.to_date +`
                                                        </p>
                                                    </div>
                                                    <div class="innlist">
                                                        <div class="minimumrate_det">
                                                            <span></span>
                                                            <span></span>
                                                        </div>
                                                        <div class="minimumrate_det">
                                                            <span></span>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <div class="innlist">
                                                        <p>`+ value.company_name +` <br>
                                                            <a href="tel:`+ value.company_phone +`"
                                                                title="">`+ value.company_phone +`</a><br>`;
                                                                 if(value.company_mc != null){
                                                                      ht += `MC# ` + value.company_mc + `/<br>`;
                                                                }else{
                                                                     ht += `DOT# ` + value.company_dot + `/<br>`;
                                                                }
                                                                
                                                                 ht +=  value.company_address +`<br>
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
                                                        <h4>`+ value.destination +`</h4>
                                                        <p>`+ value.from_date +`
                                                            -
                                                            `+ value.to_date +`
                                                        </p>
                                                        <div class="equipmentsDv">
                                                            <h5>Equipment</h5>
                                                            <ul>
                                                                <li>
                                                                    <span>Load</span>
                                                                    <span>`+  eq_detail  +` </span>
                                                                </li>
                                                                <li>
                                                                    <span>Equipment</span>
                                                                    <span>`+ value.equipment_name +`</span>
                                                                </li>
                                                                <li>
                                                                    <span>Length</span>
                                                                    <span> `+ value.length   +` ft. </span>
                                                                </li>
                                                                <li>
                                                                    <span>Weight</span>
                                                                    <span> `+ value.weight +`  lbs.</span>
                                                                </li>
                                                                <li>
                                                                    <span>Reference ID</span>
                                                                    <span>`+ value.reference_id +` </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="comments">
                                                            <h5>Comments</h5>
                                                            <p>`+ value.comment +`</p>
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
                        $(document).ready(function () {
                            var table = $('#example').DataTable({
                                info: false,
                                ordering: true,
                                paging: false,
                                searching: false
                            });

                            // Add event listener for opening and closing details
                            $('#example').on('click', 'td.details-control', function () {
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

                        $(document).ready(function () {
                            var table = $('#example1').DataTable({
                                info: false,
                                ordering: true,
                                paging: false,
                                searching: false
                            });

                            // Add event listener for opening and closing details
                            $('#example1').on('click', 'td.details-control', function () {
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
    <<script>
        $('.js-data-example-ajax').select2({
            ajax: {
                url: "{{ route(auth()->user()->type . '.state_city') }}", // POST route
                type: 'POST',
                dataType: 'json',
                delay: 250,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for security
                },
                data: function (params) {
                    return {
                        q: params.term // Send the search term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.items // Use the data returned from the backend
                    };
                },
                cache: true
            },
            placeholder: 'Search for a state or city',
            minimumInputLength: 1
        });
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI&libraries=places">
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">


        $(function() {
            $("form[name='truckFilterform']").validate({
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
            
        //   $('.js-example-basic-multiple').on('select2:open', function() {
        //         // Wait for the dropdown to render
        //         setTimeout(function() {
        //             // Select the dropdown items (li elements)
        //             $('.select2-results__option').each(function() {
        //                 let optionText = $(this).text(); // Get the text of the option
        //                 let lastAlphabetMatch = optionText.match(/[a-zA-Z](?=[^a-zA-Z]*$)/); // Find the last alphabet
            
        //                 if (lastAlphabetMatch) {
        //                     let lastAlphabet = lastAlphabetMatch[0]; // Extract the last alphabet
        //                     let newText = ''; // Initialize the new text
            
        //                     // Rebuild the text with a span for the last alphabet
        //                     for (let i = 0; i < optionText.length; i++) {
        //                         if (optionText[i] === lastAlphabet && optionText.slice(i + 1).match(/^[^a-zA-Z]*$/)) {
        //                             newText += `<span>${optionText[i]}</span>`; // Wrap the last alphabet in a span
        //                         } else {
        //                             newText += optionText[i];
        //                         }
        //                     }
            
        //                     $(this).html(newText); // Update the li element's HTML
        //                 }
        //             });
        //         }, 0); // Delay to ensure dropdown rendering is complete
        //     });
             
        });

        function myFunction() {
            $( "#loadFilterSubmit" ).trigger( "click" );
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
            console.log(place);
            document.getElementById('origin_id').value = place.place_id;
            document.getElementById('originLat').value = place.geometry.location.lat();
            document.getElementById('originLng').value = place.geometry.location.lng();
            // var lat = place.geometry.location.lat();
            // var lng = place.geometry.location.lng();
            // initMap(lat,lng);
        });
        var input1 = document.getElementById('DestinationTextField');
        var autocomplete1 = new google.maps.places.Autocomplete(input1, options);
        google.maps.event.addListener(autocomplete1, 'place_changed', function() {
            var place1 = autocomplete1.getPlace();
            console.log(place1);
            document.getElementById('destination_id').value = place1.place_id;
            document.getElementById('destinationLat').value = place1.geometry.location.lat();
            document.getElementById('destinationLng').value = place1.geometry.location.lng();
            // var lat = place.geometry.location.lat();
            // var lng = place.geometry.location.lng();
            // initMap(lat,lng);
        });
    }

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

            populateSelect2WithPreselected(destinationSelect, preselectedDestination);




    // initialize();
</script>
@endpush

