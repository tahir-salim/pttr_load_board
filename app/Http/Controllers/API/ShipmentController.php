<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\Shipment;
use App\Models\ShipmentSaved;
use App\Models\ShipmentsRequest;
use App\Models\Tracking;
use App\Models\Company;
use App\Models\ShipmentStatusTracking;
use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class ShipmentController extends Controller
{
    public function shipment()
    {
        // $shipment = Shipment::where('trucker_id', Auth::id())->first();

        // $openShipment = $shipment->where('shipment_status', 'pending')->get();

        // $activeShipment = $shipment->whereNotIn('shipment_status', ['PENDING', 'DECLINE', 'DELIVERD'])->get();

        // $historyShipment = $shipment->whereIn('shipment_status', ['decline', 'delivered'])->get();

        $s_req = ShipmentsRequest::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();
        $s_bid = Bid::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();
        $ids = [];
        if(count($s_req) > 0){
            $ids = array_unique($s_req);
        }

        if(count($s_bid) > 0){
            $ids = array_unique($s_bid);
        }

        if(count($s_req) > 0 && count($s_bid) > 0){
            $ids = array_unique(array_merge($s_req,$s_bid));
        }


        $shipment_open = Shipment::where('trucker_id',Auth::id())
        ->where(function ($q) {
            $q->where('is_post', 1)->WhereIn('status', ['BOOKED']);
        })
        ->orWhereIN('id',$ids)
        ->where(function ($q) {
            $q->where('is_post', 1)->WhereIn('status', ['WAITING']);
        })->orderBy('id', 'DESC')->where('user_id', '!=', Auth::id())->get();




        if ($shipment_open->count() > 0) {
            $this->sorting_data($shipment_open);

        }


        $shipment_active = Shipment::where('trucker_id',Auth::id())
        ->where(function ($q) {
            $q->where('is_post', 1)->WhereNotIn('status', ['WAITING', 'BOOKED', 'COMPLETE', 'CANCELED', 'EXPIRED']);
        })->orderBy('id', 'DESC')->where('user_id', '!=', Auth::id())->get();

        if ($shipment_active->count() > 0) {
            $this->sorting_data($shipment_active);
        }

        $shipment_history = Shipment::where('trucker_id',Auth::id())
        ->where(function ($q) {
            $q->where('is_post', 1)->WhereIn('status', ['COMPLETE', 'CANCELED']);
        })->orderBy('id', 'DESC')->where('user_id', '!=', Auth::id())->get();

        if ($shipment_history->count() > 0) {
            $this->sorting_data($shipment_history);
        }

        $data = [


            'open' => $shipment_open,
            'active' => $shipment_active,
            'history' => $shipment_history,
        ];

        return $this->formatResponse('success', 'shipment fetch successfully', $data);

    }
    public function private_loads()
    {


            $private_loads = [];

            $shipments = Shipment::where('is_post',1)->WhereIn('status', ['WAITING'])->where('entire_private_network_id',1)->WhereNotIn('id',requestedShipmentBid(Auth::id()))->WhereNotIn('id',requestedShipmentPublic(Auth::id()))->where(function($q){
                $q->whereHas('contacts',function($row){
                    $row->where('trucker_id', Auth::id());
                });
            })->
            orwhere('is_group',1)->where('is_post',1)->WhereIn('status', ['WAITING'])->orderBy('id','Desc')->get();
            $contact_groups = [];
            $contacts = Contact::where('trucker_id', Auth::id())->pluck('id')->toArray();
            if(count($contacts) > 0){
                $contact_groups = ContactGroup::whereIn('contact_id',$contacts)->pluck('group_id')->toArray();
            }

            if(count($shipments) > 0){
                foreach($shipments as $load){
                    if($load->is_group == 1 ){
                        $group_id = unserialize($load->group_id);
                        if (is_array($group_id) && array_intersect($group_id, $contact_groups)) {
                            $private_loads[] = $this->single_sorting_data($load);
                        }
                    }else if($load->entire_private_network_id == 1){
                        $private_loads[] = $this->single_sorting_data($load);
                    }
                }
            }else{
                return $this->formatResponse('success', 'shipment Record Not Found', []);
            }


        return $this->formatResponse('success', 'shipment fetch successfully', $private_loads);

    }

    function sorting_data($shipments){


        $shipments->transform(function ($shipment) {
            $shipment['equipment_type'] = $shipment->equipment_type ? $shipment->equipment_type : [];
            $shipment['equipment_detail'] = $shipment->equipment_detail == "0" ? "Full" : "Partial";
            $shipment['status'] = $shipment->status == "WAITING" ? "REQUESTED" : $shipment->status;
            $user = $shipment['user'] = $shipment->user ? $shipment->user : [];
            if($user){
                $shipment['status_phone'] = $shipment['status_phone'] ==  "1" ? $user->phone : '-';
                $shipment['status_email'] =  $shipment['status_email'] == "1" ? $user->email : '-';

                  if($user->parent_id != null){
                             $company = Company::where('user_id',$user->parent_id)->first();
                        }else{
                             $company = Company::where('user_id',$user->id)->first();
                        }

                        $shipment['user']['company'] = $company;
            }
            if($shipment->is_tracking == 1){
                $tracking =  $shipment['tracking'] = $shipment->tracking ? $shipment->tracking : [];
                if($tracking){
                    $tracking_details = $shipment['tracking']['tracking_details'] =  $shipment->tracking ? $shipment->tracking->tracking_details : [];
                    if(count($tracking_details) > 0){
                        $tracking_details->transform(function ($d) {
                            $d['type'] = $d->type == 1 ? "drop Off" : "Pick Up";
                            return $d;
                        });
                    }
                }
            }
            return $shipment;
        });

        return $shipments;
    }


    function single_sorting_data($shipment){


            $shipment['equipment_type'] = $shipment->equipment_type ? $shipment->equipment_type : [];
            $shipment['equipment_detail'] = $shipment->equipment_detail == "0" ? "Full" : "Partial";
            $shipment['status'] = $shipment->status == "WAITING" ? "PENDING" : strtoupper($shipment->status);
            $user = $shipment['user'] = $shipment->user ? $shipment->user : [];
            if($user){
                $shipment['status_phone'] = $shipment['status_phone'] ==  "1" ? $user->phone : '-';
                $shipment['status_email'] =  $shipment['status_email'] == "1" ? $user->email : '-';
                  if($user->parent_id != null){
                             $company = Company::where('user_id',$user->parent_id)->first();
                        }else{
                             $company = Company::where('user_id',$user->id)->first();
                        }
                        $shipment['user']['company'] = $company;
            }
            if($shipment->is_tracking == 1){
                $tracking =  $shipment['tracking'] = $shipment->tracking ? $shipment->tracking : [];
                if($tracking){
                    $tracking_details = $shipment['tracking']['tracking_details'] =  $shipment->tracking ? $shipment->tracking->tracking_details : [];
                    if(count($tracking_details) > 0){
                        $tracking_details->transform(function ($d) {
                            $d['type'] = $d->type == 1 ? "drop Off" : "Pick Up";
                            return $d;
                        });
                    }
                }
            }
            return $shipment;
    }




    public function shipmentStatusUpdate(Request $request, $shipment_id)
    {
        
        $validate = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $shipment = Shipment::find($shipment_id);
        if (!$shipment) {
            return $this->formatResponse('error', 'not found');
        }
           $app_status = $request->status;
        if (strpos($request->status, ',') !== false) {
            $request->status = preg_replace('/^\d+,/', '', $request->status);
        }   
       $status_tracking = ShipmentStatusTracking::where('shipment_id',$shipment->id)->latest()->first();
        if ($status_tracking && Str::upper($status_tracking->status) == Str::upper($request->status)  ) {
            return $this->formatResponse(
                'error',
                Str::upper($request->status) .' Status Already Received' 
            );
        }

        // $ship_stat_tracking = ShipmentStatusTracking::where('shipment_id',$shipment_id)->where('status', strtoupper($request->status))->first();
        // if($ship_stat_tracking){
        //     $ship_stat_tracking->status = strtoupper($request->status);
        //     $ship_stat_tracking->lat = isset($request->lat) ? $request->lat : null;
        //     $ship_stat_tracking->lng = isset($request->lng) ? $request->lng : null;
        //     $ship_stat_tracking->save();
        // }else{
            $ship_stat_tracking = new ShipmentStatusTracking();
            $ship_stat_tracking->status = strtoupper($request->status);
            $ship_stat_tracking->lat = isset($request->lat) ? $request->lat : null;
            $ship_stat_tracking->lng = isset($request->lng) ? $request->lng : null;
            $ship_stat_tracking->shipment_id = $shipment_id;
            $ship_stat_tracking->save();
        // }


        $shipment->status = Str::upper($request->status);
        $shipment->app_status = Str::upper($app_status);
        
        if(($shipment->is_tracking == 1)){
            if($request->status == 'BOOKED'){
                $shipment->tracking->tracking_status = 'ACCEPTED';
            }else{
                if($shipment->trackings){
                    foreach($shipment->trackings as $track){
                        $track->tracking_status = strtoupper($request->status);
                        $track->save();
                    }
                }
            }
            $shipment->tracking->save();
        }

        $shipment->save();
        $users = User::where('id',$shipment->user_id)->where('status',1)->get()->pluck('id')->toArray();
            if($users){
                $send_notification = [];
                $send_notification['user_id'] = $users;
                $send_notification['title'] = "Status Changed Successfully";
                $send_notification['body'] = "Shipment Status " .$shipment->status;
                $send_notification['url'] = '/my-shipments-overview/'.$shipment->id;
                $send_notification['from_user_id'] = $shipment->trucker_id;
                $send_notification['to_user_id'] = $shipment->user->id;
                $send_notification['type_id'] = $shipment->id;
                $send_notification['type'] = "Shipment";
                send_notification($send_notification);
            }
        return $this->formatResponse(
            'success',
            'status updated successfully'
        );
    }


    public function shimpnet_request(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'shipment_id' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'request_type' => 'required',

        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }


        if($request->request_type == 0){
            $shipment_request =  Bid::create([
                'trucker_id'=> Auth::id(),
                'shipment_id'=> $request->shipment_id,
                'amount'=> $request->amount,
                'status'=> null,
            ]);

            $shipment = Shipment::where('id',$request->shipment_id)->first();
            $users = User::where('id',$shipment->user->id)->where('status',1)->get()->pluck('id')->toArray();
            if($users){
                $send_notification = [];
                $send_notification['user_id'] = $users;
                $send_notification['title'] = "New Bid Request";
                $send_notification['body'] = "Bid Amount $".$request->amount;
                $shipment = Shipment::where('id',$request->shipment_id)->first();
                $send_notification['url'] = '/my-shipments-bid-activity/'. $shipment->id;
                $send_notification['from_user_id'] = Auth::id();
                $send_notification['to_user_id'] = $shipment->user->id;
                 $send_notification['type_id'] = $shipment->id;
                $send_notification['type'] = "Shipment";
                send_notification($send_notification);
            }


            return $this->formatResponse(
                'success',
                'Bid Request Send Successfully'
            );


        }else{



            $shipment = Shipment::find($request->shipment_id);

            // if ($request->type == 0) {
            //     $price =  $shipment->private_rate;
            // } else {
            //     $price = $shipment->dat_rate;
            // }
            $shipment_request =  ShipmentsRequest::create([
                'trucker_id'=> Auth::id(),
                'shipment_id'=> $request->shipment_id,
                'amount'=>  $request->amount,
                'status'=> null,
                'type'=> $request->type,
            ]);

            $users = User::where('id',$shipment->user->id)->where('status',1)->get()->pluck('id')->toArray();
            if($users){
                $send_notification = [];
                $send_notification['user_id'] = $users;
                $send_notification['title'] = "New Shipment Request";
                $send_notification['body'] = "Request Amount $".$shipment_request->amount;
                $send_notification['url'] = '/my-shipments-requests-activity/'.$shipment_request->shipment->id;
                $send_notification['from_user_id'] = Auth::id();
                $send_notification['to_user_id'] = $shipment->user->id;
                $send_notification['type_id'] = $shipment->id;
                $send_notification['type'] = "Shipment";
                send_notification($send_notification);
            }


            return $this->formatResponse(
                'success',
                'Shipment Request Send Successfully'
            );
        }
    }



    public function shipment_request_activity()
    {

        $shipment_request_activity = ShipmentsRequest::where('trucker_id', Auth::id())->get()->map(function ($row) {
            if($row->status == "1"){
                $status = 'Accepted';
            }elseif($row->status == "0"){
                $status = 'Decline';
            }else{
                $status = 'Pending';
            }
            $shipment = [];
            if($row->shipment){
                $shipment = $row->shipment;
                $shipment['equipment_detail'] =  $shipment->equipment_detail == "0" ? "Full" : "Partial";
            }
            return [
                'id' => $row->id,
                'shipment' => $shipment,
                'amount' => $row->amount,

                'status' => $status,
                'type' => $row->type == 0 ?  'is_private' : 'is_loadboard',
            ];
        });

        if(count($shipment_request_activity) > 0){

            return $this->formatResponse(
                'success',
                'Request fetch successfully',
                $shipment_request_activity,
                200
            );
        }else{
            return $this->formatResponse(
                'success',
                'Request Record not found',
                $shipment_request_activity,
                200
            );
        };

    }


    public function bid_request_activity()
    {
        $bid_request_activity = Bid::where('trucker_id', Auth::id())->get()->map(function ($row) {
            if($row->status == 1){
                $status = 'Accepted';
            }elseif($row->status == 0){
                $status = 'Decline';
            }else{
                $status = 'Pending';
            }

             $shipment = [];
            if($row->shipment){
                $shipment = $row->shipment;
                $shipment['equipment_detail'] =  $shipment->equipment_detail == "0" ? "Full" : "Partial";
            }


            return [
                'id' => $row->id,
                'shipment' => $shipment,
                'amount' => $row->amount,
                'status' => $status,
                'type' => $row->type == 0 ?  'is_private' : 'is_loadboard',
            ];
        });

        if(count($bid_request_activity) > 0){

            return $this->formatResponse(
                'success',
                'Request fetch successfully',
                $bid_request_activity,
                200
            );
        }else{
            return $this->formatResponse(
                'success',
                'Request Record not found',
                $bid_request_activity,
                200
            );
        };

    }


    public function shipmentDetail($shipment_id)
    {
        $shipmentDetail = Shipment::where('id', $shipment_id)->first();
        if($shipmentDetail){
            $shipmentDetail = $this->single_sorting_data($shipmentDetail);
            return $this->formatResponse(
                'success',
                'detail fetch successfully',
                $shipmentDetail,
                200
            );
        }else{
            return $this->formatResponse(
                'success',
                'detail Not Found',
                [],
                200
            );
        }


    }


    function tracking_request( Request $request , $id){
        $tracking = Tracking::find($id);
        if($tracking){
                $shipment = $tracking['shipments'] = $tracking->shipments ? $tracking->shipments : [];
                if($tracking->shipments){
                    $shipment['equipment_type'] = $shipment->equipment_type ? $shipment->equipment_type : [];
                    $user = $shipment['user'] = $shipment->user ? $shipment->user : [];
                    if($user){
                        if($user->parent_id != null){
                             $company = Company::where('user_id',$user->parent_id)->first();
                        }else{
                             $company = Company::where('user_id',$user->id)->first();
                        }
                        $shipment['user']['company'] = $company;
                    }
                }
                $tracking['tracking_details'] = $tracking->tracking_details ? $tracking->tracking_details : [];
                if($tracking->tracking_details){
                    foreach ($tracking['tracking_details'] as $detail) {
                        if ($detail['type'] == 1) {
                            $detail['type'] =  'Drop Off';
                        } else {
                            $detail['type'] = 'Pick Up';
                        }
                    }
                }

            return $this->formatResponse(
                'success',
                'Tracking Request fetch Succesfully',
                $tracking,
                200
            );

        }else{
            return $this->formatResponse(
                        'success',
                        'Tracking Request not found',
                        [],
                        200
                    );
        }

        return $this->formatResponse(
            'success',
            'SomeThing Went Wrong',
            [],
            200
        );

    }



    function tracking_status_update( Request $request , $id){

        $validate = Validator::make($request->all(), [
            'status' => 'required',

        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }


        $tracking = Tracking::find($id);
        if(!$tracking){
            return $this->formatResponse(
                'success',
                'Tracking not found',
                [],
                200
            );
        }
        $tracking->tracking_status = strtoupper($request->status);
        $tracking->save();

        return $this->formatResponse(
            'success',
            'Status Updated Successfully',
            $tracking,
            200
        );

    }

    function shipment_saved_list(){

        $ship_saved = ShipmentSaved::where('trucker_id',  Auth::id())->WhereNotIn('shipment_id',requestedShipmentBid(Auth::id()))->WhereNotIn('shipment_id',requestedShipmentPublic(Auth::id()))->whereHas('shipment', function($query){
                $query->where('is_post' , 1)->where('status','Waiting');
            })->orderBy('id','Desc')->paginate(10)->transform(function ($shipment_save) {
            $shipment_save['shipment'] = $shipment_save->shipment  ? $this->single_sorting_data($shipment_save->shipment)  : [];
            $shipment_save['status'] = $shipment_save->status == 1  ? "Saved"  : "Un-Saved";
            return $shipment_save;
        });

        if(count($ship_saved) < 1){
            return $this->formatResponse(
                'success',
                'Record not found',
                [],
                200
            );
        }

        return $this->formatResponse(
            'success',
            'Record fetch Successfully',
            $ship_saved,
            200
        );

    }

    function shipment_saved_update( Request $request){

        $validate = Validator::make($request->all(), [
            'shipment_id' => 'required',

        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }


        $ship_saved = ShipmentSaved::where('shipment_id',$request->shipment_id)->where('trucker_id', Auth::id())->first();
        if($ship_saved){

            $ship_saved->delete();

            return $this->formatResponse(
                'success',
                'Shipment Remove Successfully',
                [],
                200
            );
        }

        $ship_saved = new ShipmentSaved();
        $ship_saved->shipment_id = $request->shipment_id;
        $ship_saved->trucker_id = Auth::id();
        $ship_saved->status = 1;
        $ship_saved->save();


        return $this->formatResponse(
            'success',
            'Shipment Saved Successfully',
            [],
            200
        );

    }


}
