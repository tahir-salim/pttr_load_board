<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\City;
use App\Models\Company;
use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\EquipmentType;
use App\Models\Shipment;
use App\Models\ShipmentsRequest;
use App\Models\ShipmentStatusTracking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;





class SearchLoadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

     public function search_loads(Request $request)
     {
        // dd($request->all());
          $exact_shipments = [];
          $included_shipments = [];
          $org_lat = null;
          $org_lng = null;
          $des_lat = null;
          $des_lng = null;
          $equipment_types = EquipmentType::get();
          // dd(isset($request->origin) && count($request->origin) > 0 && $request->destination == null);
          
           if(isset($request->origin) && count($request->origin) > 0){
                if($request->origin[0] == "city_117058"){
                    $request->origin = [];
                }
            }
            if(isset($request->destination) && count($request->destination) > 0){
                if($request->destination[0] == "city_117058"){
                    $request->destination = [];
                }
            }
            
            
            
          if (isset($request->origin) && count($request->origin) > 0 && $request->destination == null) {

               if (strpos($request->origin[0], 'city_') === 0) {
                    $city_id = (int)str_replace('city_', '', $request->origin[0]);
                    $origin_city = City::find($city_id);
                    $shipments1 = Shipment::select(['id', 'origin', 'origin_lat', 'origin_lng', 'destination'])->where('status', 'WAITING')->get();
                    $org_lat = $origin_city->latitude;
                    $org_lng = $origin_city->longitude;

                    foreach ($shipments1 as $shipment) {
                         $distance = (int)get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $origin_city->latitude, $origin_city->longitude);
                         if ($distance <= (int)$request->dho) {
                              $exact_shipments[] = $shipment->id;
                         } elseif ($distance <= (int)$request->dho + 200) {
                              $included_shipments[] = $shipment->id;
                         }
                    }
               } else {

                    $state_ids = [];
                    foreach ($request->origin as $state_id) {
                         $state_ids[] = (int)str_replace('state_', '', $state_id);
                    }
                    $exact_shipments = Shipment::select(['id'])->whereIn('origin_state_id', $state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();
               }
          } elseif (isset($request->destination) && count($request->destination) > 0  && $request->origin == null) {

               if (strpos($request->destination[0], 'city_') === 0) {
                    $city_id = (int)str_replace('city_', '', $request->destination[0]);
                    $destination_city = City::find($city_id);
                    $des_lat = $destination_city->latitude;
                    $des_lng = $destination_city->longitude;
                    $shipments1 = Shipment::select(['id', 'destination_lat', 'destination_lng', 'destination'])->where('status', 'WAITING')->get();
                    foreach ($shipments1 as $shipment) {
                         $distance = (int)get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $destination_city->latitude, $destination_city->longitude);
                         if ($distance <= (int)$request->dhd) {
                              $exact_shipments[] = $shipment->id;
                         } elseif ($distance <= (int)$request->dhd + 200) {
                              $included_shipments[] = $shipment->id;
                         }
                    }
               } else {
                    $state_ids = [];
                    foreach ($request->destination as $state_id) {
                         $state_ids[] = (int)str_replace('state_', '', $state_id);
                    }
                    $exact_shipments = Shipment::select(['id'])->whereIn('destination_state_id', $state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();
               }
          } elseif (isset($request->origin) && count($request->origin) > 0 && isset($request->destination) && count($request->destination) > 0) {
               if (strpos($request->origin[0], 'city_') === 0 && strpos($request->destination[0], 'city_') === 0) {
                    $orgin_city_id = (int)str_replace('city_', '', $request->origin[0]);
                    $dest_city_id = (int)str_replace('city_', '', $request->destination[0]);
                    $origin_city = City::find($orgin_city_id);
                    $dest_city = City::find($dest_city_id);

                    $org_lat =  $origin_city->latitude;
                    $org_lng =  $origin_city->longitude;
                    $des_lat =  $dest_city->latitude;
                    $des_lng =  $dest_city->longitude;
                    $shipments1 = Shipment::select(['id', 'origin', 'origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'destination', 'status'])->where('status', 'WAITING')->get();
                    foreach ($shipments1 as $shipment) {
                         $DHO = (int)get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $origin_city->latitude, $origin_city->longitude);
                         $DHD = (int)get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $dest_city->latitude, $dest_city->longitude);
                         if ($DHO <= (int)$request->dho && $DHD <= (int)$request->dhd) {
                              $exact_shipments[] = $shipment->id;
                         } elseif ($DHO <= (int)$request->dho + 200 && $DHD <= (int)$request->dhd + 200) {
                              $included_shipments[] = $shipment->id;
                         }
                    }
               } elseif (strpos($request->origin[0], 'state_') === 0 && strpos($request->destination[0], 'state_') === 0) {

                    $origin_state_ids = [];
                    $dest_state_ids = [];
                    foreach ($request->origin as $o_state_id) {
                         $origin_state_ids[] = (int)str_replace('state_', '', $o_state_id);
                    }
                    foreach ($request->destination as $d_state_id) {
                         $dest_state_ids[] = (int)str_replace('state_', '', $d_state_id);
                    }

                    $exact_shipments = Shipment::select(['id'])->whereIn('origin_state_id', $origin_state_ids)->whereIn('destination_state_id', $dest_state_ids)->where('status', 'WAITING')->pluck('id')->toArray();
               } elseif (strpos($request->origin[0], 'city_') === 0 && strpos($request->destination[0], 'state_') === 0) {
                    $origin_city_id = (int)str_replace('city_', '', $request->origin[0]);
                    $origin_city = City::find($origin_city_id);

                    $org_lat =  $origin_city->latitude;
                    $org_lng =  $origin_city->longitude;

                    $shipments1 = Shipment::select(['id', 'origin', 'origin_lat', 'origin_lng', 'destination'])->where('status', 'WAITING')->get();
                    foreach ($shipments1 as $shipment) {
                         $distance = (int)get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $origin_city->latitude, $origin_city->longitude);
                         if ($distance <= (int)$request->dho) {
                              $exact_shipments[] = $shipment->id;
                         } elseif ($distance <= (int)$request->dho + 200) {
                              $included_shipments[] = $shipment->id;
                         }
                    }

                    $dest_state_ids = [];
                    foreach ($request->destination as $d_state_id) {
                         $dest_state_ids[] = (int)str_replace('state_', '', $d_state_id);
                    }
                    $exact_shipments =  Shipment::select(['id'])->whereIn('id', $exact_shipments)->whereIn('destination_state_id', $dest_state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();
                    $included_shipments =  Shipment::select(['id'])->whereIn('id', $included_shipments)->whereIn('destination_state_id', $dest_state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();
               } elseif (strpos($request->origin[0], 'state_') === 0 && strpos($request->destination[0], 'city_') === 0) {
                    $dest_city_id = (int)str_replace('city_', '', $request->destination[0]);
                    $dest_city = City::find($dest_city_id);

                    $des_lat =  $dest_city->latitude;
                    $des_lng =  $dest_city->longitude;
                    $shipments1 = Shipment::select(['id', 'origin', 'destination_lat', 'destination_lng', 'destination'])->where('status', 'WAITING')->get();
                    foreach ($shipments1 as $shipment) {
                         $distance = (int)get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $dest_city->latitude, $dest_city->longitude);
                         if ($distance <= (int)$request->dhd) {
                              $exact_shipments[] = $shipment->id;
                         } elseif ($distance <= (int)$request->dhd + 200) {
                              $included_shipments[] = $shipment->id;
                         }
                    }

                    $origin_state_ids = [];
                    foreach ($request->origin as $o_state_id) {
                         $origin_state_ids[] = (int)str_replace('state_', '', $o_state_id);
                    }
                    $exact_shipments =  Shipment::select(['id'])->whereIn('id', $exact_shipments)->whereIn('origin_state_id', $origin_state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();
                    $included_shipments =  Shipment::select(['id'])->whereIn('id', $included_shipments)->whereIn('origin_state_id', $origin_state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();
               }
          }

          $shipmentsQuery =  Shipment::whereIn('id', $exact_shipments);
          
          // Apply equipment type filters
          if ($request->has('eq_type_id')) {
               $shipmentsQuery->whereIn('eq_type_id', $request->eq_type_id);
          }

          if ($request->has('equipment_details')) {
               $equipment_details = ($request->equipment_details == "2") ? [0, 1] : [$request->equipment_details];
               $shipmentsQuery->WhereIn('equipment_detail', $equipment_details);
          }
          
          $shipment_without_inc = $shipmentsQuery->get()->pluck('id')->toArray();
         
          
          if ($request->has('bid')) {

               $bid = ($request->bid == "0") ? [0, 1] : [(int)$request->bid];

               $shipmentsQuery->WhereIn('is_allow_bids', $bid);
          }

          if ($request->has('load_requirements')) {

               $load_requirements = ($request->load_requirements == "2") ? [0, 1] : [(int)$request->load_requirements];

               $shipmentsQuery->WhereIn('is_tracking', $load_requirements);
          }

          if ($request->has('from_date') && $request->has('to_date')) {
               $fromDate = $request->from_date;
               $toDate = $request->to_date;

               $shipmentsQuery->where(function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('from_date', [$fromDate, $toDate])
                         ->orWhereBetween('to_date', [$fromDate, $toDate])
                         ->orWhere(function ($query) use ($fromDate, $toDate) {
                              $query->where('from_date', '<=', $fromDate)
                                   ->where('to_date', '>=', $toDate);
                         });
               });
          }

          if ($request->has('searchback') && $request->searchback != null) {
               $previousHours = Carbon::now()->subHours($request->searchback);
               $shipmentsQuery->WhereBetween('created_at', [$previousHours, Carbon::now()]);
          }
          
          $shipment_with_inc = $shipmentsQuery->get()->pluck('id')->toArray();
          if(count($shipment_without_inc) > 0 || count($shipment_with_inc) > 0){
              $array_dif = array_diff($shipment_without_inc,$shipment_with_inc);
             
            if(count($array_dif) > 0)
            {
                
               $included_shipments = array_merge($included_shipments,$array_dif);
            }  
          }
          
          if (count($included_shipments) > 0) {
              
               $equipment_details = ($request->equipment_details == "2") ? [0, 1] : [$request->equipment_details];
               $included_ships = shipment::whereIn('id', $included_shipments)->whereIn('equipment_detail', $equipment_details)->where('status', 'WAITING')->where('is_post', 1)->where('is_public_load', 1)
                    ->whereNotIn('id', requestedShipmentBid(auth()->user()->id))
                    ->whereNotIn('id', requestedShipmentPublic(auth()->user()->id))
                    ->orderBy('id', 'DESC');
          } else {
               $included_ships = null;
          }
          
          $shipmentsQuery->where(function ($query) use ($request) {

               if ($request->length != null) {
                    $query->Where('length', '<=', (int)$request->length);
               }

               if ($request->weight != null) {
                    $query->Where('weight', '<=', (int)$request->weight);
               }
          });

          $shipments = $shipmentsQuery->where('status', 'WAITING')->where('is_post', 1)->where('is_public_load', 1)->whereNotIn('id', requestedShipmentBid(auth()->user()->id))
               ->whereNotIn('id', requestedShipmentPublic(auth()->user()->id))->orderBy('id', 'DESC');
               $exact_shipments_count = $shipments->count();
               $shipments = $shipments->paginate(25);
          //  dd($org_lat, $org_lng,  $des_lat, $des_lng);

          if($shipments != null){
              
               $shipments->transform(function ($shipment) use ($org_lat,  $org_lng, $des_lng, $des_lat) {
                    $shipment['status'] = $shipment->status == "WAITING" ? "PENDING" : $shipment->status;
                    $shipment['status_phone'] = $shipment->status_phone == 1 ? $shipment->user ? $shipment->user->phone : null : null;
                    $shipment['status_email'] = $shipment->status_email == 1 ? $shipment->user ? $shipment->user->email : null : null;
                    $company = Company::where('user_id', $shipment->user->parent_id ?? $shipment->user->id)->first();
                    $shipment['company_name'] = $company ? $company->name : '';
                    $shipment['company_phone'] = $company ? $company->phone : '';
                    $shipment['company_mc'] = $company ? $company->mc : null;
                    $shipment['company_dot'] = $company ? $company->dot : null;
                    $shipment['company_address'] = $company ? $company->address : '';
                    $shipment['reference_id'] = $shipment->reference_id != null ? $shipment->reference_id : '-';
                    $shipment['commodity'] =  $shipment->commodity != null ? $shipment->commodity : '-';
                    $shipment['eq_name'] =  $shipment->eq_name != null ? $shipment->eq_name : '-';
                    $shipment['equipment_name'] = $shipment->equipment_type ? $shipment->equipment_type->name : '';
                    $shipment['dho'] = $org_lat != null && $org_lat != null ?  (int)get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $org_lat, $org_lng) : null;
                    $shipment['dhd'] = $des_lat != null && $des_lat != null ?  (int)get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $des_lat, $des_lng) : null;
                    return $shipment;
               });
          }


          if ($included_ships != null) {
               $included_ships_count = $included_ships->count();
               $included_ships = $included_ships->paginate(25, ['*'], 'includePagination');
           }
          //  dd($shipments);
          if ($request->ajax()) {

               if ($included_ships != null) {
                         $included_ships->transform(function ($include_shipment) use($org_lat,  $org_lng, $des_lng, $des_lat) {
                         $include_shipment['status'] = $include_shipment->status == 'WAITING' ? 'PENDING' : $include_shipment->status;
                         $company = $include_shipment->user->parent_id != null ? Company::where('user_id', $include_shipment->user->parent_id)->first() : Company::where('user_id', $include_shipment->user->id)->first();
                         $include_shipment['company_name'] = $company ? $company->name : '';
                         $include_shipment['company_phone'] = $company ? $company->phone : '';
                         $include_shipment['company_mc'] = $company ? $company->mc : '';
                         $include_shipment['company_address'] = $company ? $company->address : '';
                         $include_shipment['status_phone'] = $include_shipment->status_phone == 1 ? $include_shipment->user ? $include_shipment->user->phone : null : null;
                         $include_shipment['status_email'] = $include_shipment->status_email == 1 ? $include_shipment->user ? $include_shipment->user->email : null : null;
                         $include_shipment['equipment_name'] = $include_shipment->equipment_type ? $include_shipment->equipment_type->name : '';
                         $include_shipment['dho'] = $org_lat != null && $org_lat != null ?  (int)get_meters_between_points($include_shipment->origin_lat, $include_shipment->origin_lng, $org_lat, $org_lng) : null;
                         $include_shipment['dhd'] = $des_lat != null && $des_lat != null ?  (int)get_meters_between_points($include_shipment->destination_lat, $include_shipment->destination_lng, $des_lat, $des_lng) : null;
                         return $include_shipment;
                     });
               } else {
                    $included_ships = null;
                    $included_ships_count= 0;
               }


               return response()->json([
                    'shipments' => $shipments,
                    'included_ships' => $included_ships,
                    'shipments_count' => $exact_shipments_count,
                    'included_ships_count' =>  $included_ships_count,
                    'search_url' => route(auth()->user()->type . '.search_loads', $request->all())
               ]);
          } else {
               return view('Global.search-loads2', get_defined_vars());
          }
     }


   

    function getDistance($unit)
    {

        // $first_lat = '32.24861656259506, -99.83574935548249';
        // $first_lat = $this->getLnt($zip1);
        // $next_lat = $this->getLnt($zip2);
        // $next_lat = '34.12411840233855, -118.27080682825103';
        $lat1 = '32.24861656259506';
        $lon1 = '-99.83574935548249';
        $lat2 = '34.12411840233855';
        $lon2 = '-118.27080682825103';

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        dd($miles);
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344) . " " . $unit;
        } else if ($unit == "N") {
            return ($miles * 0.8684) . " " . $unit;
        } else {
            return $miles . " " . $unit;
        }
    }

    function getLnt($zip)
        {
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zip) . "&sensor=false&key=AIzaSyBzFJCfPri5srDLqtjaPF2yYMDOxtdSFFI";

            // dd($url);
            $result_string = file_get_contents($url);
            $result = json_decode($result_string, true);
            $result1[] = $result['results'][0];
            $result2[] = $result1[0]['geometry'];
            $result3[] = $result2[0]['location'];
            return $result3[0];
        }
        public function bookLoad($id)
        {
            $shipment = Shipment::find($id);
            // dd($shipment->is_exist_private);
    
            if ($shipment->is_exist_private == true) {
                $shipmentRequest = new ShipmentsRequest();
                $shipmentRequest->trucker_id = Auth::id();
                $shipmentRequest->shipment_id = $shipment->id;
                $shipmentRequest->amount = $shipment->private_rate;
                $rate = $shipment->private_rate;
                $shipmentRequest->status = null;
                $shipmentRequest->type = 0;
                $shipmentRequest->save();
            }else{
                $shipmentRequest = new ShipmentsRequest();
                $shipmentRequest->trucker_id = Auth::id();
                $shipmentRequest->shipment_id = $shipment->id;
                $shipmentRequest->amount = $shipment->dat_rate;
                $rate = $shipment->dat_rate;
                $shipmentRequest->status = null;
                $shipmentRequest->type = 1;
                $shipmentRequest->save();
            }       
            // $shipment->save();
    
            $users = User::where('id', $shipment->user_id)->where('status', 1)->get()->pluck('id')->toArray();
            if ($users) {
                $send_notification = [];
                $send_notification['user_id'] = $users;
                $send_notification['title'] = Auth::user()->name." Load Request";
                $send_notification['body'] = 'Request Amount $'.$rate;
                $send_notification['url'] = '/my-shipments-overview/' . $shipment->id;
                $send_notification['from_user_id'] = $shipment->trucker_id;
                $send_notification['to_user_id'] = $shipment->user->id;
                $send_notification['type_id'] = $shipment->id;
                $send_notification['type'] = "Shipment";
                send_notification($send_notification);
            }
    
            return back()->with('success', 'Load book Request Sent successfully');
        }
    
        public function bidLoad(Request $request, $id)
        {
            // dd($request->all(), $id);
    
            Bid::create([
                'trucker_id' => Auth::id(),
                'shipment_id' => $id,
                'amount' => $request->amount,
                'status' => null,
            ]);
    
            $shipment = Shipment::find($id);
            $users = User::where('id', $shipment->user->id)->where('status', 1)->get()->pluck('id')->toArray();
            if ($users) {
                $send_notification = [];
                $send_notification['user_id'] = $users;
                $send_notification['title'] = Auth::user()->name." Bid Request";
                $send_notification['body'] = "Bid Amount $" . $request->amount;
                $shipment = Shipment::where('id', $id)->first();
                $send_notification['url'] = '/my-shipments-bid-activity/' . $shipment->id;
                $send_notification['from_user_id'] = Auth::id();
                $send_notification['to_user_id'] = $shipment->user->id;
                $send_notification['type_id'] = $shipment->id;
                $send_notification['type'] = "Shipment";
                send_notification($send_notification);
            }
    
            return back()->with('success', 'Bid Request Sent Successfully');
    
        }
    
        public function privateLeads()
        {
            $private_load = [];
    
                $shipments = Shipment::with('company')->where('is_post',1)->whereIn('status', ['WAITING'])->where('entire_private_network_id',1)->whereNotIn('id',requestedShipmentBid(Auth::id()))->whereNotIn('id',requestedShipmentPublic(Auth::id()))->where(function($q){
                    $q->whereHas('contacts',function($row){
                        $row->where('trucker_id', Auth::id());
                    });
                })->orWhere('is_group',1)->where('is_post',1)->whereIn('status', ['WAITING'])->orderBy('id','Desc')->paginate(20);
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
                                $private_load[] = $this->single_sorting_data($load);
                            }
                        }else if($load->entire_private_network_id == 1){
                            $private_load[] = $this->single_sorting_data($load);
                        }
                    }
                }else{
                    // return $this->formatResponse('success', 'shipment Record Not Found', []);
                }
                $private_loads = collect($private_load);
    
                // Manual Pagination Setup
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 20; // Set items per page
                $items = $private_loads->slice(($currentPage - 1) * $perPage, $perPage)->values();
                $paginatedPrivateLoads = new LengthAwarePaginator(
                    $items,
                    $private_loads->count(),
                    $perPage,
                    $currentPage,
                    ['path' => LengthAwarePaginator::resolveCurrentPath()]
                );
    
                return view('Loads.private-leads', ['private_loads' => $paginatedPrivateLoads]);
        }
    
        function single_sorting_data($shipment)
        {
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
    
    
}
