<?php

use App\Models\PushNotification;
use App\Models\UserDeviceToken;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Support\Facades\Http;
use App\Models\Company;
use App\Models\ShipmentsRequest;
use App\Notifications\SendNotificationQueue;
use Illuminate\Support\Facades\Notification;
use App\Models\Advertisement;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
    
    
    function getMerchantAuthentication()
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
       $merchantAuthentication->setName(config('app.transaction_name'));
       $merchantAuthentication->setTransactionKey(config('app.transaction_key'));
       return $merchantAuthentication;
    }




    function currentlocationGetCity($lat, $lng){
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => $lat.','.$lng,
            'sensor' => 'true',
            'key'    => 'AIzaSyDC5ri3ptVu7v8KO3dg3lRv7-pTRjJy94w',
        ]);

        $data = $response->json();
       if(isset($data['status']) && $data['status'] == "OK"){
            $localityResults = collect($data['results'])->filter(function ($result) {
                return in_array('locality', $result['types']);
            });
            if($localityResults->first()){
               return  $localityResults->first()['formatted_address'];
            }else{
                 $localityResults = collect($data['results'])->filter(function ($result) {
                    return in_array('administrative_area_level_2', $result['types']);
                });
                  return  isset($localityResults->first()['formatted_address']) ? $localityResults->first()['formatted_address'] : 'Current Location';
            }
       }
       return 'Current Location';
    }
    
     function requestedShipmentBid($trucker_id)
    {

        $bids = Bid::select('trucker_id','shipment_id','status')->where(function($query){
            $query->Where('status', null)->orwhere('status',1);
        })->distinct()->pluck('shipment_id')->toArray();
        
         $bid = count($bids) > 0 ? $bids : [] ;
        return $bid;
    }
    
     function requestedShipmentPublic($trucker_id)
    {

        $bid = ShipmentsRequest::select('trucker_id','shipment_id','status')->where(function($query){
            $query->Where('status', null)->orwhere('status',1);
        })->distinct()->pluck('shipment_id')->toArray();
        
        $publics = count($bid) > 0 ? $bid : [] ;
        return $publics;
    }

    function send_notification($send_notification = [])
    {

            $users = User::WhereIn('id', $send_notification['user_id'])->where('status',1)->get();
            // dd($send_notification, $users);
            if($users){
                if(isset($send_notification['admin_id_from'])){
                    $usr_id = '';
                    foreach( $users as $k => $item){
                        if($item->id != $usr_id){
                            PushNotification::create([
                                'title' => $send_notification['title'],
                                'body' => $send_notification['body'] ,
                                'admin_id_from' => isset($send_notification['admin_id_from']) ? $send_notification['admin_id_from'] : null,
                                'to_user_id' => $item->id ,
                                'url' => $send_notification['url'] ,
                                'type_id' => $send_notification['type_id'] ,
                                'type' => $send_notification['type'] ,
                                'un_read' => 0,
                            ]);
                        }
                        $usr_id = $item->id;
                    }
                }else{
                    $usr_id = '';

                    foreach($users as $k => $item){

                        if($item->id != $usr_id){
                            PushNotification::create([
                                'title' => $send_notification['title'],
                                'body' => $send_notification['body'] ,
                                'from_user_id' => isset($send_notification['from_user_id']) ? $send_notification['from_user_id'] : null  ,
                                'to_user_id' => $item->id ,
                                'url' => $send_notification['url'] ,
                                'type_id' => $send_notification['type_id'] ,
                                'type' => $send_notification['type'] ,
                                'un_read' => 0,
                            ]);
                        }
                        $usr_id = $item->id;
                    }
                }
            }


        $firebaseToken = UserDeviceToken::WhereIn('user_id', $send_notification['user_id'])->whereNotNull('device_token')->get()->pluck('device_token')->toArray();
        if(count($firebaseToken) > 0){
        return Notification::send($firebaseToken, new SendNotificationQueue($send_notification['title'], $send_notification['body'], $send_notification['url'] , $send_notification));
        }
    }

    function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Format as (111) 111-1111
        return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
    }

    function shipment_invoice_format($shipment_invoice){

            // dd($shipment_invoice->shipment);
            $data = [];
            $company = null;
            $carrier = null;
            if($shipment_invoice->user){
                if($shipment_invoice->user->parent_id != null){
                    $company = Company::where('user_id',$shipment_invoice->user->parent_id)->first();
                }else{
                    $company = Company::where('user_id', $shipment_invoice->user->id)->first();
                }
            }
            if($shipment_invoice->carrier){
                if($shipment_invoice->carrier->parent_id != null){
                    $carrier = Company::where('user_id',$shipment_invoice->carrier->parent_id)->first();
                }else{
                    $carrier = Company::where('user_id', $shipment_invoice->carrier->id)->first();
                }
            }


            $data['invoice_no'] = $shipment_invoice->invoice_no;
            $data['shipment_id'] = $shipment_invoice->shipment_id;
            $data['bil_comp_name'] = $company ? $company->name : '-';
            $data['bil_comp_add'] = $company ? $company->address : '-';
            $data['bil_comp_phone'] = $company ? $company->phone : '-';
            $data['pay_comp_name'] = $carrier ? $carrier->name : '-';
            $data['pay_comp_add'] = $carrier ? $carrier->address : '-';
            $data['pay_comp_phone'] = $carrier ? $carrier->phone : '-';
            // $data['url'] = $shipment_invoice->shipment ? $shipment_invoice->shipment->tracking ? config('app.url').'/api/trucker/tracking-request/'.$shipment_invoice->shipment->tracking->id  : null : null;
            $data['url'] = $shipment_invoice->shipment ? $shipment_invoice->shipment->tracking ? "https://portallink.pttrloadboard.com/tracking-request-link/".$shipment_invoice->shipment->tracking->id  : null : null;
            $data['ref_no'] = $shipment_invoice->shipment ? $shipment_invoice->shipment->reference_id : '-';
            $data['invoice_date'] = Carbon\Carbon::create($shipment_invoice->created_at)->format('F j Y h:m a');
            $data['origin'] = $shipment_invoice->shipment ? $shipment_invoice->shipment->origin : '-';
            $data['destination'] = $shipment_invoice->shipment ? $shipment_invoice->shipment->destination : '-';
            $data['equipment_type'] = $shipment_invoice->shipment ? $shipment_invoice->shipment->equipment_type->name : '-';
            $data['weight'] = $shipment_invoice->shipment ? $shipment_invoice->shipment->weight : '-';
            $data['start'] = $shipment_invoice->shipment ? Carbon\Carbon::create($shipment_invoice->shipment->from_date)->format('F j, Y') : '-';
            $data['end'] = $shipment_invoice->shipment ? Carbon\Carbon::create($shipment_invoice->shipment->to_date)->format('F j, Y') : '-';
            $data['price'] = $shipment_invoice->price;
            return $data;
    }
    function ads($page, $position){

        $ads = Advertisement::where('page_name',$page)->where('position',$position)->first();
        return $ads;
    }

    function ads_get($page, $position){
            $ads = Advertisement::where('page_name',$page)->where('position',$position)->get();
            return $ads;
        }

    function get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2) {
        $p1 = deg2rad($latitude1);
        $p2 = deg2rad($latitude2);
        $dp = deg2rad($latitude2 - $latitude1);
        $dl = deg2rad($longitude2 - $longitude1);
        $a = (sin($dp/2) * sin($dp/2)) + (cos($p1) * cos($p2) * sin($dl/2) * sin($dl/2));
        $c = 2 * atan2(sqrt($a),sqrt(1-$a));
        $r = 6371008; // Earth's average radius, in meters
        $d = $r * $c; // distance, in meters
        $miles = $d / 1609.34;
        return round($miles); // distance, in miles
    }


