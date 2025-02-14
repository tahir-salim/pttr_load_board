@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="loginForms">
            <div class="lgForm">
                <figure class="logoBrand">
                    <img class="img-fluid blur1" src="{{asset('assets/images/logo.webp')}}" alt="">
                </figure>
                <form action="{{ route('signup_step3') }}" method="GET">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <h2>SignUp</h2>
                        <p>Step 2</p>
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
                    <div class="row DivHide">
                        <div class="col-md-12">
                            <div class="fields">
                                <label>Choose LC Number</label>
                                <select id="lc_number" required>
                                    <option value="" selected disabled>Please Select</option>
                                    <option value="mc">MC Number</option>
                                    <option value="dot">Dot Number</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 form-field" id="mc_no_div" style="display: none;">
                            <div class="fields">
                                <label for="mc_no">Enter MC Number</label>
                                <input type="text" name="mc_no" id="mc_no" placeholder="XXXXXXXXX">
                            </div>
                        </div>
                        <div class="col-md-12 form-field" id="dot_no_div" style="display: none;">
                            <div class="fields">
                                <label for="dot_no">Enter DOT Number</label>
                                <input type="text" name="dot_no" id="dot_no" placeholder="XXXXXXXXX">
                            </div>
                        </div>
                        <div class="col-md-8" id="company_name_div" style="display: none;">
                            <div class="fields">
                                <label>Company Name</label>
                                <input type="text" id="company_name" name="company_name">
                            </div>
                        </div>
                        <div class="col-md-4" id="state_div" style="display: none;">
                            <div class="fields">
                                <label>State</label>
                                <input type="text" id="state" name="state">
                            </div>
                        </div>

                        <div class="col-md-8" id="address_div" style="display: none;">
                            <div class="fields">
                                <label>Address</label>
                                <input type="text" id="address" name="address">
                            </div>
                        </div>

                        <div class="col-md-4" id="zip_code_div" style="display: none;">
                            <div class="fields">
                                <label>Zip code</label>
                                <input type="text" id="zip_code" name="zip_code">
                            </div>
                        </div>
                        <div class="col-md-6" id="company_email_div" style="display: none;">
                            <div class="fields">
                                <label>Company Email</label>
                                <input type="email" id="company_email" name="company_email" placeholder="Enter Email"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6" id="company_phone_div" style="display: none;">
                            <div class="fields">
                                <label>Company Phone No</label>
                                <input type="tel" id="company_phone" name="company_phone" placeholder="Enter Phone"
                                    required>
                            </div>
                        </div>

                    </div>
                    <div class="btns submits">
                        <input class="themeBtn fullbtn" type="button" value="Next" id="next">
                    </div>
                    <div class="col-md-12 ajaxBtn" id="submit_div" style="display: none;">
                        <div class="btns submits">
                            <input class="themeBtn fullbtn" type="submit" value="Submit" id="submit">
                        </div>
                    </div>
                    <div class="agreeDv">
                        <div class="agreelabel">
                            <label><input type="checkbox" required> I agree to the <a href="{{route('terms_and_conditions')}}" title="">Terms And Conditions</a>.</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#next').click(function() {
            var mc_no = document.getElementById("mc_no").value;
            var dot_no = document.getElementById("dot_no").value;
            console.log("mc " + mc_no);
            console.log("dot " + dot_no);
            let token = '{{ csrf_token() }}';
            var data = {
                "_token": token,
                "mc_no": mc_no,
                "dot_no": dot_no
            };
            var url = "{{ route('lc_number') }}";
            var res = AjaxRequest(url, data);

            if (res.status == 1) {
                $('#lc_number').attr("disabled", true);
                $('#mc_no').attr("disabled", true);
                $('#dot_no').attr("disabled", true);
                $('#company_name').val(res.company.company_name);
                $('#zip_code').val(res.company.zip_code);
                $('#state').val(res.company.state);
                $('#address').val(res.company.address);

                $('#company_name_div').show();
                $('#zip_code_div').show();
                $('#state_div').show();
                $('#address_div').show();
                $('#company_phone_div').show();
                $('#company_email_div').show();
                $('#next').hide();
                $('#submit_div').show();

            } else {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error(res.error);
                // setTimeout(() => {
                //     location.reload();
                // }, 2000);
            }

        });

        $(document).ready(function() {
            $('#lc_number').change(function() {
                var selectedOption = $(this).val();
                  console.log(selectedOption);
                $('.form-field').hide();
                if(selectedOption == 'mc'){
                    $('#dot_no').val('');
                    $('#dot_no_div').hide();
                     $('#mc_no_div').show();
                }else if(selectedOption == 'dot'){
                    $('#mc_no').val('');
                     $('#mc_no_div').hide();
                     $('#dot_no_div').show();
                }else{
                    $('.form-field').hide();
                }
                
                
                
            });
        });
    </script>
@endpush
