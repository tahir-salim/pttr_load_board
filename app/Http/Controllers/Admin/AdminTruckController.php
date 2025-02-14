<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\TruckPost;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminTruckController extends Controller
{
    public function trucksList(Request $request)
    {
        if ($request->ajax()) {

            $data = TruckPost::select("*")->orderBy('created_at', 'DESC');
            // dd($request->all());
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->addIndexColumn()
                ->addColumn('truck_status', function ($row) {
                    if (strtolower($row->truck_status) == 'available') {
                        return '<span class="badge badge-primary">Available</span>';
                    } elseif (strtolower($row->truck_status) == 'pending') {
                        return '<span class="badge badge-warning">Pending</span>';
                    } elseif (strtolower($row->truck_status) == 'pickup') {
                        return '<span class="badge badge-success">Pickup</span>';
                    } elseif (strtolower($row->truck_status) == 'drop off') {
                        return '<span class="badge badge-default">Drop off</span>';
                    } elseif (strtolower($row->truck_status) == 'in transit') {
                        return '<span class="badge badge-secondary">In transit</span>';
                    } elseif (strtolower($row->truck_status) == 'delivered') {
                        return '<span class="badge badge-info">Delivered</span>';
                    } elseif (strtolower($row->truck_status) == 'decline') {
                        return '<span class="badge badge-danger">Decline</span>';
                    }  elseif (strtolower($row->truck_status) == 'accepted') {
                        return '<span class="badge badge-danger">Accepted</span>';
                    }else {
                        return '';
                    }
                })
                ->filter(function ($instance) use ($request) {
                // dd(strtolower($request->truck_status) );
                if (strtolower($request->get('truck_status')) == 'available'
                    || strtolower($request->get('truck_status')) == 'pending'
                    || strtolower($request->get('truck_status')) == 'pickup'
                    || strtolower($request->get('truck_status')) == 'drop off'
                    || strtolower($request->get('truck_status')) == 'in transit'
                    || strtolower($request->get('truck_status')) == 'delivered'
                    || strtolower($request->get('truck_status')) == 'decline'
                    || strtolower($request->get('truck_status')) == 'accepted') {
                    $instance->where('truck_status', $request->get('truck_status'));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('id', 'LIKE', "%$search%")
                            ->orWhere('origin', 'LIKE', "%$search%")
                            ->orWhere('destination', 'LIKE', "%$search%")
                            ->orWhere('from_date', 'LIKE', "%$search%")
                            ->orWhere('to_date', 'LIKE', "%$search%");
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
                ->addColumn('length', function ($row) {
                    return $row->trucks ? $row->trucks->length : '';
                })
                ->addColumn('weight', function ($row) {
                    return $row->trucks ? $row->trucks->weight : '';
                })
                ->addColumn('equipment_detail', function ($row) {
                    if ($row->equipment_detail == 0) {
                        return '<span class="badge badge-primary">Full</span>';
                    } elseif ($row->equipment_detail == 1) {
                        return '<span class="badge badge-warning">Partial</span>';
                    } else {
                        return '<span class="badge badge-secondary">Both</span>';
                    }
                })
                ->addColumn('is_posted', function ($row) {
                    if ($row->is_posted == 0) {
                        return '<span class="badge badge-danger">un-posted</span>';
                    } else {
                        return '<span class="badge badge-success">posted</span>';
                    }
                })->rawColumns(['truck_status', 'user_name', 'equipment_detail', 'is_posted', 'from_to_date', 'length', 'weight'])
                ->make(true);
        }

        return view('Admin.trucks-list', get_defined_vars());
    }
}
