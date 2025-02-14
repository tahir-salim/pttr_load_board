<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminShipmentController extends Controller
{
    public function shipmentsList(Request $request)
    {
        if ($request->ajax()) {

            $data = Shipment::select("*")->orderBy('created_at', 'DESC');
            // dd($request->all());
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->addIndexColumn()
            // 1. WAITING 2. BOOKED 3. WITH BIDS 4. PENDING 5. ACCEPTED 6. DISPATCHED 7. AT PICK UP 8. AT DROP OFF 9. IN TRANSIT 10. DELIVERED 11. DECLINED 12. COMPLETE 13. CANCELED
                ->addColumn('shipment_status', function ($row) {
                   
                    if (strtoupper($row->status) == 'WAITING') {
                        return '<span class="badge badge-warning">PENDING</span>';
                    }
                    elseif (strtoupper($row->status) == 'BOOKED') {
                        return '<span class="badge badge-dark">BOOKED</span>';
                    } 
                    elseif (strtoupper($row->status) == 'AT-PICK-UP') {
                        return '<span class="badge badge-primary">AT PICK UP</span>';
                    } 
                    elseif (strtoupper($row->status) == 'AT DROP OFF') {
                        return '<span class="badge badge-success">AT DROP OFF</span>';
                    }
                     elseif (strtoupper($row->status) == 'IN-TRANSIT') {
                        return '<span class="badge badge-secondary">IN TRANSIT</span>';
                    }
                     elseif (strtoupper($row->status) == 'DISPATCHED') {
                        return '<span class="badge badge-info">DISPATCHED</span>';
                    }
                     elseif (strtoupper($row->status) == 'DELIVERED') {
                        return '<span class="badge badge-light">DELIVERED</span>';
                    }
                    elseif (strtoupper($row->status) == 'COMPLETE') {
                        return '<span class="badge badge-dark">COMPLETE</span>';
                    }
                    elseif (strtoupper($row->status) == 'CANCELED') {
                        return '<span class="badge badge-danger">CANCELED</span>';
                    }
                    elseif (strtoupper($row->status) == 'EXPIRED') {
                        return '<span class="badge badge-danger">EXPIRED</span>';
                    }
                     else {
                        return strtoupper($row->status);
                    }
                })->filter(function ($instance) use ($request) {
                // dd(strtolower($request->shipment_status) );
                if (strtoupper($request->get('shipment_status')) == 'WAITING'
                    || strtoupper($request->get('shipment_status')) == 'BOOKED'
                    || strtoupper($request->get('shipment_status')) == 'AT-PICK-UP'
                    || strtoupper($request->get('shipment_status')) == 'PICK-UP-2'
                    || strtoupper($request->get('shipment_status')) == 'PICK-UP-3'
                    || strtoupper($request->get('shipment_status')) == 'PICK-UP-4'
                    || strtoupper($request->get('shipment_status')) == 'AT-DROP-OFF'
                    || strtoupper($request->get('shipment_status')) == 'DROP-OFF-2'
                    || strtoupper($request->get('shipment_status')) == 'DROP-OFF-3'
                    || strtoupper($request->get('shipment_status')) == 'DROP-OFF-4'
                    || strtoupper($request->get('shipment_status')) == 'DISPATCHED'
                    || strtoupper($request->get('shipment_status')) == 'IN-TRANSIT'
                    || strtoupper($request->get('shipment_status')) == 'DELIVERED'
                    || strtoupper($request->get('shipment_status')) == 'COMPLETE'
                    || strtoupper($request->get('shipment_status')) == 'EXPIRED'
                    || strtoupper($request->get('shipment_status')) == 'CANCELED') {
                    $instance->where('status', strtoupper($request->get('shipment_status')));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('id', 'LIKE', "%$search%")
                            ->orWhere('origin', 'LIKE', "%$search%")
                            ->orWhere('destination', 'LIKE', "%$search%")
                            ->orWhere('from_date', 'LIKE', "%$search%")
                            ->orWhere('to_date', 'LIKE', "%$search%")
                            ->orWhere('length', 'LIKE', "%$search%")
                            ->orWhere('weight', 'LIKE', "%$search%");
                    });
                }
            })
                ->addColumn('user_name', function ($row) {
                    // dd($row);
                    return $row->user ? $row->user->name : '';
                })
                ->addColumn('from_to_date', function ($row) {
                    return $row->from_date . ' / ' . $row->to_date;
                })
                ->addColumn('from_to_time', function ($row) {
                    return $row->from_time . ' / ' . $row->to_time;
                })
                ->addColumn('equipment_detail', function ($row) {
                    if ($row->equipment_detail == "0") {
                        return '<span class="badge badge-primary">Full</span>';
                    } elseif ($row->equipment_detail == "1") {
                        return '<span class="badge badge-warning">Partial</span>';
                    } else {
                        return '<span class="badge badge-success">Both</span>';
                    }
                })
                ->addColumn('is_post', function ($row) {
                    if ($row->is_post == 1) {
                        // dd('hello');
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">In-Active</span>';
                    }
                })->rawColumns(['shipment_status', 'user_name', 'equipment_detail', 'is_post', 'from_to_date', 'from_to_time'])
                ->make(true);
                 
        }
        
          
        return view('Admin.shipments-list', get_defined_vars());
    }
}
