<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\EquipmentType;
use App\Models\Group;
use App\Models\Shipment;
use App\Models\Tracking;
use App\Models\State;
use App\Models\City;
use App\Models\TrackingDetail;
use Illuminate\Http\Request;
use App\Models\ShipmentStatusTracking;
use Carbon\Carbon;
use App\Models\Company;

class PostAShipmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function state_city(Request $request)
    {
        $query = $request->q;
        $results = [];
        
        

        if(isset($request->sel) && count($request->sel) > 0){
                if (strpos($request->sel[0], 'city_') === 0) {
                    $city_id = (int)str_replace('city_', '', $request->sel[0]);
                    $cities = City::where('id', $city_id)->get();
                    $results = $cities->map(function($city) {
                        if($city->states != null){
                            return [
                                'id' => 'city_' . $city->id,
                                'text' =>  $city->name . ', '.$city->states->code.', '. $city->states->country_code
                            ];
                        }else{
                            return [
                                'id' => 'city_' . $city->id,
                                'text' =>  $city->name
                            ];
                        }
                    })->toArray();
                }else{
                    $state_ids = [];
                    foreach($request->sel as $state_id){
                        $state_ids[] = (int)str_replace('state_', '', $state_id);
                    }
                    $states = State::whereIn('id', $state_ids)->get();
                    $results = $states->map(function($state) {
                        return [
                            'id' => 'state_' . $state->id,
                            'text' =>  $state->code  .', ' .$state->name
                        ];
                    })->toArray();
                }


                return response()->json([
                    'items' => $results
                ]);
        }

        if($query == null){
            return response()->json([
                    'items' => $results
                ]);
        }
        
        if(isset($request->c) && $request->c == "city"){
            
            
            //old
            // $cities = City::where(function ($que) use ($query) {
            //     $que->where('name', 'LIKE',  $query . '%')->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["{$query}%"])
            //         ->orWhereHas('states', function($qe) use ($query){
            //         $qe->where('code', 'LIKE', '%' . $query . '%');
            //     });
            // })->take(40)->get();
            
            //new implement
            $cities = City::where(function ($que) use ($query) {
                if (strpos($query, ',') !== false) {
                    [$cityName, $stateCode] = array_map('trim', explode(',', $query));
                    $que->where(function($q) use($cityName){
                            $q->where('name', 'LIKE', $cityName . '%')
                            ->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["{$cityName}%"]);
                        })
                        ->whereHas('states', function ($qe) use ($stateCode) {
                            $qe->where('code', 'LIKE', $stateCode . '%');
                        });
                } else {
                    $que->where('name', 'LIKE', $query . '%')
                        ->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["{$query}%"])
                        ->orWhereHas('states', function ($qe) use ($query) {
                            $qe->where('code', 'LIKE', '%' . $query . '%');
                        });
                }
            })->where('name', '!=','Anywhere')->take(40)->get();
            $results = $cities->map(function($city) {
                return [
                    'id' => $city->id, // Prefixing to distinguish between state and city
                    'text' =>  $city->name . ', '.$city->states->code.', '. $city->states->country_code
                ];
            })->toArray();
        }else{
            $states = State::where('code',  $query)->take(15)->get();
           
            if(count($states) >= 1){
                $results = $states->map(function($state) {
                    return [
                        'id' => 'state_' . $state->id, // Prefixing to distinguish between state and city
                        'text' =>  $state->code  .', ' .$state->name
                    ];
                })->toArray();
                return response()->json([
                    'items' => $results
                ]);
            }else{
                //old impletent
                //  $cities = City::where(function ($que) use ($query) {
                //     $que->where('name', 'LIKE',  $query . '%')->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["{$query}%"])
                //     ->orWhereHas('states', function($qe) use ($query){
                //         $qe->where('code', 'LIKE', '%' . $query . '%');
                //     });
                //  })->take(40)->get();
                 
                 //new impletemt
                 $cities = City::where(function ($que) use ($query) {
                    if (strpos($query, ',') !== false) {
                        [$cityName, $stateCode] = array_map('trim', explode(',', $query));
                        $que->where(function($q) use($cityName){
                                $q->where('name', 'LIKE', $cityName . '%')
                                ->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["{$cityName}%"]);
                            })
                            ->whereHas('states', function ($qe) use ($stateCode) {
                                $qe->where('code', 'LIKE', $stateCode . '%');
                            });
                    } else {
                        $que->where('name', 'LIKE', $query . '%')
                            ->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["{$query}%"])
                            ->orWhereHas('states', function ($qe) use ($query) {
                                $qe->where('code', 'LIKE', '%' . $query . '%');
                            });
                    }
                })->take(40)->get();
                
                
                 $results = $cities->map(function($city) {
                     
                if($city->states != null){
                    return [
                        'id' => 'city_' .$city->id, // Prefixing to distinguish between state and city
                        'text' =>  $city->name . ', '.$city->states->code .', '. $city->states->country_code 
                    ];
                }else{
                    return [
                        'id' => 'city_' . $city->id, // Prefixing to distinguish between state and city
                        'text' =>  $city->name
                    ];
                }
                })->toArray();
                
                return response()->json([
                    'items' => $results
                ]);
            }
           


            // $states = $states->map(function($state) {
            //     return [
            //         'id' => 'state_' . $state->id, // Prefixing to distinguish between state and city
            //         'text' =>  $state->code  .', ' .$state->country_code
            //     ];
            // });
            // $cities = $cities->map(function($city) {
            //     return [
            //         'id' => 'city_' . $city->id, // Prefixing to distinguish between state and city
            //         'text' =>  $city->name . ', '.$city->states->code.', '. $city->states->country_code
            //     ];
            // });

            // if(count($states) > 0){
            //     $results = $states->toArray();
            // }
            // if(count($cities) > 0){
            //     $results = $cities->toArray();
            // }
            // if(count($cities) > 0 && count($states) > 0){
            //     $results = array_merge($states->toArray(), $cities->toArray());
            // }
        }
        return response()->json([
            'items' => $results
        ]);
    }




    public function post_a_shipment()
    {
        $equipment_types = EquipmentType::get();
        $equipment_type_tools = EquipmentType::whereIn('id',[1,2,4])->get();
        $groups = Group::where('user_id' , auth()->user()->id)->get();
        $contact = Contact::where('user_id' , auth()->user()->id)->count();
        return view('Global.post-a-shipment', get_defined_vars());
    }


    public function store_a_shipment(Request $request)
    {

        $request->validate([
            "origin" => "required",
            "destination" => "required",
            "from_date" => "sometimes",
            "to_date" => "sometimes",
            "from_time" => "sometimes",
            "to_time" => "sometimes",
            "equipment_detail" => "required",
            "eq_type_id" => "required",
            "length" => "required",
            "weight" => "required",
            "eq_name" => "sometimes",
            "commodity" => "sometimes",
            "reference_id" => "sometimes",
            "status_phone" => "required_without:status_email",
            "status_email" => "required_without:status_phone",

        ],[
            "origin.required" => "Origin (City, ST, ZIP)",
            "destination.required" => "Destination (City, ST, ZIP)",
            "eq_type_id.required" => "Equipment Type",
            "length.required" => "Lenght (ft) ",
            "weight.required" => "Weight (lbs.) ",
            "status_phone.required_without" => "Phone",
            "status_email.required_without" => "Email",

        ]);

        // $url = "https://maps.googleapis.com/maps/api/directions/json?origin=place_id:".$request->origin_place_id."&destination=place_id:".$request->destination_place_id."&key=AIzaSyDC5ri3ptVu7v8KO3dg3lRv7-pTRjJy94w&mode=driving";
        $origin = City::find($request->origin);
        $destination = City::find($request->destination);


            $url = "https://maps.googleapis.com/maps/api/directions/json?origin=".$origin->latitude.",".$origin->longitude."&destination=".$destination->latitude.",".$destination->longitude."&key=AIzaSyDC5ri3ptVu7v8KO3dg3lRv7-pTRjJy94w&mode=driving";
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);
            if($json_data['status'] == "OK"){
            $miles =  str_replace(' mi', '', $json_data['routes'][0]['legs'][0]['distance']['text']);
            $duration =  $json_data['routes'][0]['legs'][0]['duration']['text'];
            }else{
                $miles = 1;
                $duration = '-';
            }

            $origin_name = $origin->name . ', '.$origin->states->code.', '. $origin->states->country_code;
            $destination_name = $destination->name . ', '.$destination->states->code.', '. $destination->states->country_code;

            $shipment = new Shipment();
            $shipment->miles =  floatval(preg_replace("/[^-0-9\.]/","",$miles));
            $shipment->duration =  $duration;
            $shipment->origin_city_id =  $origin->id;
            $shipment->origin_state_id =  $origin->state_id;
            $shipment->origin =  $origin_name;
            $shipment->origin_lat =  $origin->latitude;
            $shipment->origin_lng =  $origin->longitude;
            $shipment->origin_place_id = null;
            $shipment->destination =  $destination_name;
            $shipment->destination_city_id =  $destination->id;
            $shipment->destination_state_id =  $destination->state_id;
            $shipment->destination_lat =  $destination->latitude;
            $shipment->destination_lng =  $destination->longitude;
            $shipment->destination_place_id =  null;
            $shipment->from_date =  $request->from_date;
            $shipment->to_date =  $request->to_date;
            $shipment->from_time =  $request->from_time;
            $shipment->to_time =  $request->to_time;
            $shipment->equipment_detail =  $request->equipment_detail;
            $shipment->eq_type_id =  $request->eq_type_id;
            $shipment->length =  $request->length;
            $shipment->weight =  $request->weight;
            $shipment->eq_name =  $request->eq_name;
            $shipment->commodity =  $request->commodity;
            $shipment->reference_id =  $request->reference_id;
            $shipment->status_phone =  $request->status_phone ? 1 : 0;
            $shipment->status_email =  $request->status_email ? 1 : 0;
            $shipment->user_id =  auth()->user()->id;
            if(auth()->user()->parent_id != null){
                $company = Company::where('user_id',auth()->user()->parent_id)->first();
            }else{
                $company = Company::where('user_id', auth()->user()->id)->first();
            }
            $shipment->company_id = $company->id ;
            $shipment->status =  "WAITING";
            $shipment->is_tracking = isset($request->is_tracking) ? 1 : 0;
            $shipment->is_private_network = isset($request->is_private_network) ? 1 : 0;
            $shipment->entire_private_network_id =  isset($request->postPrivate) && $request->postPrivate == 'entire_private_network_id' ? 1 : 0;
            if(isset($request->postPrivate) && $request->postPrivate == 'is_group'){
                $shipment->is_group =  isset($request->postPrivate) && $request->postPrivate == 'is_group' ? 1 : 0;
                $shipment->group_id =  isset($request->postPrivate) && $request->postPrivate == 'is_group' ?serialize($request->groups) : null;
            }else{
                $shipment->is_group = 0;
                $shipment->group_id = null;
            }
            $shipment->is_public_load = isset($request->is_public_load) ? 1 : 0;
            $shipment->is_allow_carrier_to_book_now = isset($request-> is_allow_carrier_to_book_now) ? 1 : 0;
            $shipment->dat_rate =  isset($request->is_public_load) ? $request->dat_rate : null;
            if(isset($request->is_private_network)){

                $shipment->private_rate = $request->private_rate;
                $shipment->is_allow_bids = isset($request->is_allow_bids) &&  $request->is_allow_bids == "true" ? 1 : 0;
                $shipment->max_bid_rate = isset($request->is_allow_bids) && isset($request->is_allow_bids) == "true" ? $request->max_bid_rate : null;
            }

        $shipment->save();
        // dd($request->all());
        if(isset($request->is_tracking) && $request->is_tracking == true){
            $tracking = Tracking::create([
                "phone" => null,
                "name" => null,
                "carrier_email" => null,
                "Shipment_name_id" => null,
                "tracking_status" => 'PENDING',
                "shipment_id" => $shipment->id,
                "user_id" => auth()->user()->id

            ]);

            foreach($request->street_address as $k => $str){


                $tracking_detail = new TrackingDetail();
                $tracking_detail->street_address = $str;
                $tracking_detail->street_place_id = null;
                $tracking_detail->street_addressLat = $request->street_addressLat[$k] ? $request->street_addressLat[$k] : null;
                $tracking_detail->street_addressLng = $request->street_addressLng[$k] ? $request->street_addressLng[$k] : null;
                $tracking_detail->appointment_date = $request->appointment_date[$k] ? $request->appointment_date[$k] : null;
                $tracking_detail->dock_info = $request->appointment_date[$k] ? $request->dock_info[$k] : null;
                $tracking_detail->start_time = $request->start_time[$k] ? $request->start_time[$k] : null;
                $tracking_detail->end_time = $request->end_time[$k] ? $request->end_time[$k] : null;
                $tracking_detail->lcoation_name = $request->lcoation_name[$k] ? $request->lcoation_name[$k] : null;
                $tracking_detail->tracking_start_time = isset($request->tracking_start_time[$k]) ? $request->tracking_start_time[$k] : null;
                $tracking_detail->type = $request->types[$k] ? $request->types[$k] : 0;
                $tracking_detail->notes = $request->notes[$k] ? $request->notes[$k] : null;
                $tracking_detail->sort_no = $request->sort_no[$k] ? $request->sort_no[$k] : null;
                $tracking_detail->tracking_id = $tracking->id;
                $tracking_detail->save();
            }
            $shipment->tracking_id = $tracking->id;
            $shipment->save();
        }
        $shipment->save();

    	$ship_stat_tracking = ShipmentStatusTracking::where('shipment_id',$shipment->id)->where('status',"PENDING")->first();
        if($ship_stat_tracking){
            $ship_stat_tracking->status = "PENDING";
            $ship_stat_tracking->save();
        }else{
            $ship_stat_tracking = new ShipmentStatusTracking();
             $ship_stat_tracking->status = "PENDING";
             $ship_stat_tracking->shipment_id = $shipment->id;
            $ship_stat_tracking->save();
        }


        return redirect()->route(auth()->user()->type.'.my_shipments')->with('success', "Shipment Posted Successfully");
    }





    public function edit_a_shipment($id)
    {

        $equipment_types = EquipmentType::get();
        $equipment_type_tools = EquipmentType::whereIn('id',[1,2,4])->get();
        $contact = Contact::count();
        $groups = Group::where('user_id' , auth()->user()->id)->get();
        $shipment = Shipment::find($id);
        return view('Shipment.edit-a-shipment', get_defined_vars());
    }


    public function update_a_shipment(Request $request , $id)
    {
        
        $request->validate([
            "origin" => "required",
            "destination" => "required",
            "from_date" => "sometimes",
            "to_date" => "sometimes",
            "from_time" => "sometimes",
            "to_time" => "sometimes",
            "equipment_detail" => "required",
            "eq_type_id" => "required",
            "length" => "required",
            "weight" => "required",
            "eq_name" => "sometimes",
            "commodity" => "sometimes",
            "reference_id" => "sometimes",
            "status_phone" => "required_without:status_email",
            "status_email" => "required_without:status_phone",

        ],[
            "origin.required" => "Origin (City, ST, ZIP)",
            "destination.required" => "Destination (City, ST, ZIP)",
            "eq_type_id.required" => "Equipment Type",
            "length.required" => "Lenght (ft) ",
            "weight.required" => "Weight (lbs.) ",
            "status_phone.required_without" => "Phone",
            "status_email.required_without" => "Email",
        ]);
        

            $origin = City::find($request->origin);
            $destination = City::find($request->destination);


            $url = "https://maps.googleapis.com/maps/api/directions/json?origin=".$origin->latitude.",".$origin->longitude."&destination=".$destination->latitude.",".$destination->longitude."&key=AIzaSyDC5ri3ptVu7v8KO3dg3lRv7-pTRjJy94w&mode=driving";
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);
            if($json_data['status'] == "OK"){
            $miles =  str_replace(' mi', '', $json_data['routes'][0]['legs'][0]['distance']['text']);
            $duration =  $json_data['routes'][0]['legs'][0]['duration']['text'];
            }else{
                $miles = 1;
                $duration = '-';
            }

            $origin_name = $origin->name . ', '.$origin->states->code.', '. $origin->states->country_code;
            $destination_name = $destination->name . ', '.$destination->states->code.', '. $destination->states->country_code;



            $shipment = Shipment::find($id);
            $shipment->miles =  floatval(preg_replace("/[^-0-9\.]/","",$miles));
            $shipment->duration =  $duration;
            $shipment->origin_city_id =  $origin->id;
            $shipment->origin_state_id =  $origin->state_id;
            $shipment->origin =  $origin_name;
            $shipment->origin_lat =  $origin->latitude;
            $shipment->origin_lng =  $origin->longitude;
            $shipment->origin_place_id = null;
            $shipment->destination =  $destination_name;
            $shipment->destination_city_id =  $destination->id;
            $shipment->destination_state_id =  $destination->state_id;
            $shipment->destination_lat =  $destination->latitude;
            $shipment->destination_lng =  $destination->longitude;
            $shipment->destination_place_id =  null;
            // $shipment->origin =  $request->origin;
            // $shipment->origin_lat =  $request->origin_lat;
            // $shipment->origin_lng =  $request->origin_lng;
            // $shipment->origin_place_id = $request->origin_place_id;
            // $shipment->destination =  $request->destination;
            // $shipment->destination_lat =  $request->destination_lat;
            // $shipment->destination_lng =  $request->destination_lng;
            // $shipment->destination_place_id =  $request->destination_place_id;
            $shipment->from_date =  $request->from_date;
            $shipment->to_date =  $request->to_date;
            $shipment->from_time =  $request->from_time;
            $shipment->to_time =  $request->to_time;
            $shipment->equipment_detail =  $request->equipment_detail;
            $shipment->eq_type_id =  $request->eq_type_id;
            $shipment->length =  $request->length;
            $shipment->weight =  $request->weight;
            $shipment->eq_name =  $request->eq_name;
            $shipment->commodity =  $request->commodity;
            $shipment->reference_id =  $request->reference_id;
            $shipment->status_phone =  $request->status_phone ? 1 : 0;
            $shipment->status_email =  $request->status_email ? 1 : 0;
            $shipment->user_id =  auth()->user()->id;
            $shipment->status =  "WAITING";
            $shipment->created_at = Carbon::now();
             if(auth()->user()->parent_id != null){
                $company = Company::where('user_id',auth()->user()->parent_id)->first();
            }else{
                $company = Company::where('user_id', auth()->user()->id)->first();
            }
            $shipment->company_id = $company->id ;
            $shipment->is_tracking = isset($request->is_tracking) ? 1 : 0;
            $shipment->is_private_network = isset($request->is_private_network) ? 1 : 0;
            $shipment->entire_private_network_id =  isset($request->postPrivate) && $request->postPrivate == 'entire_private_network_id' ? 1 : 0;
            if(isset($request->postPrivate) && $request->postPrivate == 'is_group'){
                $shipment->is_group =  isset($request->postPrivate) && $request->postPrivate == 'is_group' ? 1 : 0;
                $shipment->group_id =  isset($request->postPrivate) && $request->postPrivate == 'is_group' ?serialize($request->groups) : null;
            }
            else{
                $shipment->is_group = 0;
                $shipment->group_id = null;
            }
            $shipment->is_public_load = isset($request->is_public_load) ? 1 : 0;
            $shipment->is_allow_carrier_to_book_now = isset($request-> is_allow_carrier_to_book_now) ? 1 : 0;
            $shipment->dat_rate =  isset($request->is_public_load) ? $request->dat_rate : null;
            if(isset($request->is_private_network)){
                $shipment->private_rate = $request->private_rate;
                $shipment->is_allow_bids = isset($request->is_allow_bids) &&  $request->is_allow_bids == "true" ? 1 : 0;
                $shipment->max_bid_rate = isset($request->is_allow_bids) && isset($request->is_allow_bids) == "true" ? $request->max_bid_rate : null;
            }


        $shipment->save();
        if($shipment->tracking){
            foreach($shipment->tracking->tracking_details as $tracking_detail){
                $tracking_detail->delete();
            }
            $shipment->tracking->delete();
        }
        if(isset($request->is_tracking)){

            $shipment = Shipment::find($id);
            $tracking = Tracking::create([
                "phone" => null,
                "name" => null,
                "carrier_email" => null,
                "Shipment_name_id" => null,
                "tracking_status" => 'PENDING',
                "shipment_id" => $shipment->id,
                "user_id" => auth()->user()->id
            ]);

            foreach($request->street_address as $k => $str){
                $tracking_detail = new TrackingDetail();
                $tracking_detail->street_address = $str;
                $tracking_detail->street_place_id =  null;
                $tracking_detail->street_addressLat = $request->street_addressLat[$k] ? $request->street_addressLat[$k] : null;
                $tracking_detail->street_addressLng = $request->street_addressLng[$k] ? $request->street_addressLng[$k] : null;
                $tracking_detail->appointment_date = $request->appointment_date[$k] ? $request->appointment_date[$k] : null;
                $tracking_detail->dock_info = $request->appointment_date[$k] ? $request->dock_info[$k] : null;
                $tracking_detail->start_time = $request->start_time[$k] ? $request->start_time[$k] : null;
                $tracking_detail->end_time = $request->end_time[$k] ? $request->end_time[$k] : null;
                $tracking_detail->lcoation_name = $request->lcoation_name[$k] ? $request->lcoation_name[$k] : null;
                $tracking_detail->tracking_start_time = isset($request->tracking_start_time[$k]) ? $request->tracking_start_time[$k] : null;
                $tracking_detail->type = $request->types[$k] ? $request->types[$k] : 0;
                $tracking_detail->notes = $request->notes[$k] ? $request->notes[$k] : null;
                $tracking_detail->sort_no = $request->sort_no[$k] ? $request->sort_no[$k] : null;
                $tracking_detail->tracking_id = $tracking->id;
                $tracking_detail->save();
            }
            $shipment->tracking_id = $tracking->id;
        }
        $shipment->save();
        $ship_stat_tracking = ShipmentStatusTracking::where('shipment_id',$shipment->id)->where('status',"PENDING")->first();
        if($ship_stat_tracking){
            $ship_stat_tracking->status = "PENDING";
            $ship_stat_tracking->save();
        }else{
            $ship_stat_tracking = new ShipmentStatusTracking();
             $ship_stat_tracking->status = "PENDING";
             $ship_stat_tracking->shipment_id = $shipment->id;
            $ship_stat_tracking->save();
        }
        return redirect()->route(auth()->user()->type.'.my_shipments')->with('success', "Shipment Updated Successfully");
    }


    public function delete_a_shipment($id){

        $shipment = Shipment::find($id);
        if($shipment){
            if($shipment->tracking){
                $shipment_tracking = $shipment->tracking;
                if($shipment->tracking->tracking_details){
                        foreach ($shipment->tracking->tracking_details as $td) {
                            $td->delete();
                        }
                    // dd($shipment->tracking->tracking_details);
                }
                $shipment_tracking->delete();
                // dd($shipment_tracking);
            }
            if($shipment->shimpents_requests){
                foreach ($shipment->shimpents_requests as $shp_req) {
                    $shp_req->delete();
                }
            }
            if($shipment->bids){
                foreach ($shipment->bids as $bid_req) {
                    $bid_req->delete();
                }
            }
            if($shipment->shipment_status_trackings){
                foreach ($shipment->shipment_status_trackings as $shipment_status_tracking) {
                    $shipment_status_tracking->delete();
                }
            }

            $shipment->delete();
            return back()->with('success', "Shipment Successfully Deleted");
        }else{
            return back()->with('error', "Shipment Not Found");
        }


    }

}
