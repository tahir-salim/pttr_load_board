<?php

namespace App\Http\Controllers;

use App\Mail\MyTrackingMail;
use App\Models\Group;
use App\Models\Tracking;
use App\Models\Shipment;
use App\Models\TrackingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class NewTrackingRequestController extends Controller
{

    public function trackings(Request $request)
    {

        $data = Tracking::where('user_id', auth()->user()->id)->where('tracking_type',1)->orderBy('id', 'DESC')->select('*');
        if ($request->ajax()) {
            return DataTables::of($data)
            ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return \Illuminate\Support\Str::limit($row->name, 20, $end='...');
                })->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex btnWrap"><a href="'.route(auth()->user()->type.'.tracking_details',[$row->id]).'" class="fa fa-eye btn btn-outline-success"></a>';
                    $btn .= '<a href="'.route(auth()->user()->type.'.edit_tracking_request',[$row->id]).'" class="fa fa-pencil btn btn-outline-primary"></a>';
                    $btn .= '<a href="'.route(auth()->user()->type.'.delete_tracking_request',[$row->id]).'"  onclick="return confirm(`Are you sure you want to delete it?`)" class="fa fa-trash-alt btn btn-outline-danger"></a></div>';
                    return $btn;
                })->addColumn('shipment', function ($row) {
                    return '<a href="'.route(auth()->user()->type.'.my_shipments_overview',[$row->shipments->id]).'">'.$row->shipments->origin.' / '.$row->shipments->destination.'</a>';
                })

                ->addColumn('status', function ($row) {
                  $status = strtoupper($row->shipments ? $row->shipments->status : '');
                    if ($status == 'PENDING') {
                        return '<span class="badge badge-warning">'.$status.'</span>';
                    } elseif($status == 'BOOKED') {
                        return '<span class="badge badge-primary">'.$status.'</span>';
                    } elseif($status == 'AT-PICK-UP') {
                        return '<span class="badge badge-info">'.$status.'</span>';
                    } elseif($status == 'DELIVERED') {
                        return '<span class="badge badge-secondary">'.$status.'</span>';
                    }elseif($status == 'ACCEPTED') {
                        return '<span class="badge badge-success">'.$status.'</span>';
                    }elseif($status == 'COMPLETE') {
                        return '<span class="badge badge-danger">'.$status.'</span>';
                    }elseif($status == 'DISPATCHED') {
                        return '<span class="badge badge-dark">'.$status.'</span>';
                    }elseif($status == 'AT-DROP-OFF') {
                        return '<span class="badge badge-light">'.$status.'</span>';
                    }else{
                        return $status;
                    }
                })

                ->rawColumns(['action', 'status','shipment', 'name'])
                ->make(true);
        }

        return view('Tracking.trackings' , get_defined_vars());
    }


    public function new_tracking_request()
    {
     
        $shipments = Shipment::where('user_id', auth()->user()->id)
            ->where('is_tracking',1)
            ->whereIn('status',['BOOKED','AT-PICK-UP','DELIVERED','DISPATCHED','IN-TRANSIT','AT-DROP-OFF'])
            ->where('is_post', 1)
            ->orderBy('id', 'DESC')
            ->get();
        return view('Tracking.new-tracking-request', get_defined_vars());
    }
    
    
    
    public function map()
    {
        return view('Tracking.map', get_defined_vars());
    }

    public function new_tracking_store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'phone.*' => 'required',
            'name.*' => 'required|string|max:255',
            'carrier_email.*' => 'required|email',
            'shipment_id.*' => 'required|exists:shipments,id',
        ]);

        foreach($request->phone as $key => $phone) {
        // Create a new Tracking record for each set of data
            $s = Shipment::where('id', $request->shipment_id[$key])->first();
            $s->app_status = $s->status;
            $s->save();
            $tracking = Tracking::create([
                "phone" => $request->phone[$key],
                "name" => $request->name[$key],
                "carrier_email" => $request->carrier_email[$key],
                "shipment_id" => $request->shipment_id[$key],
                "otp" => rand(1000, 9999),
                "tracking_status" => 'PENDING',
                "tracking_type" => 1,
                "user_id" => auth()->user()->id,
            ]);
            
            // dd($tracking);
    
            // Retrieve the first tracking record for the shipment ID
            $tracking1 = Tracking::where('shipment_id', $request->shipment_id[$key])->first();
            // dd($tracking1->tracking_details); // Debugging: dump and die the first tracking record
            
            foreach($tracking1->tracking_details as $k => $item){
                // dd($item->street_address);
                $tracking_detail = new TrackingDetail();
                $tracking_detail->street_address = $item->street_address ?? null;
                $tracking_detail->street_place_id = $item->street_place_id ?? null;
                $tracking_detail->street_addressLat = $item->street_addressLat ?? null;
                $tracking_detail->street_addressLng = $item->street_addressLng ?? null;
                $tracking_detail->appointment_date = $item->appointment_date ?? null;
                $tracking_detail->dock_info = $item->appointment_date ?? null;
                $tracking_detail->start_time = $item->start_time ?? null;
                $tracking_detail->end_time = $item->end_time ?? null;
                $tracking_detail->lcoation_name = $item->lcoation_name ?? null;
                $tracking_detail->tracking_start_time = $item->tracking_start_time ?? null;
                $tracking_detail->type = $item->type;
                $tracking_detail->notes = $item->notes ?? null;
                $tracking_detail->sort_no = $item->sort_no ?? null;
                $tracking_detail->tracking_id = $tracking->id;
                $tracking_detail->save();
            }
            
            $email = encrypt($request->carrier_email[$key]);

          $data = [
                "carrier_phone" => $request->phone[$key],
                "carrier_name" => $request->name[$key],
                "carrier_email" => $request->carrier_email[$key],
                "carrier_status" => $tracking->shipments->status,
                "carrier_otp" => $tracking->otp,
                'carrier_url' => "https://portallink.pttrloadboard.com/tracking-request-link/".$tracking->id,
            ];

        Mail::to($request->carrier_email[$key])->send(new MyTrackingMail($data));
        }
        
        return redirect()->route(auth()->user()->type.'.trackings')->with('success', 'New Tracking Request Successfully Sent');
    }


    public function edit_tracking_request($id)
    {
        $tracking = Tracking::find($id);
        // dd($tracking->shipments);
        if($tracking){
            return view('Tracking.edit-tracking-request', get_defined_vars());
        }else{
            abort(404);
        }
    }


    public function new_tracking_update(Request $request, $id )
    {


        // dd($request->all());

            $tracking = Tracking::find($id);
            $tracking->phone = $request->phone;
            $tracking->name = $request->name;
            $tracking->carrier_email = $request->carrier_email;
            $tracking->tracking_status = 'PENDING';
            $tracking->otp = rand(1000, 9999);
            $tracking->save();
            $s = Shipment::where('id', $tracking->shipment_id)->first();
            $s->app_status = $s->status;
            $s->save();
            $email = encrypt($tracking->carrier_email);

            $data = [
                "carrier_phone" => $tracking->phone,
                "carrier_name" => $tracking->name,
                "carrier_email" => $tracking->carrier_email,
                "carrier_status" => $tracking->shipments->status,
                "carrier_otp" => $tracking->otp,
                'carrier_url' => "https://portallink.pttrloadboard.com/tracking-request-link/".$tracking->id,
            ];


            Mail::to($request->carrier_email)->send(new MyTrackingMail($data));


$data = Tracking::whereNotNull('phone')->where('user_id',auth()->user()->id)->select('*');
            return redirect()->route(auth()->user()->type.'.trackings')->with('success', 'Updated Tracking Request Send Successfully');

    }


    public function delete_tracking_request($id)
    {
        $tracking = Tracking::find($id);
        // dd($tracking->tracking_details);
        if($tracking){

            foreach($tracking->tracking_details as $item){
                $item->delete();
            }

            $tracking->delete();

            return redirect()->route(auth()->user()->type.'.trackings')->with('success', 'Tracking Request Deleted Successfully');
        }else{
            abort(404);
        }
    }
    public function tracking_details($id)
    {
        $tracking = Tracking::find($id);
        // dd($tracking->tracking_details);
        if($tracking){
            return view('Tracking.tracking_details', get_defined_vars());
        }else{
            abort(404);
        }
    }
    
    public function tracking_request_link($id)
    {
        $tracking = Tracking::find($id);
        if($tracking){
            return redirect()->to("https://portallink.pttrloadboard.com/tracking-request-link/{$id}");
            // return view('Tracking.tracking-request-link', get_defined_vars());
        }else{
            abort(404);
        }
    }
    

}
