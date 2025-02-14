@extends('layouts.app')
@section('content')
    {{--  Search Loads --}}
    <div class="col-md-10">
        <div class="mainBody">

            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
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

                    .loader {
                        border: 2px solid #f3f3f3;
                        border-top: 2px solid #009edd;
                        border-radius: 50%;
                        width: 16px;
                        height: 16px;
                        animation: spin 1s linear infinite;
                        display: inline-block;
                        margin-left: 5px;
                    }

                    @keyframes spin {
                        0% {
                            transform: rotate(0deg);
                        }

                        100% {
                            transform: rotate(360deg);
                        }
                    }
                </style>
            @endpush

            @php

                $top_header1 = ads('search_loads', 'top_header1');

                $top_header2 = ads('search_loads', 'top_header2');

                $top_header3 = ads('search_loads', 'top_header3');

                $center_header4 = ads('search_loads', 'center_header4');

            @endphp

            <div class="main-header">
                <h2>Private Loads</h2>
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
                <br>
                <hr>
                <table id="example" class="display nowrap csbody" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="age">Age <i class="fal fa-arrow-up"></i></th>
                            <th class="rate">Rate <i class="fal fa-arrow-up"></i></th>
                            <th class="available">Available <i class="fal fa-arrow-up"></i></th>
                            <th class="trip">Trip <i class="fal fa-arrow-up"></i></th>
                            <th class="origin">Origin <i class="fal fa-arrow-up"></i></th>
                            {{-- <th class="dh">DH-0 <i class="fal fa-arrow-up"></i></th> --}}
                            <th class="destination">Destination <i class="fal fa-arrow-up"></i></th>
                            {{-- <th class="dh">DH-D <i class="fal fa-arrow-up"></i></th> --}}
                            <th class="equipment">Equipment</th>
                            <th class="company">Company</th>
                            <th class="company">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($private_loads as $k => $shipment)
                            {{-- @dd(config('app.url'),url()) --}}
                            <tr data-child-value="{{ $shipment }}">
                                <td class="details-control"></td>
                                <td class="age details-control">
                                    <strong>{{ $shipment->created_at->diffForHumans() }}</strong></td>
                                <td class="rate details-control">${{ $shipment->private_rate ?? '0' }}</td>
                                <td class="available details-control">
                                    {{ Carbon\Carbon::create($shipment->from_date)->format('m/d') }}
                                    {{ $shipment->from_date != null ? '- ' . Carbon\Carbon::create($shipment->to_date)->format('m/d') : '' }}
                                </td>
                                <td class="trip details-control">{{ $shipment->miles ?? '0' }} mi</td>
                                <td class="origin details-control">{{ $shipment->origin }}</td>
                                {{-- <td class="dh details-control">-</td> --}}
                                <td class="destination details-control">{{ $shipment->destination }}</i></td>
                                {{-- <td class="dh details-control">-</td> --}}
                                <td class="equipment details-control">
                                    <p>{{ $shipment->eq_type }}<br>{{ $shipment->weight }} lbs.
                                        {{ $shipment->length }} ft -
                                        {{ $shipment->equipment_detail == 0 ? 'Full' : 'Partial' }}</p>
                                </td>
                                <td class="company details-control">
                                    <p class="bluecols">{{ $shipment->company->name }} <br>
                                        {{ $shipment->company->phone }} - {{ $shipment->company->mc != null ? $shipment->company->mc : $shipment->company->dot }}
                                    </p>
                                </td>
                                {{-- @dd($shipment->where('id')->max_bid_rate) --}}
                                <td>
                                    @if ($shipment->is_allow_bids == 1)
                                        <a href="#" class="btn btn-outline-info"
                                            onclick="confirmActionBid(event, {{ $shipment->id }}, {{ $shipment->max_bid_rate }})">Bid
                                            Now</a>
                                    @else
                                        <a href="#" class="btn btn-outline-success"
                                            onclick="confirmAction(event, {{ $shipment->id }})">Book Now</a>
                                    @endif
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
                {!! $private_loads->links() !!}

                @push('js')
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                    <script>
                        function format(value) {
                            var eq_detail = value.equipment_detail == 0 ? 'Full' : 'Partial';
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
                                                            <span>$` + value.private_rate + `</span>
                                                        </div>
                                                        <div class="minimumrate_det">
                                                            <span>Trip</span>
                                                            <span>` + value.miles + ` mi</span>
                                                        </div>
                                                        <div class="minimumrate_det">
                                                            <span>Rate/mile</span>
                                                            <span>$` + (value.private_rate / value.miles).toFixed(2) + `</span>
                                                        </div>
                                                        <div class="minimumrate_det">
                                                            <span>Status</span>
                                                            <span>` + value.status + `</span>
                                                        </div>
                                                    </div>
                                                    <div class="innlist">
                                                        <p>` + value.company.name + ` <br>
                                                            <a href="tel:` + value.company.phone + `"
                                                                title="">` + value.company.phone + `</a>
                                                                 <br>`;
                                                                if(value.company.mc != null){
                                                                      ht += `MC# ` + value.company.mc + `/<br>`;
                                                                }else{
                                                                     ht += `DOT# ` + value.company.dot + `/<br>`;
                                                                }
                                                                 ht +=  value.company.address + `<br>
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
                                                                    <span>` + value.equipment_type.name + `</span>
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
                                                            </ul>
                                                        </div>
                                                        <div class="comments">
                                                            <h5>Comments</h5>
                                                            <p>` + value.commodity + `</p>
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
  

    <script type="text/javascript">
       
    
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

        let shipmentId;
        let maxBidRate;

        function confirmActionBid(event, id, maxRate) {
            event.preventDefault(); // Prevent default link behavior
            shipmentId = id; // Store shipment ID for later use
           
            maxBidRate = maxRate; // Store max bid rate for later use

            const amountInput = document.getElementById("amount");

            // Check if maxRate is valid
            if (typeof maxRate !== 'undefined' && maxRate !== null) {
                // Set the max attribute and oninput function for the bid amount field
                amountInput.max = maxBidRate;
                amountInput.setAttribute('oninput', `limitInputLength(this, ${maxRate.toString().length})`);
            } else {
                // Remove max attribute to allow any amount
                amountInput.removeAttribute('max');
                amountInput.setAttribute('maxlength', '10');
                amountInput.setAttribute('oninput', 'limitInputLength(this, 10)');
            }

            openModal(); // Open the modal popup
        }

        function submitBidForm(event) {
            event.preventDefault(); // Prevent form from submitting immediately

            const submitButton = document.querySelector('.submit-btn');
            const loader = document.createElement('span');
            loader.classList.add('loader');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit this bid?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#009edd',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const amount = document.getElementById("amount").value;

                    if (maxBidRate && amount > maxBidRate) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Amount',
                            text: `Please enter an amount within the allowed range of up to ${maxBidRate}.`,
                            confirmButtonColor: '#009edd'
                        });
                        return;
                    }

                    // Disable the submit button and show loader
                    submitButton.disabled = true;
                    submitButton.textContent = 'Submitting...';
                    submitButton.appendChild(loader);

                    // Simulate form submission (replace this with actual form submission logic)
                    setTimeout(() => {
                        window.location.href =
                            `{{ url(auth()->user()->type . '/bid-loads') }}/${shipmentId}?amount=${amount}`;
                    }, 400);
                }
            });
        }



        function openModal() {
            document.getElementById("myModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        function limitInputLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        }
    </script>
@endpush
