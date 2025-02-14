<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class NotificationController extends Controller
{

    public function notifications(Request $request)
    {
        $ntoi = array();
        if(request()->input('id')){
            $notifications = PushNotification::select('id', 'title', 'body', 'un_read', 'type_id' , 'type','created_at', 'updated_at')->where('to_user_id', Auth::id())->where('id',request()->input('id'))->get();
            // return $this->formatResponse(
            //     'success',
            //     'Notification fetch successfully',
            //     $notifications,
            //     200
            // );
        }else{
            $notifications = PushNotification::select('id', 'title', 'body', 'un_read', 'type_id' , 'type','created_at', 'updated_at')->where('to_user_id', Auth::id())->orderBy('id','Desc')->paginate(10);
           
        } 
                
            $notifications->transform(function ($noti) {
                  $noti['shipments'] = $noti->type == "Shipment" ? $noti->shipments ?  $this->single_sorting_data($noti->shipments) : [] : [];
                  return $noti;
            });
      

            // $notifications = $notifications->transform(function ($notification)  {
            //     return [
            //         "id" => $notification->id,
            //         "title" => $notification->title,
            //         "body" => $notification->body,
            //         "un_read" => $notification->un_read,
            //         "created_at" => $notification->created_at,
            //         "updated_at" => $notification->updated_at,
            //     ];
            // });
             $ntoi['noti_count'] =  PushNotification::where('to_user_id', Auth::id())->where('un_read', 0)->orderBy('id','Desc')->count();
             
             $ntoi['list'] = $notifications;
             
             
            return $this->formatResponse(
                'success',
                'Notification fetch successfully',
                $ntoi,
                200
            );
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


    public function notification_read($id = null)
    {
        if (is_null($id)) {
            return $this->formatResponse(
                'error',
                'Notification ID is required',
                [],
                400 
            );
        }

        $notification = PushNotification::select('id', 'title', 'body', 'un_read', 'created_at', 'updated_at')->where('to_user_id', auth()->user()->id)->where('id', $id)->first();
        $notification->un_read = 1;
        $notification->save();

        return $this->formatResponse(
            'success',
            'Notification Read successfully',
            $notification,
            200
        );
    }
    
    public function notification_delete($id = null)
    {
         if (is_null($id)) {
            return $this->formatResponse(
                'error',
                'Notification ID is required',
                [],
                400 
            );
        }
        
        $notification = PushNotification::select('id', 'title', 'body', 'un_read', 'created_at', 'updated_at')->where('to_user_id', auth()->user()->id)->where('id', $id)->delete();
        return $this->formatResponse(
            'success',
            'Notification Delete Successfully',
            [],
            200
        );
    }
    public function notification_clear_all()
    {
        
         $notifications = PushNotification::where('to_user_id',auth()->user()->id)->where('un_read',0)->update(array(
            'un_read' => 1
        ));
        return $this->formatResponse(
            'success',
            'Notification Clear Successfully',
            [],
            200
        );
    }




}
