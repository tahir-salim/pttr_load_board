<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveSupportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
   

    
    public function live_support(Request $request,$id)
    {      
        $user = User::findorfail($id);
        return view('Global.live-support',get_defined_vars());
    }

}
