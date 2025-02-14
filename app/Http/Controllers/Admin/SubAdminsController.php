<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SubAdminsController extends Controller
{
    
    public function index(Request $request){
        if($request->ajax()){
            $data = User::where("type", 0)->whereNotNull('parent_id')->orderBy('id', 'Desc');
             return DataTables::of($data)
             ->addIndexColumn()
             ->addColumn('created_at', function ($row) {
                $r = $row->created_at != null ? $row->created_at->diffForHumans() : "-";
                return $r;
            })->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btns = '';
                if ($row->status == 1) {
                    $btns .= '<a class="btn btn-danger" onclick="return confirm(`Are you sure you want to In-Activate This Admin`,'.$row->id.')" href="' . route(auth()->user()->type . ".subadmin.change_subadmin_status", [$row->id]) . '?status=0" tile="" >InActivate</a>';
                } else {
                    $btns .= '<a class="btn btn-success" onclick="return confirm(`Are you sure you want to Activate This Admin`,'.$row->id.')" href="' . route(auth()->user()->type . ".subadmin.change_subadmin_status", [$row->id]) . '?status=1" tile="">Activate</a>';
                }
                $btns .= '<a class="btn btn-primary"  href="' . route(auth()->user()->type . ".subadmin.edit", [$row->id]) . '" tile="">Edit</a>';
            
                return $btns;
            })
             ->addColumn('account_status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-success" tile="" >Active</span>';
                } else {
                    return '<span class="badge badge-success" tile="" >InActive</span>';
                }
            })
            ->rawColumns(['created_at','type','account_status' ,'action'])
            ->make(true);

        }
        return view('Admin.SubAdmin.index');
    }
    
    public function edit($id){
        $user = User::findorfail($id);
        return view('Admin.SubAdmin.edit',compact('id','user'));
    }
    
    public function add(){
        return view('Admin.SubAdmin.create');
    }
    
    public function create(Request $request){
        
       $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|min:8|same:cnfrm_password',
            'cnfrm_password' => 'required|min:8',
        ], [

            'password.same' => 'Password and confirm password must match.',
            'phone.digits' => 'The phone number must be exactly 10 digits.',
        ]);
    
        // dd($request->all());
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->parent_id = 1;
        $user->type = 0;
         $user->password = Hash::make($request->cnfrm_password);
        $user->save();
        
        $emailData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'type' => $user->type,
            'password' => $request->cnfrm_password
        ];
        
         Mail::send('emails.subadmin-email', $emailData, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your email is registered as SubAdmin in ' . config('app.name'));
        });
        return redirect()->route(auth()->user()->type . '.subadmin.list')->with('success','SubAdmin created successfuly');
    }
    
    public function update(Request $request, $id){
        
        $user = User::findorfail($id);

            if($request->has('update_password')){
                    $request->validate([ 
                    'password' => 'required|min:8|same:cnfrm_password',
                    'cnfrm_password' => 'required|min:8',
                ]);
            }
            
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'phone' => 'required', 
        ]);

            
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->type = 0;
        if($request->has('update_password')){
         $user->password = Hash::make($request->cnfrm_password);
        }
        $user->save();
        return redirect()->route(auth()->user()->type . '.subadmin.list')->with('success','SubAdmin Updated successfuly');

    }
    
    
    
    public function change_status(Request $request, $id){
                $user = User::findorfail($id);
                $user->status = $request->status;
                $user->save();
        return redirect()->route(auth()->user()->type . '.subadmin.list')->with('success','SubAdmin account status updated');

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}