<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\MyShipmentInvoice;
use App\Models\Bid;
use App\Models\Company;
use App\Models\Shipment;
use App\Models\ShipmentInvoice;
use App\Models\ShipmentsRequest;
use App\Models\ShipmentStatusTracking;
use App\Models\Tracking;
use App\Models\TrackingDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use DB;
use Yajra\DataTables\Facades\DataTables;

class MyLoadsController extends Controller
{
     public function __construct()
     {
          $this->middleware('auth');
     }

     public function myLoads(Request $request)
     {

          $data = Shipment::where('trucker_id', auth()->user()->id)->orderBy('created_at', 'DESC')->first();
          $now = Carbon::now()->format('Y-m-d');


          $shipment_active_count = Shipment::where('trucker_id', auth()->user()->id)->where(function ($q) {
               $q->where('is_post', 1)->WhereNotIn('status', ['EXPIRED','BOOKED','WAITING','COMPLETE', 'CANCELED']);
          })->orderBy('id', 'DESC')->where('trucker_id', auth()->user()->id)
               ->count();

          $shipment_history_count = Shipment::select("*")->where('trucker_id', auth()->user()->id)->orderBy('created_at', 'DESC')
               ->WhereIn('status', ['COMPLETE', 'CANCELED'])
               ->count();


          $s_req = ShipmentsRequest::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();
          $s_bid = Bid::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();

          $ids = [];
          if (count($s_req) > 0) {
               $ids = array_unique($s_req);
          }

          if (count($s_bid) > 0) {
               $ids = array_unique($s_bid);
          }

          if (count($s_req) > 0 && count($s_bid) > 0) {
               $ids = array_unique(array_merge($s_req, $s_bid));
          }
          // dd($ids, Auth::id());
          $shipment_open = Shipment::select('id')->where('trucker_id', Auth::id())
               ->where(function ($q) {
                    $q->where('is_post', 1)->WhereIn('status', ['BOOKED']);
               })
               ->orWhereIN('id', $ids)
               ->where(function ($q) {
                    $q->where('is_post', 1)->WhereIn('status', ['WAITING']);
               })->orderBy('id', 'DESC')->where('user_id', '!=', Auth::id());


               $shipment_open_count = $shipment_open->count();   
              $ship_ids = $shipment_open->pluck('id')->toArray();

               
              


          if ($request->ajax()) {
               $data = Shipment::whereIn('id', $ship_ids)->orderBy('created_at','DESC');
               return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('age', function ($row) {
                         if ($row->status == "WAITING") {
                              return $row->created_at->diffForHumans();
                         } else {
                              return $row->updated_at->diffForHumans();
                         }
                    })
                     ->addColumn('broker', function ($row) {
                         $user = User::whereHas('company')->where('id', $row->user->id)->first();
                         if ($user != null) {
                              $broker = '<a href="' . route('' . auth()->user()->type . '.broker_details', $row->user_id) . '">' . $row->user->name . '</a>';
                         } else {
                              $broker = $row->user->name;
                         }
                         return $broker;
                    })
                    ->addColumn('available', function ($row) {
                         $r = Carbon::create($row->from_date)->format('m/d');
                         $r .= $row->to_date != null ? ' - ' . Carbon::create($row->to_date)->format('m/d') : '';
                         return $r;
                    })
                    ->addColumn('equipment', function ($row) {
                         return $row->equipment_type ? $row->equipment_type->name : 'None';
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
                    ->addColumn('rate', function ($row) {
                         if($row->status == "BOOKED"){
                              $rate = $row->booking_rate;
                         }else{

                              $s_req = ShipmentsRequest::where('shipment_id', $row->id)
                              ->where('trucker_id',auth()->user()->id)->latest()->first();
                              $s_bid = Bid::where('shipment_id', $row->id)
                              ->where('trucker_id',auth()->user()->id)
                              ->latest()->first();
                              
                              if($s_bid != null){
                                   $rate = $s_bid->amount;
     
                              }else{
                                   $rate = $s_req->amount;
                              }

                         } 
                         return $rate;
                    })
                    ->filter(function ($instance) use ($request) {
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

                         $instance->where(function ($q) use ($request) {
                              // dd($request->get('posted') , $request->get('booked') , $request->get('expired'),$request->get('with_bids') );
                              if ($request->get('requested') === "true"){                                   
                                   $q->where('status', 'WAITING');
                              }
                              if ($request->get('booked') === "true") {
                                   
                                   $q->orWhere('status', 'BOOKED');
                              }
                         });

                         
                    })

                    ->addColumn('status', function ($row) {

                         $s  = $row->status == "WAITING" ? "REQUESTED" : "BOOKED";
                         return $s;
                    })
                    // ->addColumn('ship_requests', function ($row) {
                    //     return '<a href="' . route(auth()->user()->type . ".my_loads_requests_activity", [$row->id]) . '"> ' . count($row->shimpents_requests) . ' Requests </a>';
                    // })
                    ->addColumn('action', function ($row) {
                         $btn = '<div class="d-flex btnWrap"><a class="fa fa-eye btn btn-outline-success" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile=""></a>';
                         if ($row->status == "BOOKED" && $row->trucker_id == null) {
                              $btn .= '<a class="btn btn-danger" href="javascript:;" onclick="status_accept_decline(`shipment`,' . $row->id . ',`CANCELED`)" title="">Canceled</a>';
                              $btn .= '<a class="btn btn-success" href="javascript:;" onclick="status_accept_decline(`shipment`,' . $row->id . ',`COMPLETE`)" title="">Complete</a>';
                         }
                         // if ($row->status == "WAITING") {
                         //     $btn .= '<a class="fa fa-pencil btn btn-outline-primary" href="' . route(auth()->user()->type . ".edit_a_shipment", [$row->id]) . '" tile=""></a>';
                         //     $btn .= '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route(auth()->user()->type . ".delete_a_shipment", [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a></div>';
                         // }
                         return $btn;
                    })
                    ->rawColumns(['age', 'broker', 'available', 'bids', 'equipment_detail', 'equipment', 'rate', 'action', 'status'])
                    ->make(true);
          }

          return view('Loads.my-loads', get_defined_vars());
     }
     public function my_loads_active(Request $request)
     {
         

          $s_req = ShipmentsRequest::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();
          $s_bid = Bid::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();

          $ids = [];
          if (count($s_req) > 0) {
               $ids = array_unique($s_req);
          }

          if (count($s_bid) > 0) {
               $ids = array_unique($s_bid);
          }

          if (count($s_req) > 0 && count($s_bid) > 0) {
               $ids = array_unique(array_merge($s_req, $s_bid));
          }
          // dd($ids, Auth::id());
          $shipment_open_count = Shipment::where('trucker_id', Auth::id())
               ->where(function ($q) {
                    $q->where('is_post', 1)->WhereIn('status', ['BOOKED']);
               })
               ->orWhereIN('id', $ids)
               ->where(function ($q) {
                    $q->where('is_post', 1)->WhereIn('status', ['WAITING']);
               })->orderBy('id', 'DESC')->where('user_id', '!=', Auth::id())->count();


          $shipment_active_count = Shipment::where('trucker_id', auth()->user()->id)->where(function ($q) {
               $q->where('is_post', 1)->WhereNotIn('status', ['EXPIRED','BOOKED','WAITING','COMPLETE', 'CANCELED']);
          })->orderBy('id', 'DESC')->where('trucker_id', auth()->user()->id)
               ->count();

          $shipment_history_count = Shipment::select("*")->where('trucker_id', auth()->user()->id)->orderBy('created_at', 'DESC')
               ->WhereIn('status', ['COMPLETE', 'CANCELED'])
               ->count();
               
            $PickCount = TrackingDetail::select('tracking_id', DB::raw('COUNT(*) as type_0_count'))
                ->where('type', 0)
                ->whereHas('trackings', function($qe){
                        $qe->whereHas('shipments', function($q){
                            $q->where('trucker_id' ,auth()->user()->id)->WhereNotIn('status', ['WAITING', 'BOOKED', 'EXPIRED', 'COMPLETE', 'CANCELED']);
                        });
                })
                ->groupBy('tracking_id')  // Group by tracking_id
                ->orderByDesc('type_0_count')  // Order by the highest count
                ->first();
                
                
            $DropCount = TrackingDetail::select('tracking_id', DB::raw('COUNT(*) as type_1_count'))
                ->where('type', 1)
                ->whereHas('trackings', function($qe){
                         $qe->whereHas('shipments', function($q){
                            $q->where('trucker_id' ,auth()->user()->id)->WhereNotIn('status', ['WAITING', 'BOOKED', 'EXPIRED', 'COMPLETE', 'CANCELED']);
                        });
                })
                ->groupBy('tracking_id') 
                ->orderByDesc('type_1_count')
                ->first();
          
          if ($request->ajax()) {
               $data = Shipment::where('trucker_id', auth()->user()->id)->where(function ($q) {
                    $q->where('is_post', 1)->WhereNotIn('status', ['EXPIRED','BOOKED','WAITING','COMPLETE', 'CANCELED']);
               })->orderBy('created_at','DESC')->where('trucker_id', auth()->user()->id);

               return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('age', function ($row) {
                         return $row->updated_at->diffForHumans();
                    })
                    ->addColumn('available', function ($row) {
                         $r = Carbon::create($row->from_date)->format('m/d');
                         $r .= $row->to_date != null ? ' - ' . Carbon::create($row->to_date)->format('m/d') : '';
                         return $r;
                    })

                    ->addColumn('broker', function ($row) {
                         $user = User::whereHas('company')->where('id', $row->user->id)->first();
                         if ($user != null) {
                              $broker = '<a href="' . route('' . auth()->user()->type . '.broker_details', $row->user_id) . '">' . $row->user->name . '</a>';
                         } else {
                              $broker = $row->user->name;
                         }
                         return $broker;
                    })
                    ->addColumn('equipment', function ($row) {
                         return $row->equipment_type ? $row->equipment_type->name : 'None';
                    })
                    ->addColumn('status', function ($row) {
                         return $row->status;
                    })

                    ->addColumn('rate', function ($row) {
                         return $row->booking_rate;
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
                         $btn = '';
                         // if($row->status == "AT-PICK-UP"){
                         //      $btn .= '<a class="fa fa-eye btn btn-outline-primary" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile="">Dispatched</a>';
                         // }else if($row->status == "DISPATCHED"){
                         //      $btn .= '<a class="fa fa-eye btn btn-outline-primary" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile="">In Transit</a>';
                         // }else if($row->status == "DISPATCHED"){
                         //      $btn .= '<a class="fa fa-eye btn btn-outline-primary" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile="">In Transit</a>';
                         // }else if($row->status == "IN-TRANSIT"){
                         //      $btn .= '<a class="fa fa-eye btn btn-outline-primary" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile="">AT DROP OFF</a>';
                         // }
                         // else if($row->status == "AT-DROP-OFF"){
                         //      $btn .= '<a class="fa fa-eye btn btn-outline-primary" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile="">DELIVERED</a>';
                         // }
                         $btn .= '<a class="fa fa-eye btn btn-outline-primary" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile=""></a>';

                         return $btn;
                    })
                      ->filter(function ($instance) use ($request, $PickCount, $DropCount) {
                        $instance->where(function ($q) use ($request, $PickCount, $DropCount ) {
                            if($PickCount){
                                for($i = 1; $i <= $PickCount->type_0_count; $i++)
                                {
                                    if($request->get('PICK-UP-'.$i) == "true") {
                                        $st = $i == 1 ? 'AT-PICK-UP' : 'PICK-UP-'.$i;
                                        $q->orWhere('status', $st);
                                    }
                                }
                            }else{
                                if ($request->get('at_pick_up') == "true") {
                                    $q->orWhere('status', 'AT-PICK-UP');
                                }
                            }
                            if ($request->get('dispatched') == "true") {
                                $q->orWhere('status', 'DISPATCHED');
                            }
                            if ($request->get('in_transit') == "true") {
                                $q->orWhere('status', 'IN-TRANSIT');
                            }
                            if($DropCount){
                                for($i = 1; $i <= $DropCount->type_1_count; $i++)
                                {
                                    if($request->get('DROP-OFF-'.$i) == "true") {
                                        $st = $i == 1 ? 'AT-DROP-OFF' : 'DROP-OFF-'.$i;
                                        $q->orWhere('status', $st);
                                    }
                                }
                            }else{
                                if ($request->get('at_drop_off') == "true") {
                                    $q->orWhere('status', 'AT-DROP-OFF');
                                }
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
                    ->rawColumns(['age', 'available', 'status', 'equipment_detail', 'rate', 'equipment', 'broker', 'action'])
                    ->make(true);
          }

          return view('Loads.my-loads-active', get_defined_vars());
     }


     public function my_loads_history(Request $request)
     {
          // WhereIn('status', ['COMPLETE','CANCELED'])
          $s_req = ShipmentsRequest::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();
          $s_bid = Bid::where('trucker_id', Auth::id())->where('status', null)->pluck('shipment_id')->ToArray();

          $ids = [];
          if (count($s_req) > 0) {
               $ids = array_unique($s_req);
          }

          if (count($s_bid) > 0) {
               $ids = array_unique($s_bid);
          }

          if (count($s_req) > 0 && count($s_bid) > 0) {
               $ids = array_unique(array_merge($s_req, $s_bid));
          }
          // dd($ids, Auth::id());
          $shipment_open_count = Shipment::where('trucker_id', Auth::id())
               ->where(function ($q) {
                    $q->where('is_post', 1)->WhereIn('status', ['BOOKED']);
               })
               ->orWhereIN('id', $ids)
               ->where(function ($q) {
                    $q->where('is_post', 1)->WhereIn('status', ['WAITING']);
               })->orderBy('id', 'DESC')->where('user_id', '!=', Auth::id())->count();

          $shipment_active_count = Shipment::where('trucker_id', auth()->user()->id)->where('is_post', 1)->whereNotIn('status', ['WAITING', 'BOOKED', 'COMPLETE', 'CANCELED', 'EXPIRED'])->count();
          $shipment_history_count = Shipment::where('trucker_id', auth()->user()->id)->where('is_post', 1)->whereIn('status', ['COMPLETE', 'CANCELED'])->count();

          if ($request->ajax()) {
               $data = Shipment::select("*")->where('trucker_id', auth()->user()->id)->orderBy('created_at', 'DESC')
                    ->WhereIn('status', ['COMPLETE', 'CANCELED']);
               return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('age', function ($row) {
                         return $row->updated_at->diffForHumans();
                    })
                    ->addColumn('available', function ($row) {
                         $r = Carbon::create($row->from_date)->format('m/d');
                         $r .= $row->to_date != null ? ' - ' . Carbon::create($row->to_date)->format('m/d') : '';
                         return $r;
                    })

                    ->addColumn('broker', function ($row) {
                         $user = User::whereHas('company')->where('id', $row->user->id)->first();
                         if ($user != null) {
                              $broker = '<a href="' . route('' . auth()->user()->type . '.broker_details', $row->user_id) . '">' . $row->user->name . '</a>';
                         } else {
                              $broker = $row->user->name;
                         }
                         return $broker;
                    })
                    ->addColumn('equipment', function ($row) {
                         return $row->equipment_type ? $row->equipment_type->name : 'None';
                    })
                    ->addColumn('status', function ($row) {
                         return $row->status;
                    })

                    ->addColumn('rate', function ($row) {
                         return $row->booking_rate;
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
                         $btn = '<a class="fa fa-eye btn btn-outline-primary" href="' . route(auth()->user()->type . ".my_loads_overview", [$row->id]) . '" tile=""></a>';

                         return $btn;
                    })
                    ->filter(function ($instance) use ($request) {
                         $instance->where(function ($q) use ($request) {
                              // dd($request->all());
                              if ($request->get('canceled') == "true") {
                                   $q->orWhere('status', 'CANCELED');
                              }

                              if ($request->get('completed') == "true") {
                                   // dd($q->orWhere('status', 'COMPLETED')->get());
                                   $q->orWhere('status', 'COMPLETE');
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
                    ->rawColumns(['age', 'available', 'status', 'equipment_detail', 'rate', 'equipment', 'broker', 'action'])
                    ->make(true);
          }

          return view('Loads.my-loads-history', get_defined_vars());
     }

     public function my_loads_overview($id)
     {

          $shipment = Shipment::find($id);
          if (!$shipment) {
               abort(404);
          }
          $carrier = User::with('company')->where('id', $shipment->trucker_id)->first();
          // dd($shipment);
          return view('Loads.my-loads-overview', get_defined_vars());
     }
     public function my_loads_bid_activity($id)
     {
          $shipment = Shipment::find($id);
          if (!$shipment) {
               abort(404);
          }
          return view('Loads.my-loads-bid-activity', get_defined_vars());
     }
     public function my_loads_tracking($id)
     {
          $shipment = Shipment::find($id);
          if (!$shipment) {
               abort(404);
          }
          return view('Loads.my-loads-tracking', get_defined_vars());
     }
     public function my_loads_update_tracking($id, Request $request)
     {
          $tracking = Tracking::where('id', $id)->where('shipment_id', $request->shipment_id)->first();
          if ($tracking) {
               $tracking->phone = $request->phone;
               $carrier = User::where('email', $request->carrier_email)->first();
               if ($carrier) {
                    $shipment = Shipment::where('id', $request->shipment_id)->first();
                    $shipment->trucker_id = $carrier->id;
                    $shipment->status = "BOOKED";
                    $shipment->booking_rate = $shipment->private_rate;
                    $tracking->carrier_email = $request->carrier_email;
                    $tracking->name = $request->name;
                    $tracking->Shipment_name_id = $request->Shipment_name_id;
                    $tracking->shipment_id = $request->shipment_id;
                    $tracking->tracking_status = "ACCEPTED";
                    $tracking->save();
                    $shipment->save();

                    $shipment_invoice = ShipmentInvoice::create([
                         'invoice_no' => $randomNumber = mt_rand(10000000, 99999999),
                         'trucker_id' => $carrier->id,
                         'shipment_id' => $shipment->id,
                         'user_id' => auth()->user()->id,
                         'price' => $shipment->private_rate,
                    ]);

                    $data1 = shipment_invoice_format($shipment_invoice);
                    if($carrier->parent_id != null){
                            $company = Company::where('user_id',$carrier->parent_id)->first();
                        }else{
                            $company = Company::where('user_id', $carrier->id)->first();
                        }
                    Mail::to($company->email)->send(new MyShipmentInvoice($data1));

                    // ;
                    $data1['is_trucker'] = 1;
                    Mail::to($carrier->email)->send(new MyShipmentInvoice($data1));

                    $ship_stat_tracking = ShipmentStatusTracking::where('shipment_id', $shipment->id)->where('status', "BOOKED")->first();
                    if ($ship_stat_tracking) {
                         $ship_stat_tracking->status = "BOOKED";
                         $ship_stat_tracking->save();
                    } else {
                         $ship_stat_tracking = new ShipmentStatusTracking();
                         $ship_stat_tracking->status = "BOOKED";
                         $ship_stat_tracking->shipment_id = $shipment->id;
                         $ship_stat_tracking->save();
                    }
               } else {
                    return back()->with('swalerror', 'User Not Found');
               }
          }
          // $tracking

          // "phone" => "45646"
          // "shipment_id" => "4"
          // "name" => "fasfas"
          // "carrier_email" => "roru@mailinator.com"
          // "Shipment_name_id" => "fsa"

          return back()->with('success', 'Updated Successfully changed');
     }

     public function my_loads_requests_activity($id)
     {
          $shipment = Shipment::find($id);
          if (!$shipment) {
               abort(404);
          }
          return view('Loads.my-loads-requests-activity', get_defined_vars());
     }

     public function my_loads_status_tracking($id)
     {

          $shipment_status = ShipmentStatusTracking::where('shipment_id', $id)->OrderBy('id', 'Asc')->get();
          return view('Loads.my-loads-status-tracking', get_defined_vars());
     }

     public function status_accept_decline($id, Request $request)
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
                    $ship_stat_tracking = ShipmentStatusTracking::where('shipment_id', $bid->shipment->id)->where('status', "BOOKED")->first();
                    if ($ship_stat_tracking) {
                         $ship_stat_tracking->status = "BOOKED";
                         $ship_stat_tracking->save();
                    } else {
                         $ship_stat_tracking = new ShipmentStatusTracking();
                         $ship_stat_tracking->status = "BOOKED";
                         $ship_stat_tracking->shipment_id = $bid->shipment->id;
                         $ship_stat_tracking->save();
                    }
                    $shipment_invoice = ShipmentInvoice::create([
                         'invoice_no' => $randomNumber = mt_rand(10000000, 99999999),
                         'trucker_id' => $bid->trucker_id,
                         'shipment_id' => $bid->shipment->id,
                         'user_id' => auth()->user()->id,
                         'price' => $bid->amount,
                    ]);
                    $data1 = shipment_invoice_format($shipment_invoice);
                    $carrier = User::find($bid->trucker_id);
                     if($carrier->parent_id != null){
                        $company = Company::where('user_id',$carrier->parent_id)->first();
                    }else{
                        $company = Company::where('user_id', $carrier->id)->first();
                    }
                    Mail::to($company->email)->send(new MyShipmentInvoice($data1));

                    // ;
                    $data1['is_trucker'] = 1;
                    Mail::to($carrier->email)->send(new MyShipmentInvoice($data1));

                    if ($bid->shipment->is_tracking == 1) {
                         $tracking = Tracking::find($bid->shipment->tracking_id);
                         $tracking->name = $bid->carrier_user->name;
                         $tracking->phone = $bid->carrier_user->phone;
                         $tracking->carrier_email = $bid->carrier_user->email;
                         $tracking->Shipment_name_id = $bid->shipment->reference_id;
                         $tracking->user_id = auth()->user()->id;
                         $tracking->tracking_status = "ACCEPTED";
                         $tracking->save();
                    }
                    $bid->save();
                    $bid = Bid::find($id);
                    $data = [
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

                    // Mail::to($carrier->email)->send(new MyShipmentStatusMail($data));
                    $users = User::where('id', $bid->trucker_id)->where('status', 1)->get()->pluck('id')->toArray();
                    if ($users) {
                         $send_notification = [];
                         $send_notification['user_id'] = $users;
                         $send_notification['title'] = $bid->shipment->user->name . " Request Accepted";
                         $send_notification['body'] = "Bid Amount $" . $bid->amount;
                         $send_notification['url'] = '/my-loads-bid-activity/' . $bid->shipment->id;
                         $send_notification['from_user_id'] = $bid->shipment->user->id;
                         $send_notification['to_user_id'] = Auth::id();
                         $send_notification['type_id'] = $bid->shipment->id;
                         $send_notification['type'] = "Shipment";
                         send_notification($send_notification);
                    }
               } else {
                    $bid->save();
                    $bid = Bid::find($id);
                    $data = [
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
                    // Mail::to('devjohnwick8@gmail.com')->send(new MyShipmentStatusMail($data));

                    $users = User::where('id', $bid->trucker_id)->where('status', 1)->get()->pluck('id')->toArray();
                    if ($users) {
                         $send_notification = [];
                         $send_notification['user_id'] = $users;
                         $send_notification['title'] = $bid->shipment->user->name . " Request Declined";
                         $send_notification['body'] = "Bid Amount $" . $bid->amount;
                         $send_notification['url'] = '/my-loads-bid-activity/' . $bid->shipment->id;
                         $send_notification['from_user_id'] = $bid->shipment->user->id;
                         $send_notification['to_user_id'] = Auth::id();
                         $send_notification['type_id'] = $bid->shipment->id;
                         $send_notification['type'] = "Shipment";
                         send_notification($send_notification);
                    }
               }
               // $bid->shipment->trucker_id
               return response()->json(['status' => 1, 'message' => strtoupper($request->type) . ' Successfully changed']);
          } elseif ($request->type == "requests") {

               $ship_requests = ShipmentsRequest::find($id);
               $ship_requests->status = $request->value;
               if ($request->value == 1) {
                    if ($ship_requests->type == 0) {
                         $price = $ship_requests->shipment->private_rate;
                    } else {
                         $price = $ship_requests->shipment->dat_rate;
                    }
                    $ship_requests->shipment->status = 'BOOKED';
                    $ship_requests->shipment->booking_rate = $price;
                    $ship_requests->shipment->trucker_id = $ship_requests->trucker_id;
                    $ship_requests->shipment->save();

                    $ship_stat_tracking = ShipmentStatusTracking::where('shipment_id', $ship_requests->shipment->id)->where('status', "BOOKED")->first();
                    if ($ship_stat_tracking) {
                         $ship_stat_tracking->status = "BOOKED";
                         $ship_stat_tracking->save();
                    } else {
                         $ship_stat_tracking = new ShipmentStatusTracking();
                         $ship_stat_tracking->status = "BOOKED";
                         $ship_stat_tracking->shipment_id = $ship_requests->shipment->id;
                         $ship_stat_tracking->save();
                    }
                    $shipment_invoice = ShipmentInvoice::create([
                         'invoice_no' => $randomNumber = mt_rand(10000000, 99999999),
                         'trucker_id' => $ship_requests->trucker_id,
                         'shipment_id' => $ship_requests->shipment->id,
                         'user_id' => auth()->user()->id,
                         'price' => $price,
                    ]);
                    $data1 = shipment_invoice_format($shipment_invoice);
                    $carrier = User::find($ship_requests->trucker_id);
                    if($carrier->parent_id != null){
                            $company = Company::where('user_id',$carrier->parent_id)->first();
                        }else{
                            $company = Company::where('user_id', $carrier->id)->first();
                        }
                    Mail::to($company->email)->send(new MyShipmentInvoice($data1));

                    // ;
                    $data1['is_trucker'] = 1;
                    Mail::to($carrier->email)->send(new MyShipmentInvoice($data1));

                    if ($ship_requests->shipment->is_tracking == 1) {
                         $tracking = Tracking::find($ship_requests->shipment->tracking_id);
                         $tracking->name = $ship_requests->carrier_user->name;
                         $tracking->phone = $ship_requests->carrier_user->phone;
                         $tracking->carrier_email = $ship_requests->carrier_user->email;
                         $tracking->Shipment_name_id = $ship_requests->shipment->reference_id;
                         $tracking->user_id = auth()->user()->id;
                         $tracking->tracking_status = "ACCEPTED";
                         $tracking->save();
                    }
                    $ship_requests->save();
                    $ship_requests = ShipmentsRequest::find($id);
                    $data = [
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

                    // \Mail::to($carrier->email)->send(new MyShipmentStatusMail($data));

                    $users = User::where('id', $ship_requests->trucker_id)->where('status', 1)->get()->pluck('id')->toArray();
                    if ($users) {
                         $send_notification = [];
                         $send_notification['user_id'] = $users;
                         $send_notification['title'] = $ship_requests->shipment->user->name . " Request Accepted";
                         $send_notification['body'] = "Bid Amount $" . $ship_requests->amount;
                         $send_notification['url'] = '/my-loads-requests-activity/' . $ship_requests->shipment->id;
                         $send_notification['from_user_id'] = $ship_requests->shipment->user->id;
                         $send_notification['to_user_id'] = Auth::id();
                         $send_notification['type_id'] = $ship_requests->shipment->id;
                         $send_notification['type'] = "Shipment";
                         send_notification($send_notification);
                    }
                    return response()->json(['status' => 1, 'message' => strtoupper($request->type) . ' Successfully changed']);
               } else {
                    $ship_requests->save();
                    $ship_requests = ShipmentsRequest::find($id);
                    $data = [
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
                    // \Mail::to('devjohnwick8@gmail.com')->send(new MyShipmentStatusMail($data));

                    $users = User::where('id', $ship_requests->trucker_id)->where('status', 1)->get()->pluck('id')->toArray();

                    if ($users) {
                         $send_notification = [];
                         $send_notification['user_id'] = $users;
                         $send_notification['title'] = $ship_requests->shipment->user->name . " Request Rejected";
                         $send_notification['body'] = "Bid Amount $" . $ship_requests->amount;
                         $send_notification['url'] = '/my-loads-requests-activity/' . $ship_requests->shipment->id;
                         $send_notification['from_user_id'] = $ship_requests->shipment->user->id;
                         $send_notification['to_user_id'] = Auth::id();
                         $send_notification['type_id'] = $ship_requests->shipment->id;
                         $send_notification['type'] = "Shipment";
                         send_notification($send_notification);
                    }

                    return response()->json(['status' => 1, 'message' => strtoupper($request->type) . ' Successfully changed']);
               }

               //  return back()->with('success', strtoupper($request->type) . ' Successfully changed');
          } else {
               $shipment = Shipment::find($id);
               $shipment->status = strtoupper($request->value);
               $shipment->save();

               $ship_stat_tracking = ShipmentStatusTracking::where('shipment_id', $shipment->id)->where('status', strtoupper($request->value))->first();
               if ($ship_stat_tracking) {
                    $ship_stat_tracking->status = strtoupper($request->value);
                    $ship_stat_tracking->save();
               } else {
                    $ship_stat_tracking = new ShipmentStatusTracking();
                    $ship_stat_tracking->status = strtoupper($request->value);
                    $ship_stat_tracking->shipment_id = $shipment->id;
                    $ship_stat_tracking->save();
               }

               $users = User::where('id', $shipment->trucker_id)->where('status', 1)->get()->pluck('id')->toArray();

               if ($users) {
                    $send_notification = [];
                    $send_notification['user_id'] = $users;
                    $send_notification['title'] = $shipment->user->name . " Marked as Completed";
                    $send_notification['body'] = "The Shipment Status has been COMPLETED";
                    $send_notification['url'] = '/my-loads-overview/' . $shipment->id;
                    $send_notification['from_user_id'] = $shipment->user->id;
                    $send_notification['to_user_id'] = $shipment->trucker_id;
                    $send_notification['type_id'] = $shipment->id;
                    $send_notification['type'] = "Shipment";
                    send_notification($send_notification);
               }
               // return back()->with('success', strtoupper($request->type) . ' Successfully changed');
               return response()->json(['status' => 1, 'message' => strtoupper($request->type) . ' Successfully changed']);
          }
     }

     public function carrierDetail($id)
     {
          $user = User::with('company')->where('id', $id)->first();
          // dd($user);
          return view('Shipment.carrier-detail', get_defined_vars());
     }
}
