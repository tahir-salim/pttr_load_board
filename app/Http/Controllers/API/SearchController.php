<?php

namespace App\Http\Controllers\API;

use App\Models\City;
use App\Models\Company;
use App\Models\EquipmentType;
use App\Models\RecentSearch;
use App\Models\Shipment;
use App\Models\State;
use Carbon\Carbon;
use function PHPSTORM_META\map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SearchController extends ShipmentController
{
    public function search(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            'origin' => 'required_without_all:origin_city,origin_lat,origin_lng,origin_states,destination',
            'origin_states' => 'required_without_all:origin_city,origin_lat,origin_lng,origin',
            'origin_city' => 'required_without_all:origin,origin_states,origin_lat,origin_lng',
            'origin_lat' => 'required_without_all:origin,origin_states,origin_city',
            'origin_lng' => 'required_without_all:origin,origin_states,origin_city',
            'dho' => 'required_with:origin_city,origin_lat,origin_lng|required_without_all:origin,origin_states',
            'destination' => 'required_without_all:destination_states,destination_city,destination_lat,destination_lng,origin',
            'destination_states' => 'required_without_all:destination_city,destination_lat,destination_lng,destination',
            'destination_city' => 'required_without_all:destination,destination_states,destination_lat,destination_lng',
            'destination_lat' => 'required_without_all:destination,destination_states,destination_city',
            'destination_lng' => 'required_without_all:destination,destination_states,destination_city',
            'dhd' => 'required_with:destination_city,destination_lat,destination_lng|required_without_all:destination,destination_states',
            'eq_type_id' => 'required',
            'equipment_detail' => 'required',
            'length' => 'sometimes',
            'weight' => 'sometimes',
            'searchback' => 'sometimes',
        ],
            [
                'from_date.required' => "The start date field is required.",
                'to_date.required' => "The end date field is required.",

                'origin_lat.required_without_all' => "The origin latitude (current location) is required.",
                'origin_lng.required_without_all' => "The origin longitude (current location) is required.",

                'destination_lat.required_without_all' => "The destination latitude (current location) is required.",
                'destination_lng.required_without_all' => "The destination longitude (current location) is required.",

                'origin.required_without_all' => "The origin is required unless other origin details are provided.",
                'destination.required_without_all' => "The destination is required unless other destination details are provided.",
            ]);


        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $now = Carbon::now();

        $exact_shipments = [];
        $recentSearch = new RecentSearch();

        if ($request->has('origin') && $request->origin != null && $request->has('destination_city') && $request->destination_city != null ) {
            //Done Case
            $city = City::find($request->destination_city[0]);
            $recentSearch->origin = $request->origin;
            if (isset($city) && isset($state)) {
                $recentSearch->destination = $city->name . ',' . $city->states->code;
            }
            $shipments1 = Shipment::select(['id', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $city->latitude, $city->longitude);
                if ($DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin') && $request->origin != null  && $request->has('destination_lat') && $request->destination_lat != null && $request->has('destination_lng') && $request->destination_lng != null) {
            $recentSearch->origin = $request->origin;
            $recentSearch->destination = currentlocationGetCity($request->destination_lat, $request->destination_lng);
            $shipments1 = Shipment::select(['id', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $request->destination_lat, $request->destination_lng);
                if ($DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin_states') && $request->origin_states != null  && $request->has('destination_city') && $request->destination_city != null) {
            //Done Case
            $dest_city = City::find($request->destination_city[0]);
            $states = State::WhereIn('id', $request->origin_states)->get();
            $array = '';
            foreach ($states as $state) {
                if (count($states) == 1) {
                    $array .= $state->code;
                } elseif (count($states) > 1) {
                    $array .= $state->code . ',';
                }
            }

            $recentSearch->origin = $array;
            $recentSearch->destination = $dest_city->name . ',' . $dest_city->states->code;
            $shipments1 = Shipment::select(['id', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $dest_city->latitude, $dest_city->longitude);
                if ($DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
            $exact_shipments =  Shipment::select(['id'])->whereIn('id', $exact_shipments)->whereIn('origin_state_id',  $request->origin_states)->where('status', 'WAITING')->get()->pluck('id')->toArray();
        } elseif ($request->has('origin_states') && $request->origin_states != null && $request->has('destination_lat') && $request->destination_lat != null && $request->has('destination_lng') && $request->destination_lng != null) {
            //Done Case
            $states = State::select('code')->whereIn('id', $request->origin_states)->get();
            $array = '';
            foreach ($states as $state) {
                if (count($states) == 1) {
                    $array .= $state->code;
                } elseif (count($states) > 1) {
                    $array .= $state->code . ',';
                }
            }
            $recentSearch->origin = $array;
            $recentSearch->destination = currentlocationGetCity($request->destination_lat, $request->destination_lng);
            $shipments1 = Shipment::select(['id', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $request->destination_lat, $request->destination_lng);
                if ($DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
            $exact_shipments =  Shipment::select(['id'])->whereIn('id', $exact_shipments)->whereIn('origin_state_id',  $request->origin_states)->where('status', 'WAITING')->get()->pluck('id')->toArray();
        } elseif ($request->has('origin_city') && $request->origin_city != null && $request->has('destination')  && $request->destination != null ) {
            //Done Case
            $city = City::find($request->origin_city[0]);
            $recentSearch->origin = $city->name . ',' . $city->states->code;
            $recentSearch->destination = 'Anywhere';
            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $city->latitude, $city->longitude);
                if ($DHO <= (int) $request->dho) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin_city')  && $request->origin_city != null && $request->has('destination_states')  && $request->destination_states != null) {
            //Done Case
            $city = City::find($request->origin_city[0]);
            $states = State::select('code')->whereIn('id', $request->destination_states)->get();
            $array = '';
            foreach ($states as $state) {
                if (count($states) == 1) {
                    $array .= $state->code;
                } elseif (count($states) > 1) {
                    $array .= $state->code . ',';
                }
            }
            $recentSearch->origin = $city->name . ',' . $city->states->code;
            $recentSearch->destination = $array;

            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $city->latitude, $city->longitude);
                if ($DHO <= (int) $request->dho) {
                    $exact_shipments[] = $shipment->id;
                }
            }
            $exact_shipments =  Shipment::select(['id'])->whereIn('id', $exact_shipments)->whereIn('destination_state_id',  $request->destination_states)->where('status', 'WAITING')->get()->pluck('id')->toArray();
        } elseif ($request->has('origin_city') && $request->origin_city != null && $request->has('destination_city')  && $request->destination_city != null) {
            // Done Case
            $origin_city = City::find($request->origin_city[0]);
            $destination_city = City::find($request->destination_city[0]);
            $recentSearch->origin = $origin_city->name . ',' . $origin_city->states->code;
            $recentSearch->destination = $destination_city->name . ',' . $destination_city->states->code;
            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $origin_city->latitude, $origin_city->longitude);
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $destination_city->latitude, $destination_city->longitude);
                if ($DHO <= (int) $request->dho && $DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin_city') && $request->origin_city != null && $request->has('destination_lat') && $request->destination_lat != null  && $request->has('destination_lng') && $request->destination_lng != null) {
            //Done Case
            $city = City::find($request->origin_city[0]);
            $recentSearch->origin = $city->name . ',' . $city->states->code;
            $recentSearch->destination = currentlocationGetCity($request->destination_lat, $request->destination_lng);
            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $city->latitude, $city->longitude);
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $request->destination_lat, $request->destination_lng);
                if ($DHO <= (int) $request->dho && $DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin_lat') && $request->origin_lat != null && $request->has('origin_lng') && $request->origin_lng != null && $request->has('destination')  && $request->destination != null) {
            //Done CAse
            $recentSearch->origin = currentlocationGetCity($request->origin_lat, $request->origin_lng);
            $recentSearch->destination = 'Anywhere';
            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $request->origin_lat, $request->origin_lng);
                if ($DHO <= (int) $request->dho) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin_lat') && $request->origin_lat != null  && $request->has('origin_lng') && $request->origin_lng != null  && $request->has('destination_states') && $request->destination_states != null) {
            //Done Case
            $destination_states = State::select('code')->whereIn('id', $request->destination_states)->get();
            $array = '';
            foreach ($destination_states as $state) {
                if (count($destination_states) == 1) {
                    $array .= $state->code;
                } elseif (count($destination_states) > 1) {
                    $array .= $state->code . ',';
                }
            }
            $recentSearch->origin = currentlocationGetCity($request->origin_lat, $request->origin_lng);
            $recentSearch->destination = $array;
            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $request->origin_lat, $request->origin_lng);
                if ($DHO <= (int) $request->dho) {
                    $exact_shipments[] = $shipment->id;
                }
            }
          $exact_shipments =  Shipment::select(['id'])->whereIn('id', $exact_shipments)->whereIn('destination_state_id',  $request->destination_states)->where('status', 'WAITING')->get()->pluck('id')->toArray();

        } elseif ($request->has('origin_lat') && $request->origin_lat != null && $request->has('origin_lng') && $request->origin_lng != null && $request->has('destination_city') && $request->destination_city != null) {
            //Done Case
            $destination = City::find($request->destination_city[0]);
            $recentSearch->origin = currentlocationGetCity($request->origin_lat, $request->origin_lng);
            $recentSearch->destination = $destination->name . ',' . $destination->states->code;
            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $request->origin_lat, $request->origin_lng);
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $destination->latitude, $destination->longitude);
                if ($DHO <= (int) $request->dho && $DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin_lat') && $request->origin_lat != null && $request->has('origin_lng')  && $request->origin_lng != null && $request->has('destination_lat') && $request->destination_lat != null  && $request->has('destination_lng') && $request->destination_lng != null ) {
            //Done Case
            $recentSearch->origin = currentlocationGetCity($request->origin_lat, $request->origin_lng);
            $recentSearch->destination = currentlocationGetCity($request->destination_lat, $request->destination_lng);
            $shipments1 = Shipment::select(['id', 'origin_lat', 'origin_lng', 'destination_lat', 'destination_lng', 'status'])->where('status', 'WAITING')->get();
            foreach ($shipments1 as $shipment) {
                $DHO = (int) get_meters_between_points($shipment->origin_lat, $shipment->origin_lng, $request->origin_lat, $request->origin_lng);
                $DHD = (int) get_meters_between_points($shipment->destination_lat, $shipment->destination_lng, $request->destination_lat, $request->destination_lng);
                if ($DHO <= (int) $request->dho && $DHD <= (int) $request->dhd) {
                    $exact_shipments[] = $shipment->id;
                }
            }
        } elseif ($request->has('origin_states') && $request->origin_states != null && $request->has('destination') && $request->destination != null) {
            //Done Case
            $states = State::select('code')->whereIn('id', $request->origin_states)->get();
            $array = '';
            foreach ($states as $state) {
                if (count($states) == 1) {
                    $array .= $state->code;
                } elseif (count($states) > 1) {
                    $array .= $state->code . ',';
                }
            }
            $recentSearch->origin = $array;
            $recentSearch->destination = 'Anywhere';
            $exact_shipments =  Shipment::select(['id'])->whereIn('origin_state_id',  $request->origin_states)->where('status', 'WAITING')->get()->pluck('id')->toArray();
        } elseif ($request->has('origin') && $request->origin != null && $request->has('destination_states') && $request->destination_states != null) {
            //Done Case
            $destination_states = State::select('code')->whereIn('id', $request->destination_states)->get();
            $array = '';
            foreach ($destination_states as $state) {
                if (count($destination_states) == 1) {
                    $array .= $state->code;
                } elseif (count($destination_states) > 1) {
                    $array .= $state->code . ',';
                }
            }
            $recentSearch->origin = 'Anywhere';
            $recentSearch->destination = $array;
             $exact_shipments =  Shipment::select(['id'])->whereIn('destination_state_id', $request->destination_states)->where('status', 'WAITING')->get()->pluck('id')->toArray();
        } else {
            $origin_states = State::select('code')->whereIn('id', $request->origin_states)->get();
            $desti_states = State::select('code')->whereIn('id', $request->destination_states)->get();
            $origin_array = '';
            $desti_array = '';
            foreach ($origin_states as $state) {
                if (count($origin_states) == 1) {
                    $origin_array .= $state->code;
                } elseif (count($origin_states) > 1) {
                    $origin_array .= $state->code . ',';
                }
            }
            foreach ($desti_states as $state) {
                if (count($desti_states) == 1) {
                    $desti_array .= $state->code;
                } elseif (count($desti_states) > 1) {
                    $desti_array .= $state->code . ',';
                }
            }
            $recentSearch->origin = $origin_array;
            $recentSearch->destination = $desti_array;
            $exact_shipments =  Shipment::select(['id'])->whereIn('origin_state_id', $request->origin_states)->whereIn('destination_state_id',  $request->destination_states)->where('status', 'WAITING')->get()->pluck('id')->toArray();
        }

          $shipmentsQuery =  Shipment::whereIn('id', $exact_shipments)->whereNotIn('id', requestedShipmentPublic(auth()->user()->id));
           
            $shipmentsQuery->where(function ($query) use ($request) {
    
                if ($request->has('length') && $request->length != null) {
                    $query->orWhere('length', '<=' , $request->length);
                }
    
                if ($request->has('weight') && $request->weight != null) {
                    $query->orWhere('weight', '<=' , $request->weight);
                }
            });


            if ( $request->has('eq_type_id')) {
                $shipmentsQuery->whereIn('eq_type_id', $request->eq_type_id);
            }

            if ($request->has('equipment_detail')) {
                $request->equipment_details = (int)$request->equipment_detail;
                $equipment_details = ($request->equipment_detail == 2) ? [0, 1] : [$request->equipment_detail];
                $shipmentsQuery->WhereIn('equipment_detail', $equipment_details);
            }


            if ($request->has('searchback') && $request->searchback != null ) {
                $previousHours = Carbon::now()->subHours($request->searchback);
                $shipmentsQuery->WhereBetween('created_at', [$previousHours, Carbon::now()]);
            }


            if ($request->has('from_date') && $request->has('to_date')) {
                $fromDate = $previousHours;
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
// 
        $shipments = $shipmentsQuery->where('status', 'WAITING')->where('is_post', 1)->where('user_id', '!=', auth()->user()->id)->where('is_public_load', 1)->orderBy('id', 'DESC')->paginate(25);

        $shipments->transform(function ($shipment) {
            $shipment['status'] = $shipment->status == "WAITING" ? "PENDING" : $shipment->status;
            $company = Company::where('user_id', $shipment->user->parent_id ?? $shipment->user->id)->first();
            $shipment['company_name'] = $company ? $company->name : '';
            $shipment['company_phone'] = $company ? $company->phone : '';
            $shipment['company_mc'] = $company ? $company->mc : '';
            $shipment['company_address'] = $company ? $company->address : '';
            $shipment['equipment_name'] = $shipment->equipment_type ? $shipment->equipment_type->name : '';
            return $shipment;
        });


        // $shipments->transform(function ($shipment) {
        //     $shipment['status'] = $shipment->status == "WAITING" ? "PENDING" : $shipment->status;
        //     return $shipment;
        // });

        $req1 = [
            "from_date" => $request->from_date,
            "to_date" => $request->to_date,
            "origin" => isset($request->origin) ? $request->origin : null,
            "origin_states" => isset($request->origin_states) ? $request->origin_states : null,
            "origin_city" => isset($request->origin_city) ? $request->origin_city : null,
            "origin_lat" => isset($request->origin_lat) ? $request->origin_lat : null,
            "origin_lng" => isset($request->origin_lng) ? $request->origin_lng : null,
            "dho" => isset($request->dho) ? $request->dho : null,
            "destination" => isset($request->destination) ? $request->destination : null,
            "destination_states" => isset($request->destination_states) ? $request->destination_states : null,
            "destination_city" => isset($request->destination_city) ? $request->destination_city : null,
            "destination_lat" => isset($request->destination_lat) ? $request->destination_lat : null,
            "destination_lng" => isset($request->destination_lng) ? $request->destination_lng : null,
            "dhd" => isset($request->dhd) ? $request->dhd : null,
            "eq_type_id" => isset($request->eq_type_id) ? $request->eq_type_id : null,
            "equipment_detail" => isset($request->equipment_detail) ? $request->equipment_detail : null,
            "length" => isset($request->length) ? $request->length : null,
            "weight" => isset($request->weight) ? $request->weight : null,
            "searchback" => isset($request->searchback) ? $request->searchback : null,
        ];

        $recentSearch->from_date = $request->from_date;
        $recentSearch->to_date = $request->to_date;
        $recentSearch->eq_type_id = serialize($request->eq_type_id);
        $recentSearch->equipment_detail = $request->equipment_detail;
        $recentSearch->length = $request->length ? $request->length : '';
        $recentSearch->weight = $request->weight ? $request->weight : '';
        $recentSearch->request = serialize($req1);
        $recentSearch->user_id = Auth::id();
        $recentSearch->save();
        
        if (count($shipments) == 0) {
            return $this->formatResponse('error', 'no result found');
        }

        return $this->formatResponse(
            'success',
            'search result found',
            $shipments,
            200
        );
    }

    public function sorting_data($shipments)
    {
        $shipments->transform(function ($shipment) {
            $shipment['equipment_type'] = $shipment->equipment_type ? $shipment->equipment_type : [];
            $user = $shipment['user'] = $shipment->user ? $shipment->user : [];
            if ($user) {
                $shipment['user']['company'] = $shipment->user ? $shipment->user->company : [];
            }
            if ($shipment->is_tracking == 1) {
                $tracking = $shipment['tracking'] = $shipment->tracking ? $shipment->tracking : [];
                if ($tracking) {
                    $tracking_details = $shipment['tracking']['tracking_details'] = $shipment->tracking ? $shipment->tracking->tracking_details : [];
                    if (count($tracking_details) > 0) {
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
    public function recentSearch()
    {
        $recentSearchs = RecentSearch::where('user_id', Auth::id())->orderBy('id', 'Desc')->get()->map(function ($row) {

            if ($row->equipment_detail == 2) {
                $equipment_detail = 'Full And Partial';
            } else {
                $equipment_detail = $row->equipment_detail == 0 ? 'Full' : 'Partial';

            }

            return [
                "id" => $row->id,
                "origin" => $row->origin,
                "destination" => $row->destination,
                "from_date" => $row->from_date,
                "to_date" => $row->to_date,
                "equipment_detail" => $equipment_detail,
                "eq_type_id" => EquipmentType::whereIn('id', unserialize($row->eq_type_id))->where('is_active', 1)->get()->toArray(),
                "eq_name" => $row->eq_name,
                "length" => $row->length,
                "weight" => $row->weight,
                "user_id" => $row->user_id,
                "request" => unserialize($row->request),
            ];
        });

        return $this->formatResponse(
            'success',
            'recent search result found',
            $recentSearchs,
            200
        );
    }

    public function deleteRecentSearch($id)
    {
        $deleteRecentSearch = RecentSearch::find($id);

        if (!$deleteRecentSearch) {
            return $this->formatResponse('error', 'no result found');
        }
        $deleteRecentSearch->delete();

        return $this->formatResponse(
            'success',
            'deleted successfully',
            200
        );
    }

    public function equipmentTypes()
    {
        $equipmentTypes = EquipmentType::where('is_active', 1)->get();

        return $this->formatResponse(
            'success',
            'fetch record successfully',
            $equipmentTypes,
            200
        );
    }

    public function cities(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }
        $query = $request->name;
        // old Code
        // $cities = City::where(function ($que) use ($query) {
        //     $que->where('name', 'LIKE', $query . '%')->orWhereRaw("REPLACE(name, ' ', '') LIKE ?", ["{$query}%"])
        //     ->orWhereHas('states', function($qe) use ($query){
        //         $qe->where('code', 'LIKE', '%' . $query . '%');
        //     });
        // })->take(40)->get();

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
        return $this->formatResponse(
            'success',
            'fetch cities successfully',
            $cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'text' => $city->name
                    . ', '
                    . $city->states->code
                    . ', '
                    . $city->states->country_code,
                    'latitude' => $city->latitude,
                    'longitude' => $city->longitude,
                ];
            }),
            200
        );
    }

    public function states()
    {
        $US = State::select('id', 'code')->where('country_id', 233)->orderBy('code','ASC')->get()->map(function ($state) {
            $state->text = $state->code;
            unset($state->code); // Optionally, remove the 'code' field
            return $state;
        });
        $Canada = State::select('id', 'code')->where('country_id', 39)->orderBy('code','ASC')->get()->map(function ($state) {
            $state->text = $state->code;
            unset($state->code); // Optionally, remove the 'code' field
            return $state;
        });
        return $this->formatResponse(
            'success',
            'fetch states successfully',
            [
                'US' => $US,
                'Canada' => $Canada,
            ],
            200
        );
    }
}
