<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Shipment;
use App\Models\State;
use App\Models\Truck;
use App\Models\TruckPost;
use App\Models\TruckPostDestState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TruckController extends Controller
{
    public function createTruck(Request $request)
    {
        // validation
        $validate = Validator::make($request->all(), [
            'name' => 'sometimes',
            'eq_type_id' => 'required',
            'equipment_detail' => 'required',
            'length' => 'required',
            'weight' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $newTruck = Truck::create([
            'name' => $request->name,
            'eq_type_id' => $request->eq_type_id,
            'equipment_detail' => $request->equipment_detail,
            'length' => $request->length,
            'weight' => $request->weight,
            'user_id' => Auth::id(),
        ]);
        // dd($newTruck);
        if ($newTruck->name == null) {
            $newTruck = Truck::find($newTruck->id);
            $newTruck->name = 'Truck #' . $newTruck->id;
            $newTruck->save();
        }

        return $this->formatResponse(
            'success',
            'truck created successfully',
            $newTruck,
            200
        );

    }

    public function truckList(Request $request)
    {
        if (request()->input('id')) {
            $truckList = Truck::where('user_id', Auth::id())->where('id', request()->input('id'))->get();
        } else {
            $truckList = Truck::where('user_id', Auth::id())->OrderBy('id', 'Desc')->paginate(10);

        }

        if (request()->input('id')) {
            $truckList->first();
        }
        $truckList->transform(function ($truck) {
            $truck['equipment_type'] = $truck->equipment_type ? $truck->equipment_type : '';
            return $truck;
        });

        return $this->formatResponse(
            'success',
            'trucks found successfully',
            $truckList,
            200
        );
    }

    public function truckUpdate(Request $request, $truck_id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'sometimes',
            'eq_type_id' => 'required',
            'equipment_detail' => 'required',
            'length' => 'required',
            'weight' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }
        $truckUpdate = Truck::where('user_id', Auth::id())->find($truck_id);

        if ($truckUpdate == null) {
            return $this->formatResponse(
                'error',
                'no truck found'
            );
        }
        if ($request->name == null || $request->name == "") {
            $name = 'Truck #' . $truck_id;
        } else {
            $name = $request->name;
        }
        $truckUpdate = Truck::where('id', $truck_id)
            ->where('user_id', Auth::id())
            ->update([
                'name' => $name,
                'eq_type_id' => $request->eq_type_id,
                'equipment_detail' => $request->equipment_detail,
                'length' => $request->length,
                'weight' => $request->weight,
            ]);

        $truckUpdate = Truck::find($truck_id);
        $truckUpdate['equipment_type'] = $truckUpdate->equipment_type ? $truckUpdate->equipment_type : '';
        return $this->formatResponse(
            'success',
            'truck update successfully',
            $truckUpdate,
            200
        );

    }

    public function truckDelete($truck_id)
    {

        $truck = Truck::where('user_id', Auth::id())->find($truck_id);

        if ($truck == null) {
            return $this->formatResponse(
                'error',
                'no truck found'
            );
        }

        if (count($truck->truck_posts) > 0) {
            foreach ($truck->truck_posts as $truck_post) {
                $truck_post->delete();
            }
        }
        $truck->delete();

        return $this->formatResponse(
            'success',
            'truck Deleted successfully',
            [],
            200
        );

    }

    public function truckPostCreate(Request $request)
    {

        // validation
        $validate = Validator::make($request->all(), [
            'truck_id' => 'required',
            'current_location.*' => 'required_without_all:origin_city',
            'origin_city' => 'required_without_all:current_location',
            'destination_city' => 'required_without_all:destination_states,is_anywhere',
            'destination_states.*' => 'required_without_all:destination_city,is_anywhere',
            'is_anywhere' => 'required_without_all:destination_city,destination_states',
            'from_date' => 'required',
            'to_date' => 'required',
            'rate' => 'sometimes',
            'status_phone' => 'required_without_all:status_email',
            'status_email' => 'required_without_all:status_phone',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        if (isset($request['current_location'])) {
            $origin = currentlocationGetCity($request['current_location'][0], $request['current_location'][1]);
            $origin_lat = $request['current_location'][0];
            $origin_lng = $request['current_location'][1];
            $origin_city_id = null;
            $origin_state_id = null;
        }
        // dd(City::find($request['origin_city']));
        if (isset($request['origin_city'])) {
            $city = City::find($request['origin_city']);
            $origin = $city->name . ', ' . $city->states->code;
            $origin_lat = $city->latitude;
            $origin_lng = $city->longitude;
            $origin_city_id = $city->id;
            $origin_state_id = $city->state_id;
        }
            $destination = null;
            $destination_lat = null;
            $destination_lng = null;
            $destination_city_id = null;
                
       

        if (isset($request['is_anywhere'])) {
            $destination = 'AnyWhere';
            $destination_lat = null;
            $destination_lng = null;
        }
        
        
        // dd(Auth::id());
        $truck_post = TruckPost::create([
            'truck_id' => $request->truck_id,
            'origin' => isset($origin) ? $origin : null,
            'origin_lat' => isset($origin_lat) ? $origin_lat : null,
            'origin_lng' => isset($origin_lng) ? $origin_lng : null,
            'origin_city_id' => isset($origin_city_id) ? $origin_city_id : null,
            'origin_state_id' => isset($origin_state_id) ? $origin_state_id : null,
            'destination' => isset($destination) ? $destination : null,
            'destination_lat' => isset($destination_lat) ? $destination_lat : null,
            'destination_lng' => isset($destination_lng) ? $destination_lng : null,
            'destination_city_id' => isset($destination_city_id) ? $destination_city_id : null,
            'from_date' => isset($request->from_date) ? $request->from_date : null,
            'to_date' => isset($request->to_date) ? $request->to_date : null,
            'user_id' => Auth::id(),
            'rate' => isset($request->rate) ? $request->rate : null,
            'comment' => isset($request->comment) ? $request->comment : null,
            'status_phone' => $request->status_phone == 1 ? 1 : 0,
            'status_email' => $request->status_email == 1 ? 1 : 0,
            'is_posted' => 1,
        ]);

        $truck_post = TruckPost::find($truck_post->id);
        // dd($truck_post);
        
        if (isset($request['destination_states'])) {
            $states = State::select('id', 'name', 'code')->whereIn('id', $request->destination_states)->get()->toArray();
            $destination = '';
            foreach ($states as $k => $state) {
                if ($k === array_key_last($states)) {
                    $destination .= $state['code'];
                } else {
                    $destination .= $state['code'] . ', ';
                }

                TruckPostDestState::create([
                    'state_id' => $state['id'],
                    'code' => $state['code'],
                    'truck_post_id' => $truck_post->id,
                ]);
            }
            $destination_lat = null;
            $destination_lng = null;

            $truck_post->destination = $destination;
            $truck_post->save();

        }
        if (isset($request['destination_city'])) {
            $city = City::find($request['destination_city']);
            $destination = $city->name . ', ' . $city->states->code;
            $destination_lat = $city->latitude;
            $destination_lng = $city->longitude;
            $destination_city_id = $city->id;
            $truck_post->destination = $destination ;
            $truck_post->destination_lat = $destination_lat;
            $truck_post->destination_lng = $destination_lng;
            $truck_post->destination_city_id = $destination_city_id;
                TruckPostDestState::create([
                    'state_id' => $city->states->id,
                    'code' => $city->states->code,
                    'truck_post_id' => $truck_post->id,
                ]);
            $truck_post->save();
            
        }
        
        
        $truck_post['truck_post_states'] = $truck_post->truck_post_states;
        
        
                // dd($truck_post->trucks);
        // return response()->json([
        //      'status' => 'success',
        //     'message' => 'truck created successfully',
        //     'data' => $truck_post,
        // ], 200
        // );
        return $this->formatResponse(
            'success',
            'truck created successfully',
            $truck_post,
            200
        );

    }

    public function truckPostList(Request $request)
    {
        if (request()->input('id')) {
            $truckPostList = TruckPost::where('user_id', Auth::id())->where('id', request()->input('id'))->get();
        } else {
            $truckPostList = TruckPost::where('user_id', Auth::id())->OrderBy('id', 'Desc')->paginate(10);

        }

        if(count($truckPostList) == 0){
            return $this->formatResponse(
            'success',
            'Truck Post is empty',
            $truckPostList,
            200
            );
        }

      if(request()->input('id')){
            $truckPostList = $this->formatTruckData($truckPostList->first());
        }else{
           $truckPostList->getCollection()->transform(function ($truck) {
                return $this->formatTruckData($truck);
            });
        }


        return $this->formatResponse(
            'success',
            'Truck Post fetch successfully',
            $truckPostList,
            200
        );
    }

    private function formatTruckData($truck)
    {
        $truck['trucks'] = $truck->trucks ? $truck->trucks : null;
        $truck['truck_post_states'] = $truck->truck_post_states ? $truck->truck_post_states : null;

        if ($truck->trucks) {
            $truck['trucks']['equipment_type'] = $truck->trucks->equipment_type ?? '';
        }

        return $truck;
    }

    public function truckPostUpdate(Request $request, $truck_post_id)
    {
        $validate = Validator::make($request->all(), [
            'current_location.*' => 'required_without_all:origin_city',
            'origin_city' => 'required_without_all:current_location',
            'destination_city' => 'required_without_all:destination_states,is_anywhere',
            'destination_states.*' => 'required_without_all:destination_city,is_anywhere',
            'is_anywhere' => 'required_without_all:destination_city,destination_states',
            'from_date' => 'required',
            'to_date' => 'required',
            'rate' => 'sometimes',
            'comment' => 'sometimes',
            'status_phone' => 'required_without_all:status_email',
            'status_email' => 'required_without_all:status_phone',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        if (isset($request['current_location'])) {
            $origin =  currentlocationGetCity($request['current_location'][0], $request['current_location'][1]);
            $origin_lat = $request['current_location'][0];
            $origin_lng = $request['current_location'][1];
            $origin_city_id = null;
            $origin_state_id = null;
        }

        if (isset($request['origin_city'])) {
            $city = City::find($request['origin_city']);
            $origin = $city->name . ', ' . $city->states->code;
            $origin_lat = $city->latitude;
            $origin_lng = $city->longitude;
            $origin_city_id = $city->id;
            $origin_state_id = $city->state_id;
        }

            $destination = null;
            $destination_lat = null;
            $destination_lng = null;
            $destination_city_id = null;
            

        if (isset($request['is_anywhere'])) {
            $destination = 'AnyWhere';
            $destination_lat = null;
            $destination_lng = null;
            $destination_city_id = null;
        }
    
            
        $truck_post = TruckPost::find($truck_post_id);
        $truck_post->origin = isset($origin) ? $origin : null;
        $truck_post->origin_lat = isset($origin_lat) ? $origin_lat : null;
        $truck_post->origin_lng = isset($origin_lng) ? $origin_lng : null;
        $truck_post->origin_city_id = isset($origin_city_id) ? $origin_city_id : null;
        $truck_post->origin_state_id = isset($origin_state_id) ? $origin_state_id : null;
        $truck_post->destination = isset($destination) ? $destination : null;
        $truck_post->destination_lat = isset($destination_lat) ? $destination_lat : null;
        $truck_post->destination_lng = isset($destination_lng) ? $destination_lng : null;
        $truck_post->destination_city_id = isset($destination_city_id) ? $destination_city_id : null;
        $truck_post->from_date = isset($request->from_date) ? $request->from_date : null;
        $truck_post->to_date = isset($request->to_date) ? $request->to_date : null;
        $truck_post->comment = isset($request->comment) ? $request->comment : null;

        $truck_post->user_id = Auth::id();
        $truck_post->rate = isset($request->rate) ? $request->rate : null;
        $truck_post->status_phone = $request->status_phone == 1 ? 1 : 0;
        $truck_post->status_email = $request->status_email == 1 ? 1 : 0;
        $truck_post->is_posted = 1;
        $truck_post->save();

        if (count($truck_post->truck_post_states) > 0) {
            foreach ($truck_post->truck_post_states as $truck_post_state) {
                $truck_post_state->delete();
            }
        }
        if (isset($request['destination_states'])) {

            $states = State::select('id', 'name', 'code')->whereIn('id', $request->destination_states)->get()->toArray();
            $destination = '';
            foreach ($states as $k => $state) {
                if ($k === array_key_last($states)) {
                    $destination .= $state['code'];
                } else {
                    $destination .= $state['code'] . ', ';
                }

                TruckPostDestState::create([
                    'state_id' => $state['id'],
                    'code' => $state['code'],
                    'truck_post_id' => $truck_post->id,
                ]);
            }
            $destination_lat = null;
            $destination_lng = null;

            $truck_post->destination = $destination;
            $truck_post->save();

        }
        
        if (isset($request['destination_city'])) {
            $city = City::find($request['destination_city']);
            $destination = $city->name . ', ' . $city->states->code;
            $destination_lat = $city->latitude;
            $destination_lng = $city->longitude;
            $destination_city_id = $city->id;
            $truck_post->destination = isset($destination) ? $destination : null;
            $truck_post->destination_lat = isset($destination_lat) ? $destination_lat : null;
            $truck_post->destination_lng= isset($destination_lng) ? $destination_lng : null;
            $truck_post->destination_city_id = isset($destination_city_id) ? $destination_city_id : null;
                TruckPostDestState::create([
                    'state_id' => $city->states->id,
                    'code' => $city->states->code,
                    'truck_post_id' => $truck_post->id,
                ]);
            $truck_post->save();
            
        }
        
        
        $truck_post = TruckPost::find($truck_post_id);
        $truck_post['truck_post_states'] = $truck_post->truck_post_states;
        return $this->formatResponse(
            'success',
            'Truck Post Updated successfully',
            $truck_post,
            200
        );

    }

    public function truckPostDelete($truck_post_id)
    {

        $truck_post = truckPost::where('user_id', Auth::id())->find($truck_post_id);

        if ($truck_post == null) {
            return $this->formatResponse(
                'error',
                'No Truck found'
            );
        }

        if (count($truck_post->truck_post_states) > 0) {
            foreach ($truck_post->truck_post_states as $truck_post_state) {
                $truck_post_state->delete();
            }
        }
        $truck_post->delete();

        return $this->formatResponse(
            'success',
            'Truck post Deleted successfully',
            [],
            200
        );

    }

    public function truckStatusPosted(Request $request, $truck_post_id)
    {

        $validate = Validator::make($request->all(), [
            'is_posted' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $truck_post = truckPost::where('user_id', Auth::id())->find($truck_post_id);

        if ($truck_post == null) {
            return $this->formatResponse(
                'error',
                'No Truck found'
            );
        }
        // dd($request->all());
        $truck_post->is_posted = $request->is_posted;
        $truck_post->save();

        if ($request->is_posted) {
            $msg = 'Truck Posted successfully';
        } else {
            $msg = 'Truck Un Posted successfully';
        }
        return $this->formatResponse(
            'success',
            $msg,
            [],
            200
        );

    }

    public function QuickRateLookup(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'origin' => 'required',
            'destination' => 'required',
            'eq_type_id' => 'required',
        ], [
            'eq_type_id.required' => 'Equipment type field is required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        if ($request->eq_type_id == "4") {
            $eq_type_id = $request->eq_type_id;
            $fuel_surcharge = "Rates for Reefer include a fuel surcharge of $0.42/mi";
        } else if ($request->eq_type_id == "2") {
            $eq_type_id = $request->eq_type_id;
            $fuel_surcharge = "Rates for Flatbeds include a fuel surcharge of $0.46/mi";
        } else {
            $eq_type_id = 1;
            $fuel_surcharge = "Rates for Vans include a fuel surcharge of $0.38/mi";

        }
        $fifteen_day = Carbon::now()->subDay(15);
        $shipment = Shipment::where('origin_city_id', $request->origin)->where('destination_city_id', $request->destination)->where('eq_type_id', $eq_type_id)->where('created_at', '>=', $fifteen_day->format('Y-m-d') . ' 00:00:00')
        ->where('is_post',1)->where('is_public_load',1);
        $ship = $shipment->first();
        $data = [];
        if ($ship) {

            $s_max = number_format((float) $shipment->max('dat_rate'), 2, '.', '');
            $s_min = number_format((float) $shipment->min('dat_rate'), 2, '.', '');
            $s_avg = number_format((float) $shipment->avg('dat_rate'), 2, '.', '');

            $data['origin'] = $ship->origin;
            $data['destination'] = $ship->destination;
            $data['miles'] = number_format((float) $ship->miles, 2, '.', '');
            $data['average_rate'] = $s_avg;
            $data['average_mile'] = number_format((float) $s_avg / $ship->miles, 2, '.', '');
            $data['range_min_rate'] = $s_min;
            $data['range_max_rate'] = $s_max;
            $data['range_min_mile'] = number_format((float) $s_min / $ship->miles, 2, '.', '');
            $data['range_max_mile'] = number_format((float) $s_max / $ship->miles, 2, '.', '');
            $data['fuel_surcharge'] = $fuel_surcharge;
        }
        // dd($data);

        if (count($data) == 0) {
            return $this->formatResponse(
                'error',
                'record not found',
            );
        }

        return $this->formatResponse(
            'success',
            'Record Fetch Successfully',
            $data,
            200
        );

    }

}
