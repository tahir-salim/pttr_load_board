@extends('Admin.layouts.app')
@section('content')
    <div class="col-md-10">
        <div class="mainBody">
            <!-- Begin: Notification -->
            @include('layouts.notifications')
            <!-- END: Notification -->

            <div class="main-header">
                <h2>Create Advertisement</h2>
            </div>
            @push('css')
                <style>
                #imagePreviewApp {
                    background-position: center;
                    height: 200px;
                    background-repeat: no-repeat;
                    background-size: contain;
                    width: 300px;
                }
                #imagePreviewWeb {
                    background-position: center;
                    height: 200px;
                    background-repeat: no-repeat;
                    background-size: contain;
                    width: 300px;
                }
                .tabsMains{     display: flex;
                    justify-content: center;
                    margin: 0;
                    
                }
                .tabsMains a{
                        border-radius: 4px;
                        background-color: #f2f2f2;
                        font-size: 12px;
                        font-weight: 600;
                        color: #8f8f8f;
                        text-align: center;
                        padding: 0.6rem 2rem;
                        font-size: 16px;
                        text-transform: uppercase;
                        margin: 0 2px;
                }
                .tabsMains a.active{
                        background-color: #009edd;
                        color:#fff;
                }
                
                .listinstructions{display:flex;align-items:center;padding-left: 20px;margin-top: 10px;gap: 20px;}
                .listinstructions li{padding: 0 5px;font-size:13px;}
                
                
            </style>
            @endpush
            <div class="contBody">
              
                    <div class="row">
                        <div class=" col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>*{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shipmentDetails">
                                <div class="tabsMains">
                                    <a class="active" data-targetit="box-tab1" href="javascript:;" title="">App</a>
                                    <a data-targetit="box-tab2" href="javascript:;" title="">Web</a>
                                </div>
                                <div class="box-tab1 showfirst">
                                    <h3>Create Advertisement</h3>
                                     <form action="{{ route(auth()->user()->type . '.advertisements.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="fields">
                                                    <select id='type' required name="page_name" class="form-control" style="height: auto">
                                                        <option hidden value=""> Select Location Page</option>
                                                        <option value="app1" {{old('app1') == "app1" ? "selected" : ""}}>{{strtoupper('app1')}}</option>
                                                        <option value="app2" {{old('app2') == "app2" ? 'seleceted' : ""}}>{{strtoupper('app2')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <select id='type' required name="position" class="form-control" style="height: auto">
                                                                  <option value="mobile_app" {{old('position') == "mobile_app" ? "selected" : ""}}>{{strtoupper('mobile app')}}</option>
                                                            </select>
                                                        </div>
        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="url" required  name="url" value="{{old('url')}}"
                                                                placeholder="https://www.example.com/">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ol class="listinstructions">
                                                    <li>Top Header ( 600 * 130 )</li>
                                                    <li>Center Header  ( 800 * 100 )</li>
                                                    <li>Bottom Footer  ( 800 * 100 )</li>
                                                </ol>
                                                <div class="fields">
                                                    <input type="file" required name="image" class="form-control" placeholder="image"  id="imageUploadApp" accept=".png, .jpg, .jpeg, .gif" style="height: auto">
                                                </div>
                                                <div id="imagePreviewApp" style="display:none">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btnShipments halfbtn">
                                            <a href="{{ route('super-admin.advertisements.list') }}" type="button"
                                                class="cancelBtn">Cancel Advertisement</a>
                                            <input type="submit" class="postBtn" value="Create Advertisement">
                                        </div>
                                    </form>
                                </div>
                                <div class="box-tab2">
                                    <h3>Create Advertisement</h3>
                                     <form action="{{ route(auth()->user()->type . '.advertisements.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="fields">
                                                    <select id='select1' required name="page_name" class="form-control" style="height: auto">
                                                        <option hidden value=""> Select Location Page</option>
                                                        <option value="dashboard" {{old('page_name') == "dashboard" ? "selected" : ""}}>DASHBOARD</option>
                                                        <option value="search_truck" {{old('page_name') == "search_truck" ? "selected" : ""}}>{{strtoupper('search truck')}}</option>
                                                        <option value="search_loads" {{old('page_name') == "search_loads" ? "selected" : ""}}>{{strtoupper('search loads')}}</option>
                                                        <option value="my_shipments" {{old('page_name') == "my_shipments" ? "selected" : ""}}>{{strtoupper('my shipments')}}</option>
                                                        <option value="shipment_overview" {{old('page_name') == "shipment_overview" ? "selected" : ""}}>{{strtoupper('shipment overview')}}</option>
                                                        <option value="post_a_shipment" {{old('page_name') == "post_a_shipment" ? "selected" : ""}}>{{strtoupper('post a shipment')}}</option>
                                                        <option value="edit_a_shipment" {{old('page_name') == "edit_a_shipment" ? "selected" : ""}}>{{strtoupper('edit a shipment')}}</option>
                                                        <option value="new_tracking_request" {{old('page_name') == "new_tracking_request" ? "selected" : ""}}>{{strtoupper('new tracking request')}}</option>
                                                        <option value="tracking_detail" {{old('page_name') == "tracking_detail" ? "selected" : ""}}>{{strtoupper('tracking detail')}}</option>
                                                        <option value="create_tracking_request" {{old('page_name') == "create_tracking_request" ? "selected" : ""}}>{{strtoupper('create tracking request')}}</option>
                                                        <option value="edit_tracking_request" {{old('page_name') == "edit_tracking_request" ? "selected" : ""}}>{{strtoupper('edit tracking request')}}</option>
                                                        <option value="live_chat_support" {{old('page_name') == "live_chat_support" ? "selected" : ""}}>{{strtoupper('live chat support')}}</option>
                                                        <option value="private_network" {{old('page_name') == "private_network" ? "selected" : ""}}>{{strtoupper('private network')}}</option>
                                                        <option value="private_network_detail" {{old('page_name') == "private_network_detail" ? "selected" : ""}}>{{strtoupper('private network detail')}}</option>
                                                        <option value="edit_private_network" {{old('page_name') == "edit_private_network" ? "selected" : ""}}>{{strtoupper('edit private network')}}</option>
                                                        <option value="groups" {{old('page_name') == "groups" ? "selected" : ""}}>{{strtoupper('groups')}}</option>
                                                        <option value="groups_details" {{old('page_name') == "groups_details" ? "selected" : ""}}>{{strtoupper('groups details')}}</option>
                                                        <option value="tools" {{old('page_name') == "tools" ? "selected" : ""}}>{{strtoupper('tools')}}</option>
                                                        <option value="feedbacks_form" {{old('page_name') == "feedbacks_form" ? "selected" : ""}}>{{strtoupper('feedbacks form')}}</option>
                                                        <option value="compnay_profile" {{old('page_name') == "compnay_profile" ? "selected" : ""}}>{{strtoupper('compnay profile')}}</option>
                                                        <option value="Billings" {{old('page_name') == "Billings" ? "selected" : ""}}>{{strtoupper('Billings')}}</option>
                                                        <option value="Billing_details" {{old('page_name') == "Billing_details" ? "selected" : ""}}>{{strtoupper('Billing Details')}}</option>
                                                        <option value="privacy_policy" {{old('page_name') == "privacy_policy" ? "selected" : ""}}>{{strtoupper('privacy policy')}}</option>
                                                        <option value="terms_and_condition" {{old('page_name') == "terms_and_condition" ? "selected" : ""}}>{{strtoupper('terms and condition')}}</option>
                                                        <option value="create_contact" {{old('page_name') == "create_contact" ? "selected" : ""}}>{{strtoupper('Create Contact')}}</option>
                                                        <option value="my_shipment_bid_activity" {{old('page_name') == "my_shipment_bid_activity" ? "selected" : ""}}>{{strtoupper('My shipment Bid Activity')}}</option>
                                                        <option value="user_profile" {{old('page_name') == "user_profile" ? "selected" : ""}}>{{strtoupper('User Profile')}}</option>
                                                        <option value="user_management" {{old('page_name') == "user_management" ? "selected" : ""}}>{{strtoupper('User Management')}}</option>
                                                        <option value="user_management_create" {{old('page_name') == "user_management_create" ? "selected" : ""}}>{{strtoupper('Create User')}}</option>
                                                        <option value="my_shipment_request_activity" {{old('page_name') == "my_shipment_request_activity" ? "selected" : ""}}>{{strtoupper('My Shipment Request Activity')}}</option>
                                                        <option value="all_notifications" {{old('page_name') == "all_notifications" ? "selected" : ""}}>{{strtoupper('All Notifications')}}</option>
                                                        <option value="help_center" {{old('page_name') == "help_center" ? "selected" : ""}}>{{strtoupper('Help Center')}}</option>
                                                        <option value="carrier_detail" {{old('page_name') == "carrier_detail" ? "selected" : ""}}>{{strtoupper('carrier detail')}}</option>
                                                        <option value="my_shipment_status_tracking" {{old('page_name') == "my_shipment_status_tracking" ? "selected" : ""}}>{{strtoupper('my shipment status tracking')}}</option>
                                                        <option value="my_shipments_active" {{old('page_name') == "my_shipments_active" ? "selected" : ""}}>{{strtoupper('my shipments active')}}</option>
                                                        <option value="my_shipments_bid_activity" {{old('page_name') == "my_shipments_bid_activity" ? "selected" : ""}}>{{strtoupper('my shipments bid activity')}}</option>
                                                        <option value="my_shipments_history" {{old('page_name') == "my_shipments_history" ? "selected" : ""}}>{{strtoupper('my shipments history')}}</option>
                                                        <option value="my_shipments_requests_activity" {{old('page_name') == "my_shipments_requests_activity" ? "selected" : ""}}>{{strtoupper('my shipments requests activity')}}</option>
                                                        <option value="my_shipments_tracking" {{old('page_name') == "my_shipments_tracking" ? "selected" : ""}}>{{strtoupper('my shipments tracking')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="fields" id='select2'>
                                                            <select  required name="position" class="form-control" style="height: auto">
                                                                <option hidden value=""> Select Postion Page</option>
                                                                <option value="top_header1" {{old('position') == "top_header1" ? 'seleceted' : ""}}>{{strtoupper('Top Header1')}}</option>
                                                                <option value="top_header2" {{old('position') == "top_header2" ? 'seleceted' : ""}}>{{strtoupper('Top Header2')}}</option> 
                                                                <option value="top_header3" {{old('position') == "top_header3" ? 'seleceted' : ""}}>{{strtoupper('Top Header3')}}</option> 
                                                                <option value="center_header1" {{old('position') == "center_header1" ? 'seleceted' : ""}}>{{strtoupper('Center Header1')}}</option> 
                                                                <option value="center_header2" {{old('position') == "center_header2" ? 'seleceted' : ""}}>{{strtoupper('Center Header2')}}</option> 
                                                                <option value="center_header4" {{old('position') == "center_header4" ? 'seleceted' : ""}}>{{strtoupper('Center Header4')}}</option> 
                                                                <option value="center_header5" {{old('position') == "center_header5" ? 'seleceted' : ""}}>{{strtoupper('Center Header5')}}</option> 
                                                                <option value="bottomfooter1" {{old('position') == "bottomfooter1" ? 'seleceted' : ""}}>{{strtoupper('Bottom footer 1')}}</option>
                                                                <option value="bottomfooter2" {{old('position') == "bottomfooter2" ? 'seleceted' : ""}}>{{strtoupper('Bottom footer 2')}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fields">
                                                            <input type="url" required  name="url" value="{{old('url')}}"
                                                                placeholder="https://www.example.com/">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                  <ol class="listinstructions">
                                                    <li>Top Header ( 600 * 130 )</li>
                                                    <li>Center Header  ( 800 * 100 )</li>
                                                    <li>Bottom Footer  ( 800 * 100 )</li>
                                                </ol>
                                                <div class="fields">
                                                    <input type="file" required name="image" class="form-control" placeholder="image"  id="imageUploadWeb" accept=".png, .jpg, .jpeg, .gif" style="height: auto">
                                                </div>
                                                <div id="imagePreviewWeb" style="display:none">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btnShipments halfbtn">
                                            <a href="{{ route('super-admin.advertisements.list') }}" type="button"
                                                class="cancelBtn">Cancel Advertisement</a>
                                            <input type="submit" class="postBtn" value="Create Advertisement">
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
        $(document).ready(function() {
            $('#select1').on('change', function() {
                var selectedValue = $(this).val();
                
                if(selectedValue == "dashboard"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="center_header3">Center Header3</option><option value="center_header4">Center Header4</option></select>');
                }
                else if(selectedValue == "search_truck"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="top_header4">Top Header4</option><option value="top_header5">Top Header5</option></select>');
                }
                else if(selectedValue == "search_loads"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="center_header4">Center Header4</option></select>');
                }
                else if(selectedValue == "my_shipments"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "shipment_overview"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="center_header4">Center Header4</option></select>');
                }
                else if(selectedValue == "edit_a_shipment"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option></select>');
                }
                else if(selectedValue == "private_network"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="center_header4">Center Header4</option><option value="center_header5">Center Header5</option></select>');
                }
                else if(selectedValue == "groups"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="center_header4">Center Header4</option></select>');
                }
                else if(selectedValue == "create_contact"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "edit_tracking_request"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "new_tracking_request"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "live_chat_support"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="center_header1">Center Header1</option><option value="center_header2">Center Header2</option></select>');
                }
                else if(selectedValue == "tools"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "feedbacks_form"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="bottom_footer1">Bottom Footer1</option><option value="bottom_footer2">Bottom Footer2</option></select>');
                }
                else if(selectedValue == "my_shipment_bid_activity"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "user_profile"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="center_header4">Center Header4</option></select>');
                }
                else if(selectedValue == "user_management"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "Billings"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "Billing_details"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "compnay_profile"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "my_shipment_request_activity"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "all_notifications"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "help_center"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option><option value="center_header4">Center Header4</option><option value="center_header5">Center Header5</option></select>');
                }
                else if(selectedValue == "post_a_shipment"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option></select>');
                }
                else if(selectedValue == "create_tracking_request"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "tracking_detail"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "private_network_detail"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "edit_private_network"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "groups_details"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "user_management_create"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "carrier_detail"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "my_shipment_status_tracking"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "my_shipments_active"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "my_shipments_bid_activity"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "my_shipments_history"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "my_shipments_requests_activity"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                else if(selectedValue == "my_shipments_tracking"){
                $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="top_header1">Top Header1</option><option value="top_header2">Top Header2</option><option value="top_header3">Top Header3</option></select>');
                }
                
                else{
                     $('#select2').html('<select  required name="position" class="form-control" style="height: auto"><option value="">Select Position</option></select>');
                }
                // console.log(selectedValue);
        
                // $('#select2 option').each(function() {
                //     var optionValue = $(this).val();
                //     // console.log(optionValue);
                //     if (optionValue == 'top_header1' && optionValue == 'top_header2' && optionValue == 'center_header3' && optionValue == 'center_header4') {
                //         $(this).show();
                //     } else {
                //         $(this).hide();
                //     }
                // });
            });
        
            // Trigger change event on page load to set initial state
            $('#select1').trigger('change');
        });
        
        $('#imagePreviewApp').hide();
        $('#imagePreviewWeb').hide();

        function readURLApp(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(e.target.result );
                        $('#imagePreviewApp').css('background-image', 'url('+e.target.result +')');
                        $('#imagePreviewApp').show();
                        $('#imagePreviewApp').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }else{
                    $('#imagePreviewApp').hide();
                }
            }
        function readURLWeb(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(e.target.result );
                        $('#imagePreviewWeb').css('background-image', 'url('+e.target.result +')');
                        $('#imagePreviewWeb').show();
                        $('#imagePreviewWeb').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }else{
                    $('#imagePreviewWeb').hide();
                }
            }
            $("#imageUploadWeb").change(function() {
                readURLWeb(this);

            });
            $("#imageUploadApp").change(function() {
                readURLApp(this);

            });


    </script>
@endpush
