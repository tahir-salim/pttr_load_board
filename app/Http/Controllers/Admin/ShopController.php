<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Yajra\DataTables\DataTables;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Shop::select("*")->orderBy('created_at','Desc')->orderBy('name', 'Asc');
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->addIndexColumn()
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<a class="badge badge-success" onclick="return confirm(`Are you sure you want to In-Active Shop`)" href="' . route(auth()->user()->type . ".change_shops_status", [$row->id]) . '" tile="" >Active</a>';
                } else {
                    return '<a class="badge badge-danger" onclick="return confirm(`Are you sure you want to Active Shop`)" href="' . route(auth()->user()->type . ".change_shops_status", [$row->id]) . '" tile="">InActive</a>';
                }
            })
            ->addColumn('image', function ($row) {
                if($row->image != null){
                    $img = '<a href="' .asset($row->image).'" target="_blank"><img src="' .asset($row->image).'" style="width:100px; height:100px;"></img></a>';
                }else{
                    $img = 'Image Not Found';
                }
                return $img;
            })
            ->addColumn('action', function ($row) {
                    $btn = '<a class="fa fa-eye btn btn-outline-success" href="' . route("super-admin.shops.show", [$row->id]) . '" tile=""></a>';
                    
                    if(auth()->user()->parent_id == null){
                        $btn .= '<a class="fa fa-pencil btn btn-outline-primary" href="' . route("super-admin.shops.edit", [$row->id]) . '" tile=""></a>';
                        $btn .= '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route('super-admin.shops.destroy', [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a>';
                    }
                return '<div class="d-flex btnWrap">'.$btn.'</div>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('name') != 0) {
                        $instance->where('name', $request->get('name'));
                    }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = str_replace(" ","_",$request->get('search'));
                        $w->orWhere('id', 'LIKE', "%$search%")
                        ->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('lat', 'LIKE', "%$search%")
                        ->orWhere('lng', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'image' , 'action'])
            ->make(true);
        }

        return view('Admin.Shop.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Shop.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'sometimes',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'description' => 'sometimes',
            'image'=>'required|mimes:jpg,jpeg,png,bmp,gif',
            ]);

            $shop =  Shop::where('name', $request->name)->first();

            $imageName = '';
            if(isset($shop)){
                return back()->withInput()->with('error','Already Exist this Shop ID '. $shop->id );
            }
            else{
                if ($image = $request->file('image')){
                    $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                    $image->move('assets/shops/uploads/', $imageName);
                }
                
                Shop::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code ? $request->zip_code : null,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'description' => $request->description ? $request->description : null,
                    'status' => 1,
                    'image'=> 'assets/shops/uploads/'.$imageName,
                ]);
                $success ='Shop Created Successfully!';
            }

        return redirect()->route('super-admin.shops.list')->with('success',$success);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shop = Shop::find($id);
        // dd($package);
        return view('Admin.Shop.show',get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shop = Shop::find($id);
        // dd($package);
        return view('Admin.Shop.edit',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'sometimes',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'description' => 'sometimes',
            'image'=>'sometimes|mimes:jpg,jpeg,png,bmp,gif',
            'status' => 'required',
            ]);

            $shop = Shop::find($id);
            // dd($shop->image);
            $imageName = null;
                if ($image = $request->file('image')){
                    $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                    $image->move('assets/shops/uploads/', $imageName);
                    // Shop::where('id',$id)->update([
                    //     'image'=> 'assets/shops/uploads/'.$imageName ? 'assets/shops/uploads/'.$imageName : $shop->image,
                    // ]);                    
                }
                
                Shop::where('id',$id)->update([
                    'name' => $request->name,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code ? $request->zip_code : null,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                    'description' => $request->description ? $request->description : null,
                     'image'=> $imageName != null ? 'assets/shops/uploads/'.$imageName : $shop->image,
                    'status'=>$request->status,
                ]);
            
        return redirect()->route('super-admin.shops.list')->with('success','Shop Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shop = Shop::find($id);
        $shop->delete();
        
        return redirect()->route('super-admin.shops.list')->with('success','Shop Deleted Successfully!');
    }
    
    public function change_shops_status($id)
    {
        $adv = Shop::find($id);
        if ($adv->status == 1) {
            $adv->status = 0;
            $adv->save();
        }elseif($adv->status == 0){
            $adv->status = 1;
            $adv->save();
        }
         else {
            return back()->with('error', 'Shop ID Not Found');
        }
        return back()->with('success', 'Status Changed Successfully');
    }
}
