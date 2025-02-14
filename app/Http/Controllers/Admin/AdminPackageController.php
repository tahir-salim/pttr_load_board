<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AdminPackageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Package::select("*")->orderBy('created_at', 'DESC');
            // dd($request->all());
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('promo_owner_amount', 'LIKE', "%$search%")
                            ->orWhere('promo_user_amount', 'LIKE', "%$search%")
                            ->orWhere('regular_owner_amount', 'LIKE', "%$search%")
                            ->orWhere('regular_user_amount', 'LIKE', "%$search%");
                    });
                }
            })->addColumn('type', function ($row) {
                    if($row->type == 1){
                        return "Carrier";
                    }elseif($row->type == 3){
                        return "Broker";
                    }else{
                        return "Combo";
                    }
                })->addColumn('promo_owner_amount', function ($row) {
                    return '$'.$row->promo_owner_amount;
                })->addColumn('promo_user_amount', function ($row) {
                    return '$'.$row->promo_user_amount;
                })->addColumn('regular_owner_amount', function ($row) {
                    return '$'.$row->regular_owner_amount;
                })->addColumn('regular_user_amount', function ($row) {
                    return '$'.$row->regular_user_amount;
                })
                ->addColumn('description', function ($row) {
                    return Str::limit(strip_tags($row->description), 30, '...');
                })
                ->addColumn('actions', function ($row) {
                    $btn = '';
                    if(auth()->user()->parent_id == null){
                        $btn .= '<div class="d-flex btnWrap"><a href="' . route(auth()->user()->type . '.packages.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a>
                        <a href="' . route(auth()->user()->type . '.packages.edit', [$row->id]) . '"class="fa fa-pencil btn btn-outline-primary"></a></div>';
                    }else{
                        $btn .= '<div class="d-flex btnWrap"><a href="' . route(auth()->user()->type . '.packages.show', [$row->id]) . '"class="fa fa-eye btn btn-outline-success"></a></div>';
                    }
                    return $btn;
                
                // . '<a onclick="return confirm(`Are you sure you want to Delete this Package?`)" href="' . route(auth()->user()->type . '.packages.destroy', [$row->id]) . '" class="fa fa-trash-alt btn btn-outline-danger"></a></div>'
            })->rawColumns(['promo_owner_amount','promo_user_amount','regular_owner_amount','regular_user_amount','actions','description','type'])
                ->make(true);
        }
        return view('Admin.Packages.index', get_defined_vars());
    }
    
    public function create()
    {
        $packages = Package::all();
        return view('Admin.Packages.create',get_defined_vars());
    }
    
    public function detail($id)
    {
        $package = Package::find($id);
        // dd($package);
        return view('Admin.Packages.show',get_defined_vars());
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        
        // $package = new Package();
        // $package->name = $request->name;
        // $package->type = $request->type;
        // $package->promo_owner_amount = $request->promo_owner_amount;
        // $package->promo_user_amount = $request->promo_user_amount;
        // $package->regular_owner_amount = $request->regular_owner_amount;
        // $package->regular_user_amount = $request->regular_user_amount;
        // $package->description = isset($request->description) ? $request->description : '';
        // $package->save();
        
        return redirect()->route('super-admin.packages.list')->with('success','Package Created Successfully!');
    }
    
    public function edit($id)
    {
        $package = Package::find($id);
        // dd($package);
        return view('Admin.Packages.edit',get_defined_vars());
    }
    
    public function update(Request $request,$id)
    {
        // dd($request->all());
        $package = Package::find($id);
        $package->name = $request->name;
        $package->promo_owner_amount = $request->promo_owner_amount;
        $package->promo_user_amount = $request->promo_user_amount;
        $package->regular_owner_amount = $request->regular_owner_amount;
        $package->regular_user_amount = $request->regular_user_amount;
        $package->description = isset($request->description) ? $request->description : '';
        $package->save();
        
        return redirect()->route('super-admin.packages.list')->with('success','Package Updated Successfully!');
    }
    
    public function destroy($id)
    {
        // $users = User::where('package_id',$id)->get();
        // if($users->count() > 0){
        //     return back()->with('error','Wouldn\'t Be Able To Delete This Package');
        // }
        // $package = Package::find($id);
        // $package->delete();
        return redirect()->route('super-admin.packages.list')->with('success','Package Deleted Successfully!');
    }
}
