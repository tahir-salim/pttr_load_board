@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->
            <style>
              #dynamic-form-fields .form-group:first-child .remove-field{ display:none; }
              .is-invalid {
                    border-color: red !important;
                }
            </style>
            <div class="main-header">
                <h2>Send Tracking</h2>
                <div class="rightBtn">
                    <a class="themeBtn skyblue" href="{{ route(auth()->user()->type . '.trackings') }}" tile="">
                        Send Tracking List
                    </a>
                </div>
            </div>
            @php
                $top_header1 = ads('new_tracking_request','top_header1');
                $top_header2 = ads('new_tracking_request','top_header2');
                $top_header3 = ads('new_tracking_request','top_header3');
            @endphp
            <div class="contBody">
                @if(isset($top_header1) && isset($top_header2) && isset($top_header3))
                    <div class="row">
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header1->url}}" target="_blank" title=""><img src="{{asset($top_header1->image)}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header2->url}}" target="_blank" title=""><img src="{{asset($top_header2->image)}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="advertisments">
                                <a href="{{$top_header3->url}}" target="_blank" title=""><img src="{{asset($top_header3->image)}}" alt=""></a>
                            </div>
                        </div>
                    </div>
                    <br>
                @endif
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="col-md-6 alert alert-danger alert-dismissible fade show">{{ $error }}</div>
                        @endforeach
                    @endif

               <form action="{{ route(auth()->user()->type . '.new_tracking_store') }}" method="POST" enctype="multipart/form-data" id="tracking-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div id="dynamic-form-fields">
                                <div class="col-md-12 form-group">
                                    <div class="card shipmentDetails pick-field1">
                                        <h3>Driver Details</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields phoneusa">
                                                    <input type="tel" placeholder="Driver Phone Number" name="phone[]"  minlength="8" value="{{ old('phone.0') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="text" placeholder="Driver Name" name="name[]"  value="{{ old('name.0') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="email" class="email" placeholder="Carrier Email" name="carrier_email[]"  value="{{ old('carrier_email.0') }}">
                                                    <span id="email-error" style="color:red; display:none;">Invalid email address</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <select  name="shipment_id[]" id="shipment_id">
                                                        <option hidden value="">Select Shipment*</option>
                                                        @foreach ($shipments as $shipment)
                                                            <option value="{{ $shipment->id }}" {{ old('shipment_id.0') == $shipment->id ? 'selected' : '' }}>{{ $shipment->origin }} / {{ $shipment->destination }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-danger remove-field">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-left:2%">
                                <button type="button" class="btn btn-primary add-field">Add More</button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="btnShipments">
                                <input type="button" class="cancelBtn" value="Reset">
                                <input type="submit" id="SubBtn" class="postBtn"  value="Post">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
      <script>
          $(document).ready(function() {
            $('#tracking-form').on('submit', function(event) {
                $('#SubBtn').attr("disabled","disabled");
                let isValid = true;
                $('#dynamic-form-fields .card').each(function() {
                    $(this).find('input, select').each(function() {
                        let inputValue = $(this).val();
                        if ($(this).attr('name') === 'phone[]' && inputValue.length < 8) {
                            $(this).addClass('is-invalid');
                            isValid = false;
                        } else if (inputValue === '') {
                            isValid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                });
                if (!isValid) {
                    
                    event.preventDefault();
                    Swal.fire({
                      icon: "error",
                      title: "Oops...",
                      text: "Please fill out all required fields, and ensure the phone number has at least 8 digits.'",
                    });
                    $('#SubBtn').removeAttr("disabled");
                }
            });

            // Add more fields
            $('.add-field').click(function() {
                let newField = $('#dynamic-form-fields .form-group:first').clone();
                newField.find('input').val(''); // Clear input values
                newField.find('select').val(''); // Clear select values
                $('#dynamic-form-fields').append(newField);
                input_valid();
            });

            // Remove fields
            $(document).on('click', '.remove-field', function() {
                if ($('#dynamic-form-fields .form-group').length > 1) {
                    $(this).closest('.form-group').remove();
                } else {
                    alert('At least one set of fields is required.');
                }
                input_valid();
            });
        });

        input_valid();
        function input_valid(){
            $("input[name='phone[]']").on('input', function() {
                if($(this).val().length > 25) {
                    $(this).val($(this).val().slice(0, 25));
                }
            });
            $("input[name='name[]']").on('input', function() {
                if($(this).val().length > 25) {
                    $(this).val($(this).val().slice(0, 25));
                }
            });

            $("input[name='email[]']").on('input', function() {
                if($(this).val().length > 150) {
                    $(this).val($(this).val().slice(0, 150));
                }
            });
        }



      </script>
    @endpush
@endsection
