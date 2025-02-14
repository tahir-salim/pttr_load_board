<?php

namespace App\Http\Controllers;
use App\Models\EquipmentType;
use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tools()
    {   
        $equipment_types = EquipmentType::whereIn('id',[1,2,4])->get();
        $data = [];
        return view('Global.tools', get_defined_vars());
    }
    public function form_tools(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'eq_type_id' => 'required',
        ], [
            'eq_type_id.required' => 'Equipment type field is required',
        ]);

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
        $shipment = Shipment::where('origin_city_id', $request->origin)
        ->where('destination_city_id', $request->destination)
        ->where('eq_type_id', $eq_type_id)
        ->where('created_at', '>=', $fifteen_day->format('Y-m-d') . ' 00:00:00')
        ->where('is_post',1)->where('is_public_load',1);
        // dd($shipment->first());
        $ship = $shipment->first();
        $data = null;
        if ($ship != null) {

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
               
       return response()->json(['message' => $data ]);
        // $equipment_types = EquipmentType::get();
        // return view('Global.tools', get_defined_vars());
    }

    public function helpCenter()
    {
        return view('Global.help-center');
    }

    public function helpCenterDetail()
    {
        return view('Global.help-center-detail');
    }

}
