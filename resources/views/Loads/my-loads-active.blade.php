@extends('layouts.app')
@section('content')
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
        <style>
            table.dataTable td a+a {
                margin-left: 2px;
            }
        </style>
    @endpush

    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>My Loads</h2>
                {{-- <div class="rightBtn">
                <a class="themeBtn skyblue" href="{{route(auth()->user()->type.'.post_a_shipment')}}" tile="">
                    <img src="{{asset('assets/images/icons/shipmenticon.webp')}}" alt="">
                    NEW SHIPMENT
                </a>
            </div> --}}
            </div>
            <div class="contBody">
                {{-- @php
                $top_header1 = ads('my_shipments_active','top_header1');
                $top_header2 = ads('my_shipments_active','top_header2');
                $top_header3 = ads('my_shipments_active','top_header3');
            @endphp --}}

                @if (isset($top_header1) && isset($top_header2) && isset($top_header3))
                    <div class="row mb-3">
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
                <div class="tablescroll">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="tabsShipment">
                                <a data-targetit="open" href="{{ route(auth()->user()->type . '.my_loads') }}"
                                    title="">Open
                                    ({{ $shipment_open_count }})</a>
                                <a class="active" href="javascript:;" title="">Active
                                    ({{ $shipment_active_count }})</a>
                                <a data-targetit="history" href="{{ route(auth()->user()->type . '.my_loads_history') }}"
                                    title="">History ({{ $shipment_history_count }})</a>
                            </div>
                            <div class="filtersBtns">
                                <form action="">
                                <div class="d-flex align-items-center">
                                    <h3>Filter:</h3>
                                    <div class="chckboxs">
                                         @if($PickCount)
                                            @for($i = 1 ; $i <= $PickCount->type_0_count ; $i++)
                                                <div class="items">
                                                    <input type="checkbox" name="PICK-UP-{{$i}}" class="filter-checkbox" 
                                                        id="pick_up_{{$i}}">
                                                    <span class="checkmark">
                                                        {{ $i == 1 ? 'At Pick up' : 'Pick Up ' . $i }}
                                                    </span>
                                                </div>
                                            @endfor
                                        @else
                                            <div class="items">
                                                <input type="checkbox" name="at_pick_up" class="filter-checkbox" id="at_pick_up">
                                                <span class="checkmark">At Pick up</span>
                                            </div>
                                        @endif
                                        <div class="items">
                                            <input type="checkbox" name="dispatched"  class="filter-checkbox">
                                            <span class="checkmark">Dispatched</span>
                                        </div>
        
                                        <div class="items">
                                            <input type="checkbox" name="in_transit"  class="filter-checkbox">
                                            <span class="checkmark">In Transit</span>
                                        </div>
                                        
                                        @if($DropCount)
                                            @for($i = 1 ; $i <= $DropCount->type_1_count ; $i++)
                                                <div class="items">
                                                    <input type="checkbox" name="DROP-OFF-{{$i}}" class="filter-checkbox">
                                                    <span class="checkmark">
                                                        {{ $i == 1 ? 'At Drop off' : 'Drop off ' . $i }}
                                                    </span>
                                                </div>
                                            @endfor
                                        @else
                                            <div class="items">
                                                <input type="checkbox" name="at_drop_off"  class="filter-checkbox">
                                                <span class="checkmark">At Drop Off</span>
                                            </div>
                                        @endif
                                        <div class="items">
                                            <input type="checkbox" name="delivered"  class="filter-checkbox">
                                            <span class="checkmark">Delivered</span>
                                        </div>
                                        <div class="items">
                                            <input type="checkbox" name="declined"  class="filter-checkbox">
                                            <span class="checkmark">Declined</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        <!--<div class="col-md-6">-->
                        <!--    <div class="advertisments">-->
                        <!--        <a href="javascript:;" target="_blank" title=""><img src="{{ asset('assets/images/ad-08.jpg') }}" alt=""></a>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>

                    <div class="card">
                        <div class="box-open showfirst">
                            <div class="tableLayout">
                                <table id="ShipmentTable" class="display csbody dataTable data-table">
                                    <thead>
                                        <tr>
                                            <th>Age</th>
                                            <th>Broker</th>
                                            <th>Available</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Reference</th>
                                            <th>Equipment</th>
                                            <th>Length (ft)</th>
                                            <th>Weight (lbs)</th>
                                            <th>Full/Partial</th>
                                            <th>Rate ($)</th>
                                             {{-- <th>Bids</th> --}}
                                            {{-- <th>Shipment Requests</th> --}}
                                            <th>Status</th>
                                            <th width="100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="NoshipmentImage">
                            <figure>
                                <img class="img-fluid" src="{{asset('assets/images/Illustration-img.webp')}}" alt="">
                </figure>
                <p>
                    <strong>You don't have any shipments</strong>
                    Your posts, bids and booking requests will appear here.
                </p>
            </div> --}}
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>



        <script type="text/javascript">
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ajax: {
                        url: "{{ route(auth()->user()->type . '.my_loads_active') }}",
                        data: function(d) {
                                 $('.filter-checkbox').each(function() {
                                    d[$(this).attr('name')] = $(this).is(":checked") ? true : false;
                                });
                                // d.dispatched = $('input[name="dispatched"]').is(":checked") ? true : false,
                                // d.at_pick_up = $('input[name="at_pick_up"]').is(":checked") ? true : false,
                                // d.in_transit = $('input[name="in_transit"]').is(":checked") ? true : false,
                                // d.at_drop_off = $('input[name="at_drop_off"]').is(":checked") ? true : false,
                                // d.delivered = $('input[name="delivered"]').is(":checked") ? true : false,
                                d.search = $('input[type="search"]').val()
                        }
                    },
                    columns: [{
                            data: 'age',
                            name: 'age'
                        },
                        {
                            data: 'broker',
                            name: 'broker'
                        },
                        {
                            data: 'available',
                            name: 'available'
                        },
                        {
                            data: 'origin',
                            name: 'origin'
                        },
                        {
                            data: 'destination',
                            name: 'destination'
                        },
                        {
                            data: 'reference_id',
                            name: 'reference_id'
                        },
                        {
                            data: 'equipment',
                            name: 'equipment'
                        },
                        {
                            data: 'length',
                            name: 'length'
                        },
                        {
                            data: 'weight',
                            name: 'weight'
                        },

                        {
                            data: 'equipment_detail',
                            name: 'equipment_detail'
                        },
                        {
                            data: 'rate',
                            name: 'rate'
                        }, 


                        
                        // {
                        //     data: 'booked_rate',
                        //     name: 'booked_rate',
                        // },

                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('input[type="checkbox"]').change(function() {
                    table.draw();
                });
            });

            function status_accept_decline(type, id, value) {
                var url = "{{ config('app.url') }}/{{ auth()->user()->type }}/status-accept-decline/" + id + '/?value=' +
                    value +
                    '&type=' + type;

                // Show loader before sending AJAX request
                Swal.fire({
                    title: "Are you sure you want to perform this action?",
                    // html: '<div class="loader" id="loader" style="display:none;"></div>', // Add loader to modal
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, continue",
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    preConfirm: () => {
                        // document.getElementById('loader').style.display = "block"; // Show loader
                        return fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-Token': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    id: id,
                                    value: value
                                })
                            })
                            .then(response => {
                                // document.getElementById('loader').style.display = "none"; // Hide loader after response
                                if (!response.ok) {
                                    throw new Error(response.statusText);
                                }
                                return response.json();
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Request failed: ${error}`);
                            });
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }




            // function status_accept_decline(type , id, value){
            //     Swal.fire({
            //         title: "Are you sure do you really want to perform this action?",
            //         icon: "warning",
            //         showCancelButton: true,
            //         confirmButtonText: "Yes continue",
            //         showLoaderOnConfirm: true,
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             url = '{{ config('app.url') }}/broker/status-accept-decline/'+ id + '?value=' + value + '&type=' + type ;
            //             $.get(url);
            //             $(document).ajaxStop(function(){
            //                 window.location.reload();
            //             });
            //         }
            //     });
            // }
        </script>
    @endpush
@endsection
