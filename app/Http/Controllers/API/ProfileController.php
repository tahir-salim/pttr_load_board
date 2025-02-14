<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function truckerProfile()
    {
        $userProfile = User::
                where('id', Auth::id())
            ->first();
            
            if($userProfile){
                $userProfile['company'] = $userProfile->parent_id != null ? Company::where('user_id', $userProfile->parent_id)->first() : $userProfile->company ;
                $userProfile['package'] = $userProfile->package  ? $userProfile->package : null ;
            }

        return $this->formatResponse(
            'success',
            'get-trucker-profile',
            $userProfile,
            200
        );
    }

    public function truckerProfileUpdate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'sometimes',
            'email' => 'sometimes',
            'password' => 'sometimes',
            'phone' => 'sometimes',
            'extention' => 'sometimes',
            'company_name' => 'sometimes',

        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $user = User::find(Auth::id());

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->has('extention')) {
            $user->alt_phone = $request->extention;
        }

        if ($request->has('company_name')) {
             if($user->parent_id != null){
                $company = Company::where('user_id', $user->parent_id)->first();
            }else{
                $company = Company::where('user_id',  $user->id)->first();
            }
            $company->name = $request->company_name;
            $company->save();
        }

        $user->save();

        return $this->formatResponse('success', 'trucker-profile-updated', $user, 200);
    }
}
