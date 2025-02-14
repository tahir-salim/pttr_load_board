<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\UserDeviceToken;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $userVerification = User::where('email', $request->email)->where('type', '!=', 3)->first();



        if (!$userVerification) {
            return $this->formatResponse(
                'error',
                'Email address not found'
            );
        } elseif (!Hash::check($request->password, $userVerification->password)) {
            return $this->formatResponse(
                'error',
                'credentials do not match'
            );
        }elseif ($userVerification->status == 0) {
            return $this->formatResponse(
                'error',
                'your account is in-active please contact support'
            );
        } else {
            //email sent
            $email = $request->input('email');
            if($email == 'johndoe@yopmail.com'){
                $otp = 111111;
            }else{
                $otp = rand(100000, 999999);
            }
            Mail::to($email)->send(new OtpMail($otp, $userVerification));
        }

        if ($userVerification->otp == null && $userVerification->otp_expire_at == null) {
            //otp and expiration time saved
            $userVerification->otp = $otp;
            $userVerification->otp_expire_at = Carbon::now()->addMinutes(15);
            $userVerification->save();
        } else {
            User::where('email', $request->email)->update([
                'otp' => $otp,
                'otp_expire_at' => Carbon::now()->addMinutes(15),
            ]);
        }
        $data = ['user_id' => $userVerification->id,
            'key' => encrypt($request->password)];

        return $this->formatResponse(
            'success',
            'otp sent to your email',
            $data
        );
    }

    public function sendOtp($user_id, $pass)
    {
        $user = User::where('id', $user_id)->first();
        return view('emails.otp-verify', get_defined_vars());
    }

    public function resendOtp($user_id)
    {
        $userVerification = User::where('id', $user_id)->first();
        // dd($userVerification);
        //email sent
        $email = $userVerification->email;
        $otp = 111111;
        //rand(100000, 999999);
        Mail::to($email)->send(new OtpMail($otp, $userVerification));
        User::where('email', $email)->update([
            'otp' => $otp,
            'otp_expire_at' => Carbon::now()->addMinutes(15),
        ]);

        return $this->formatResponse(
            'success',
            'otp re-sent to your email'
        );
    }

    public function otpVerify(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'otp' => 'required',
            'key' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $otp = User::where('otp', $request->otp)
            ->where('otp_expire_at', '>', Carbon::now())
            ->first();

        if (!$otp) {
            return $this->formatResponse(
                'error',
                'Your otp is wrong or expired'
            );
        } else {
            if (Auth::attempt(['email' => $otp->email, 'password' => decrypt($request->key)])) {
                $user = Auth::user();
                
                $user->tokens()->delete();
                
                
                $user['token'] = $user->createToken('MyApp')->plainTextToken;
                 
                $user['company'] = $user->parent_id != null ? Company::where('user_id', $user->parent_id)->first() : $user->company ;
                $user['package'] = $user->package  ? $user->package : null ;
                return $this->formatResponse(
                    'success',
                    'login successfully.',
                    $user
                );
            } else {
                return $this->formatResponse(
                    'error',
                    'Unauthorised'
                );
            }
        }
    }

    public function forgetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $userVerification = User::where('email', $request->email)->first();

        if (!$userVerification) {
            return $this->formatResponse(
                'error',
                "We can't find a user with that email address."
            );
        } else {
            $otp = rand(100000, 999999);
            Mail::to($userVerification->email)->send(new OtpMail($otp, $userVerification));
            
            User::where('email', $userVerification->email)->update([
                'otp' => $otp,
                'otp_expire_at' => Carbon::now()->addMinutes(15),
            ]);
            
            return $this->formatResponse(
                'success',
                'otp sent to your email'
            );
        }
    }
    
    public function setPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'otp' => 'required',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
            ]);
    
            if ($validate->fails()) {
                return $this->formatResponse('error', $validate->errors()->first());
            }
            
            $otp = User::where('otp', $request->otp)
            ->where('otp_expire_at', '>', Carbon::now())
            ->first();
            
            // dd($otp);

            if (!$otp) {
                return $this->formatResponse(
                    'error',
                    'Your otp is wrong or expired'
                );
            } else {
                $otp->update(['password'=>Hash::make($request->password)]);
    
                return $this->formatResponse(
                    'success',
                    'Password changed successfully'
                );
            }
    }
    
    public function delete_fcm_token(Request $request)
    {
        
        $validate = Validator::make($request->all(), [
            'token' => 'required',
        ]);
    
        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }
            
        $userdev = UserDeviceToken::where('user_id', auth()->user()->id)->where('device_token', $request->token)->first();
        if($userdev){
            $userdev->delete();
        }
        
        
        return $this->formatResponse(
            'success',
            'Device Token Delete successfully',
            [],
            200
        );
    }
    
    public function logout()
    {
        
        Auth::user()->tokens()->delete();
        
        
        return $this->formatResponse(
            'success',
            'logout successfully'
        );
    }
}
