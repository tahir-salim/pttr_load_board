<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if ($user->type == 'trucker') {
            $truckerSubscriptions = User::whereHas('subscriptions', function ($q) {
                $q->where('expired_at', '>', now())
                    ->where('is_active', 1);
            })->where('id', $user->id)->where('type', 1)->first();
            // dd($truckerSubscriptions);

            if ($truckerSubscriptions != null) { 
                return $next($request);
            } else {
                if ($user->parent_id == null) {
                    return redirect()->route($user->type . '.update_subscription');
                } else {
                    return redirect()->route($user->type . '.contact_owner');
                }
            }
 
        } elseif($user->type == "broker") {
            $brokerSubscriptions = User::whereHas('subscriptions', function ($q) {
                $q->where('expired_at', '>', now())
                    ->where('is_active', 1);
            })->where('id', $user->id)->where('type', 3)->first();

            if ($brokerSubscriptions != null) {
                return $next($request);
            } else {
                if ($user->parent_id == null) {
                    return redirect()->route($user->type . '.update_subscription');
                } else {

                    return redirect()->route($user->type . '.contact_owner');
                }
            }

        }else{
            $brokerSubscriptions = User::whereHas('subscriptions', function ($q) {
                $q->where('expired_at', '>', now())
                    ->where('is_active', 1);
            })->where('id', $user->id)->where('type', 4)->first();

            if ($brokerSubscriptions != null) {
                return $next($request);
            } else {
                if ($user->parent_id == null) {
                    return redirect()->route($user->type . '.update_subscription');
                } else {

                    return redirect()->route($user->type . '.contact_owner');
                }
            }
        }

        // if ($user->type == 'trucker') {
        //     $truckerSubscriptions = $user->subscriptions()->where('expired_at', '>', now())->first();

        //     if ($truckerSubscriptions != null) {
        //         return redirect()->route('trucker.dashboard');
        //     } elseif ($user->parent_id == null) {
        //         return redirect()->route($user->type . '.update_subscription');
        //     } else {
        //         return redirect()->route($user->type . '.contact_owner');
        //     }
        // } elseif ($user->type == 'broker') {
        //     $brokerSubscriptions = $user->subscriptions()->where('expired_at', '>', now())->first();

        //     if ($brokerSubscriptions != null) {
        //         return redirect()->route('broker.dashboard');
        //     } elseif ($user->parent_id == null) {
        //         return redirect()->route($user->type . '.update_subscription');
        //     } else {
        //         return redirect()->route($user->type . '.contact_owner');
        //     }
        // }

        return $next($request);
    }
}
