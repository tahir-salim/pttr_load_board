<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\OnboardingProfile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class onBoardingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($user->type);
         $user = auth()->user();
        if ($user->type != 'broker' || $user->type != 'shipper') {
            if($user->parent_id == null){
                if($user->onboardingProfile == null){
                      return redirect()->route($user->type.'.on_boarding_proflie');
                }
                if($user->onboardingProfile->steps_completed < 7){
                    return redirect()->route($user->type.'.on_boarding_proflie');
                    // return $next($request);
                }else{
                    return $next($request);
                }
            }
            elseif($user->parent_id != null){
              $user = User::where('id', $user->parent_id)->first();
               if(!OnboardingProfile::where('user_id', $user->id)->first()){
                      return redirect()->route($user->type.'.on_boarding_proflie_notify');
                }
            }
        }
            return $next($request);

    }
}
