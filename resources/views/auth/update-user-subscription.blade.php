@extends('layouts.app')
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
            <div class="contBody">
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
                    <div class="col-md-3">
                        <div class="card paymentCardBox">
                            <div class="paymentCat">AUTO PAYMENT CARD</div>
                            <div class="text-right menuicons">
                                <a href="javascript:;" title="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512">
                                        <path
                                            d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="cardDet">
                                <figure>
                                    <img src="{{asset('assets/images/visa-card.png')}}" alt="">
                                </figure>
                                <div class="cont">
                                    <h3>Visa <span>**** **** **** 6571</span></h3>
                                    <p>EXPIRES 05/28</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card paymentCardBox">
                            <div class="paymentCat">AUTO PAYMENT CARD</div>
                            <div class="text-right menuicons">
                                <a href="javascript:;" title="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512">
                                        <path
                                            d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="cardDet">
                                <figure>
                                    <img src="{{asset('assets/images/master-card.png')}}" alt="">
                                </figure>
                                <div class="cont">
                                    <h3>Mastercard <span>**** **** **** 6571</span></h3>
                                    <p>EXPIRES 05/28</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card paymentCardBox">
                            <div class="paymentCat">AUTO PAYMENT CARD</div>
                            <div class="text-right menuicons">
                                <a href="javascript:;" title="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512">
                                        <path
                                            d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="cardDet">
                                <figure>
                                    <img src="{{asset('assets/images/american-express-cards.png')}}" alt="">
                                </figure>
                                <div class="cont">
                                    <h3>American Express <span> **** **** 6571</span></h3>
                                    <p>EXPIRES 05/28</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card paymentCardBox">
                            <div class="paymentCat">AUTO PAYMENT CARD</div>
                            <div class="text-right menuicons">
                                <a href="javascript:;" title="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512">
                                        <path
                                            d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="cardDet">
                                <figure>
                                    <img src="{{asset('assets/images/dicover-cards.png')}}" alt="">
                                </figure>
                                <div class="cont">
                                    <h3>Discover <span>**** **** **** 6571</span></h3>
                                    <p>EXPIRES 05/28</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card addpaymentMethod">
                            <a href="javascript:;" data-toggle="modal" data-target="#addpaymentcard" title="">ADD
                                PAYMENT METHOD</a>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="col-md-12">
                <div class="Bxtools">
                    <form action="{{ route(auth()->user()->type . '.update_users_subscription') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class=" col-md-12">
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fields">
                                    <label>Card Number</label>
                                    <input id="creditCard" type="text" class="inpt numberonly" maxlength="19"
                                        placeholder="1234 1234 1234 1234" required="" name="card_number"
                                        value="{{ old('card_number') }}">
                                    <input type="hidden" name="user_id" value={{ $id }}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fields">
                                    <label>Expiration Month</label>
                                    <select id="cardMonth" data-ref="cardDate" class="inpt" required=""
                                        name="month" value="{{ old('month') }}">
                                        <option value="" disabled="disabled" selected="selected">Month</option>
                                        <option value="01" {{ old('month') == '01' ? 'selected' : '' }}> 01 </option>
                                        <option value="02" {{ old('month') == '02' ? 'selected' : '' }}> 02 </option>
                                        <option value="03" {{ old('month') == '03' ? 'selected' : '' }}> 03 </option>
                                        <option value="04" {{ old('month') == '04' ? 'selected' : '' }}> 04 </option>
                                        <option value="05" {{ old('month') == '05' ? 'selected' : '' }}> 05 </option>
                                        <option value="06" {{ old('month') == '06' ? 'selected' : '' }}> 06 </option>
                                        <option value="07" {{ old('month') == '07' ? 'selected' : '' }}> 07 </option>
                                        <option value="08" {{ old('month') == '08' ? 'selected' : '' }}> 08 </option>
                                        <option value="09" {{ old('month') == '09' ? 'selected' : '' }}> 09 </option>
                                        <option value="10" {{ old('month') == '10' ? 'selected' : '' }}> 10 </option>
                                        <option value="11" {{ old('month') == '11' ? 'selected' : '' }}> 11 </option>
                                        <option value="12" {{ old('month') == '12' ? 'selected' : '' }}> 12 </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fields">
                                    <label>Expiration Year</label>
                                    <select id="cardYear" data-ref="cardDate" class="inpt" required=""
                                        name="year">
                                        <option value="" disabled="disabled" selected="selected">Year</option>
                                        @for ($year = date('Y'); $year <= 2050; $year++)
                                            <option value="{{ $year }}"
                                                {{ old('year') == $year ? 'selected' : '' }}> {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="btns submits">
                            <input class="themeBtn fullbtn" type="submit" value="Update User Subscription">
                        </div>
                    </form>
                </div>
            </div> --}}

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
                            <form action="{{ route(auth()->user()->type . '.update_users_subscription') }}" class="shipmentDetails" method="POST">
                                @csrf
                                <div class="popBxs">
                                    <h3>Credit Card Details</h3>
                                    <h6>All fields are required</h6>
                                    <div class="notificationsbx">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <p>In order to validate your Credit Card a temporary preauthorization of $1.00 will
                                            be processed. This will temporarily show on your bank transactions but
                                            should drop off within 7-10 business days.</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="fields cardnumb">
                                                <input id="creditCard" type="text" class="inpt numberonly" maxlength="19"
                                                    placeholder="Card Number" required name="card_number"
                                                    value="{{ old('card_number') }}">
                                                <input type="hidden" name="user_id" value={{ $id }}>
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
                                                    <option value="" disabled="disabled" selected="selected">Month</option>
                                                    <option value="01" {{ old('month') == '01' ? 'selected' : '' }}> 01 </option>
                                                    <option value="02" {{ old('month') == '02' ? 'selected' : '' }}> 02 </option>
                                                    <option value="03" {{ old('month') == '03' ? 'selected' : '' }}> 03 </option>
                                                    <option value="04" {{ old('month') == '04' ? 'selected' : '' }}> 04 </option>
                                                    <option value="05" {{ old('month') == '05' ? 'selected' : '' }}> 05 </option>
                                                    <option value="06" {{ old('month') == '06' ? 'selected' : '' }}> 06 </option>
                                                    <option value="07" {{ old('month') == '07' ? 'selected' : '' }}> 07 </option>
                                                    <option value="08" {{ old('month') == '08' ? 'selected' : '' }}> 08 </option>
                                                    <option value="09" {{ old('month') == '09' ? 'selected' : '' }}> 09 </option>
                                                    <option value="10" {{ old('month') == '10' ? 'selected' : '' }}> 10 </option>
                                                    <option value="11" {{ old('month') == '11' ? 'selected' : '' }}> 11 </option>
                                                    <option value="12" {{ old('month') == '12' ? 'selected' : '' }}> 12 </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fields">
                                                <label class="posabs">Expiration Year</label>
                                                <select id="cardYear" data-ref="cardDate" class="inpt" required
                                                    name="year">
                                                    <option value="" disabled="disabled" selected="selected">Year</option>
                                                    @for ($year = date('Y'); $year <= 2050; $year++)
                                                        <option value="{{ $year }}"
                                                            {{ old('year') == $year ? 'selected' : '' }}> {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fields">
                                                <label class="posabs">Security Code</label>
                                                <input class="inpt numberonly card-cvc required" type="text" id="cardCvv" placeholder="CVV" maxlength="4" name="cvv" autocomplete="off" required value="{{old('cvv')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="popBxs">
                                    <h3>Billing Address</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="text" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="text" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="fields">
                                                <input type="text" placeholder="Street Address" name="address" value="{{ old('address') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <select id="country" name="country" required> 
                                                    <option value="" disabled="disabled" selected="selected">Country</option>
                                                        <option value="233"> USA </option>
                                                        <option value="39"> Canada </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select id="state" name="state" required>
                                                        <option value="" disabled="disabled" selected="selected">State / Province</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="City" name="city" value="{{ old('city') }}" required>
                                                </div>
                                            </div>
                                        <div class="col-md-6">
                                            <div class="fields">
                                                <input type="number" placeholder="Zip / Postal Code" name="zip" value="{{ old('zip') }}" required>
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
                                            Your current autopay method is "Visa...1985"
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
        input1.addEventListener('input', function (e) {  
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
                if(countryId) {
                    $.ajax({
                        url: "{{ url('/get-states') }}/" + countryId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#state').empty();
                            $('#state').append('<option value="" disabled="disabled" selected="selected">State / Province</option>');
                            $.each(data, function(key, value) {
                                $('#state').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching states:', error);
                        }
                    });
                } else {
                    $('#state').empty();
                    $('#state').append('<option value="" disabled="disabled" selected="selected">State / Province</option>');
                }
            });
        });
    </script>
@endpush
