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

                    .paging_full_numbers {
                        margin-left: 1308px;
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

                    .dataTable colgroup {
                        display: none;
                    }

                    .dt-paging .dt-paging-button {
                        color: #007bff;
                        /* Custom color */
                        background-color: #f8f9fa;
                        /* Background color */
                        border: 1px solid #ddd;
                        /* Border */
                    }

                    .dt-paging .dt-paging-button:hover {
                        color: #ffffff;
                        background-color: #007bff;
                    }
                </style>
            @endpush()

            @php

                $top_header1 = ads('search_loads', 'top_header1');

                $top_header2 = ads('search_loads', 'top_header2');

                $top_header3 = ads('search_loads', 'top_header3');

                $center_header4 = ads('search_loads', 'center_header4');

            @endphp

            <div class="main-header">
                <h2>Search Loads</h2>
            </div>
            <div class="contBody">
                @if (isset($top_header1) && isset($top_header2) && isset($top_header3))
                    <div class="row">
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{ $top_header1->url }}" target="_blank" title=""><img
                                        src="{{ asset($top_header1->image) }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{ $top_header2->url }}" target="_blank" title=""><img
                                        src="{{ asset($top_header2->image) }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{ $top_header3->url }}" target="_blank" title=""><img
                                        src="{{ asset($top_header3->image) }}" alt=""></a>
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

                <div class="parentTabs py-4">
                    <div class="tabsWrapper">
                        <div class="searchfilteropt active">
                            <div class="searchitems">
                                <span id="tab_origin">New Location 1</span>
                                <div class="searchdir">
                                    <i></i>
                                    <div class="bar"></div>
                                    <i class="fill"></i>
                                </div>
                                <span id="tab_destination">New Location 1</span>
                                <div class="iconsfilters">
                                    {{-- <i class="fal fa-bell-slash"></i> --}}
                                    <i class="far fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="addedTabs">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="navArrows">
                        <i class="fas fa-chevron-left"></i>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="tab-data" id="data-New">
                    <form id="loadFilterform" action="{{ route(auth()->user()->type . '.search_loads') }}" method="GET"
                        name="loadFilterform" enctype="multipart/form-data">
                        <div class="card">
                            <div class="formFilters">
                                <div class="left">
                                    <div class="fields width-200 selectffs">
                                        {{-- @dd(app('request')->input('origin') , app('request')->input('destination') ); --}}
                                        <label>Origin</label>
                                        {{-- <input type="text" name="origin" id="OriginTextField" value="" hidden placeholder="Origin (City, ST, ZIP)*" autocomplete="off" class="pac-target-input"> --}}
                                        <select class="origin-multiple" name="origin[]" multiple="multiple"></select>
                                        <input type="hidden" name="origin_lat" id="originLat" value="32.776665">
                                        <input type="hidden" name="origin_lng" id="originLng" value="-96.796989">
                                        <input type="hidden" name="origin_id" id="origin_id"
                                            value="ChIJS5dFe_cZTIYRj2dH9qSb7Lk">
                                        <label id="origin[]-error" class="error" for="origin[]"
                                            style="display: none"></label>
                                        {{-- <input type="text" name="origin" id="OriginTextField"
                                        value="{{ app('request')->input('origin') }}" placeholder="Origin (City, ST, ZIP)*">


                                        {{-- <select name="" id="">
                                        <option value="">Select City</option>
                                        <option value="">Select City</option>
                                    </select> --}}
                                    </div>
                                    <div class="fields width-60" id="dho">
                                        <label>DH-O</label>
                                        <input type="text" name="dho" class="dho"
                                            value="{{ app('request')->input('dho') ?? 150 }}">
                                    </div>
                                    <div class="leftright_direc">
                                        <i class="fal fa-long-arrow-right"></i>
                                        <i class="fal fa-long-arrow-left"></i>
                                    </div>
                                    <div class="fields width-200 selectffs">
                                        <label>Destination</label>
                                        <select class="destination-multiple" name="destination[]"
                                            multiple="multiple"></select>
                                        <input type="hidden" name="destination_lat" id="destinationLat" value="37.774929">
                                        <input type="hidden" name="destination_lng" id="destinationLng"
                                            value="-122.419418">
                                        <input type="hidden" name="destination_id" id="destination_id"
                                            value="ChIJIQBpAG2ahYAR_6128GcTUEo">
                                        <label id="origin[]-error" class="error" for="origin[]"
                                            style="display: none"></label>
                                        {{-- <input type="text" id="DestinationTextField" required name="destination"
                                        value="{{ app('request')->input('destination') }}"
                                        placeholder="Destination (City, ST, ZIP)*">
                                     --}}
                                        {{-- <select name="" id="">
                                        <option value="">Select City</option>
                                        <option value="">Select City</option>
                                    </select> --}}
                                    </div>
                                    <div class="fields width-60" id="dhd">
                                        <label>DH-D</label>
                                        <input type="text" name="dhd" class="dhd"
                                            value="{{ app('request')->input('dhd') ?? 150 }}">
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="fields width-210">
                                        <label>Equipment Type*</label>
                                        <select class="EquipmentType js-example-basic-multiple" placeholder="Select Type"
                                            required name="eq_type_id[]" multiple="multiple">
                                            @foreach ($equipment_types as $equipment_type)
                                                <option value="{{ $equipment_type->id }}"
                                                    data-prefix="{{ $equipment_type->prefix }}"
                                                    {{ app('request')->input('eq_type_id') ? (in_array($equipment_type->id, app('request')->input('eq_type_id')) ? 'selected="selected"' : '') : '' }}>
                                                    {{ $equipment_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="fields loadselect">
                                        <label>Load Type*</label>
                                        <select name="equipment_details" id="">
                                            <option value="2"
                                                {{ app('request')->input('equipment_details') == 2 ? 'selected' : '' }}>
                                                Full &
                                                Partial</option>
                                            <option value="0"
                                                {{ app('request')->input('equipment_details') == 0 ? 'selected' : '' }}>
                                                Full
                                            </option>
                                            <option value="1"
                                                {{ app('request')->input('equipment_details') == 1 ? 'selected' : '' }}>
                                                Partial
                                            </option>
                                        </select>
                                    </div>
                                    <div class="fields width-30">
                                        <label>Length</label>
                                        <input type="number" name="length"
                                            value="{{ app('request')->input('length') }}">
                                    </div>
                                    <div class="fields width-120">
                                        <label>Weight(lbs)</label>
                                        <input type="number" name="weight"
                                            value="{{ app('request')->input('weight') }}">
                                    </div>
                                    <div class="fields">
                                        <label>Date Range</label>
                                        <div class="daterange">
                                            <input type="date" name="from_date"
                                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ app('request')->input('from_date') ?? Carbon\Carbon::now()->format('Y-m-d') }}"
                                                required max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                            <input type="date" name="to_date"
                                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ app('request')->input('to_date') ?? Carbon\Carbon::now()->format('Y-m-d') }}"
                                                required max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="submitbtns">
                                        <a href="javascript:;" onclick="selectree()" type="button" class="redoIco"><i
                                                class="fal fa-redo"></i></a>
                                        <input type="submit" id="loadFilterSubmit" class="btnSubmit skyblue"
                                            value="Search">



                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="selectfilters">
                                    <div class="truckdet">
                                        <select name="load_requirements" onchange="myFunction()" id="">
                                            <option value="2"
                                                {{ app('request')->input('load_requirements') == null || app('request')->input('load_requirements') == '2' ? 'selected' : '' }}>
                                                Both</option>
                                            <option value="1"
                                                {{ app('request')->input('load_requirements') == '1' ? 'selected' : '' }}>
                                                Tracking Required</option>
                                            <option value="0"
                                                {{ app('request')->input('load_requirements') == '0' ? 'selected' : '' }}>
                                                Tracking not Required</option>
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
                                            <option value="0"
                                                {{ app('request')->input('bid') == 0 ? 'selected' : '' }}>All
                                            </option>
                                            <option value="1"
                                                {{ app('request')->input('bid') == 1 ? 'selected' : '' }}>Only Bid
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if (isset($center_header4))
                                <div class="col-md-4">
                                    <div class="advertisments">
                                        <a href="{{ $center_header4->url }}" target="_blank" title=""><img
                                                src="{{ asset($center_header4->image) }}" alt=""></a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="searchresultMain">
                            <div class="left">
                                <div class="resultsCount">
                                    <a href="javascript:;" class="refresh_datatable refresh-img" data-ajax-url=""> <img
                                            src="{{ asset('/assets/images/icons/arrows-rotate-solid.png') }}"
                                            alt="Refresh Icon" /></a>
                                    <div class="countCont">
                                        <h3>0 Results</h3>
                                        {{-- <p>Similar Results</p> --}}
                                    </div>
                                </div>
                                {{-- <p>Sort by <span>Age - Newest</span></p> --}}
                            </div>
                            <input type="hidden" name="page">

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

                            tr.shown td:first-child.details-control {
                                background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
                            }
                        </style>
                    @endpush
                    <div class="MainTableWrapper">
                        <table id="example" class="TableXX display nowrap csbody" cellspacing="0" width="100%">
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
                            <tbody class="TBodyNew" id="tbody_id">

                                <div id="append_modal"></div>
                                <div id="append_pagination" class="append_pagination">
                                    {!! $shipments->appends(request()->query())->links() !!}
                                </div>
                            </tbody>

                        </table>

                    </div>
                    <hr>
                    <div class="included_table_div">
                        <div class="searchresultMain">
                            <div class="left">
                                <div class="resultsCount">
                                    <a href="javascript:;" class="refresh-img included_table_refresh">
                                        <img src="{{ asset('/assets/images/icons/arrows-rotate-solid.png') }}"
                                            alt="Refresh Icon" />
                                    </a>
                                    <div class="countCont includeCont">

                                        <h3>0 Included
                                            Results</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="RelatedTableWrapper">
                            <table id="example1" class="included_table display nowrap csbody" cellspacing="0"
                                width="100%">
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

                                <div id="append_included_table_pagination" class="append_included_table_pagination">
                                    @if ($included_ships != null)
                                        {!! $included_ships->appends(request()->query())->links() !!}
                                    @endif
                                </div>
                                <div id="append_additional_modal"></div>


                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        {{-- @endif --}}
                    </div>
                </div>

                @push('js')
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


                    <script>
                        function resetFormFields(tabData) {
                            tabData.find('input, select, textarea').not('input[type="submit"]').val('').prop('checked', false).each(
                                function() {
                                    var type = $(this).attr('type');

                                    if (type === 'checkbox' || type === 'radio') {
                                        $(this).prop('checked', false); // Uncheck checkboxes and radios
                                    } else {
                                        $(this).val(''); // Reset value for text, number, and other inputs
                                    }
                                });

                            tabData.find('select').each(function() {
                                if ($(this).hasClass('select2-hidden-accessible')) {
                                    $(this).val(null).trigger('change'); // Reset Select2 to default
                                } else {
                                    $(this).prop('selectedIndex', 0); // Reset regular select
                                }
                            });

                            // Reset select elements explicitly
                            tabData.find('select').prop('selectedIndex', 0); // Reset to the first option

                            // Clear date inputs
                            tabData.find('input[type="date"]').val('');

                            return true;
                        }

                        function showTabData(tab, tabData) {
                            $('.searchfilteropt').removeClass('active');
                            tab.addClass('active');
                            $('.tab-data').hide();
                            tabData.show();
                        }

                        function toggleArrows() {
                            var totalTabs = $('.searchfilteropt').length;
                            if (totalTabs > 5) {
                                $('.navArrows').addClass('show');
                            } else {
                                $('.navArrows').removeClass('show');
                            }
                        }

                        function scrollToLastTab() {
                            var totalTabs = $('.searchfilteropt').length;
                            if (totalTabs > 5) {
                                var wrapper = $('.tabsWrapper');
                                var totalWidth = 0;
                                $('.searchfilteropt').each(function() {
                                    totalWidth += $(this).outerWidth(true);
                                });
                                var lastTabOffset = totalWidth - wrapper.width();
                                wrapper.animate({
                                    scrollLeft: lastTabOffset
                                }, 300);
                            }
                        }

                        $('.navArrows .fa-chevron-left').click(function() {
                            var currentPos = $('.tabsWrapper').scrollLeft();
                            $('.tabsWrapper').animate({
                                scrollLeft: currentPos - 200
                            }, 300);
                        });

                        $('.navArrows .fa-chevron-right').click(function() {
                            var currentPos = $('.tabsWrapper').scrollLeft();
                            $('.tabsWrapper').animate({
                                scrollLeft: currentPos + 200
                            }, 300);
                        });

                        function ensureFirstTabVisible() {
                            var totalTabs = $('.searchfilteropt').length;
                            if (totalTabs > 0) {
                                $('.searchfilteropt').first().find('.searchitems span:first').trigger('click');
                            }
                        }

                        $('.searchfilteropt').first().find('.searchitems span:first').trigger('click');

                        $(".searchfilteropt:first").click(function() {
                            $(this).addClass("active").siblings().removeClass('active');
                            $("#data-New").show();
                            $(".tab-data").next().hide();
                        });

                        function removePageParam(url) {
                            // Create a URL object for easy manipulation
                            let urlObj = new URL(url);

                            // Remove all instances of the 'page' parameter
                            urlObj.searchParams.delete('page');

                            // Return the updated URL as a string
                            return urlObj.toString();
                        }

                        function change_page(next_page_url, pageID) {
                            let updatedUrl = removePageParam(next_page_url) + '&page=' + pageID;
                            let url = new URL(updatedUrl, window.location.href);
                            let page = pageID;

                            // Check if the page input already exists; if not, add it
                            let form = $('.tab-data:visible form[name="loadFilterform"]');
                            let pageInput = form.find('input[name="page"]');

                            if (pageInput.length === 0) {
                                pageInput = $('<input>').attr('type', 'hidden').attr('name', 'page').val(page);
                                form.append(pageInput);
                            } else {
                                // Update the existing input's value
                                pageInput.val(page);
                                console.log(pageInput.val());

                            }

                            // Update the form action and submit
                            form.attr('action', next_page_url);

                            form.submit();
                            return true;
                        }
                        function change_page_inc(next_page_url, pageID) {
                            let updatedUrl = removePageParam(next_page_url) + '&includePagination=' + pageID;
                            let url = new URL(updatedUrl, window.location.href);
                            let page = pageID;

                            // Check if the page input already exists; if not, add it
                            let form = $('.tab-data:visible form[name="loadFilterform"]');
                            let pageInput = form.find('input[name="includePagination"]');

                            if (pageInput.length === 0) {
                                pageInput = $('<input>').attr('type', 'hidden').attr('name', 'includePagination').val(page);
                                form.append(pageInput);
                            } else {
                                // Update the existing input's value
                                pageInput.val(page);
                                console.log(pageInput.val());

                            }

                            // Update the form action and submit
                            form.attr('action', next_page_url);

                            form.submit();
                            return true;
                        }

                        function format(value) {

                            if (value.company_mc != null) {
                                var companyMC = 'MC# ' + value.company_mc;
                            } else if (value.company_mc != null && value.company_dot) {
                                var companyMC = 'MC# ' + value.company_mc + '<br>' + 'DOT# ' + value.company_dot;
                            } else if (value.company_dot != null) {
                                var companyMC = 'DOT# ' + value.company_dot;
                            }

                            var eq_detail = value.equipment_detail == 0 ? 'Full' : 'Partial';
                            var origin = value.origin || 'N/A'; // Fallback to 'N/A' if origin is undefined or null
                            var destination = value.destination || 'N/A'; // Fallback to 'N/A' if destination is undefined or null
                            var fromDate = value.from_date ? moment(value.from_date).format('MM/DD') :
                                'N/A'; // Format using moment.js if not null
                            var toDate = value.to_date ? moment(value.to_date).format('MM/DD') :
                                'N/A'; // Format using moment.js if not null
                            var companyName = value.company_name || 'N/A'; // Fallback for company_name
                            var companyPhone = value.company_phone || 'N/A'; // Fallback for company_phone
                            var companyAddress = value.company_address || 'N/A'; // Fallback for company_address
                            var equipmentName = value.equipment_name || 'N/A'; // Fallback for equipment_name
                            var length = value.length || 'N/A'; // Fallback for length
                            var weight = value.weight || 'N/A'; // Fallback for weight
                            var referenceId = value.reference_id || 'N/A'; // Fallback for reference_id
                            var commodity = value.commodity || 'N/A'; // Fallback for commodity

                            var ht = `
                                        <div class="itemsDetails">
                                             <div class="headSearchs">
                                                  <h3>${origin}</h3>
                                                  <div class="searchdir">
                                                       <i></i>
                                                       <div class="bar"></div>
                                                       <i class="fill"></i>
                                                  </div>
                                                  <h3>${destination}</h3>
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
                                                            <h4>${origin}</h4>
                                                            <p>${fromDate} - ${toDate}</p>
                                                       </div>
                                                       <div class="innlist">
                                                            <div class="minimumrate_det">
                                                                 <span>Total</span>
                                                                 <span>$${value.dat_rate}</span>
                                                            </div>
                                                            <div class="minimumrate_det">
                                                                 <span>Trip</span>
                                                                 <span>${value.miles} mi</span>
                                                            </div>
                                                            <div class="minimumrate_det">
                                                                 <span>Rate/mile</span>
                                                                 <span>$${(value.dat_rate / value.miles).toFixed(2)}</span>
                                                            </div>
                                                            <div class="minimumrate_det">
                                                                 <span>Status</span>
                                                                 <span>${value.status}</span>
                                                            </div>
                                                       </div>
                                                       <div class="innlist">
                                                            <p>${companyName} <br>
                                                                 <a href="tel:${companyPhone}" title="">${companyPhone}</a><br>
                                                                  ${companyMC} /<br>
                                                                 ${companyAddress}<br>
                                                                 <span>
                                                                      <div class="stars">`;
                                                                        if (value.rating) {
                                                                            if (value.rating > 4.00) {
                                                                                ht += `<i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>`;
                                                                            } else if (value.rating > 3.00) {
                                                                                ht += `<i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>`;
                                                                            } else if (value.rating > 2.00) {
                                                                                ht += `<i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>`;
                                                                            } else if (value.rating > 1.00) {
                                                                                ht += `<i class="fas fa-star"></i>
                                                                                    <i class="fas fa-star"></i>`;
                                                                            } else if (value.rating > 0.00) {
                                                                                ht += `<i class="fas fa-star"></i>`;
                                                                            }else{
                                                                                ht += `No Rating`;
                                                                            }
                                                                        }else{
                                                                            ht += `No Rating`;
                                                                        }
                                                                      ht +=  `</div>
                                                                      （${value.rating != null ? value.rating : 0}）
                                                                 </span>
                                                            </p>
                                                       </div>
                                                       </div>
                                                       <div class="Inneritems">
                                                       <div class="innlist">
                                                            <h4>${destination}</h4>
                                                            <p>${fromDate} - ${toDate}</p>
                                                            <div class="equipmentsDv">
                                                                 <h5>Equipment</h5>
                                                                 <ul>
                                                                      <li>
                                                                           <span>Load</span>
                                                                           <span>${eq_detail}</span>
                                                                      </li>
                                                                      <li>
                                                                           <span>Equipment</span>
                                                                           <span>${equipmentName}</span>
                                                                      </li>
                                                                      <li>
                                                                           <span>Length</span>
                                                                           <span>${length} ft.</span>
                                                                      </li>
                                                                      <li>
                                                                           <span>Weight</span>
                                                                           <span>${weight} lbs.</span>
                                                                      </li>
                                                                      <li>
                                                                           <span>Reference ID</span>
                                                                           <span>${referenceId}</span>
                                                                      </li>
                                                                 </ul>
                                                            </div>
                                                            <div class="comments">
                                                                 <h5>Comments</h5>
                                                                 <p>${commodity}</p>
                                                            </div>
                                                       </div>

                                                        <div class="innlist">
                                                        <h4> Contact Information </h4>
                                                                 <div class="equipmentsDv">
                                                                      <ul>`;
                            if (value.status_phone != null) {
                                ht += `<li>
                                                                                     <span>Phone</span>
                                                                                     <span>` + value.status_phone + ` </span>
                                                                                </li>`;
                            }
                            if (value.status_email != null) {
                                ht += `<li>
                                                                                          <span>Email</span>
                                                                                          <span>` + value
                                    .status_email + `</span>
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
                            function get_pagination(links, search_url) {
                                $('.tab-data:visible .append_pagination').html('');

                                if (links == 'no_data') {
                                    return false;
                                    $('.tab-data:visible .append_pagination').html('');
                                }
                                $('.tab-data:visible .append_pagination').append(
                                    `<nav>
                                             <ul class="pagination">
                                                  ${links.map(link => {
                                                       let urlParams = new URL(link.url, window.location.href);
                                                       let page = urlParams.searchParams.get('page');
                                                       return `<li class="page-item ${link.active ? 'active' : ''}">
                                                                                                            ${link.url ? `<a class="page-link" href="javascript:;" data-url="${search_url}&page=${page}" onclick="change_page('${search_url}&page=${page}', ${page})" class="change_exacttable_page">${link.label}</a>` : `<span class="page-link">${link.label}</span>`}
                                                                                                       </li>`;
                                                  }).join('')}
                                             </ul>
                                        </nav>`
                                );
                            }

                            function get_included_pagination(links, search_url) {
                                $('.tab-data:visible .append_included_table_pagination').html('');

                                if (links == 'no_data') {
                                    return false;
                                    $('.tab-data:visible .append_included_table_pagination').html('');
                                }
                                $('.tab-data:visible .append_included_table_pagination').append(
                                    `<nav>
                                             <ul class="pagination">
                                                  ${links.map(link => {
                                                       let urlParams = new URL(link.url, window.location.href);
                                                       let page = urlParams.searchParams.get('includePagination');
                                                       return `<li class="page-item ${link.active ? 'active' : ''}">
                                                                                                                                                 ${link.url ? `<a class="page-link" href="javascript:;" data-url="${search_url}&includePagination=${page}" onclick="change_page_inc('${search_url}&includePagination=${page}', ${page})" class="change_exacttable_page">${link.label}</a>` : `<span class="page-link">${link.label}</span>`}
                                                                                                                                                </li>`;
                                                  }).join('')}
                                             </ul>
                                        </nav>`
                                );
                            }
                            var table;
                            //    var table = $('.TableXX').DataTable({
                            //        info: false,
                            //        ordering: true,
                            //        paging: false,
                            //        searching: false
                            //    });

                            //    var included_table = $('.included_table').DataTable({
                            //        info: false,
                            //        ordering: true,
                            //        paging: false,
                            //        searching: false
                            //    });

                            var new_included_table_id = $('.included_table:visible').attr('id');
                            var new_table_id = $('.TableXX:visible').attr('id');

                            // Add event listener for opening and closing details
                            $(document).on("click", "td.details-control", function(e) {
                                var tableID = $(this).closest('table').attr('id');
                                var new_table = $('#' + tableID).DataTable();
                                var tr = $(this).closest('tr');
                                var row = new_table.row(tr);
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
                            //    $('#' + new_included_table_id).on('click', 'td.details-control', function() {

                            //        var new_table = $('#' + new_included_table_id).DataTable();
                            //        var tr = $(this).closest('tr');
                            //        var row = new_table.row(tr);
                            //        if (row.child.isShown()) {
                            //            // This row is already open - close it
                            //            row.child.hide();
                            //            tr.removeClass('shown');
                            //        } else {
                            //            // Open this row
                            //            row.child(format(tr.data('child-value'))).show();
                            //            tr.addClass('shown');
                            //        }
                            //    });
                            //    const LoadDataTable = () => {
                            //        var table = $('#example').DataTable({
                            //            info: false,
                            //            ordering: true,
                            //            paging: false,
                            //            searching: false
                            //        });
                            //    }

                            //    const LoadInlcudedDataTable = () => {
                            //        var table2 = $('.tab-data:visible .included_table').DataTable({
                            //            info: false,
                            //            ordering: true,
                            //            paging: false,
                            //            searching: false
                            //        });
                            //    }



                            $('.tab-data form[name="loadFilterform"]').validate({
                                rules: {
                                    "eq_type_id[]": {
                                        required: true
                                    },
                                    "origin[]": {
                                        required: function() {
                                            // Check if all destination[] fields are empty
                                            var isDestinationEmpty = $(
                                                    '.tab-data form[name="loadFilterform"] select[name="destination[]"] option:selected'
                                                )
                                                .length === 0;
                                            console.log(isDestinationEmpty);
                                            // Origin is required only if destination[] has no selected options
                                            return isDestinationEmpty;
                                        }
                                    },
                                    "destination[]": {
                                        required: function() {
                                            // Check if all origin[] fields are empty
                                            var isOriginEmpty = $(
                                                    '.tab-data form[name="loadFilterform"] select[name="origin[]"] option:selected'
                                                ).length ===
                                                0;

                                            // Destination is required only if origin[] has no selected options
                                            return isOriginEmpty;
                                        }
                                    }
                                },
                                messages: {
                                    "origin[]": "Please select at least one Origin or Destination.",
                                    "destination[]": "Please select at least one Origin or Destination.",
                                    "eq_type_id[]": "Equipment Type is required."
                                },

                            });



                            $(document).on("submit", ".tab-data:visible form[name='loadFilterform']", function(e) {
                                e.preventDefault();

                                // if ($('.tab-data:visible .origin-multiple option:selected').length === 0) {
                                //     $('.tab-data:visible .error').css('display', 'block');
                                //     $('.tab-data:visible #origin\\[\\]-error').html(
                                //         'Please select at least one Origin or Destination 1.');
                                //     return false;
                                // } else {
                                //     $('.tab-data:visible .error').css('display', 'none');
                                // }
                                
                                var new_table_id = $('.TableXX:visible').attr('id');
                                $('#' + new_table_id).DataTable().destroy();

                                var originText = $('.tab-data:visible .origin-multiple option:selected').text();
                                originText = originText.trim() !== '' ? originText : 'Anywhere'; // Default if empty

                                var destinationText = $('.tab-data:visible .destination-multiple option:selected').text();
                                destinationText = destinationText.trim() !== '' ? destinationText :
                                    'Anywhere'; // Default if empty
                               
                               
                               
                                var Orgi_txt = $('.tab-data:visible .origin-multiple option:selected').text();
                                var Dest_txt = $('.tab-data:visible .destination-multiple option:selected').text();
                               
                               
                                if (Dest_txt === "Anywhere" && Orgi_txt === "") {
                                    alert("Origin is required if you select 'Anywhere' in Destination.");
                                    return false;
                                }
                                else if (Orgi_txt === "Anywhere" && Dest_txt === "") {
                                    alert("Destination is required if you select 'Anywhere' in Origin.");
                                    return false;
                                }
                                else if (Orgi_txt === "" && Dest_txt === "" ) {
                                    alert("Please select at least one Origin or Destination.");
                                    return false;
                                }
                                else if (Orgi_txt === "Anywhere" && Dest_txt === "Anywhere" ) {
                                    alert("You cannot select 'Anywhere' in both Origin and Destination.");
                                    return false;
                                }
                                
                                
                                
                                
                                // Update the tab with origin and destination
                                $('.active #tab_origin').text(originText);
                                $('.active #tab_destination').text(destinationText);
                                
                                
                                    
                                    
                                    

                                var new_related_table_id = $('.included_table:visible').attr('id');
                                $('#' + new_related_table_id).DataTable().destroy();

                                $('.active #tab_destination').css('display', 'block');
                                //   $('.searchdir:visible').css('display', 'block');
                                $('.searchitems .searchdir').show();

                                // $('.tab-data:visible .btnSubmit').click(function(){
                                //     alert('js');
                                //     var ajax_url = '{{ route(auth()->user()->type . '.search_loads') }}'
                                // });
                                try {
                                    var btnClicked = e.originalEvent.submitter;
                                    if (btnClicked && btnClicked.value === 'Search') {
                                        var ajax_url = '{{ route(auth()->user()->type . '.search_loads') }}';
                                    }
                                } catch (error) {
                                    var ajax_url = $('.tab-data:visible form[name="loadFilterform"]').attr("action");
                                }
                                var form1 = $(this).serialize();
                                $.ajax({
                                    url: ajax_url,
                                    type: 'get',
                                    data: form1,
                                    cache: false,
                                    contentType: false, //must, tell jQuery not to process the data
                                    processData: false,
                                    success: function(response) {
                                        var table = $('#' + new_table_id).DataTable({
                                            info: false,
                                            ordering: true, // Enable search functionality
                                            paging: false, // Enable pagination
                                            searching: false,
                                            dom: 'rtip'
                                        });
                                        table.clear().draw();
                                        $('.resultsCount:visible .countCont').html('<h3>' + response
                                            .shipments_count + ' Results</h3>');
                                        if (response.shipments_count > 0) {
                                            get_pagination(response.shipments.links, response.search_url);
                                            $.each(response.shipments.data, function(key, shipment) {
                                                let dhoValue = shipment.dho !== null && shipment.dho !==
                                                    0 ?
                                                    shipment.dho : '-';
                                                let tableCell =
                                                    `<td class="dh details-control">${dhoValue}</td>`;


                                                let dhdValue = shipment.dhd !== null && shipment.dhd !==
                                                    0 ?
                                                    shipment.dhd : '-';
                                                let dhdtableCell =
                                                    `<td class="dhd details-control">${dhdValue}</td>`;

                                                var rowHtml = `
                                                                <tr data-child-value="${JSON.stringify(shipment).replace(/"/g, "&quot;")}">
                                                                    <td class="details-control"></td>
                                                                    <td class="age details-control">
                                                                        <strong>${moment(shipment.created_at).fromNow()}</strong>
                                                                    </td>
                                                                    <td class="rate details-control">$${shipment.dat_rate ?? '0'}</td>
                                                                    <td class="available details-control">
                                                                        ${moment(shipment.from_date).format('MM/DD')}
                                                                            -
                                                                        ${moment(shipment.to_date).format('MM/DD')}
                                                                    </td>
                                                                    <td class="trip details-control">${shipment.miles ?? '0'} mi</td>
                                                                    <td class="origin details-control">${shipment.origin}</td>
                                                                    <td class="dh details-control">${shipment.dho ?? 0}</td>

                                                                    <td class="destination details-control">${shipment.destination}</td>
                                                                    <td class="dh details-control">${shipment.dhd ?? 0}</td>
                                                                    <td class="equipment details-control">
                                                                        <p>${shipment.equipment_name}<br>${shipment.weight} lbs. ${shipment.length} ft - ${shipment.equipment_detail == 0 ? 'Full' : 'Partial'}</p>
                                                                    </td>
                                                                    <td class="company details-control">
                                                                        <p class="bluecols">${shipment.company_name ?? ''} <br>
                                                                            ${shipment.company_phone} - ${shipment.company_mc}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="btn btn-outline-success" onclick="confirmAction(event,${shipment.id})">Book Now</a>
                                                                    </td>
                                                                </tr>
                                                                <div id="myModal_${shipment.id}" class="modal">
                                                                    <div class="modal-content">
                                                                    <span class="close" onclick="closeModal(${shipment.id})">&times;</span>
                                                                    <h2>Create Bid</h2>
                                                                    <form id="bidForm_${shipment.id}" onsubmit="submitBidForm(event)">
                                                                        <label for="amount">Bid Amount:</label>
                                                                        <input type="number" id="amount" name="amount" required
                                                                            max="99999" oninput="limitInputLength(this, 5)"
                                                                            placeholder="Enter bid amount">
                                                                        <button type="submit" class="submit-btn">Submit</button>
                                                                    </form>
                                                                    </div>
                                                                </div>
                                                        `;


                                                $('#append_modal').append(`
                                                                <div id="myModal_${shipment.id}" class="modal" style="display:none;">
                                                                    <div class="modal-content">
                                                                        <span class="close" onclick="closeModal(${shipment.id})">&times;</span>
                                                                        <h2>Create Bid</h2>
                                                                        <form id="bidForm_${shipment.id}" onsubmit="submitBidForm(event)">
                                                                            <label for="amount">Bid Amount:</label>
                                                                            <input type="number" id="amount" name="amount" required
                                                                                    max="99999" oninput="limitInputLength(this, 5)"
                                                                                    placeholder="Enter bid amount">
                                                                            <button type="submit" class="submit-btn">Submit</button>
                                                                        </form>
                                                                    </div>
                                                                </div>`)
                                                // $('#tbody_id').append(rowHtml);
                                                table.row.add($(rowHtml)).draw();

                                                return format(shipment);
                                            });
                                        } else {
                                            get_pagination('no_data', 0);
                                        }

                                        var new_included_table_id = $('.included_table:visible').attr('id');

                                        var new_included_table = $('#' + new_included_table_id).DataTable({
                                            info: false,
                                            ordering: true, // Enable search functionality
                                            paging: false, // Enable pagination
                                            searching: false,
                                            dom: 'rtip'
                                        });
                                        new_included_table.clear().draw();

                                        $('.resultsCount:visible .includeCont').html('<h3>' + response
                                            .included_ships_count + ' Results</h3>');
                                        console.log(response.included_ships_count);

                                        if (response.included_ships_count > 0) {
                                            get_included_pagination(response.included_ships.links, response
                                                .search_url);
                                            $.each(response.included_ships.data, function(key, shipment) {

                                                let dhoValue = shipment.dho !== null && shipment.dho !==
                                                    0 ?
                                                    shipment.dho : '-';
                                                let tableCell =
                                                    `<td class="dh details-control">${dhoValue}</td>`;


                                                let dhdValue = shipment.dhd !== null && shipment.dhd !==
                                                    0 ?
                                                    shipment.dhd : '-';
                                                let dhdtableCell =
                                                    `<td class="dhd details-control">${dhdValue}</td>`;

                                                var rowHtml2 = `
                                                                <tr data-child-value="${JSON.stringify(shipment).replace(/"/g, "&quot;")}">
                                                                    <td class="details-control"></td>
                                                                    <td class="age details-control">
                                                                        <strong>${moment(shipment.created_at).fromNow()}</strong>
                                                                    </td>
                                                                    <td class="rate details-control">$${shipment.dat_rate ?? '0'}</td>
                                                                    <td class="available details-control">
                                                                        ${moment(shipment.from_date).format('MM/DD')}
                                                                            -
                                                                        ${moment(shipment.to_date).format('MM/DD')}
                                                                    </td>
                                                                    <td class="trip details-control">${shipment.miles ?? '0'} mi</td>
                                                                    <td class="origin details-control">${shipment.origin}</td>
                                                                    <td class="dh details-control">${shipment.dho ?? 0}</td>
                                                                    <td class="destination details-control">${shipment.destination}</td>
                                                                    <td class="dh details-control">${shipment.dhd ?? 0}</td>
                                                                    <td class="equipment details-control">
                                                                        <p>${shipment.equipment_name}<br>${shipment.weight} lbs. ${shipment.length} ft - ${shipment.equipment_detail == 0 ? 'Full' : 'Partial'}</p>
                                                                    </td>
                                                                    <td class="company details-control">
                                                                        <p class="bluecols">${shipment.company_name ?? ''} <br>
                                                                            ${shipment.company_phone} - ${shipment.company_mc}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="btn btn-outline-success" onclick="confirmAction(event,${shipment.id})">Book Now</a>
                                                                    </td>
                                                                </tr>
                                                    `;
                                                $('#append_additional_modal').append(`
                                                        <div id="myModal_${shipment.id}" class="modal" style="display:none;">
                                                                    <div class="modal-content">
                                                                    <span class="close" onclick="closeModal(${shipment.id})">&times;</span>
                                                                    <h2>Create Bid</h2>
                                                                    <form id="bidForm_${shipment.id}" onsubmit="submitBidForm(event)">
                                                                        <label for="amount">Bid Amount:</label>
                                                                        <input type="number" id="amount" name="amount" required
                                                                            max="99999" oninput="limitInputLength(this, 5)"
                                                                            placeholder="Enter bid amount">
                                                                        <button type="submit" class="submit-btn">Submit</button>
                                                                    </form>
                                                                    </div>
                                                                </div>`)
                                                // $('#tbody_id').append(rowHtml);
                                                new_included_table.row.add($(rowHtml2)).draw();
                                                return format(shipment)
                                            });
                                        } else {
                                            get_included_pagination('no_data', 0);
                                        }
                                        initializeValidator('.tab-data:visible form[name="loadFilterform"]');
                                        //  format(shipments)
                                    }
                                });

                            });
                        });
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


    <style>
        .formFilters .select2-container {
            width: 100% !important;
        }
    </style>
    {{-- // Origin Dropdown --}}
    <script>

function initializeValidator(formSelector) {
                console.log("=======" + $.data($(formSelector)[0]));

                //  if ($.data($(formSelector)[0], 'validator')) {
                //     alert('s');

                    $(formSelector).validate().destroy();
                // }

                // Reinitialize validation
                $(formSelector).validate({
                    rules: {
                        "eq_type_id[]": {
                            required: true
                        },
                        "origin[]": {
                            required: function() {


                                var isDestinationEmpty = $(formSelector +
                                    ' select[name="destination[]"] option:selected').length === 0;
                                return isDestinationEmpty;
                                console.log(isDestinationEmpty);
                            }
                        },
                        "destination[]": {
                            required: function() {
                                var isOriginEmpty = $(formSelector + ' select[name="origin[]"] option:selected')
                                    .length === 0;
                                return isOriginEmpty;
                            }
                        }
                    },
                    messages: {
                        "eq_type_id[]": "Equipment Type is required.",
                        "origin[]": "Please select at least one Origin or Destination.",
                        "destination[]": "Please select at least one Origin or Destination."
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element);
                    },
                });
            }

         $('.tabsWrapper').on('click', '.searchfilteropt', function () {
            var preselectedOrigin = {!! json_encode(app('request')->input('origin')) !!};
            var preselectedDestination = {!! json_encode(app('request')->input('destination')) !!};
        });
        
        
        function selectree() {
            $(".tab-data:visible .origin-multiple").parent().find('.select2-container--default').remove();
            $(".tab-data:visible .destination-multiple").parent().find('.select2-container--default').remove();
            $(".tab-data:visible .js-example-basic-multiple").parent().find('.select2-container--default').remove();

            var preselectedOrigin = {!! json_encode(app('request')->input('origin')) !!};
            var preselectedDestination = {!! json_encode(app('request')->input('destination')) !!};

            var originSelect = $('.origin-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Origin (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            }).on('select2:open', function () {
                // Remove the style attribute
                $(this).removeAttr('style');
            });

            var destinationSelect = $('.destination-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Destination (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            }).on('select2:open', function () {
                // Remove the style attribute
                $(this).removeAttr('style');
            });

            var originSelect = $('.tab-data:visible .origin-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Origin (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            }).on('select2:open', function () {
                // Remove the style attribute
                $(this).removeAttr('style');
            });
            var destinationSelect = $('.tab-data:visible .destination-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Destination (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            }).on('select2:open', function () {
                // Remove the style attribute
                $(this).removeAttr('style');
            });
            
             initializeValidator('.tab-data:visible form[name="loadFilterform"]');
            //   $('.tab-data:visible .js-example-basic-multiple').select2({
            //       placeholder: "Select Type",
            //       templateResult: formatOption, // For dropdown items
            //       templateSelection: formatSelection,
            //       escapeMarkup: function(markup) {
            //           return markup;
            //       }
            //   });


            // On page load
           


            var EquipmentTypeSelect = $('.EquipmentType').select2({
                placeholder: "Select Type",
                templateResult: formatOption, // For dropdown items
                templateSelection: formatSelection,
                escapeMarkup: function(markup) {
                    return markup;
                }
            });
            $(".tab-data:visible .js-example-basic-multiple").val("");
            $(".tab-data:visible .js-example-basic-multiple").trigger("change");

            $(".tab-data:visible .origin-multiple").val("");
            $(".tab-data:visible .origin-multiple").trigger("change");

            $(".tab-data:visible .destination-multiple").val("");
            $(".tab-data:visible .destination-multiple").trigger("change");

            $('.tab-data:visible input[name="dho"]').removeAttr('disabled');
            $('.tab-data:visible input[name="dho"]').val(150);

            $('.tab-data:visible input[name="dhd"]').removeAttr('disabled');
            $('.tab-data:visible input[name="dhd"]').val(150);

            originSelect.on('select2:select', function(e) {
                var selectedOption = e.params.data.id;
                var selectedOptions = originSelect.val() || [];
                $('.tab-data:visible input[name="dho"]').val(150);
                $('.tab-data:visible input[name="dho"]').removeAttr('disabled');
                // Check if the selected option is a city or a state
                if (selectedOption.startsWith('city_')) {
                    $('.tab-data:visible input[name="dho"]').val(150);
                    $('.tab-data:visible input[name="dho"]').removeAttr('disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
                        return item.startsWith('city_') === false && item.startsWith('state_') ===
                            false;
                    });
                    selectedOptions.push(selectedOption); // Keep the newly selected city
                } else if (selectedOption.startsWith('state_')) {
                    $('.tab-data:visible input[name="dho"]').val('');
                    $('.tab-data:visible input[name="dho"]').attr('disabled', 'disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
                        return item.startsWith('city_') === false;
                    });
                    selectedOptions.push(selectedOption); // Add the newly selected state
                }
                originSelect.val(selectedOptions).trigger('change');
            });

            destinationSelect.on('select2:select', function(e) {
                var selectedOption = e.params.data.id;
                var selectedOptions = destinationSelect.val() || [];
                $('input[name="dhd"]').val(150);
                $('input[name="dhd"]').removeAttr('disabled');
                // Check if the selected option is a city or a state
                if (selectedOption.startsWith('city_')) {
                    $('input[name="dhd"]').val(150);
                    $('input[name="dhd"]').removeAttr('disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
                        return item.startsWith('city_') === false && item.startsWith('state_') ===
                            false;
                    });
                    selectedOptions.push(selectedOption); // Keep the newly selected city
                } else if (selectedOption.startsWith('state_')) {
                    $('input[name="dhd"]').val('');
                    $('input[name="dhd"]').attr('disabled', 'disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
                        return item.startsWith('city_') === false;
                    });
                    selectedOptions.push(selectedOption); // Add the newly selected state
                }
                destinationSelect.val(selectedOptions).trigger('change');
            });

            $(document).on('blur', '.tab-data:visible .dho', function() {
                var inputValue = $(this).val();
                if (inputValue === null || inputValue === '') {
                    $(this).val(150);
                }
            });

            $('.tab-data:visible .dho').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\D/g, '');
                if (inputValue.length > 3) {
                    inputValue = inputValue.slice(0, 3);
                }
                $(this).val(inputValue);
            });

            $('input[name="dhd"]').blur(function() {
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


            //
            $(document).on('blur', '#dho:visible .dho, input[name="dho"]', function() {
                var inputValue = $(this).val();
                if (inputValue === null || inputValue === '') {
                    $(this).val(150);
                }
            });

            $('#dhd:visible .dhd, input[name="dhd"]').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\D/g, '');
                if (inputValue.length > 3) {
                    inputValue = inputValue.slice(0, 3);
                }
                $(this).val(inputValue);
            });

            $('input[name="dhd"]').blur(function() {
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

        }

        $('.tab-data:visible form[name="loadFilterform"]').attr('action', '{{ route(auth()->user()->type . '.search_loads') }}');

        $(document).ready(function() {


            var preselectedOrigin = {!! json_encode(app('request')->input('origin')) !!};
            var preselectedDestination = {!! json_encode(app('request')->input('destination')) !!};

            $('input[name="searchback"]').blur(function() {
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

            $(document).on('blur', '#dho:visible .dho, input[name="dho"]', function() {
                var inputValue = $(this).val();
                if (inputValue === null || inputValue === '') {
                    $(this).val(150);
                }
            });

            $('#dho:visible .dho, input[name="dho"]').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\D/g, '');
                if (inputValue.length > 3) {
                    inputValue = inputValue.slice(0, 3);
                }
                $(this).val(inputValue);
            });

            $('input[name="dhd"]').blur(function() {
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
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.items, function(item) {
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
                            $.each(data.items, function(index, item) {
                                var newOption = new Option(item.text, item.id, true, true);
                                selectElement.append(newOption);
                            });
                            selectElement.trigger('change')
                        }
                    });
                }
            }





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


            var originSelect = $('.origin-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Origin (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            });

            originSelect.on('select2:select', function(e) {
                var selectedOption = e.params.data.id;
                var selectedOptions = originSelect.val() || [];
                $('.tab-data:visible input[name="dho"]').val(150);
                $('.tab-data:visible input[name="dho"]').removeAttr('disabled');
                // Check if the selected option is a city or a state
                if (selectedOption.startsWith('city_')) {
                    $('.tab-data:visible input[name="dho"]').val(150);
                    $('.tab-data:visible input[name="dho"]').removeAttr('disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
                        return item.startsWith('city_') === false && item.startsWith('state_') ===
                            false;
                    });
                    selectedOptions.push(selectedOption); // Keep the newly selected city
                } else if (selectedOption.startsWith('state_')) {
                    $('.tab-data:visible input[name="dho"]').val('');
                    $('.tab-data:visible input[name="dho"]').attr('disabled', 'disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
                        return item.startsWith('city_') === false;
                    });
                    selectedOptions.push(selectedOption); // Add the newly selected state
                }
                originSelect.val(selectedOptions).trigger('change');
            });

            populateSelect2WithPreselected(originSelect, preselectedOrigin);
            var destinationSelect = $('.destination-multiple').select2({
                maximumSelectionLength: 0,
                placeholder: "Destination (City, ST)*",
                ajax: getAjaxStateAndCity(),
                closeOnSelect: true
            });

            destinationSelect.on('select2:select', function(e) {
                var selectedOption = e.params.data.id;
                var selectedOptions = destinationSelect.val() || [];
                $('input[name="dhd"]').val(150);
                $('input[name="dhd"]').removeAttr('disabled');
                // Check if the selected option is a city or a state
                if (selectedOption.startsWith('city_')) {
                    $('input[name="dhd"]').val(150);
                    $('input[name="dhd"]').removeAttr('disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
                        return item.startsWith('city_') === false && item.startsWith('state_') ===
                            false;
                    });
                    selectedOptions.push(selectedOption); // Keep the newly selected city
                } else if (selectedOption.startsWith('state_')) {
                    $('input[name="dhd"]').val('');
                    $('input[name="dhd"]').attr('disabled', 'disabled');
                    selectedOptions = selectedOptions.filter(function(item) {
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
        $(document).ready(function() {
            $('.tab-data:visible .js-example-basic-multiple').select2({
                placeholder: "Select Type",
                templateResult: formatOption, // For dropdown items
                templateSelection: formatSelection,
                escapeMarkup: function(markup) {
                    return markup;
                }
            });
        });

        function myFunction() {
            // e.preventDefault();
            $(".tab-data:visible, #loadFilterSubmit").submit();
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

        function confirmAction(event, id) {
            // initialize();
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
                        $.ajax({
                            url: `{{ url('/'.auth()->user()->type.'/book-loads') }}/${id}`,
                            method: 'get',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success',
                                    text: "Shipment Request Send Successfuly.",
                                    icon: 'success',
                                })
                                $('.tab-data:visible form[name="loadFilterform"]').validate().destroy();
                                $('.tab-data:visible .btnSubmit').click();
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                            }
                        })
                    }, 1000); // Adjust the delay as needed
                }
            });
        }

        let shipmentId;

        function confirmActionBid(event, id) {

            event.preventDefault(); // Prevent default link behavior
            shipmentId = id; // Store shipment ID for later use
            openModal(shipmentId); // Open the modal popup
        }

        function openModal(shipmentId) {
            $("#myModal_" + shipmentId).css("display", "flex");
        }

        function closeModal(shipmentId) {
            $("#myModal_" + shipmentId).css("display", "none");
        }

        function submitBidForm(event) {
            event.preventDefault(); // Prevent form from submitting immediately

            const userConfirmed = confirm("Are you sure you want to proceed?");

            if (userConfirmed) {
                const amount = document.getElementById("amount").value;

                if (!amount) {
                    alert("Please fill all required fields.");
                    return;
                }
                // Submit form using AJAX or direct window location change
                // Using window.location.href for demonstration

                $.ajax({
                    url: `{{ url('/trucker/bid-loads') }}/${shipmentId}?amount=${amount}`,
                    method: 'get',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert("Big confirmed successfully!");
                        //     window.location.href = "{{ url('/trucker/search-loads') }}";
                    },
                    error: function(xhr, status, error) {
                        alert("Error confirming booking.");
                    }
                })

                //  window.location.href = `{{ url('/trucker/bid-loads') }}/${shipmentId}?amount=${amount}`;
            }
        }



        function limitInputLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        }

        $('.addedTabs').click(function() {

            var newTab = $('.searchfilteropt').first().clone();
            var newTabData = $('.tab-data').first().clone();

            //resetFormFields(newTabData);

            $('.searchfilteropt').last().after(newTab);
            $('.tab-data').last().after(newTabData);

            //newTabData.find('.searchresultMain').hide();
            newTabData.find('.MainTableWrapper').html('');
            newTabData.find('.RelatedTableWrapper').html('');
            //    newTabData.find('.card').last().hide();
            var tabCount = $('.searchfilteropt').length;


            newTab.find('.searchitems span:first').text('New Location ' + tabCount);
            newTab.find('.searchitems .searchdir').hide();
            newTab.find('.searchitems span:last').hide();

            newTabData.attr('id', 'data-New' + tabCount).hide();

            newTab.find('.searchitems').click(function() {
                showTabData(newTab, newTabData);
            });

            newTab.find('.far.fa-times-circle').click(function() {
                var tabToRemove = newTab;
                var tabDataToRemove = newTabData;
                tabToRemove.remove();
                tabDataToRemove.remove();

                toggleArrows();
                ensureFirstTabVisible();

                var remainingTabs = $('.searchfilteropt');
                var remainingTabData = $('.tab-data');
                if (remainingTabs.length > 0) {
                    var lastTab = remainingTabs.last();
                    var lastTabData = remainingTabData.last();
                    showTabData(lastTab, lastTabData);
                }
            });

            //   var originSelect = $('#data-New'+tabCount+' .origin-multiple').select2({
            //       maximumSelectionLength: 0,
            //       placeholder: "Origin (City, ST)*",
            //       ajax: getAjaxStateAndCity(),
            //       closeOnSelect: true
            //   });

            //   var destinationSelect = $('#data-New'+tabCount+' .origin-multiple').select2({
            //       maximumSelectionLength: 0,
            //       placeholder: "Destination (City, ST)*",
            //       ajax: getAjaxStateAndCity(),
            //       closeOnSelect: true
            //   });

            toggleArrows();
            scrollToLastTab();
            showTabData(newTab, newTabData);
            selectree();

            $('#data-New' + tabCount + ' .error').css('display', 'none');


            $('.tab-data:visible .refresh_datatable').parent().find('.countCont h3').html('0 Results');
            $('.tab-data:visible .included_table_refresh').parent().find('.countCont h3').html('0 Results');

            $(document).on("click", '#data-New' + tabCount + ' .refresh_datatable', function(e) {
                $('.tab-data:visible form[name="loadFilterform"]').validate().resetForm();
                //  $(this).closest('.TableXX').DataTable().ajax.reload();
                $('.tab-data:visible form[name="loadFilterform"]').submit();
            })

            $(document).on("click", '#data-New' + tabCount + ' .included_table_refresh', function(e) {
                $('.tab-data:visible form[name="loadFilterform"]').validate().resetForm();
                //  $(this).closest('.TableXX').DataTable().ajax.reload();
                $('.tab-data:visible form[name="loadFilterform"]').submit();
            })
            //   $('.searchfilteropt, .active, .searchitems, #tab_destination').css("display", "block");
            //   $('.searchfilteropt, .active, .searchitems, .searchdir').css("display", "block");

            $('#data-New' + tabCount + ' .TableXX').attr('id', 'new_table' + tabCount);
            $('#data-New' + tabCount + ' .included_table').attr('id', 'newinlcuded_table' + tabCount);

            $('.tab-data:visible .js-example-basic-multiple').select2({
                placeholder: "Select Type",
                templateResult: formatOption, // For dropdown items
                templateSelection: formatSelection,
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            var RawTable = `<table id="new_table` + tabCount + `" class="TableXX display nowrap csbody" cellspacing="0" width="100%">
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
                              <tbody class="TBodyNew" id="tbody_id">

                              </tbody>

                               <div id="append_modal"></div>
                                <div id="append_pagination" class="append_pagination">
                         </table>`;

            var RawTable2 = `<table id="newinlcuded_table` + tabCount + `" class="included_table display nowrap csbody" cellspacing="0" width="100%">
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
                              <tbody class="TBodyNew" id="tbody_id">

                              </tbody>
                              <div id="append_included_table_pagination" class="append_included_table_pagination">

                                </div>
                                <div id="append_additional_modal"></div>
                         </table>`;


            $('.tab-data:visible .MainTableWrapper').append(RawTable);
            var table = $('.tab-data:visible .MainTableWrapper table').DataTable({
                info: false,
                ordering: true, // Enable search functionality
                paging: false, // Enable pagination
                searching: false,
                dom: 'rtip'
            });

            $('.tab-data:visible .RelatedTableWrapper').append(RawTable2);
            var table2 = $('.tab-data:visible .RelatedTableWrapper table').DataTable({
                info: false,
                ordering: true, // Enable search functionality
                paging: false, // Enable pagination
                searching: false,
                dom: 'rtip'
            });

        });

        $(document).ready(function() {

            $('#data-New .refresh_datatable').click(function() {
                //  $(this).closest('.TableXX').DataTable().ajax.reload();
                $('.tab-data:visible form[name="loadFilterform"]').submit();
            })
            $('#data-New .included_table_refresh').click(function() {
                //  $(this).closest('.TableXX').DataTable().ajax.reload();
                $('.tab-data:visible form[name="loadFilterform"]').submit();
            })


            $.fn.dataTable.ext.errMode = 'none';
            $("#example").DataTable({
                info: false,
                ordering: true, // Enable search functionality
                paging: false, // Enable pagination
                searching: false,
                dom: 'rtip'
            });
            $("#example1").DataTable({
                info: false,
                ordering: true, // Enable search functionality
                paging: false, // Enable pagination
                searching: false,
                dom: 'rtip'
            });


        });

        $('.dt-layout-row').remove();
    </script>
@endpush
