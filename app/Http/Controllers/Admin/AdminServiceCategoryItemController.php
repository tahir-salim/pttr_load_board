<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminServiceCategoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // dd('123');
            $data = ServiceCategoryItem::select("*")->orderBy('created_at', 'Desc');
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                // dd($row);/
                return $row->created_at ? $row->created_at->diffForHumans() : '';
            })->addIndexColumn()->addColumn('service', function ($row) {
                // dd('123');
                return $row->service ? $row->service->name : '';
            })->addIndexColumn()->addColumn('address', function ($row) {
                // dd('123');
                return \Illuminate\Support\Str::limit($row->street_address, 20, $end = '...');
            })->addIndexColumn()->addColumn('serviceCategory', function ($row) {
                return $row->serviceCategory ? $row->serviceCategory->name : '';
            })->addIndexColumn()->addColumn('icon', function ($row) {
                // dd($row->icon);
                // return '<a href="' . asset(config('app.url').$row->icon) . '" tile=""></a>';
                if ($row->icon != null) {
                    $icon = '<a href="' . asset($row->icon) . '" target="_blank"><img src="' . asset($row->icon) . '" style="width:50px; height:50px;"></img></a>';
                } else {
                    $icon = 'Image Not Found';
                }
                return $icon;
            })->addIndexColumn()
                ->addColumn('location', function ($row) {
                    if ($row->lat != null && $row->lng != null) {
                   $loc = currentlocationGetCity($row->lat, $row->lng);
                    $loc_name = '<a href="https://www.google.com/maps/place/'.$row->lat.','.$row->lng.'" target="_blank">'.($loc == "Current Location" ? "Invalid location" : $loc).'</a>';
                    return $loc_name;
                    } else {
                        return '-';
                    }
                })->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->is_active == 1) {
                        return '<a class="badge badge-success" onclick="return confirm(`Are you sure you want to In-Active Service Category Item`)" href="' . route(auth()->user()->type . ".change_service_category_item_status", [$row->id]) . '" tile="" >Active</a>';
                    } else {
                        return '<a class="badge badge-danger" onclick="return confirm(`Are you sure you want to Active Service Category Item`)" href="' . route(auth()->user()->type . ".change_service_category_item_status", [$row->id]) . '" tile="">InActive</a>';
                    }
                })
                ->addColumn('action', function ($row) {
                    // dd($row);

                    $btn = '<a class="fa fa-eye btn btn-outline-success" href="' . route("super-admin.service_category_item.show", [$row->id]) . '" tile=""></a>';
                    // if ($row->id != 23) {
                    if(auth()->user()->parent_id == null){
                       $btn .= '<a class="fa fa-pencil btn btn-outline-primary" href="' . route("super-admin.service_category_item.edit", [$row->id]) . '" tile=""></a>';
                        $btn .= '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route('super-admin.service_category_item.destroy', [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a>';
                    }// }
                    return '<div class="d-flex btnWrap">' . $btn . '</div>';
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('address') != 0) {
                        $instance->where('street_address', $request->get('address'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = str_replace(" ", "_", $request->get('search'));
                            $w->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('street_address', 'LIKE', "%$search%")
                                ->orWhereHas('service', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', "%$search%");
                                })->orWhereHas('serviceCategory', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%$search%");
                            });
                        });
                    }
                })
                ->rawColumns(['status', 'action', 'location', 'icon', 'serviceCategory', 'service', 'address'])
                ->make(true);
        }

        return view('Admin.ServiceCategoryItem.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::where('is_active', 1)->get();
        return view('Admin.ServiceCategoryItem.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'service_id' => 'required',
            // 'category_name' => 'sometimes',
            'image' => 'required',
        ]);
        dd($request->file('image'));
        foreach ($request->street_address as $key => $value) {
            if ($request->file('image')[$key]) {
                $icon = $request->file('image')[$key];
                $iconName = time() . '-' . uniqid() . '.' . $icon->getClientOriginalExtension();
                $icon->move('assets/services/icons/', $iconName);
            }
            $service = new ServiceCategoryItem();
            $service->service_id = $request->service_id;
            $service->service_category_id = $request->category_id;
            $service->street_address = $request->street_address[$key];
            $service->lat = $request->street_addressLat[$key];
            $service->lng = $request->street_addressLng[$key];
            $service->icon = '/assets/services/icons/' . $iconName;
            $service->is_active = 1;
            $service->save();
        }

        return redirect()->route('super-admin.service_category_item.list')->with('success', 'Service or Category Items Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serviceCategoryItem = ServiceCategoryItem::find($id);
        // dd($serviceCategoryItem);
        return view('Admin.ServiceCategoryItem.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceCategoryItem = ServiceCategoryItem::find($id);
        $services = Service::all();
        $serviceCategories = ServiceCategory::where('service_id', $serviceCategoryItem->service_id)->get();
        // dd($services, $serviceCategories);

        return view('Admin.ServiceCategoryItem.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());

        if ($request->file('image')) {
            $icon = $request->file('image');
            $iconName = time() . '-' . uniqid() . '.' . $icon->getClientOriginalExtension();
            $icon->move('assets/services/icons/', $iconName);

            $item = ServiceCategoryItem::find($id);
            $item->service_id = $request->service_id;
            $item->service_category_id = $request->category_id;
            $item->street_address = $request->street_address;
            $item->lat = $request->street_addressLat;
            $item->lng = $request->street_addressLng;
            $item->icon = '/assets/services/icons/' . $iconName;
            $item->is_active = 1;
            $item->save();
        }else{
            $item = ServiceCategoryItem::find($id);
            $item->service_id = $request->service_id;
            $item->service_category_id = $request->category_id;
            $item->street_address = $request->street_address;
            $item->lat = $request->street_addressLat;
            $item->lng = $request->street_addressLng;
            $item->icon = $request->old_icon;
            $item->is_active = 1;
            $item->save();
        }

        return redirect()->route('super-admin.service_category_item.list')->with('success', 'Service or Category Items Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ServiceCategoryItem::find($id);
        $item->delete();
        return redirect()->route('super-admin.service_category_item.list')->with('success', 'Service or Category Items Deleted Successfully!');
    }

    public function serviceCategory(Request $request)
    {
        $parentValue = $request->input('parent_value');

        $childData = ServiceCategory::where('service_id', $parentValue)->get();
        // dd($childData);
        return response()->json($childData);
    }
}
