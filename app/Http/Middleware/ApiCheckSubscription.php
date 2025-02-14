<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class ApiCheckSubscription
{
     protected function formatResponse($status, $message = null, $data = null, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // dd($user);
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
                    return $this->formatResponse('error', 'your account is in-active update your subscription');
                } else {
                    return $this->formatResponse('error', 'your account is in-active please contact your owner');
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
                    return $this->formatResponse('error', 'your account is in-active update your subscription');
                } else {
                    return $this->formatResponse('error', 'your account is in-active please contact your owner');
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
                    return $this->formatResponse('error', 'your account is in-active update your subscription');
                } else {
                    return $this->formatResponse('error', 'your account is in-active please contact your owner');
                }
            }
        }
        return $next($request);
    }
}
