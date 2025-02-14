@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="loginForms">
            <div class="lgForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                </figure>
                <form action="{{ route(auth()->user()->type . '.create_users_subscription') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                        {{-- <h2> </h2> --}}
                        <p>Create Subscription</p>
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
                                <input id="creditCard" type="text" class="inpt numberonly" maxlength="19"
                                    placeholder="1234 1234 1234 1234" required="" name="card_number">
                                    <input type="hidden" name="user_id" value={{$id}}>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fields">
                                <label>Expiration Date</label>
                                <select id="cardMonth" data-ref="cardDate" class="inpt" required="" name="month">
                                    <option value="" disabled="disabled" selected="selected">Month</option>
                                    <option value="01"> 01 </option>
                                    <option value="02"> 02 </option>
                                    <option value="03"> 03 </option>
                                    <option value="04"> 04 </option>
                                    <option value="05"> 05 </option>
                                    <option value="06"> 06 </option>
                                    <option value="07"> 07 </option>
                                    <option value="08"> 08 </option>
                                    <option value="09"> 09 </option>
                                    <option value="10"> 10 </option>
                                    <option value="11"> 11 </option>
                                    <option value="12"> 12 </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fields">
                                <label>&nbsp;</label>
                                <select id="cardYear" data-ref="cardDate" class="inpt" required="" name="year">
                                    <option value="" disabled="disabled" selected="selected">Year</option>
                                    <option value="2024"> 2024 </option>
                                    <option value="2025"> 2025 </option>
                                    <option value="2026"> 2026 </option>
                                    <option value="2027"> 2027 </option>
                                    <option value="2028"> 2028 </option>
                                    <option value="2029"> 2029 </option>
                                    <option value="2030"> 2030 </option>
                                    <option value="2031"> 2031 </option>
                                    <option value="2032"> 2032 </option>
                                    <option value="2033"> 2033 </option>
                                    <option value="2034"> 2034 </option>
                                    <option value="2035"> 2035 </option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="fields">
                                <label>CVV</label>
                                <input class="inpt numberonly" type="text" id="cardCvv" maxlength="4" name="cvv"
                                    autocomplete="off" required="">
                            </div>
                        </div> --}}
                    </div>
                    <div class="btns submits">
                        <input class="themeBtn fullbtn" type="submit" value="Create User Subscription">
                    </div>

                    {{-- <div class="agreeDv">
                        <div class="agreelabel">
                            <label><input type="checkbox"> I agree to the <a href="javascript:;" title="">Master
                                    Subscription Agreement</a>.</label>
                        </div>
                    </div> --}}

                    <!-- <div class="protected">
                            <p>By registering, you agree to the processing of your personal data by Salesforce as
                                described in the Privacy Statement.</p>
                        </div> -->
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