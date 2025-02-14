@extends('layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>New Invoice</h2>
            </div>
            <div class="">
                <form action="{{ route(auth()->user()->type . '.invoice.store') }}" method="POST"
                    enctype="multipart/form-data">
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

                            <div class="card shipmentDetails">
                                <h3>Invoice Form</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="text" required name="customer" id="customer" value="{{old('customer')}}"
                                                placeholder="Enter Customer">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="email" name="email" id="email" value="{{old('email')}}"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="number" id="invoice_no" required name="invoice_no" value="{{old('invoice_no')}}"
                                                placeholder="Enter Invoice Nnumber">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <input type="number" id="po_no" name="po_no" value="{{old('po_no')}}"
                                                placeholder="Enter P.O Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <select name="shipment_id" id="shipment_id">
                                                  <option value="">Select Shipment</option>
                                            @if($shipments != null)
                                                @foreach($shipments as $shipment)
                                                  <option value="{{$shipment->id}}">{{$shipment->origin.' / '.$shipment->destination}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fields">

                                                    <input type="number" placeholder="Enter Invoice Total Amount"
                                                        name="invoice_amount" value="{{old('invoice_amount')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fields">
                                                    <input type="number" name="total_miles" value="{{old('total_miles')}}"
                                                        placeholder="Enter Total Miles">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="fields">
                                            <div class="fields">
                                                <textarea class="form-control" id="comment" placeholder="Enter Comments" rows="15" name="comment">{{old('comment')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fields">
                                            <label class="ml-2">Upload Logo Image :</label>
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" required>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="fields">
                                            <label class="ml-2">Upload PDF :</label>
                                             <input type="file" name="pdf"  title="Upload PDF File" accept=".pdf" Placeholder="Upload PDF File" >
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btnShipments halfbtn">
                        <a href="{{ route(auth()->user()->type . '.invoice.index') }}" type="button"
                            class="cancelBtn">Cancel Invoice</a>
                        <input type="submit" class="postBtn" value="Create Invoice">
                        

                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        ClassicEditor.create( document.querySelector( '#comment' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush
