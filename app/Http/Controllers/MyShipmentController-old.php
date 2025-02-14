<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Shipment;
use App\Models\ShipmentsRequest;
use App\Models\Tracking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\MyShipmentStatusMail;
use App\Models\ShipmentStatusTracking;
use Illuminate\Support\Facades\Auth;
use Mail;
class MyShipmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function my_shipments(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');
        // 'WAITING','BOOKED','PENDING','ACCEPTED','DISPATCHED','AT-PICK-UP','AT-DROP-OFF','IN-TRANSIT','DELIVERED','DECLINED','COMPLETE','CANCELED','EXPIRED'
        $shipment_open_count = Shipment::where('user_id', auth()->user()->id)->where('is_post', 1)
        // ->where('from_date', '>=', $now)
        ->WhereIn('status', ['WAITING', 'BOOKED', 'EXPIRED'])->count();
        $shipment_active_count = Shipment::where('user_id', auth()->user()->id)->where('is_post', 1)->WhereNotIn('status', ['WAITING', 'BOOKED', 'COMPLETE', 'CANCELED', 'EXPIRED'])->count();
        $shipment_history_count = Shipment::where('user_id', auth()->user()->id)->where('is_post', 1)->WhereIn('status', ['COMPLETE', 'CANCELED'])->count();


        if ($request->ajax()) {
            $data = Shipment::select("*")->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')
                // ->where('from_date', '>=', $now)
                // ->where('to_date', '<=', $now)
                ->WhereIn('status', ['WAITING', 'BOOKED', 'EXPIRED']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('age', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('available', function ($row) {
                    $r =  Carbon::create($row->from_date)->format('m/d');
                    $r .= $row->to_date != null ? ' - ' . Carbon::create($row->to_date)->format('m/d') : '';
                    return $r;
                })
                ->addColumn('equipment', function ($row) {
                    return  $row->equipment_type ? $row->equipment_type->name : 'None';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status != 'WAITING') {
                        $status = strtoupper($row->status);
                    } else {
                        if ($row->is_post == 1) {
                            $status = strtoupper("Posted");
                        } else {
                            $status = strtoupper("Un-Post");
                        }
                    }
                    return $status;
                })
                ->addColumn('equipment_detail', function ($row) {

                    if ($row->equipment_detail == 0) {
                        $eq = 'Full';
                    } elseif ($row->equipment_detail == 1) {
                        $eq = 'Partial';
                    } else {
                        $eq = 'Full/Partial';
                    }
                    return $eq;
                })
                ->addColumn('bids', function ($row) {
                    if($row->is_allow_bids == 1){
                        return '<a href="' . route(auth()->user()->type . ".my_shipments_bid_activity", [$row->id]) . '"> ' . count($row->bids) . ' bids</a>';
                    }else{
                        return '-';
                    }
                })
                ->addColumn('ship_requests', function ($row) {
                    return '<a href="' . route(auth()->user()->type . ".my_shipments_requests_activity", [$row->id]) . '"> ' . count($row->shimpents_requests) . ' Requests </a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="fa fa-eye btn btn-outline-success" href="' . route(auth()->user()->type . ".my_shipments_overview", [$row->id]) . '" tile=""></a>';
                    if($row->status == "BOOKED" && $row->trucker_id == null){
                        $btn .=   '<a class="btn btn-danger" href="javascript:;" onclick="status_accept_decline(`shipment`,'.$row->id.',`CANCELED`)" title="">Canceled</a>';
                        $btn .=   '<a class="btn btn-success" href="javascript:;" onclick="status_accept_decline(`shipment`,'.$row->id.',`COMPLETE`)" title="">Complete</a>';
                    }
                    if($row->status == "WAITING"){
                        $btn .= '<a class="fa fa-pencil btn btn-outline-primary" href="' . route(auth()->user()->type . ".edit_a_shipment", [$row->id]) . '" tile=""></a>';
                        $btn .= '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route(auth()->user()->type . ".delete_a_shipment", [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a>';
                    }
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    $instance->where(function ($q) use ($request) {
                        // dd($request->get('posted') , $request->get('booked') , $request->get('expired'),$request->get('with_bids') );
                        if ($request->get('posted') == "true") {
                            $q->where('is_post', 1);
                        }

                        if ($request->get('booked') == "true") {
                            $q->orWhere('status', 'BOOKED');
                        }

                        if ($request->get('expired') == "true") {
                            $q->orWhere('status', 'EXPIRED');
                        }

                        if ($request->get('with_bids') == "true") {
                            $q->orWhere('is_allow_bids', 1);
                        }
                    });

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('origin', 'LIKE', "%$search%")
                                ->orWhere('destination', 'LIKE', "%$search%")
                                ->orWhere('reference_id', 'LIKE', "%$search%")
                                ->orWhere('length', 'LIKE', "%$search%")
                                ->orWhere('weight', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['age', 'available', 'status', 'bids', 'equipment_detail', 'equipment', 'action', 'ship_requests'])
                ->make(true);
        }

        return view('Global.my-shipments', get_defined_vars());
    }
    public function my_shipments_active(Request $request)
    {

        $shipment_open_count = Shipment::where('user_id', auth()->user()->id)
        ->where(function ($q) {
            $q->where('is_post', 1)->WhereIn('status', ['WAITING', 'BOOKED', 'EXPIRED']);
        })->count();


        $shipment_active_count = Shipment::where('user_id', auth()->user()->id)->where('is_post', 1)->WhereNotIn('status', ['WAITING', 'BOOKED', 'COMPLETE', 'CANCELED', 'EXPIRED'])->count();
        $shipment_history_count = Shipment::where('user_id', auth()->user()->id)->where('is_post', 1)->WhereIn('status', ['COMPLETE', 'CANCELED'])->count();


        if ($request->ajax()) {
            $data = Shipment::select("*")->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')
                ->WhereNotIn('status', ['WAITING', 'BOOKED', 'EXPIRED', 'COMPLETE', 'CANCELED']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('age', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('available', function ($row) {
                    $r =  Carbon::create($row->from_date)->format('m/d');
                    $r .= $row->to_date != null ? ' - ' . Carbon::create($row->to_date)->format('m/d') : '';
                    return $r;
                })
                ->addColumn('carrier', function ($row) {

                    $r = '<h6>'.$row->carrier->name.'</h6>';
                    $r .= '<p>'.$row->carrier->phone.'</p>';
                    return $r;
                })
                ->addColumn('equipment', function ($row) {
                    return  $row->equipment_type ? $row->equipment_type->name : 'None';
                })
                ->addColumn('status', function ($row) {

                    if ($row->status != 'WAITING') {
                        $status = strtoupper($row->status);
                    } else {
                        if ($row->is_post == 1) {
                            $status = strtoupper("Posted");
                        } else {
                            $status = strtoupper("Un-Post");
                        }
                    }
                    return $status;
                })
                ->addColumn('equipment_detail', function ($row) {

                    if ($row->equipment_detail == 0) {
                        $eq = 'Full';
                    } elseif ($row->equipment_detail == 1) {
                        $eq = 'Partial';
                    } else {
                        $eq = 'Full/Partial';
                    }
                    return $eq;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary" href="' . route(auth()->user()->type . ".my_shipments_overview", [$row->id]) . '" tile="">View</a>';
                    if($row->status == "DELIVERED"){
                        $btn .=   '<a class="btn btn-success" href="javascript:;" onclick="status_accept_decline(`shipment`,'.$row->id.',`COMPLETE`)" title="">Complete</a>';
                        $btn .=   '<a class="btn btn-danger" href="javascript:;" onclick="status_accept_decline(`shipment`,'.$row->id.',`CANCELED`)" title="">Canceled</a>';
                    }
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    $instance->where(function ($q) use ($request) {
                        if ($request->get('at_pick_up') == "true") {
                            $q->orWhere('status', 'AT-PICK-UP');
                        }
                        if ($request->get('dispatched') == "true") {
                            $q->orWhere('status', 'DISPATCHED');
                        }
                        if ($request->get('in_transit') == "true") {
                            $q->orWhere('status', 'IN-TRANSIT');
                        }

                        if ($request->get('at_drop_off') == "true") {
                            $q->orWhere('status', 'AT-DROP-OFF');
                        }
                        if ($request->get('delivered') == "true") {
                            $q->orWhere('status', 'DELIVERED');
                        }
                        if ($request->get('declined') == "true") {
                            $q->orWhere('status', 'DECLINED');
                        }
                    });

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('origin', 'LIKE', "%$search%")

                                ->orWhere('destination', 'LIKE', "%$search%")
                                ->orWhere('reference_id', 'LIKE', "%$search%")
                                ->orWhere('length', 'LIKE', "%$search%")
                                ->orWhere('weight', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['age', 'available', 'status', 'carrier', 'equipment_detail', 'equipment', 'action'])
                ->make(true);
        }

        return view('Shipment.my-shipments-active', get_defined_vars());
    }
    public function my_shipments_history(Request $request)
    {
        // WhereIn('status', ['COMPLETE','CANCELED'])
        $shipment_open_count = Shipment::where('user_id', auth()->user()->id)
        ->where(function ($q) {
            $q->where('is_post', 1)->WhereIn('status', ['WAITING', 'BOOKED', 'EXPIRED']);
        })->count();

        $shipment_active_count = Shipment::where('user_id', auth()->user()->id)->where('is_post', 1)->WhereNotIn('status', ['WAITING', 'BOOKED', 'COMPLETE', 'CANCELED', 'EXPIRED'])->count();
        $shipment_history_count = Shipment::where('user_id', auth()->user()->id)->where('is_post', 1)->WhereIn('status', ['COMPLETE', 'CANCELED'])->count();


        if ($request->ajax()) {
            $data = Shipment::select("*")->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')
                ->WhereIn('status', ['COMPLETE', 'CANCELED']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('age', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('available', function ($row) {
                    $r =  Carbon::create($row->from_date)->format('m/d');
                    $r .= $row->to_date != null ? ' - ' . Carbon::create($row->to_date)->format('m/d') : '';
                    return $r;
                })
                ->addColumn('carrier', function ($row) {
                    // $r = '<h6> Kiad </h6>';
                    if($row->carrier){
                        $r = '<h6>'. $row->carrier->name  .'</h6>';
                        $r .= '<p>'. $row->carrier->phone .'</p>';
                    }
                    $r = "None";
                    return $r;
                })
                ->addColumn('equipment', function ($row) {
                    return  $row->equipment_type ? $row->equipment_type->name : 'None';
                })
                ->addColumn('status', function ($row) {

                    if ($row->status != 'WAITING') {
                        $status = strtoupper($row->status);
                    } else {
                        if ($row->is_post == 1) {
                            $status = strtoupper("Posted");
                        } else {
                            $status = strtoupper("Un-Post");
                        }
                    }
                    return $status;
                })
                ->addColumn('equipment_detail', function ($row) {

                    if ($row->equipment_detail == 0) {
                        $eq = 'Full';
                    } elseif ($row->equipment_detail == 1) {
                        $eq = 'Partial';
                    } else {
                        $eq = 'Full/Partial';
                    }
                    return $eq;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary" href="' . route(auth()->user()->type . ".my_shipments_overview", [$row->id]) . '" tile="">View</a>';
                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    $instance->where(function ($q) use ($request) {
                        if ($request->get('completed') == "true") {
                            $q->orWhere('status', 'COMPLETE');
                        }

                        if ($request->get('canceled') == "true") {
                            $q->orWhere('status', 'CANCELED');
                        }
                    });

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('origin', 'LIKE', "%$search%")
                                ->orWhere('destination', 'LIKE', "%$search%")
                                ->orWhere('reference_id', 'LIKE', "%$search%")
                                ->orWhere('length', 'LIKE', "%$search%")
                                ->orWhere('weight', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['age', 'available', 'carrier','status',  'equipment_detail', 'equipment', 'action'])
                ->make(true);
        }

        return view('Shipment.my-shipments-history', get_defined_vars());
    }

    public function my_shipments_overview($id)
    {
        // dd($id);
        $shipment = Shipment::find($id);
        return view('Shipment.my-shipments-overview', get_defined_vars());
    }
    public function my_shipments_bid_activity($id)
    {
        $shipment = Shipment::find($id);
        return view('Shipment.my-shipments-bid-activity', get_defined_vars());
    }
    public function my_shipments_tracking($id)
    {
         $shipment = Shipment::find($id);
        return view('Shipment.my-shipments-tracking', get_defined_vars());
    }
    function my_shipment_update_tracking($id,Request $request){
        $tracking = Tracking::where('id', $id)->where('shipment_id', $request->shipment_id)->first();
        if($tracking){

            $tracking->phone = $request->phone;
           $carrier =  User::where('email', $request->carrier_email)->first();

            if($carrier){
               $shipment =  Shipment::where('user_id', $carrier->id)->first();
               $shipment->trucker_id = $carrier->id;
               $shipment->status = "BOOKED";
               $shipment->save();
            }else{
                $shipment =  Shipment::where('id', $request->shipment_id)->first();
                $shipment->status = "BOOKED";
                $shipment->save();
            }
            
            
	    $ship_stat_tracking = ShipmentStatusTracking::where('shipment_id',$shipment->id)->where('status',"BOOKED")->first();
        if($ship_stat_tracking){
            $ship_stat_tracking->status = "BOOKED";
            $ship_stat_tracking->save();
        }else{
            $ship_stat_tracking = new ShipmentStatusTracking();
             $ship_stat_tracking->status = "BOOKED";
             $ship_stat_tracking->shipment_id = $shipment->id;
            $ship_stat_tracking->save();
        }
            $tracking->carrier_email = $request->carrier_email;
            $tracking->name = $request->name;
            $tracking->Shipment_name_id = $request->Shipment_name_id;
            $tracking->shipment_id = $request->shipment_id;
            $tracking->save();

        }
        // $tracking

        // "phone" => "45646"
        // "shipment_id" => "4"
        // "name" => "fasfas"
        // "carrier_email" => "roru@mailinator.com"
        // "Shipment_name_id" => "fsa"

        return back()->with('success','Updated Successfully changed');;
    }
    function my_shipments_requests_activity($id)
    {
        $shipment = Shipment::find($id);
        return view('Shipment.my-shipments-requests-activity', get_defined_vars());
    }

    function status_accept_decline($id, Request $request)
    {
        $data = array();
        if ($request->type == "bids") {
            $bid = Bid::find($id);
            $bid->status = $request->value;
            if ($request->value == 1) {
                $bid->shipment->status = 'BOOKED';
                $bid->shipment->booking_rate = $bid->amount;
                $bid->shipment->trucker_id = $bid->trucker_id;
                $bid->shipment->save();
                if($bid->shipment->is_tracking == 1){
                    $tracking =  Tracking::find($bid->shipment->tracking_id);
                    $tracking->name = $bid->carrier_user->name;
                    $tracking->phone = $bid->carrier_user->phone;
                    $tracking->carrier_email = $bid->carrier_user->email;
                    $tracking->Shipment_name_id = $bid->shipment->reference_id;
                    $tracking->save();

                }
                $bid->save();
                $bid = Bid::find($id);
                $data  = [
                    'title' => 'Shipment Bid Request Status',
                    'origin' => $bid->shipment->origin,
                    'destination' => $bid->shipment->destination,
                    'date' => Carbon::create($bid->created_at)->format('F j, Y'),
                    'bid_amount' => $bid->amount,
                    'carrier_name' => $bid->carrier_user ? $bid->carrier_user->name : '',
                    'equipment_type' => $bid->shipment->equipment_type ? $bid->shipment->equipment_type->name : '',
                    'shipment_no' => $bid->shipment->id,
                    'status' => $bid->status == "0" ? 'Decline' : 'Accepted',
                ];
                Mail::to('devjohnwick8@gmail.com')->send(new MyShipmentStatusMail($data));
                $users = User::where('id',$bid->trucker_id)->where('status',1)->get()->pluck('id')->toArray();
                if($users){
                    $send_notification = [];
                    $send_notification['user_id'] = $users;
                    $send_notification['title'] =  $bid->shipment->user->name ." Request Accepted";
                    $send_notification['body'] = "Bid Amount $".$bid->amount;
                    $send_notification['url'] = route('broker.my_shipments_bid_activity',[$bid->shipment->id]);
                    $send_notification['from_user_id'] = $bid->shipment->user->id;
                    $send_notification['to_user_id'] = Auth::id();
                    send_notification($send_notification);
                }
            }else{
                $bid->save();
                $bid = Bid::find($id);
                $data  = [
                    'title' => 'Shipment Bid Request Status',
                    'origin' => $bid->shipment->origin,
                    'destination' => $bid->shipment->destination,
                    'date' => Carbon::create($bid->created_at)->format('F j, Y'),
                    'bid_amount' => $bid->amount,
                    'carrier_name' => $bid->carrier_user ? $bid->carrier_user->name : '',
                    'equipment_type' => $bid->shipment->equipment_type ? $bid->shipment->equipment_type->name : '',
                    'shipment_no' => $bid->shipment->id,
                    'status' => $bid->status == "0" ? 'Decline' : 'Accepted',
                ];
                Mail::to('devjohnwick8@gmail.com')->send(new MyShipmentStatusMail($data));

                $users = User::where('id',$bid->trucker_id)->where('status',1)->get()->pluck('id')->toArray();

                if($users){
                    $send_notification = [];
                    $send_notification['user_id'] = $users;
                    $send_notification['title'] =  $bid->shipment->user->name ." Request Declined";
                    $send_notification['body'] = "Bid Amount $".$bid->amount;
                    $send_notification['url'] = route('broker.my_shipments_bid_activity',[$bid->shipment->id]);
                    $send_notification['from_user_id'] = $bid->shipment->user->id;
                    $send_notification['to_user_id'] = Auth::id();
                    send_notification($send_notification);
                }
            }
            // $bid->shipment->trucker_id
            return response()->json(['status' => 1 , 'message'=> strtoupper($request->type) . ' Successfully changed']);

        }
        elseif($request->type == "requests")
        {
            $ship_requests =  ShipmentsRequest::find($id);
            $ship_requests->status = $request->value;
            if ($request->value == 1) {
                $ship_requests->shipment->status = 'BOOKED';
                if ($ship_requests->type == 0) {
                    $price =  $ship_requests->shipment->private_rate;
                } else {
                    $price = $ship_requests->shipment->dat_rate;
                }
                $ship_requests->shipment->status = 'BOOKED';
                $ship_requests->shipment->booking_rate = $price;
                $ship_requests->shipment->trucker_id = $ship_requests->trucker_id;
                $ship_requests->shipment->save();

                if($ship_requests->shipment->is_tracking == 1){
                    $tracking =  Tracking::find($ship_requests->shipment->tracking_id);
                    $tracking->name = $ship_requests->carrier_user->name;
                    $tracking->phone = $ship_requests->carrier_user->phone;
                    $tracking->carrier_email = $ship_requests->carrier_user->email;
                    $tracking->Shipment_name_id = $ship_requests->shipment->reference_id;
                    $tracking->save();
                }
                $ship_requests->save();
                $ship_requests =  ShipmentsRequest::find($id);
                $data  = [
                    'title' => 'Shipment Request Status',
                    'origin' => $ship_requests->shipment->origin,
                    'destination' => $ship_requests->shipment->destination,
                    'date' => Carbon::create($ship_requests->created_at)->format('F j, Y'),
                    'bid_amount' => $ship_requests->amount,
                    'carrier_name' => $ship_requests->carrier_user ? $ship_requests->carrier_user->name : '',
                    'equipment_type' => $ship_requests->shipment->equipment_type ? $ship_requests->shipment->equipment_type->name : '',
                    'shipment_no' => $ship_requests->shipment->id,
                    'status' => $ship_requests->status == "0" ? 'Decline' : 'Accepted',
                ];


                    \Mail::to('devjohnwick8@gmail.com')->send(new MyShipmentStatusMail($data));

                    $users = User::where('id',$ship_requests->trucker_id)->where('status',1)->get()->pluck('id')->toArray();
                    if($users){
                        $send_notification = [];
                        $send_notification['user_id'] = $users;
                        $send_notification['title'] =  $ship_requests->shipment->user->name ." Request Accepted";
                        $send_notification['body'] = "Bid Amount $".$ship_requests->amount;
                        $send_notification['url'] = route('broker.my_shipments_requests_activity',[$ship_requests->shipment->id]);
                        $send_notification['from_user_id'] = $ship_requests->shipment->user->id;
                        $send_notification['to_user_id'] = Auth::id();
                        send_notification($send_notification);
                    }
                    return response()->json(['status' => 1 , 'message' => strtoupper($request->type) . ' Successfully changed']);
            }else{
                $ship_requests->save();
                $ship_requests =  ShipmentsRequest::find($id);
                $data  = [
                    'title' => 'Shipment Request Status',
                    'origin' => $ship_requests->shipment->origin,
                    'destination' => $ship_requests->shipment->destination,
                    'date' => Carbon::create($ship_requests->created_at)->format('F j, Y'),
                    'bid_amount' => $ship_requests->amount,
                    'carrier_name' => $ship_requests->carrier_user ? $ship_requests->carrier_user->name : '',
                    'equipment_type' => $ship_requests->shipment->equipment_type ? $ship_requests->shipment->equipment_type->name : '',
                    'shipment_no' => $ship_requests->shipment->id,
                    'status' => $ship_requests->status == "0" ? 'Decline' : 'Accepted',
                ];
                    \Mail::to('devjohnwick8@gmail.com')->send(new MyShipmentStatusMail($data));

                    $users = User::where('id',$ship_requests->trucker_id)->where('status',1)->get()->pluck('id')->toArray();

                    if($users){
                        $send_notification = [];
                        $send_notification['user_id'] = $users;
                        $send_notification['title'] =  $ship_requests->shipment->user->name ." Request Rejected";
                        $send_notification['body'] = "Bid Amount $".$ship_requests->amount;
                        $send_notification['url'] = route('broker.my_shipments_requests_activity',[$ship_requests->shipment->id]);
                        $send_notification['from_user_id'] = $ship_requests->shipment->user->id;
                        $send_notification['to_user_id'] = Auth::id();
                        send_notification($send_notification);
                    }

                    return response()->json(['status' => 1 , 'message' => strtoupper($request->type) . ' Successfully changed']);


            }



            //  return back()->with('success', strtoupper($request->type) . ' Successfully changed');
        }
        else
        {
            $shipment =  Shipment::find($id);
            $shipment->status = $request->value;
            $shipment->save();

            // return back()->with('success', strtoupper($request->type) . ' Successfully changed');
            return response()->json(['status' => 1 , 'message' => strtoupper($request->type) . ' Successfully changed']);

        }
    }
}
