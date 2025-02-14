<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\OnboardingProfile;
use App\Models\OnboardPrefredAreas;
use App\Models\OnboardPrefredLanes;
use App\Models\OnboardPrefredRefrence;
use App\Models\OnboardProfileFiles;
use App\Models\CustomerPaymentProfile;


class AdminUserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select("*")->where('type', '!=', 0)->orderBy('created_at', 'DESC');
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->addIndexColumn()
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<a class="badge badge-success" onclick="return confirm(`Are you sure you want to In-Active User`)" href="' . route(auth()->user()->type . ".change_user_status", [$row->id]) . '" tile="" >Active</a>';

                } else {
                    return '<a class="badge badge-danger" onclick="return confirm(`Are you sure you want to Active User`)" href="' . route(auth()->user()->type . ".change_user_status", [$row->id]) . '" tile="">InActive</a>';
                }
            })
            
            ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    if ($row->type == 'trucker') {
                        return '<span class="badge badge-primary">Trucker</span>';
                    } elseif ($row->type == 'shipper') {
                        return '<span class="badge badge-warning">Shipper</span>';
                    }
                    elseif ($row->type == 'broker') {
                        return '<span class="badge badge-warning">Broker</span>';
                    } else {
                        return '<span class="badge badge-danger">Combo</span>';
                    }
                })->addColumn('actions', function ($row) {
                    $actions = '';
                    if(auth()->user()->parent_id == null){
                        $actions .='<div class="d-flex btnWrap"><a onclick="return confirm(`Are you sure you want to Delete this User And Cancel Subscription`)" href="'.route('super-admin.billing.destroy', [$row->id]) . '" class="fa fa-trash-alt btn btn-outline-danger"></a></div>';
                    }
                    $actions .='<div class="d-flex btnWrap"><a href="'.route('super-admin.user_details', [$row->id]) . '" class="fa fa-eye btn btn-outline-primary"></a></div>';
                    return $actions;
                    
                 })->addColumn('has_parent', function ($row) {
                         if($row->parent_id != null){
                           $details = '<a href="'.route("super-admin.user_details",$row->parentUser->id).'">'.$row->parentUser->name.' <br> <small>'.$row->parentUser->email.'</small></a> '; 
                        }else{
                            $details = 'N/A';
                        }
                        return $details;

                 })->filter(function ($instance) use ($request) {
                    if ($request->get('type') == 0) {
                        $instance->where('type', '!=', 0);
                    } elseif ($request->get('type') == 1 || $request->get('type') == 2 || $request->get('type') == 3 || $request->get('type') == 4) {
                        $instance->where('type', $request->get('type'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhere('phone', 'LIKE', "%$search%")
                                ->orWhere('alt_phone', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['type','status','has_parent','actions'])
                ->make(true);
        }

        return view('Admin.User.index', get_defined_vars());
    }

    public function user_profile()
    {
        $user = Auth::user();
        $split = explode(" ", $user->name);
        $firstname = array_shift($split);
        $lastname = implode(" ", $split);
        
        return view('Admin.User.user-profile',get_defined_vars());
    }
    
    public function user_details($id){
              $user = User::with('company')->where('id',$id)->first();
        if(!$user){
            abort(404);
        }
        $user_chi = null;
      
        if($user->parent_id != null){
            $user_chi = User::where('id', $user->parent_id)->first();
        }
        if($user->type != "broker"){
                if($user_chi){
                    $user_id = $user_chi->id;
                }else{
                    $user_id = $user->id;
                }
                $onboarding_profile = OnboardingProfile::where('user_id', $user_id)->first();
                if ($onboarding_profile != null) {
                    $onboarding_file =  OnboardProfileFiles::where('form_id', $onboarding_profile->id);
                    $onboarding_refrnces = OnboardPrefredRefrence::where('form_id', $onboarding_profile->id)->first();
                    $onboarding_canada_areas = OnboardPrefredAreas::where('form_id', $onboarding_profile->id)->where('all_areas_of_canada', '!=', null)->get();
                    $onboarding_unitedstates_areas = OnboardPrefredAreas::where('form_id', $onboarding_profile->id)->where('all_areas_of_usa', '!=', null)->get();
                    $onboard_lanes = OnboardPrefredLanes::where('form_id', $onboarding_profile->id)->get();
                } else {
                    $onboarding_file = null;
                }  
        }
        
        if($user->subscriptions){
            $subscription = $user->subscriptions->last();
            
            if($subscription){
                 $customer_payment_profile = CustomerPaymentProfile::where('customer_profile_id', $subscription->customer_profile_id)
                 ->where('live_mode', 1)->first();
                 if($customer_payment_profile != null){
                    $card_4_digits = decrypt($customer_payment_profile->card_no);
                    $maskedNumber = str_repeat('*', strlen($card_4_digits) - 4) . substr($card_4_digits, -4);
                     
                 }else{
                     $maskedNumber = '------';
                 }
            }else{
                     $maskedNumber = '------';
            }
        }else{
                     $maskedNumber = '------';
        }
        
        
        
        return view('Admin.User.user-details',get_defined_vars());
    }
    
    
    

    public function changeStatus($id)
    {
        $user = User::find($id);
        if ($user->status == 1) {
            $user->status = 0;
            $user->save();
        } else {
            $user->status = 1;
            $user->save();
        }
        return back()->with('success', 'Status Changed Successfully');
    }
    
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'min:8','same:new_password']
        ]);
        
        // $user = User::find($id);
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with('error','Wrong Old Password');
        }
        
        $changePassword = User::find(auth()->user()->id);
        $changePassword->password = Hash::make($request->new_password);
        $changePassword->save();
        
        return redirect()->back()->with('success','Password Changed Successfully Login to your New Password');
    }

}
