<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\chat;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLiveSupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   

    
    public function adminLiveSupport(Request $request)
    {
        
       
        $chatList = chat::latest()->get()->groupBy('sender_id');
        // dd($chatList[1]);
        $arr = [];
        foreach($chatList as $key=> $v){
            $users = User::where('id',$key)->where('id','!=',1)->get();
            array_push($arr,$users);
        }
        // dd($arr->orderBy('created_at','DESC'));
        // dd($request->id);
        // dd($arr->type);
        if ($request->has('id')) {
            $id = $request->id;
        }else{
            $id = '';
        }

        // dd('error');
        
        return view('Admin.admin-live-support',get_defined_vars());
    }
}
