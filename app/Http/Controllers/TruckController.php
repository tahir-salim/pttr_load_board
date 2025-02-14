<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\User;
use App\Models\EquipmentType;
use Carbon\Carbon;
use App\Models\State;
use App\Models\City;
use App\Models\TruckPost;
use App\Models\TruckPostDestState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // dd(auth()->user()->id);
            $data = TruckPost::select("*")->where('user_id',Auth::id())->orderBy('id', 'DESC');
            return DataTables::of($data)
            ->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                    $btn = '<a class="fa fa-eye btn btn-outline-success" href="' . route(auth()->user()->type.".truck.detail", [$row->id]) . '" tile=""></a>';
                    $btn .= '<a class="fa fa-pencil btn btn-outline-primary" href="' . route(auth()->user()->type.".truck.edit", [$row->id]) . '" tile=""></a>';
                    $btn .= '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route(auth()->user()->type.'.truck.delete', [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a>';
                return '<div class="d-flex btnWrap">'.$btn.'</div>';
            })
            ->addIndexColumn()
                ->addColumn('eq_detail', function ($row) {
                    if ($row->trucks->equipment_detail  == "0") {
                        return 'Full';
                    } else {
                        return 'Partial';
                    }
                })
                ->addColumn('from_to_date', function ($row) {
                    $r =  Carbon::create($row->from_date)->format('m/d');
                    $r .= $row->to_date != null ? ' - ' . Carbon::create($row->to_date)->format('m/d') : '';
                    return $r;
                })
                ->addColumn('eq_type_id', function ($row) {
                    return $row->trucks ? $row->trucks->equipment_type ? $row->trucks->equipment_type->name : '' : '';
                })

                ->addColumn('length', function ($row) {
                    return isset($row->trucks) ? $row->trucks->length : '' ;
                })
                ->addColumn('weight', function ($row) {
                    return isset($row->trucks) ? $row->trucks->weight : '' ;
                })
                ->addColumn('is_posted', function ($row) {
                    return isset($row->is_posted)  == 1 ? 'Posted' : 'Un-posted' ;
                })

            ->rawColumns(['created_at','actions','eq_type_id','is_posted','eq_detail'.'from_to_date','lenght','weight'])
            ->make(true);

        }

        return view('Trucking.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipment_types = EquipmentType::all();
        return view('Trucking.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {




        $request->validate([
            'origin' => 'required',
            'destination' => 'sometimes',
            'from_date' => 'required',
            'to_date' => 'required',
            'rate' => 'sometimes',
            'name' => 'sometimes',
            'eq_type_id' => 'required',
            'equipment_detail' => 'required',
            'length' => 'required',
            'weight' => 'sometimes',
            'status_phone' => 'required_without_all:status_email',
            'status_email' => 'required_without_all:status_phone',
        ]);
    
        if (isset($request['destination']) && is_array($request['destination']) && count($request['destination']) > 0) {
            if (in_array("city_117058", $request['destination'])) {
                $request['destination'] = ["city_117058"];
            }
        }

        $newTruck = Truck::create([
            'name' => null,
            'eq_type_id' => $request->eq_type_id,
            'equipment_detail' => $request->equipment_detail,
            'length' => $request->length,
            'weight' =>  isset($request->weight) && $request->weight != null ? $request->weight : 0,
            'reference_id' => isset($request->reference_id) ? $request->reference_id : '',
            'user_id' => Auth::id(),
        ]);
        if ($newTruck->name == null) {
            $newTruck = Truck::find($newTruck->id);
            $newTruck->name = 'Truck #' . $newTruck->id;
            $newTruck->save();
        }

        if (isset($request['origin'])) {
            $city = City::find($request['origin']);
            $origin = $city->name . ', ' . $city->states->code;
            $origin_lat = $city->latitude;
            $origin_lng = $city->longitude;
            $origin_city_id = $city->id;
            $origin_state_id = $city->state_id;
        }


        $truck_post = TruckPost::create([
            'truck_id' => $newTruck->id,
            'origin' => isset($request->origin) ? $origin : null,
            'origin_lat' => isset($origin_lat) ? $origin_lat : null,
            'origin_lng' => isset($origin_lng) ? $origin_lng : null,
            'origin_city_id' => isset($origin_city_id) ? $origin_city_id : null,
            'origin_state_id' => isset($origin_state_id) ? $origin_state_id : null,
            'destination' => isset($destination) ? $destination : 'Anywhere',
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
        if (isset($request['destination'])) {
            $destination = '';
            $destination_lat = null;
            $destination_lng = null;
            $destination_city_id = null;

            if (strpos($request->destination[0], 'city_') === 0) {
                $city_id = (int)str_replace('city_', '', $request->destination[0]);
                $destination_city = City::find($city_id);
                if($destination_city->states != null){
                    $destination =    $destination_city->name . ', ' . $destination_city->states->code;
                    $destination_lat = $destination_city->latitude;
                    $destination_lng = $destination_city->longitude;
                    $destination_city_id = $destination_city->id;
                    TruckPostDestState::create([
                        'state_id' => $destination_city->states->id,
                        'code' => $destination_city->states->code,
                        'truck_post_id' => $truck_post->id,
                    ]);
                }
                else{
                     $destination =    $destination_city->name ;
                }
              
               
            }
            else if((strpos($request->destination[0], 'state_') === 0)){
                $state_ids = [];
                foreach($request->destination as $state_id){
                    $state_ids[] = (int)str_replace('state_', '', $state_id);
                }

                $states = State::select('id', 'name', 'code')->whereIn('id', $state_ids)->get()->toArray();
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

            }

            $truck_post->destination_lat =  $destination_lat ;
            $truck_post->destination_lng =  $destination_lng ;
            $truck_post->destination_city_id =  $destination_city_id ;
            $truck_post->destination = $destination;
            $truck_post->save();

        }
        return redirect()->route(auth()->user()->type.'.truck.index')->with('success', 'Truck Post Created Succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $truck_post = TruckPost::find($id);
        return view('Trucking.show',get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $truck_post = TruckPost::find($id);
        $equipment_types = EquipmentType::all();
        return view('Trucking.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'sometimes',
            'from_date' => 'required',
            'to_date' => 'required',
            'rate' => 'sometimes',
            'name' => 'sometimes',
            'eq_type_id' => 'required',
            'equipment_detail' => 'required',
            'length' => 'required',
            'weight' => 'sometimes',
            'status_phone' => 'required_without_all:status_email',
            'status_email' => 'required_without_all:status_phone',
        ]);
        
        $truck_post = TruckPost::find($id);

        if (isset($request['origin'])) {
            if($request['origin'] != "current"){
                $city = City::find($request['origin']);
                $origin = $city->name . ', ' . $city->states->code;
                $origin_lat = $city->latitude;
                $origin_lng = $city->longitude;
                $origin_city_id = $city->id;
                $origin_state_id = $city->state_id;
            }else{
                $origin = $truck_post->origin;
                $origin_lat =  $truck_post->origin_lat;
                $origin_lng =  $truck_post->origin_lng;
                $origin_city_id =  $truck_post->origin_city_id;
                $origin_state_id =  $truck_post->origin_state_id;
            }

        }

        if($truck_post->truck_post_states){
            foreach ($truck_post->truck_post_states as $key => $truck_post_state) {
                $truck_post_state->delete();
            }
        }   
        
           if (isset($request['destination']) && is_array($request['destination']) && count($request['destination']) > 0) {
                if (in_array("city_117058", $request['destination'])) {
                   $request['destination'] = ["city_117058"];
                }
            }

        if (isset($request['destination'])) {
            $destination = '';
            $destination_lat = null;
            $destination_lng = null;
            $destination_city_id = null;

            // dd($truck_post->truck_post_states);
            if (strpos($request->destination[0], 'city_') === 0) {
                $city_id = (int)str_replace('city_', '', $request->destination[0]);
                $destination_city = City::find($city_id);
                if($destination_city->states != null){
                    $destination =    $destination_city->name . ', ' . $destination_city->states->code;
                    $destination_lat = $destination_city->latitude;
                    $destination_lng = $destination_city->longitude;
                    $destination_city_id = $destination_city->id;
                        TruckPostDestState::create([
                            'state_id' => $destination_city->states->id,
                            'code' => $destination_city->states->code,
                            'truck_post_id' => $truck_post->id,
                        ]);
                }else{
                    $destination =    $destination_city->name;
                }
            }
            else if((strpos($request->destination[0], 'state_') === 0)){
                $state_ids = [];
                foreach($request->destination as $state_id){
                    $state_ids[] = (int)str_replace('state_', '', $state_id);
                }

                $states = State::select('id', 'name', 'code')->whereIn('id', $state_ids)->get()->toArray();
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

            }

        }

        $truck_post->origin = isset($request->origin) ? $origin : null;
        $truck_post->origin_lat = isset($origin_lat) ? $origin_lat : null;
        $truck_post->origin_lng = isset($origin_lng) ? $origin_lng : null;
        $truck_post->origin_city_id = isset($origin_city_id) ? $origin_city_id : null;
        $truck_post->origin_state_id = isset($origin_state_id) ? $origin_state_id : null;
        $truck_post->destination = isset($destination) ? $destination : "Anywhere";
        $truck_post->destination_lat = isset($destination_lat) ? $destination_lat : null;
        $truck_post->destination_lng = isset($destination_lng) ? $destination_lng : null;
        $truck_post->destination_city_id = isset($destination_city_id) ? $destination_city_id : null;
        $truck_post->from_date = isset($request->from_date) ? $request->from_date : null;
        $truck_post->to_date = isset($request->to_date) ? $request->to_date : null;
        $truck_post->rate = isset($request->rate) ? $request->rate : null;
        $truck_post->comment = isset($request->comment) ? $request->comment : null;
        $truck_post->status_phone = $request->status_phone == 1 ? 1 : 0;
        $truck_post->status_email = $request->status_email == 1 ? 1 : 0;
        $truck_post->is_posted = $request->is_posted;
        $truck_post->trucks->equipment_detail = $request->equipment_detail;
        $truck_post->trucks->eq_type_id = $request->eq_type_id;
        $truck_post->trucks->length  = $request->length;
        $truck_post->trucks->weight = isset($request->weight) && $request->weight != null ?  $request->weight : 0;
        $truck_post->status_phone = isset($request->status_phone) ? 1 : 0;
        $truck_post->status_email = isset($request->status_email) ? 1 : 0;
        $truck_post->created_at = Carbon::now();
        $truck_post->trucks->save();
        $truck_post->save();






        $success ='Truck Post Updated Successfully!';

        return redirect()->route(auth()->user()->type.'.truck.index')->with('success',$success);
    }

    public function destroy(string $id)
    {
        $truck_post = TruckPost::find($id);
        if($truck_post){
            if($truck_post->truck_post_states){
                foreach ($truck_post->truck_post_states as $key => $value) {
                    $value->delete();
                }
            }
            $truck_post->delete();
        }else{
            return back()->with('success','Truck Post Not Found!');
        }


        return redirect()->route(auth()->user()->type.'.truck.index')->with('success','Truck Post Deleted Successfully!');
    }
}
