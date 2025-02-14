<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        
        // dd('123');
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // dd($input);

        $userVerification = User::where('email', $request->email)->first();
        // dd(isset($userVerification), Hash::check($request->password, $userVerification->password) ,$userVerification->type);
    // dd($userVerification);
            
        if (isset($userVerification) == true && Hash::check($request->password, $userVerification->password) == true && $userVerification->type == 'super-admin' && $userVerification->status == 1) {
            Auth::attempt(['email' => $userVerification->email, 'password' => $request->password]);
            $user = Auth::user();
            $user->session_token = Str::random(80); // Generate a random session token
            $user->save();
            session(['session_token' => $user->session_token]);
            
            return redirect()->route('super-admin.dashboard');
        } else {
            if (!$userVerification) {
                return redirect()->route('login')
                    ->with('error', 'Email is not correct');
            } elseif (!Hash::check($request->password, $userVerification->password)) {
                return redirect()->route('login')
                    ->with('error', 'Password is not correct');
            }elseif ($userVerification->status == 0) {
                return redirect()->route('login')
                    ->with('error', 'Your Account has been In Active Please Contact Support');
            } else {
                //email sent
                $email = $request->input('email');
                $otp = 111111;
                // rand(100000, 999999);
                // dd(env('MAIL_USERNAME'));
                Mail::to($email)->send(new OtpMail($otp, $userVerification));
            }

            if (!$userVerification) {
                return redirect()->route('login')
                    ->with('error', 'Email and password are not correct');
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
            return redirect()->route('send_otp', ['user_id' => $userVerification->id, 'pass' => encrypt($request->password)]);
        }
    }

    public function sendOtp($user_id, $pass)
    {
        $user = User::where('id', $user_id)->first();
        return view('emails.otp-verify', get_defined_vars());
    }

    public function resendOtp($user_id, $pass)
    {
        $user = User::where('id', $user_id)->first();

        //email sent
        $email = $user->email;
        $pass = $pass;
        $otp = 111111;
        // rand(100000, 999999);
        Mail::to($email)->send(new OtpMail($otp, $user));
        User::where('email', $email)->update([
            'otp' => $otp,
            'otp_expire_at' => Carbon::now()->addMinutes(15),
        ]);
        return back()->with('success', "OTP sent Succefully to your email");
        // return view('emails.otp-verify', get_defined_vars())->with('success', "OTP sent Succefully to your email");
    }

    public function otpVerify(Request $request)
    {   
        
        $otp = User::where('id', $request->id)->where('otp', $request->otp)
            ->where('otp_expire_at', '>', Carbon::now())
            ->first();

        if (!$otp) {
            return redirect()->back()->with('error', 'Your otp is wrong or expired');
        } else {
            if (Auth::attempt(['email' => $otp->email, 'password' => decrypt($request->pass)])) {
                $user = Auth::user();
                $user->session_token = Str::random(80); // Generate a random session token
                $user->save();
                session(['session_token' => $user->session_token]);
                    
            
                // $user = Auth::user();
                // if ($user->type == 'trucker' && $user->subscriptions->isNotEmpty() == true) {
                //     foreach ($user->subscriptions as $subscription) {
                //         $checkSubscription = $subscription->expired_at > Carbon::now();
                //         if ($checkSubscription) {
                //             return redirect()->route('trucker.dashboard');
                //         }
                //     }
                // } elseif ($user->type == 'trucker') {
                //     if ($user->parent_id == null) {
                //         return redirect()->route('trucker.update_subscription')->with('error', 'Kindly Update Your Subscription');
                //     } else {
                //         return redirect()->route('trucker.contact_owner')->with('error', 'Please Contact Your Owner');
                //     }
                // } else if ($user->type == 'shipper') {
                //     return redirect()->route('shipper.dashboard');
                // } else if ($user->type == 'broker' && $user->subscription ?? ($user->subscription->expired_at > Carbon::now())) {
                //     return redirect()->route('broker.dashboard');
                // } else if ($user->type == 'broker' && $user->subscriptions->isNotEmpty() == true) {
                //     foreach ($user->subscriptions as $subscription) {
                //         $checkSubscription = $subscription->expired_at > Carbon::now();
                //         if ($checkSubscription) {
                //             return redirect()->route('broker.dashboard');
                //         }
                //     }
                // }
                // elseif ($user->type == 'broker') {
                //     if ($user->parent_id == null) {
                //         return redirect()->route('broker.update_subscription')->with('error', 'Kindly Update Your Subscription');
                //     } else {
                //         return redirect()->route('broker.contact_owner')->with('error', 'Please Contact Your Owner');
                //     }
                // }
                if (Auth::user()->type == 'shipper') {
                    return redirect()->route('shipper.dashboard');
                }
                elseif (Auth::user()->type == 'broker') {
                    return redirect()->route('broker.dashboard');
                }
                elseif (Auth::user()->type == 'trucker') {
                    // dd('123');
                    return redirect()->route('trucker.dashboard');
                } 
                elseif (Auth::user()->type == 'combo') {
                    // dd('123');
                    return redirect()->route('combo.dashboard');
                } 
                else {
                    return redirect()->route('super-admin.dashboard');
                }
            } else {
                return redirect()->route('login')
                    ->with('error', 'Email-Address And Password Are Wrong.');
            }
        }
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $user->session_token = null;
            $user->save();
    
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } 
            return redirect()->route('login');
    }

    

}