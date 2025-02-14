@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="loginForms">
            <div class="lgForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                </figure>
                <form action="{{ route(auth()->user()->type . '.update_user_subscription') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                        {{-- <h2> </h2> --}}
                        <p>Update Subscription</p>
                    </div>
                    {{-- @php
                        $amount = auth()->user()->package->promo_owner_amount;
                    @endphp --}}
                    <div class="row">
                        {{-- <div class="col-md-12">
                            <div class="fields">
                                <label>Total Amount</label>
                                <input type="text" class="inpt numberonly" value="{{ $amount }}" name="amount">
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Card Number</label>
                                <input id="creditCard" type="text" class="inpt numberonly" maxlength="19" readonly
                                    placeholder="1234 1234 1234 1234" required="" name="card_number" value="{{decrypt($customerPaymentProfile->card_no)}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fields">
                                <label>Expiration Date</label>
                                <input id="cardMonth" type="text" class="inpt numberonly" name="month" value="{{$expiryMonth}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fields">
                                <label>&nbsp;</label>
                                <input id="cardYear" type="text" class="inpt numberonly" name="year" value="{{$expiryYear}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="btns submits">
                        <input class="themeBtn fullbtn" type="submit" value="Update Subscription">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>

    const input = document.getElementById('creditCard'); 
        input.addEventListener('input', function (e) {  
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
@endpush