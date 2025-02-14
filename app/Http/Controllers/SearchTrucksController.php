<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Truck;
use App\Models\TruckPost;
use App\Models\City;
use App\Models\Company;
use App\Models\TruckPostDestState;
use App\Models\EquipmentType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchTrucksController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search_trucks(Request $request)
    {
        
        // abort(403, 'This feature is under development. An update will be available soon');
        $equipment_types = EquipmentType::get();
        // if($request->dho != null && $request->dhd == null || $request->dho != null && $request->dhd != null && $request->origin_lat != null && $request->destination_lng == null ){
        //    $trucks = Truck::select(['id','origin','origin_lat','origin_lng','destination'])->get();
        //    foreach($trucks as $truck){
        //      if((int)get_meters_between_points($truck->origin_lat, $truck->origin_lng, $request->origin_lat, $request->origin_lng) <= (int)$request->dho){
        //           array_push($exact_trucks,$truck->id);
        //      }elseif((float)get_meters_between_points($truck->origin_lat, $truck->origin_lng, $request->origin_lat, $request->origin_lng) <= (int)$request->dho+200){
        //           array_push($included_trucks,$truck->id);
        //      }
        //    }

        // }elseif($request->dhd != null && $request->dho == null || $request->dho != null && $request->dhd != null && $request->origin_lat == null && $request->destination_lng != null ){
        //    $trucks = Truck::select(['id','origin','destination_lat','destination_lng','destination'])->get();
        //    foreach($trucks as $truck){
        //      if((int)get_meters_between_points($truck->destination_lat, $truck->destination_lng, $request->destination_lat, $request->destination_lng) <= (int)$request->dhd){
        //           array_push($exact_trucks,$truck->id);
        //      }elseif((float)get_meters_between_points($truck->destination_lat, $truck->destination_lng, $request->destination_lat, $request->destination_lng) <= (int)$request->dhd+200){
        //           array_push($included_trucks,$truck->id);
        //      }
        //    }
        // }
        // elseif($request->dho != null && $request->dhd != null && $request->origin_lat != null && $request->destination_lng != null){
        //    $trucks = Truck::select(['id','origin','origin_lat','origin_lng','destination_lat','destination_lng','destination'])->get();
        //    foreach($trucks as $truck){
        //      $DHO = (int)get_meters_between_points($truck->origin_lat, $truck->origin_lng, $request->origin_lat, $request->origin_lng);
        //      $DHD = (int)get_meters_between_points($truck->destination_lat, $truck->destination_lng, $request->destination_lat, $request->destination_lng);
        //      if($DHO <= (int)$request->dho && $DHD <= (int)$request->dhd){
        //         array_push($exact_trucks,$truck->id);
        //      }elseif($DHO <= (int)$request->dho+200 && $DHD <= (int)$request->dhd+200){
        //         array_push($included_trucks,$truck->id);
        //      }
        //    }
        // //   dd($request->destination_lat, $request->destination_lng , $exact_trucks,$included_trucks);
        // }
        // else{
        //      if ($request->origin != null && $request->destination == null ) {
        //         $exact_trucks = Truck::where('origin',$request->origin)->pluck('id')->toArray();
        //     }
        //     else if( $request->destination != null && $request->origin == null) {
        //         $exact_trucks = Truck::where('destination', $request->destination)->pluck('id')->toArray();
        //     }
        //     else{
        //        $exact_trucks = [];
        //     }

        // }

        $exact_trucks = [];
        $included_trucks = [];
        $org_lat = null;
        $org_lng = null;
        $des_lat = null;
        $des_lng = null;
        
        
        if (isset($request->origin) && count($request->origin) > 0) {
            if ($request->origin[0] == "city_117058") {
                $request->origin = [];
            }
        }
        if (isset($request->destination) && count($request->destination) > 0) {
            if ($request->destination[0] == "city_117058") {
                $request->destination = [];
            }
        }
        
        // dd(isset($request->origin) && count($request->origin) > 0 && $request->destination == null);
        if (isset($request->origin) && count($request->origin) > 0 && $request->destination == null) {

            if (strpos($request->origin[0], 'city_') === 0) {
                $city_id = (int)str_replace('city_', '', $request->origin[0]);
                $origin_city = City::find($city_id);
                $org_lat =  $origin_city->latitude;
                $org_lng =  $origin_city->longitude;
                $truckposts = TruckPost::select(['id', 'origin', 'origin_lat', 'origin_lng', 'destination'])->where('is_posted', 1)->get();
                foreach ($truckposts as $truckpost) {
                    $distance = (int)get_meters_between_points($truckpost->origin_lat, $truckpost->origin_lng, $origin_city->latitude, $origin_city->longitude);
                    if ($distance <= (int)$request->dho) {
                        $exact_trucks[] = $truckpost->id;
                    } elseif ($distance <= (int)$request->dho + 200) {
                        $included_trucks[] = $truckpost->id;
                    }
                }
            } else {
                $state_ids = [];
                foreach ($request->origin as $state_id) {
                    $state_ids[] = (int)str_replace('state_', '', $state_id);
                }
                $exact_trucks = TruckPost::select(['id'])->whereIn('origin_state_id', $state_ids)->where('is_posted', 1)->get()->pluck('id')->toArray();
            }
        } elseif (isset($request->destination) && count($request->destination) > 0  && $request->origin == null) {

            if (strpos($request->destination[0], 'city_') === 0) {
                $city_id = (int)str_replace('city_', '', $request->destination[0]);
                $destination_city = City::find($city_id);
                $des_lat =  $destination_city->latitude;
                $des_lng =  $destination_city->longitude;
                $truckposts = TruckPost::select(['id', 'destination_lat', 'destination_lng', 'destination'])->where('is_posted', 1)->get();
                foreach ($truckposts as $truckpost) {
                    $distance = (int)get_meters_between_points($truckpost->destination_lat, $truckpost->destination_lng, $destination_city->latitude, $destination_city->longitude);
                    if ($distance <= (int)$request->dhd) {
                        $exact_trucks[] = $truckpost->id;
                    } elseif ($distance <= (int)$request->dhd + 200) {
                        $included_trucks[] = $truckpost->id;
                    }
                }
            } else {
                $state_ids = [];
                foreach ($request->destination as $state_id) {
                    $state_ids[] = (int)str_replace('state_', '', $state_id);
                }
                $exact_trucks = TruckPostDestState::select('id', 'truck_post_id', 'state_id')
                    ->whereIn('state_id', $state_ids)
                    ->whereHas('truck_post', function ($query) {
                        $query->where('is_posted', 1);
                    })
                    ->get()
                    ->pluck('truck_post_id')
                    ->unique()
                    ->toArray();
            }
        } elseif (isset($request->origin) && count($request->origin) > 0 && isset($request->destination) && count($request->destination) > 0) {
            if (strpos($request->origin[0], 'city_') === 0 && strpos($request->destination[0], 'city_') === 0) {
                $orgin_city_id = (int)str_replace('city_', '', $request->origin[0]);
                $dest_city_id = (int)str_replace('city_', '', $request->destination[0]);
                $origin_city = City::find($orgin_city_id);
                $dest_city = City::find($dest_city_id);
                $des_lat =  $dest_city->latitude;
                $des_lng =  $dest_city->longitude;
                $org_lat =  $origin_city->latitude;
                $org_lng =  $origin_city->longitude;
                 
                $truck_posts = TruckPost::select(['id', 'origin', 'origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'destination'])->where('is_posted', 1)->get();
                foreach ($truck_posts as $truck_post) {
                    $DHO = (int)get_meters_between_points($truck_post->origin_lat, $truck_post->origin_lng, $origin_city->latitude, $origin_city->longitude);
                    $DHD = (int)get_meters_between_points($truck_post->destination_lat, $truck_post->destination_lng, $dest_city->latitude, $dest_city->longitude);
                    if ($DHO <= (int)$request->dho && $DHD <= (int)$request->dhd) {
                        $exact_trucks[] = $truck_post->id;
                    } elseif ($DHO <= (int)$request->dho + 200 && $DHD <= (int)$request->dhd + 200) {
                        $included_trucks[] = $truck_post->id;
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
                $exact_trucks = TruckPostDestState::select('id', 'truck_post_id', 'state_id')
                    ->whereIn('state_id', $dest_state_ids)
                    ->whereHas('truck_post', function ($query) use ($origin_state_ids) {
                        $query->whereIn('origin_state_id', $origin_state_ids)->where('is_posted', 1);
                    })
                    ->get()
                    ->pluck('truck_post_id')
                    ->unique()
                    ->toArray();
            } elseif (strpos($request->origin[0], 'city_') === 0 && strpos($request->destination[0], 'state_') === 0) {
                $origin_city_id = (int)str_replace('city_', '', $request->origin[0]);
                $origin_city = City::find($origin_city_id);
                 $org_lat =  $origin_city->latitude;
                 $org_lng =  $origin_city->longitude;
                $truck_posts = TruckPost::select(['id', 'origin', 'origin_lat', 'origin_lng', 'destination'])->where('is_posted', 1)->get();
                foreach ($truck_posts as $truck_post) {
                    $distance = (int)get_meters_between_points($truck_post->origin_lat, $truck_post->origin_lng, $origin_city->latitude, $origin_city->longitude);
                    if ($distance <= (int)$request->dho) {
                        $exact_trucks[] = $truck_post->id;
                    } elseif ($distance <= (int)$request->dho + 200) {
                        $included_trucks[] = $truck_post->id;
                    }
                }

                $dest_state_ids = [];
                foreach ($request->destination as $d_state_id) {
                    $dest_state_ids[] = (int)str_replace('state_', '', $d_state_id);
                }


                $exact_trucks = TruckPostDestState::select('id', 'truck_post_id', 'state_id')
                    ->whereIn('state_id', $dest_state_ids)
                    ->whereHas('truck_post', function ($query) use ($exact_trucks) {
                        $query->whereIn('id', $exact_trucks)->where('is_posted', 1);
                    })
                    ->get()
                    ->pluck('truck_post_id')
                    ->unique()
                    ->toArray();



                $included_trucks = TruckPostDestState::select('id', 'truck_post_id', 'state_id')
                    ->whereIn('state_id', $dest_state_ids)
                    ->whereHas('truck_post', function ($query) use ($included_trucks) {
                        $query->whereIn('id', $included_trucks)->where('is_posted', 1);
                    })
                    ->get()
                    ->pluck('truck_post_id')
                    ->unique()
                    ->toArray();




                // $exact_trucks =  Shipment::select(['id'])->whereIn('id', $exact_trucks)->whereIn('destination_state_id', $dest_state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();
                // $included_trucks =  Shipment::select(['id'])->whereIn('id', $included_trucks)->whereIn('destination_state_id', $dest_state_ids)->where('status', 'WAITING')->get()->pluck('id')->toArray();

            } elseif (strpos($request->origin[0], 'state_') === 0 && strpos($request->destination[0], 'city_') === 0) {
                $dest_city_id = (int)str_replace('city_', '', $request->destination[0]);
                $dest_city = City::find($dest_city_id);
                $des_lat =  $dest_city->latitude;
                $des_lng =  $dest_city->longitude;
                $truck_posts = TruckPost::select(['id', 'origin', 'destination_lat', 'destination_lng', 'destination'])->where('is_posted', 1)->get();
                foreach ($truck_posts as $truck_post) {
                    $distance = (int)get_meters_between_points($truck_post->destination_lat, $truck_post->destination_lng, $dest_city->latitude, $dest_city->longitude);
                    if ($distance <= (int)$request->dho) {
                        $exact_trucks[] = $truck_post->id;
                    } elseif ($distance <= (int)$request->dho + 200) {
                        $included_trucks[] = $truck_post->id;
                    }
                }

                $origin_state_ids = [];
                foreach ($request->origin as $o_state_id) {
                    $origin_state_ids[] = (int)str_replace('state_', '', $o_state_id);
                }

                $exact_trucks =  TruckPost::select(['id'])->whereIn('id', $exact_trucks)->whereIn('origin_state_id', $origin_state_ids)
                ->where('is_posted', 1)->get()->pluck('id')->toArray();

                $included_trucks =  TruckPost::select(['id'])->whereIn('id', $included_trucks)
                ->whereIn('origin_state_id', $origin_state_ids)->where('is_posted', 1)
                ->get()->pluck('id')->toArray();
            }
        }
        $now = Carbon::now();
        $trucks = TruckPost::whereIn('id', $exact_trucks);
        if (count($included_trucks) > 0) {
            if (isset($request->equipment_details) && $request->equipment_details == "2") {
                $equipment_details = [0, 1];
            } else {
                $equipment_details = [$request->equipment_details];
            }


            $include_trucks = TruckPost::whereIn('id', $included_trucks)->whereHas('trucks', function ($query) use ($equipment_details) {
                $query->whereIn('equipment_detail', $equipment_details);
            });
            
           
            
        } else {
            $include_trucks = null;
        }


        if ($request->eq_type_id) {
            $eq_type_id = $request->eq_type_id;
            $trucks->whereHas('trucks', function ($query) use ($eq_type_id) {
                $query->whereIn('eq_type_id', $eq_type_id);
            });
        }

        if ($request->equipment_details != null) {
            if (isset($request->equipment_details) && $request->equipment_details == "2") {
                $equipment_details = [0, 1];
            } else {
                $equipment_details = [$request->equipment_details];
            }

            $trucks->whereHas('trucks', function ($query) use ($equipment_details) {
                $query->whereIn('equipment_detail', $equipment_details);
            });
        }


        $trucks->where(function ($query) use ($request) {
            if ($request->length != null) {
                $length = $request->length;
                $query->whereHas('trucks', function ($q) use ($length) {
                    $q->Where('length', '<=',  $length);
                });
            }

            if ($request->weight != null) {
                $weight = $request->weight;
                $query->whereHas('trucks', function ($q) use ($weight) {
                    $q->Where('weight', '<=', $weight);
                });
            }
        });




        if ($request->has('searchback') && $request->searchback != null) {
            $previousHours = Carbon::now()->subHours($request->searchback);
            $trucks->Where('created_at', '>=', $previousHours->format('Y-m-d h:i:s'));
        }

        // dd($previousHours->format('Y-m-d'));
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = ($previousHours->format('Y-m-d'));
            // dd($fromDate, $request->to_date);
            $toDate = $request->to_date;
            $trucks->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('from_date', [$fromDate, $toDate])
                    ->orWhereBetween('to_date', [$fromDate, $toDate])
                    ->orWhere(function ($query) use ($fromDate, $toDate) {
                        $query->where('from_date', '<=', $fromDate)
                            ->where('to_date', '>=', $toDate);
                    });
            });
        }
        $trucks_count = $trucks->count();

        $trucks = $trucks->orderBy('id', 'Desc')->paginate(2);


        if($trucks != null){
            $trucks->transform(function ($truckpost) use ($org_lat, $org_lng, $des_lng, $des_lat)  {
                // Add the new key to each item
                if ($truckpost->user->parent_id != null) {
                    $company = Company::where('user_id', $truckpost->user->parent_id)->first();
                } else {
                    $company = Company::where('user_id', $truckpost->user->id)->first();
                }
                $truckpost['dat_rate'] = $truckpost ? $truckpost->rate : '' ;
                $truckpost['company_name'] = $company ? $company->name : ''; 
                $truckpost['company_phone'] = $company ? $company->phone : '';
                $truckpost['company_mc'] =  $company ? $company->mc : '';
                $truckpost['company_address'] =  $company ? $company->address : '';
                $truckpost['equipment_name'] = $truckpost->trucks->equipment_type ?   $truckpost->trucks->equipment_type->name : '';
                $truckpost['equipment_detail'] = $truckpost->trucks->equipment_detail ==  "0" ?  'Full' : 'Partial';
                $truckpost['weight'] = $truckpost->trucks ?   $truckpost->trucks->weight : '';
                $truckpost['length'] = $truckpost->trucks ?   $truckpost->trucks->length : '';
                $truckpost['reference_id'] = $truckpost->trucks ?   $truckpost->trucks->reference_id : '-';
                $truckpost['dho'] = $org_lat != null && $org_lat != null ? (int) get_meters_between_points($truckpost->origin_lat,$truckpost->origin_lng,$org_lat,$org_lng ): null;
                $truckpost['dhd'] = $des_lat != null && $des_lat != null ? (int)get_meters_between_points($truckpost->destination_lat,$truckpost->destination_lng,$des_lat,$des_lng) : null;
                $truckpost['status_phone'] =
                            $truckpost->status_phone == 1
                            ? ($truckpost->user
                                ? $truckpost->user->phone
                                : null)
                            : null;
                        $truckpost['status_email'] =
                            $truckpost->status_email == 1
                            ? ($truckpost->user
                                ? $truckpost->user->email
                                : null)
                            : null;
                // dd($truckpost->trucks);
                return $truckpost;
            });
        }
        
        // dd($include_trucks->get());

        if ($include_trucks != null) {
            $included_trucks_count = $include_trucks->count();
            $include_trucks = $include_trucks->paginate(25, ['*'], 'includeTruckPagination');
            // dd($included_trucks_count);
        $include_trucks->transform(function ($includ_truck) use ($org_lat, $org_lng, $des_lng, $des_lat) {
            $includ_truck['status'] =
                $includ_truck->status == 'WAITING' ? 'PENDING' : $includ_truck->status;
            if ($includ_truck->user->parent_id != null) {
                $company = \App\Models\Company::where(
                    'user_id',
                    $includ_truck->user->parent_id
                )->first();
            } else {
                $company = \App\Models\Company::where(
                    'user_id',
                    $includ_truck->user->id
                )->first();
            }
            $includ_truck['company_name'] = $company ? $company->name : '';
            $includ_truck['company_phone'] = $company ? $company->phone : '';
            $includ_truck['company_mc'] = $company ? $company->mc : null;
            $includ_truck['company_dot'] = $company ? $company->dot : null;
            $includ_truck['status_phone'] =
                $includ_truck->status_phone == 1
                ? ($includ_truck->user
                    ? $includ_truck->user->phone
                    : null)
                : null;
            $includ_truck['status_email'] =
                $includ_truck->status_email == 1
                ? ($includ_truck->user
                    ? $includ_truck->user->email
                    : null)
                : null;
            $includ_truck['company_address'] = $company ? $company->address : '';
            $includ_truck['equipment_name'] = $includ_truck->trucks->equipment_type
                ? $includ_truck->trucks->equipment_type->name
                : '';
            $includ_truck['weight'] = $includ_truck->trucks
                ? $includ_truck->trucks->weight
                : '';
            $includ_truck['length'] = $includ_truck->trucks
                ? $includ_truck->trucks->length
                : '';
            $includ_truck['equipment_detail'] =
                $includ_truck->trucks->equipment_detail == '0' ? 'Full' : 'Partial';
            $includ_truck['reference_id'] = $includ_truck->trucks
                ? ($includ_truck->trucks->reference_id != null
                    ? $includ_truck->trucks->reference_id != null
                    : '-')
                : '-';
            $includ_truck['comment'] =
                $includ_truck->comment != null ? $includ_truck->comment : '-';
            $includ_truck['dho'] =
                $org_lat != null && $org_lat != null
                ? (int) get_meters_between_points(
                    $includ_truck->origin_lat,
                    $includ_truck->origin_lng,
                    $org_lat,
                    $org_lng
                )
                : null;
            $includ_truck['dhd'] =
                $des_lat != null && $des_lat != null
                ? (int) get_meters_between_points(
                    $includ_truck->destination_lat,
                    $includ_truck->destination_lng,
                    $des_lat,
                    $des_lng
                )
                : null;
            
            return $includ_truck;
        }); 
    }else{
        $included_trucks_count = 0;
        $include_trucks = null;
    }

        if ($request->ajax()) {
            // dd($trucks);
            return response()->json([
                'trucks' => $trucks,
                'included_trucks' => $include_trucks,
                'trucks_count' => $trucks_count,
                'included_trucks_count' => $included_trucks_count,
                'search_url' => route(auth()->user()->type . '.search_trucks', $request->all())
            ]);
        } else {
            return view('Global.search-trucks', get_defined_vars());
        }
    }
    }
