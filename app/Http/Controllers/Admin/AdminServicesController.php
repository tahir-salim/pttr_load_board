<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryItem;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::select("*")->orderBy('created_at', 'Desc');
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->addIndexColumn()->addColumn('updated_at', function ($row) {
                return $row->updated_at->diffForHumans();
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
                ->addColumn('status', function ($row) {
                    if ($row->is_active == 1) {
                        return '<a class="badge badge-success" onclick="return confirm(`Are you sure you want to In-Active Service`)" href="' . route(auth()->user()->type . ".change_service_status", [$row->id]) . '" tile="" >Active</a>';
                    } else {
                        return '<a class="badge badge-danger" onclick="return confirm(`Are you sure you want to Active Service`)" href="' . route(auth()->user()->type . ".change_service_status", [$row->id]) . '" tile="">InActive</a>';
                    }
                })
                ->addColumn('action', function ($row) {
                    // dd($row);

                    $btn = '<a class="fa fa-eye btn btn-outline-success" href="' . route("super-admin.service.show", [$row->id]) . '" tile=""></a>';
                    // if ($row->id != 23) {
                    if(auth()->user()->parent_id == null){
                    $btn .= '<a class="fa fa-pencil btn btn-outline-primary" href="' . route("super-admin.service.edit", [$row->id]) . '" tile=""></a>';
                        $btn .= '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route('super-admin.service.destroy', [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a>';
                    }
                    // }
                    return '<div class="d-flex btnWrap">' . $btn . '</div>';
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('name') != 0) {
                        $instance->where('name', $request->get('name'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = str_replace(" ", "_", $request->get('search'));
                            $w->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('name', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['status', 'action', 'icon'])
                ->make(true);
        }

        return view('Admin.Service.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'service_name' => 'required',
            'category_name' => 'sometimes',
            // 'street_address' => 'required',
            // 'image' => 'required',
            'list_name' => 'required',
            'icon' => 'required',
        ]);

        // dd($request->category_name[0] != null);

        $service = Service::where('name', $request->service_name)->first();

        if (isset($service)) {
            return back()->withInput()->with('error', 'Already Exist this Service ID ' . $service->id);
        } else {
            if ($icon = $request->file('icon')) {
                $icon = $request->file('icon');
                $iconName = time() . '-' . uniqid() . '.' . str_replace(" ", "-",$icon->getClientOriginalExtension());
                $icon->move('assets/services/icons/', $iconName);
            }
            $service = new Service();
            $service->name = $request->service_name;
            $service->list_name = $request->list_name;
            $service->icon = '/assets/services/icons/' . $iconName;
            $service->is_active = 1;
            $service->save();

            if ($request->category_name[0] != null) {
                foreach ($request->category_name as $key => $item) {
                    $serviceCategory = new ServiceCategory();
                    $serviceCategory->service_id = $service->id;
                    $serviceCategory->name = $request->category_name[$key];
                    $serviceCategory->save();
    
                }
            }


            // if ($request->has('category_name')) {
            //     $serviceCategory = new ServiceCategory();
            //     $serviceCategory->service_id = $service->id;
            //     $serviceCategory->name = $request->category_name;
            //     $serviceCategory->save();

            //     foreach ($request->street_addressLat as $key => $value) {
            //         if ($image = $request->file('image') && isset($request->file('image')[$key])) {
            //             $image = $request->file('image')[$key];
            //             $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            //             $image->move('assets/services/icons/', $imageName);
            //         }
            //         ServiceCategoryItem::create([
            //             'service_id' => $service->id,
            //             'service_category_id' => $serviceCategory->id,
            //             'street_address' => $request->street_address[$key],
            //             'street_place_id' => $request->street_place_id[$key],
            //             'lat' => $request->street_addressLat[$key],
            //             'lng' => $request->street_addressLng[$key],
            //             'icon' => '/assets/services/icons/'.$imageName,
            //         ]);
            //     }

            // } else {
            //     foreach ($request->street_addressLat as $key => $value) {
            //         if ($image = $request->file('image') && isset($request->file('image')[$key])) {
            //             $image = $request->file('image')[$key];
            //             $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            //             $image->move('assets/services/icons/', $imageName);
            //         }
            //         ServiceCategoryItem::create([
            //             'service_id' => $service->id,
            //             'street_address' => $request->street_address[$key],
            //             'street_place_id' => $request->street_place_id[$key],
            //             'lat' => $request->street_addressLat[$key],
            //             'lng' => $request->street_addressLng[$key],
            //             'icon' => '/assets/services/icons/'.$imageName,
            //         ]);
            //     }
            // }

        }

        return redirect()->route('super-admin.service.list')->with('success', 'Service Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::find($id);
        return view('Admin.Service.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::find($id);
        $list_items = Service::select('list_name')->groupBy('list_name')->get();
        // dd($list_items);
        return view('Admin.Service.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'service_name' => 'required',
            'image' => 'sometimes|file',
        ]);
        
        $service = Service::find($id);
        $service->name = $request->service_name;
        $service->list_name = $request->list_name;
        if ($request->file('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '-' . uniqid() . '.' . str_replace(" ", "-",$icon->getClientOriginalExtension());
            $icon->move('assets/services/icons/', $iconName);
            $service->icon = '/assets/services/icons/' . $iconName;
        } else {
            $service->icon = $request->old_icon;
        }

        $service->save();

        return redirect()->route('super-admin.service.list')->with('success', 'Service Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        ServiceCategoryItem::where('service_id', $id)->delete();
        ServiceCategory::where('service_id', $id)->delete();
        $service->delete();

        return redirect()->route('super-admin.service.list')->with('success', 'Service Deleted Successfully!');
    }

    public function change_service_status($id)
    {
        $service = Service::find($id);
        if ($service->is_active == 1) {
            $service->is_active = 0;
            $service->save();
        } elseif ($service->is_active == 0) {
            $service->is_active = 1;
            $service->save();
        } else {
            return back()->with('error', 'Service ID Not Found');
        }
        return back()->with('success', 'Status Changed Successfully');
    }
}
