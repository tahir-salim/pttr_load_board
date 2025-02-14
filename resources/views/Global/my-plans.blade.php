@extends('layouts.app')
@push('css')
    <style>
        a.BtnSvg {
            display: block;
            position: absolute;
            right: 0;
            top: 0;
            z-index: 999;
        }

        a.BtnSvg svg {
            width: 8px;
        }

        .UserDropdown {
            position: relative;
        }

        .UserDropdown-menu {
            background-color: #fff;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            position: absolute;
            right: 0;
            top: 24px;
            display: none;
            padding: 1rem
        }

        .UserDropdown-menu a+a {
            border-top: 1px solid #dedede;
        }
    </style>
@endpush
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>My Payment Methods</h2>
            </div>
            <br />
            <div class="contBody">
                @php
                    $top_header1 = ads('Billings', 'top_header1');
                    $top_header2 = ads('Billings', 'top_header2');
                    $top_header3 = ads('Billings', 'top_header3');
                @endphp
    
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
                <br />
                <div class="">
                    <div class="bodyhead">
                        <h3>Saved Credit Cards</h3>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> Please correct the errors in the following fields:<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    @if ($error == 'Phone')
                                        <li>* Please select at least one method of contact to post</li>
                                    @elseif ($error == 'Email')
                                    @else
                                        <li>* {{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        @foreach ($cardDetails as $cardDetail)
                            <div class="col-md-3">
                                <div class="card paymentCardBox">
                                    @if ($cardDetail['is_active'] == 1)
                                        <div class="paymentCat">AUTO PAYMENT CARD</div>
                                    @endif
    
                                    <div class="UserDropdown">
                                        <a href="#" class="BtnSvg">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512">
                                                <path
                                                    d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z" />
                                            </svg>
                                        </a>
                                        <div class="UserDropdown-menu" aria-labelledby="dropdownMenu2">
                                            @if ($cardDetail['is_active'] == 0)
                                                <a class="dropdown-item"
                                                    href="{{ route(auth()->user()->type . '.auto_customer_payment_profile', $cardDetail['payment_profile']) }}">Set
                                                    as auto payment</a>
                                                <a class="dropdown-item"
                                                    href="{{ route(auth()->user()->type . '.delete_customer_payment_profile', $cardDetail['payment_profile']) }}">
                                                    Remove
                                                </a>
                                            @else
                                                <span>You must set another card as the auto payment card before removing this
                                                    one.</span>
                                            @endif
                                            {{-- <a class="dropdown-item"
                                                href="{{ route(auth()->user()->type . '.delete_customer_payment_profile', $cardDetail['payment_profile']) }}">Remove</a> --}}
                                        </div>
                                    </div>
                                    <div class="cardDet">
                                        <figure>
                                            @if ($cardDetail['type'] == 'Visa')
                                                <img src="{{ asset('assets/images/visa-card.png') }}" alt="">
                                            @elseif($cardDetail['type'] == 'MasterCard')
                                                <img src="{{ asset('assets/images/master-card.png') }}" alt="">
                                            @elseif($cardDetail['type'] == 'AmericanExpress')
                                                <img src="{{ asset('assets/images/american-express-cards.png') }}"
                                                    alt="">
                                            @else
                                                <img src="{{ asset('assets/images/dicover-cards.png') }}" alt="">
                                            @endif
                                        </figure>
    
                                        <div class="cont">
                                            <h3>{{ $cardDetail['type'] }} <br><span>{{ $cardDetail['card_number'] }}</span>
                                            </h3>
                                            <p>EXPIRES {{ Carbon\Carbon::parse($cardDetail['expiry_date'])->format('m/y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-3">
                            <div class="card addpaymentMethod">
                                <a href="javascript:;" data-toggle="modal" data-target="#addpaymentcard" title="">ADD
                                    PAYMENT METHOD</a>
                            </div>
                        </div>
                    </div>
    
                </div>
    
                <div class="modal fade paymentcardAddedpop" id="addpaymentcard" data-backdrop="paymentcard"
                    data-keyboard="false" tabindex="-1" aria-labelledby="paymentcardLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route(auth()->user()->type . '.my_plans') }}" class="shipmentDetails"
                                    method="POST">
                                    @csrf
                                    <div class="popBxs">
                                        <h3>Credit Card Details</h3>
                                        <h6>All fields are required</h6>
                                        <div class="notificationsbx">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <p>In order to validate your Credit Card a temporary preauthorization. This will temporarily show on your bank transactions but
                                                should drop off within 7-10 business days.</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="fields cardnumb">
                                                    <input id="creditCard" type="text" class="inpt numberonly" maxlength="19"
                                                        placeholder="Card Number" required name="card_number"
                                                        value="{{ old('card_number') }}">
                                                    <div class="card-row">
                                                        <span class="visa"></span>
                                                        <span class="mastercard"></span>
                                                        <span class="amex"></span>
                                                        <span class="discover"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="fields">
                                                    <input type="text" placeholder="Cardholder Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="fields">
                                                    <label class="posabs">Expiration Month</label>
                                                    <select id="cardMonth" data-ref="cardDate" class="inpt" required
                                                        name="month" value="{{ old('month') }}">
                                                        <option value="" disabled="disabled" selected="selected">Month
                                                        </option>
                                                        <option value="01" {{ old('month') == '01' ? 'selected' : '' }}>
                                                            01 </option>
                                                        <option value="02" {{ old('month') == '02' ? 'selected' : '' }}>
                                                            02 </option>
                                                        <option value="03" {{ old('month') == '03' ? 'selected' : '' }}>
                                                            03 </option>
                                                        <option value="04" {{ old('month') == '04' ? 'selected' : '' }}>
                                                            04 </option>
                                                        <option value="05" {{ old('month') == '05' ? 'selected' : '' }}>
                                                            05 </option>
                                                        <option value="06" {{ old('month') == '06' ? 'selected' : '' }}>
                                                            06 </option>
                                                        <option value="07" {{ old('month') == '07' ? 'selected' : '' }}>
                                                            07 </option>
                                                        <option value="08" {{ old('month') == '08' ? 'selected' : '' }}>
                                                            08 </option>
                                                        <option value="09" {{ old('month') == '09' ? 'selected' : '' }}>
                                                            09 </option>
                                                        <option value="10" {{ old('month') == '10' ? 'selected' : '' }}>
                                                            10 </option>
                                                        <option value="11" {{ old('month') == '11' ? 'selected' : '' }}>
                                                            11 </option>
                                                        <option value="12" {{ old('month') == '12' ? 'selected' : '' }}>
                                                            12 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="fields">
                                                    <label class="posabs">Expiration Year</label>
                                                    <select id="cardYear" data-ref="cardDate" class="inpt" required
                                                        name="year">
                                                        <option value="" disabled="disabled" selected="selected">Year
                                                        </option>
                                                        @for ($year = date('Y'); $year <= 2050; $year++)
                                                            <option value="{{ $year }}"
                                                                {{ old('year') == $year ? 'selected' : '' }}>
                                                                {{ $year }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="fields">
                                                    <label class="posabs">Security Code</label>
                                                    <input class="inpt numberonly card-cvc required" type="text"
                                                        id="cardCvv" placeholder="CVV" maxlength="4" name="cvv"
                                                        autocomplete="off" required value="{{ old('cvv') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="popBxs">
                                        <h3>Billing Address</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="First Name" name="first_name"
                                                        value="{{ old('first_name') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Last Name" name="last_name"
                                                        value="{{ old('last_name') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="fields">
                                                    <input type="text" placeholder="Street Address" name="address"
                                                        value="{{ old('address') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select id="country" name="country" required>
                                                        <option value="" disabled="disabled" selected="selected">
                                                            Country</option>
                                                        <option value="233"> USA </option>
                                                        <option value="39"> Canada </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select id="state" name="state" required>
                                                        <option value="" disabled="disabled" selected="selected">State
                                                            / Province</option>
                                                        <!-- Populate states here -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select id="city" name="city" required>
                                                        <option value="" disabled="disabled" selected="selected">City
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" placeholder="Zip / Postal Code" name="zip"
                                                        value="{{ old('zip') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="popBxs">
                                        <h3>Set as Autopay</h3>
                                        <div class="notificationsbx">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <p>Setting a credit card as an autopay method automatically updates your account to
                                                use a credit card as the default payment method.
                                                You can use the Billing and invoices page to change to a different card at any
                                                time, but to change the default payment method for your
                                                account you <strong>must call PTTR Billing</strong></p>
                                        </div>
                                        <div class="requiredtrackField">
                                            <input type="checkbox" id="autopay" name="is_allow_autopayment">
                                            <label for="autopay">
                                                <strong>Set as auto payment</strong>
                                                Your current autopay method is @foreach ($cardDetails as $cardDetail)
                                                    @if ($cardDetail['is_active'] == 1)
                                                        "{{ $cardDetail['type'] . ' ' . $cardDetail['card_number'] }}"
                                                    @endif
                                                @endforeach
                                            </label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const input = document.getElementById('creditCard');
        input.addEventListener('input', function(e) {
            // Remove all non-digit characters  
            let value = e.target.value.replace(/\D/g, '');
            // Format the value as XXXX-XXXX-XXXX-XXXX  
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            e.target.value = formattedValue;
        });

        const input1 = document.getElementById('cardCvv');
        input1.addEventListener('input', function(e) {
            // Remove all non-digit characters  
            let value = e.target.value.replace(/\D/g, '');
            // Format the value as XXXX-XXXX-XXXX-XXXX  
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            e.target.value = formattedValue;
        });

        $(document).ready(function() {
            $('#country').on('change', function() {
                let countryId = $(this).val();
                 var url = "{{ config('app.url') }}/{{ auth()->user()->type }}/get-states/" + countryId;
              
                if (countryId) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#state').empty();
                            $('#state').append(
                                '<option value="" disabled="disabled" selected="selected">State / Province</option>'
                            );
                            $.each(data, function(key, value) {
                                $('#state').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching states:', error);
                        }
                    });
                } else {
                    $('#state').empty();
                    $('#state').append(
                        '<option value="" disabled="disabled" selected="selected">State / Province</option>'
                    );
                }
            });
        });

        $(document).ready(function() {
            $('#state').on('change', function() {
                let stateId = $(this).val();
                var url = "{{ config('app.url') }}/{{ auth()->user()->type }}/get-cities/" + stateId;
                if (stateId) {
                    $.ajax({
                        url: url, // Fetch cities based on stateId
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#city').empty();
                            $('#city').append(
                                '<option value="" disabled="disabled" selected="selected">City</option>'
                                );
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching cities:', error);
                        }
                    });
                } else {
                    $('#city').empty();
                    $('#city').append(
                        '<option value="" disabled="disabled" selected="selected">City</option>');
                }
            });
        });



        $('.BtnSvg').on('click', function(e) {
            e.preventDefault();
            $('.UserDropdown-menu').not($(this).next('.UserDropdown-menu')).removeClass('d-block');
            $(this).next('.UserDropdown-menu').toggleClass('d-block');
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get the form, autopay checkbox, and necessary fields
            const form = document.querySelector('form.shipmentDetails');
            const autopayCheckbox = document.getElementById('autopay');

            // Card-related fields
            const creditCardInput = document.getElementById('creditCard');
            const cardMonthInput = document.getElementById('cardMonth');
            const cardYearInput = document.getElementById('cardYear');
            const cardCvvInput = document.getElementById('cardCvv');

            // Billing-related fields
            const firstNameInput = form.querySelector('input[name="first_name"]');
            const lastNameInput = form.querySelector('input[name="last_name"]');
            const addressInput = form.querySelector('input[name="address"]');
            const cityInput = form.querySelector('input[name="city"]');
            const countrySelect = form.querySelector('select[name="country"]');
            const zipInput = form.querySelector('input[name="zip"]');



            // Handle form submission
            form.addEventListener('submit', function(e) {
                const messages = [];
                let valid = true;
                const activeCard = "{{ $activeCard->card_number ?? null }}";

                const cardNumber = creditCardInput.value.replace(/\D/g,
                    ''); // Remove non-numeric characters
                if (cardNumber.length !== 16) {
                    messages.push('Please enter a valid 16-digit credit card number.');
                    valid = false;
                }


                // Check if autopay is checked and active card exists

                if (autopayCheckbox.checked && activeCard) {
                    messages.push('Please set another card as auto-payment before proceeding.');
                    valid = false;
                }

                // Validate Credit Card Number (e.g., 16 digits for Visa/Mastercard)
                // const creditCardValue = creditCardInput.value.trim();
                // const creditCardRegex = /^[0-9]{16}$/; // Modify this for other card types
                // if (!creditCardRegex.test(creditCardValue)) {
                //     messages.push('Please enter a valid 16-digit credit card number.');
                //     valid = false;
                // }

                // Validate Expiration Month and Year
                const cardMonthValue = cardMonthInput.value;
                const cardYearValue = cardYearInput.value;
                if (!cardMonthValue || !cardYearValue) {
                    messages.push('Please select a valid expiration month and year.');
                    valid = false;
                }

                // Validate CVV (e.g., 3 digits for Visa/Mastercard)
                const cardCvvValue = cardCvvInput.value.trim();
                const cardCvvRegex = /^[0-9]{3}$/; // Modify this for Amex if needed
                if (!cardCvvRegex.test(cardCvvValue)) {
                    messages.push('Please enter a valid 3-digit CVV.');
                    valid = false;
                }

                // Validate other required fields
                if (!firstNameInput.value.trim()) {
                    messages.push('First Name is required.');
                    valid = false;
                }
                if (!lastNameInput.value.trim()) {
                    messages.push('Last Name is required.');
                    valid = false;
                }
                if (!addressInput.value.trim()) {
                    messages.push('Street Address is required.');
                    valid = false;
                }
                if (!cityInput.value.trim()) {
                    messages.push('City is required.');
                    valid = false;
                }
                if (!countrySelect.value) {
                    messages.push('Country is required.');
                    valid = false;
                }
                if (!zipInput.value.trim()) {
                    messages.push('Zip/Postal Code is required.');
                    valid = false;
                }

                // If form is not valid, prevent submission and show errors
                if (!valid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: messages.join('<br>'), // Join messages with line breaks
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
@endpush
