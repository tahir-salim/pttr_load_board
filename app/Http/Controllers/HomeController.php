<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\EquipmentType;
use App\Models\State;
use App\Models\Shipment;
use App\Models\UserDeviceToken;
use App\Models\CustomerPaymentProfile;



class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (auth()->check()) {
            $equipment_types = EquipmentType::get();
                 $states = State::select('id','code','name')->where('country_id',233)->orderBy('code','ASC')->get();
                 $selectedTypes = isset($request->types) ? $request->types   : ['all_type'];
                if(isset($request->types) && count($request->types) > 0 && !in_array('all_type', $selectedTypes)){
                    foreach($states as $key => $state){
                      $ms = (int)count($request->types).'00';
                      $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['code'] = $state->code;
                      $shipments[$key]['name'] = $state->name;
                    }
                }else{
                     $ms = (int)count($equipment_types).'00';
                    foreach($states as $key => $state){
                      $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['code'] = $state->code;
                      $shipments[$key]['name'] = $state->name;
                    }
                }
            return redirect()->route(auth()->user()->type . '.dashboard', get_defined_vars());
        } else {
            return redirect()->route('login');
        }

    }

    public function SuperAdminDashboard(Request $request): View
    {
         $equipment_types = EquipmentType::get();
                 $states = State::select('id','code','name')->where('country_id',233)->orderBy('code','ASC')->get();
                 $selectedTypes = isset($request->types) ? $request->types   : ['all_type'];
                if(isset($request->types) && count($request->types) > 0 && !in_array('all_type', $selectedTypes)){
                    foreach($states as $key => $state){
                         $ms = (int)count($request->types).'00';
                      $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['code'] = $state->code;
                      $shipments[$key]['name'] = $state->name;
                    }
                }else{
                    $ms = (int)count($equipment_types).'00';
                    foreach($states as $key => $state){
                       $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['code'] = $state->code;
                      $shipments[$key]['name'] = $state->name;
                    }
                }
        
        return view('Admin.dashboard',get_defined_vars());
    }

    public function truckerDashboard(Request $request)
    {
         $equipment_types = EquipmentType::get();
         $states = State::select('id','code','name')->where('country_id',233)->orderBy('code','ASC')->get();
          $selectedTypes = isset($request->types) ? $request->types   : ['all_type'];
        if(isset($request->types) && count($request->types) > 0 && !in_array('all_type', $selectedTypes)){
            foreach($states as $key => $state){
                    $ms = (int)count($request->types).'00';
                    $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                    $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                    $shipments[$key]['code'] = $state->code;
                    $shipments[$key]['name'] = $state->name;
            }
        }else{
            $ms = (int)count($equipment_types).'00'; 
            foreach($states as $key => $state){
                    $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['code'] = $state->code;
                      $shipments[$key]['name'] = $state->name;
            }
        }
        return view('Global.dashboard',get_defined_vars());
    }
    
    
    public function comboDashboard(Request $request)
    { 
          $equipment_types = EquipmentType::get();
         $states = State::select('id','code','name')->where('country_id',233)->orderBy('code','ASC')->get();
         $selectedTypes = isset($request->types) ? $request->types   : ['all_type'];
        if(isset($request->types) && count($request->types) > 0 && !in_array('all_type', $selectedTypes)){
            $ms = (int)count($request->types).'00';
            foreach($states as $key => $state){
                 $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                    $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                    $shipments[$key]['code'] = $state->code;
                    $shipments[$key]['name'] = $state->name;
            }
        }else{
            $ms = (int)count($equipment_types).'00'; 
            foreach($states as $key => $state){
             $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['code'] = $state->code;
                      $shipments[$key]['name'] = $state->name;
            }
        }
       
        
       
        return view('Global.dashboard',get_defined_vars());
    }

    public function shipperDashboard(Request $request): View
    {    
        $equipment_types = EquipmentType::get();
         $states = State::select('id','code','name')->where('country_id',233)->orderBy('code','ASC')->get();
       $selectedTypes = isset($request->types) ? $request->types   : ['all_type'];
        if(isset($request->types) && $request->types > 0 && !in_array('all_type', $selectedTypes)){
            foreach($states as $key => $state){
              $shipments[$key]['in'] = Shipment::where(function($query) use ($state){
                  $query->where('origin_state_id', $state->id);
              })->whereNotIn('status',['COMPLETE'])->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + 100;
              
              $shipments[$key]['out'] = Shipment::where(function($query) use ($state){
                  $query->where('destination_state_id', $state->id);
              })->whereIn('status',['COMPLETE'])->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + 100;
              $shipments[$key]['code'] = $state->code;
              $shipments[$key]['name'] = $state->name;
            }
        }else{
             $ms = (int)count($equipment_types).'00'; 
            foreach($states as $key => $state){
            $shipments[$key]['in'] = Shipment::where(function($query) use ($state){
                  $query->where('origin_state_id', $state->id);
              })->whereNotIn('status',['COMPLETE'])->where('is_post',1)->count() + $ms;
              
              $shipments[$key]['out'] = Shipment::where(function($query) use ($state){
                  $query->where('destination_state_id', $state->id);
              })->whereIn('status',['COMPLETE'])->where('is_post',1)->count() + $ms;
              $shipments[$key]['code'] = $state->code;
              $shipments[$key]['name'] = $state->name;
            }
        }
        return view('Global.dashboard',get_defined_vars());
    }

    public function brokerDashboard(Request $request): View
    {
         $equipment_types = EquipmentType::get();
                 $states = State::select('id','code','name')->where('country_id',233)->orderBy('code','ASC')->get();
               $selectedTypes = isset($request->types) ? $request->types   : ['all_type'];
                if(isset($request->types) && count($request->types) > 0 && !in_array('all_type', $selectedTypes)){
                        $ms = (int)count($request->types).'00';
                    foreach($states as $key => $state){
                        $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                        $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->whereIn('eq_type_id', $request->types)->where('is_post',1)->count() + $ms;
                        $shipments[$key]['code'] = $state->code;
                        $shipments[$key]['name'] = $state->name;
                    }
                }else{
                     $ms = (int)count($equipment_types).'00'; 
                    foreach($states as $key => $state){
                     $shipments[$key]['in'] = Shipment::where('destination_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['out'] = Shipment::where('origin_state_id', $state->id)->where('is_post',1)->count() + $ms;
                      $shipments[$key]['code'] = $state->code;
                      $shipments[$key]['name'] = $state->name;
                    }
                }
        return view('Global.dashboard',get_defined_vars());
    }

    public function feedback(): View
    {
        return view('Global.feedback-form');
    }

    public function feedbackSubmit(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $feedback = new Feedback;
        $feedback->name = $user->name;
        $feedback->email = $user->email;
        $feedback->message = $request->message;
        $feedback->user_id = $user->id;
        $feedback->save();
        // dd('abc');

        return back()->with('success', "Feedback Form Submitted Successfully!");
    }

    public function updateSubscription()
    {
        // dd(auth()->user());
            $customerPaymentProfile = CustomerPaymentProfile::where('customer_profile_id',auth()->user()->subscriptions[0]->customer_profile_id)->where('live_mode', 1)->first();
        if($customerPaymentProfile)
        {
            $expirationDate = explode('-', $customerPaymentProfile->expired_at);
            $expiryYear = $expirationDate[0];
            $expiryMonth = $expirationDate[1];
        }else{
            return redirect()->route(auth()->user()->type.'.user_profile')->with('error','Customer Profile Not Exist Please Create New User, Subscription may expired.');
        }
        return view('auth.update-subscription',get_defined_vars());
    }

    public function contactOwner(){
        return view('auth.contact-owner');

    }


    public function saveToken(Request $request)
    {

        $UserDeviceToken = UserDeviceToken::where('device_token' , $request->oldToken)->where('user_id',auth()->user()->id)->first();
        if($UserDeviceToken){
            $UserDeviceToken->device_token = $request->token;
            $UserDeviceToken->save();
        }else{
            $UserDeviceToken = new UserDeviceToken();
            $UserDeviceToken->user_id = auth()->user()->id;
            $UserDeviceToken->device_token = $request->token;
            $UserDeviceToken->save();
        }

        return response()->json(['token saved successfully.']);
    }
}
