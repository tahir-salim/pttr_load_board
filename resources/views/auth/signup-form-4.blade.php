@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="loginForms">
            <div class="lgForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{ asset('assets/images/logo.webp') }}" alt="">
                </figure>
                <form accept-charset="UTF-8" action="{{ route('package.payment') }}" method="POST" class="require-validation"
                data-cc-on-file="false" 
                id="payment-form">

                    @csrf
                    <div class="d-flex justify-content-between">
                        <h2>SignUp</h2>
                        <p>Step 4</p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Total Amount</label>
                                <input type="text" class="inpt numberonly" value="{{ $totalPromoAmount }}"
                                    name="total_amount" readonly>
                                <input type="hidden" name="promo_owner_amount" value="{{ $promoOwnerAmount }}">
                                <input type="hidden" name="promo_user_amount" value="{{ $promoUserAmount }}">
                                <input type="hidden" name="regular_owner_amount" value="{{ $regularOwnerAmount }}">
                                <input type="hidden" name="regular_user_amount" value="{{ $regularUserAmount }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Card Number</label>
                                <input id="creditCard" type="text" class="inpt numberonly required card-name" maxlength="19"
                                    placeholder="1234 1234 1234 1234" required="" name="card_number" value="{{old('card_number')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fields">
                                <label>Expiration Date</label>
                                <select id="cardMonth" data-ref="cardDate" class="inpt required card-expiry-month" required="" name="month">
                                    <option value="" disabled="disabled" selected="selected">Month</option>
                                    <option value="01" {{ old('month')=='01' ? 'selected' : ''  }}> 01 </option>
                                    <option value="02" {{ old('month')=='02' ? 'selected' : ''  }}> 02 </option>
                                    <option value="03" {{ old('month')=='03' ? 'selected' : ''  }}> 03 </option>
                                    <option value="04" {{ old('month')=='04' ? 'selected' : ''  }}> 04 </option>
                                    <option value="05" {{ old('month')=='05' ? 'selected' : ''  }}> 05 </option>
                                    <option value="06" {{ old('month')=='06' ? 'selected' : ''  }}> 06 </option>
                                    <option value="07" {{ old('month')=='07' ? 'selected' : ''  }}> 07 </option>
                                    <option value="08" {{ old('month')=='08' ? 'selected' : ''  }}> 08 </option>
                                    <option value="09" {{ old('month')=='09' ? 'selected' : ''  }}> 09 </option>
                                    <option value="10" {{ old('month')=='10' ? 'selected' : ''  }}> 10 </option>
                                    <option value="11" {{ old('month')=='11' ? 'selected' : ''  }}> 11 </option>
                                    <option value="12" {{ old('month')=='12' ? 'selected' : ''  }}> 12 </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fields">
                                <label>&nbsp;</label>
                                <select id="cardYear" data-ref="cardDate" class="inpt required card-expiry-year" required="" name="year">
                                    <option value="" disabled="disabled" selected="selected">Year</option>
                                    @for ($year=date('Y'); $year<=2050; $year++)
                                        <option value="{{ $year }}" {{ old('year')== $year ? 'selected' : ''  }}> {{ $year }} </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="fields">
                                <label>CVV</label>
                                <input class="inpt numberonly card-cvc required" type="text" id="cardCvv" maxlength="4" name="cvv"
                                    autocomplete="off" required="" value="{{old('cvv')}}">
                            </div>
                        </div>
                    </div>
                    <div class="btns submits">
                        <input class="themeBtn fullbtn" type="submit" value="Pay Now">
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
</script>
@endpush