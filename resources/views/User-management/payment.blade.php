@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Create New User</h2>
            </div>
            <div class="contBody">
                <div class="row">
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="javascript:;" target="_blank" title=""><img
                                    src="{{ asset('assets/images/ad-03.jpg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="javascript:;" target="_blank" title=""><img
                                    src="{{ asset('assets/images/ad-03.jpg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="advertisments">
                            <a href="javascript:;" target="_blank" title=""><img
                                    src="{{ asset('assets/images/ad-03.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <form action="{{ route(auth()->user()->type . '.user_management.user_subscription') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <h3>New User Payment</h3>
                        </div>
                        <br>
                        <div class="row createUsers">
                            <div class="col-md-6">
                                <div class="fields">
                                    <label>Total Amount</label>
                                    <input type="text" class="inpt numberonly form-control"
                                        value="{{ $package->promo_user_amount }}" name="promo_user_amount" readonly>
                                    <input type="hidden" name="regular_user_amount"
                                        value="{{ $package->regular_user_amount }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fields">
                                    <label>Card Number</label>
                                    <input id="creditCard" type="text" class="inpt numberonly card-name form-control"
                                        maxlength="19" readonly name="card_number"
                                        value="{{ decrypt($customerPaymentProfile->card_no) }}">
                                    @if ($errors->has('card_number'))
                                        <span class="text-danger">{{ $errors->first('card_number') }}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="fields">
                                            <label>Expiration Date</label>
                                            <input type="text" class="inpt form-control" readonly name="month"
                                                value="{{ $expiryMonth }}">
                                            @if ($errors->has('month'))
                                                <span class="text-danger">{{ $errors->first('month') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fields">
                                            <label>&nbsp;</label>
                                            <input type="text" class="inpt form-control" readonly name="year"
                                                value="{{ $expiryYear }}">
                                            @if ($errors->has('year'))
                                                <span class="text-danger">{{ $errors->first('year') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fields">
                                            <label>CVV</label>
                                            <input id="cardCvv" type="text"
                                                class="inpt numberonly card-name form-control" maxlength="4" required
                                                name="cvv" value="{{ old('cvv') }}">
                                            @if ($errors->has('cvv'))
                                                <span class="text-danger">{{ $errors->first('cvv') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btnShipments">
                                    <input class="postBtn" type="submit" value="Pay Now">
                                    <a href="{{ route(auth()->user()->type . '.user_management.create_user') }}"
                                        class="cancelBtn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
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
    </script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `{!! implode('<br>', $errors->all()) !!}`
                });
            });
        </script>
    @endif

@endpush
