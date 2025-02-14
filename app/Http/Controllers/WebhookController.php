<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webhook;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class WebhookController extends Controller
{
    public function handle(Request $request){
        
        $webhook = new Webhook();
        $webhook->description = $request;
        // $webhook->description_payload = $request->payload;
        $webhook->save();
        
        $payload = json_decode($request->getContent(), true);
        
       // Extract required fields
        $eventType = $payload['eventType'];
        $subscriptionId = $payload['payload']['id']; // Assuming 'subscriptionId' is the field for subscription ID
        $reason = $payload['payload']['status']; // Reason for subscription failure
        
        $subscription = Subscription::where('subscription_id',$subscriptionId)->first();
        
        // payment webhook
        if($eventType == 'net.authorize.payment.capture.created' && isset($subscription)){
            $subscription->update(['is_active' => 1, 'subscription_detail' => 'webhook-'.$reason, 'expired_at' => Carbon::now()->addMonth()]);
            $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now()->addMonth();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.payment.fraud.approved' && isset($subscription)){
            $subscription->update(['is_active'=>0, 'subscription_detail'=>$reason, 'expired_at'=>now()]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now()->addMonth();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.payment.fraud.declined' && isset($subscription)){
            $subscription->update(['is_active'=>1, 'subscription_detail'=>$reason]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.payment.fraud.held' && isset($subscription)){
            $subscription->update(['is_active'=>1, 'subscription_detail'=>$reason]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }
        
        // subscription webhook
        if($eventType == 'net.authorize.customer.subscription.created' && isset($subscription)){
            $subscription->update(['subscription_detail'=>$reason]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now()->addMonth();
                $user->save();
            }
            
        }
        if($eventType == 'net.authorize.customer.subscription.updated' && isset($subscription)){
            $subscription->update(['is_active'=>1, 'subscription_detail'=>$reason]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now()->addMonth();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.customer.subscription.suspended' && isset($subscription)){
            $subscription->update(['is_active'=>0, 'subscription_detail'=>$reason, 'expired_at'=>Carbon::now()]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.customer.subscription.terminated' && isset($subscription)){
            $subscription->update(['is_active'=>0, 'subscription_detail'=>$reason, 'expired_at'=>Carbon::now()]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.customer.subscription.cancelled' && isset($subscription)){
            $subscription->update(['is_active'=>0, 'subscription_detail'=>$reason, 'expired_at'=>Carbon::now()]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.customer.subscription.expiring' && isset($subscription)){
            $subscription->update(['subscription_detail'=>$reason]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.customer.subscription.expired' && isset($subscription)){
            $subscription->update(['is_active'=>0, 'subscription_detail'=>$reason, 'expired_at'=>Carbon::now()]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }
        if($eventType == 'net.authorize.customer.subscription.failed' && isset($subscription)){
            $subscription->update(['is_active'=>0, 'subscription_detail'=>$reason, 'expired_at'=>Carbon::now()]);
             $user = User::find($subscription->user_id);
            if($user){
                $user->expired_at = Carbon::now();
                $user->save();
            }
        }

        // Log the extracted data
        \Log::info('Event Type: ' . $eventType);
        \Log::info('Subscription ID: ' . $subscriptionId);
        \Log::info('Reason: ' . $reason);
    }
}
