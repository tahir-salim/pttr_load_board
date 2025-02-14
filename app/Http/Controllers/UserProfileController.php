<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\OnboardingProfile;
use App\Models\OnboardPrefredAreas;
use App\Models\OnboardPrefredLanes;
use App\Models\OnboardPrefredRefrence;
use App\Models\OnboardProfileFiles;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use File;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function user_profile()
    {
        $user = Auth::user();
        $split = explode(" ", $user->name);
        $firstname = array_shift($split);
        $lastname = implode(" ", $split);
        return view('Global.user-profile', get_defined_vars());
    }
    public function user_company_profile()
    {
        if(auth()->user()->parent_id != null){
            $company = Company::where('user_id',auth()->user()->parent_id)->first();
        }else{
            $company = Company::where('user_id', auth()->user()->id)->first();
        }
        // dd($company);
        return view('Global.company-profile', get_defined_vars());
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


    public function  privacy_policy(){

        return view('Global.privacy-policy');
    }


    public function  term_and_conditions(){

        return view('Global.term-and-conditions');
    }



    public function on_boarding_proflie()
     {
          $onboarding_profile = OnboardingProfile::where('user_id', auth()->user()->id)->first();
          if ($onboarding_profile != null) {
               $onboarding_file =  OnboardProfileFiles::where('form_id', $onboarding_profile->id)->first();
          } else {
               $onboarding_file = null;
          }
          return view('Global.on-boarding-profile', compact('onboarding_profile', 'onboarding_file'));
     }

     public function onboarding_files($file_name, $file_type, $form_id)
     {
          $file_key = 'step_file_id_' . rand();
          $img_2 =  time() . $file_name->getClientOriginalName();
          $file_name->move(public_path('assets/images/onboarding_files'), $img_2);

          $onboarding_file = new OnboardProfileFiles;
          $onboarding_file->file_name = $img_2;
          $onboarding_file->file_type = $file_type;
          $onboarding_file->file_keys = $file_key;
          $onboarding_file->form_id = $form_id;
          $onboarding_file->save();
     }

     public function save_onboarding_profile_step_1(Request $request)
     {
          //  return response()->json()
          // dd($request->all());
          $profile = new OnboardingProfile;
          $profile->user_id = Auth::user()->id;
          $profile->company_type = $request->company_type;
          $profile->year_founded = $request->year_founded;
          $profile->scac = $request->scac;
          $profile->own_by = $request->own_by;
          
           if($request->has('own_by'))
          {
              $profile->own_by = $request->own_by;
              if($request->own_by == "Minorityowned"){
                  $profile->minority_type = $request->minority_type;
                  $profile->is_certified_msdsc = $request->is_certified_msdsc;
              }
          }else{
               $profile->own_by = null;
               $profile->minority_type  = null;
               $profile->is_certified_msdsc = null;
          }
         
          
          if ($request->has_factory_company == "true") {
               $profile->has_factory_company = 'yes';
               $profile->factory_name = $request->factory_name;
               $profile->street = $request->street;
               $profile->city = $request->city;
               $profile->state = $request->state;
               $profile->postal_code = $request->postal_code;
               $profile->phone_num = $request->phone_num;
               $profile->extansion = $request->extansion;
          }else{
              $profile->has_factory_company = 'no';
          }
          $profile->save();
          if ($request->hasFile('factoring_company_files')) {
               $file_type = "step_1_file";
               $this->onboarding_files($request->factoring_company_files, $file_type, $profile->id);
          }
          // $profile->save();
          return response()->json([
               'message' => 'succss'
          ]);
     }

     public function save_onboarding_profile_step_2(Request $request)
     {
          // dd($request->all());
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->officer_name = $request->officer_name;
          $profile->officer_phone = $request->officer_phone;
          $profile->officer_ext = $request->officer_ext;
          $profile->officer_email = $request->officer_email;

          $profile->officer_title = $request->officer_title;
          $profile->officer_fax = $request->officer_fax;
          $profile->officer_is_primary = $request->officer_is_primary;
          $profile->accounting_name = $request->accounting_name;
          $profile->accounting_phone = $request->accounting_phone;
          $profile->accounting_ext = $request->accounting_ext;
          $profile->accounting_email = $request->accounting_email;
          $profile->accounting_title = $request->accounting_title;

          $profile->accounting_fax = $request->accounting_fax;
          $profile->accounting_is_primary = $request->accounting_is_primary;
          $profile->operation_name = $request->operation_name;
          $profile->operation_phone = $request->operation_phone;
          $profile->operation_ext = $request->operation_ext;
          $profile->operation_email = $request->operation_email;
          $profile->operation_title = $request->operation_title;
          $profile->operation_fax = $request->operation_fax;
          $profile->operation_is_primary = $request->operation_is_primary;

          $profile->safety_name = $request->safety_name;
          $profile->safety_phone = $request->safety_phone;
          $profile->safety_ext = $request->safety_ext;
          $profile->safety_email = $request->safety_email;
          $profile->safety_title = $request->safety_title;
          $profile->safety_fax = $request->safety_fax;
          $profile->safety_is_primary = $request->safety_is_primary;

          $profile->emergency_name = $request->emergency_name;
          $profile->emergency_phone = $request->emergency_phone;
          $profile->emergency_ext = $request->emergency_ext;
          $profile->emergency_email = $request->emergency_email;
          $profile->emergency_title = $request->emergency_title;
          $profile->emergency_fax = $request->emergency_fax;
          $profile->emergency_is_primary = $request->emergency_is_primary;
          $profile->steps_completed = 1;
          $profile->save();
            // dd($request->all());
          if ($request->has('name')) {
               // dd($request->name);
               $refrences = new OnboardPrefredRefrence;
               $refrences->name = $request->name;
               $refrences->company = $request->company;
               $refrences->company_phone = $request->company_phone;
               $refrences->company_ext = $request->company_ext;
               $refrences->form_id = $profile->id;
               $refrences->save();
               // }
          }

          return response()->json([
               'message' => 'succss'
          ]);
     }
     public function save_onboarding_profile_step_3(Request $request)
     {
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->steps_completed = 2;
          $profile->number_of_power_units = $request->number_of_power_units;
          $profile->number_of_owner_operators = $request->number_of_owner_operators;
          $profile->number_of_company_drivers = $request->number_of_company_drivers;
          $profile->number_of_teams = $request->number_of_teams;
          $profile->on_board_contractors = $request->on_board_contractors;
          $profile->save();
        //   $profile->equip_number_of_power_units = $request->equip_number_of_power_units;
        //   $profile->equip_number_of_owner_operators = $request->equip_number_of_owner_operators;
        //   $profile->equip_number_of_company_drivers = $request->equip_number_of_company_drivers;
        //   $profile->equip_number_of_teams = $request->equip_number_of_teams;
        //   $profile->equip_board_comm = $request->equip_board_comm;
        //   $profile->dangerous_goods = $request->dangerous_goods;
        //   $profile->have_hazmat_certification = $request->have_hazmat_certification;
        //   $file_type = "step_3_file";
        //   if($request->hasFile('hammar_certificate_file')){
        //       $this->onboarding_files($request->hammar_certificate_file, $file_type, $profile->id);
        //   }

          return response()->json([
               'message' => 'succss'
          ]);
     }

     public function save_onboarding_profile_step_4(Request $request)
     {
           $form_Id = auth()->user()->onboardingProfile->id;
          if ($request->has('origin') && $request->origin[0] != null) {
               foreach ($request->origin as $key => $lanes) {
                    $prefered_lanes = new OnboardPrefredLanes;
                    $prefered_lanes->form_id = $form_Id;
                    $prefered_lanes->origin = $lanes;
                    $prefered_lanes->destination = $request->destination[$key];
                    $prefered_lanes->save();
               }
          }
        
          if ($request->has('canada_maxico') && $request->canada_maxico[0] != null){
               foreach ($request->canada_maxico as $key => $areas) {
                    $prefered_areas = new OnboardPrefredAreas();
                    $prefered_areas->areas_canada_maxico = 'yes';
                    $prefered_areas->form_id =  $form_Id;
                    $prefered_areas->all_areas_of_canada = $areas;
                    $prefered_areas->save();
               }
          }
          
          
          if($request->has('united_states_zones') && $request->united_states_zones[0] != null) {
                foreach ($request->united_states_zones as $usa_zoness) {
                    $prefered_areas = new OnboardPrefredAreas();
                    $prefered_areas->areas_united_states = 'yes';
                    $prefered_areas->form_id =  $form_Id;
                    $prefered_areas->all_areas_of_usa = $usa_zoness;
                    $prefered_areas->save();
                }
              }

          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->update(array(
               'steps_completed' => 3,
          ));
          return response()->json([
               'message' => 'succss'
          ]);
     }

     public function save_onboarding_profile_step_5(Request $request){
          // dd($request->all());
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->steps_completed = 4;
          $profile->name_on_tax_file = $request->name_on_tax_file;
          $profile->business_entity_name = $request->business_entity_name;
          $profile->tax_classification = $request->tax_classification;
          $profile->exempt_payee_code = $request->exempt_payee_code;
          $profile->reporting_code = $request->reporting_code;
          $profile->exemption_address = $request->exemption_address;
          $profile->exemption_city = $request->exemption_city;
          $profile->exemption_state = $request->exemption_state;
          $profile->exemption_zip_code = $request->exemption_zip_code;
          $profile->ssn = $request->ssn;
          $profile->ian = $request->ian;
          $profile->save();

          return response()->json([
               'message' =>'succss'
          ]);
     }

     public function save_onboarding_profile_step_6(Request $request){

          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->steps_completed = 5;
          $profile->doc_name = $request->doc_name;
          $profile->doc_type = $request->doc_type;
          $profile->doc_description = $request->doc_description;
          $profile->save();

          if ($request->hasFile('doc_file')) {
               $file_type = "step_6_file";
               $this->onboarding_files($request->doc_file, $file_type, $profile->id);
          }

          return response()->json([
               'message' =>'succss'
          ]);
     }

     public function save_onboarding_profile_step_7(Request $request){
         
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->steps_completed = 6;
          $profile->coverage_auto = isset($request->coverage_auto) ? $request->coverage_auto : null ;
          $profile->coverage_cargo = isset($request->coverage_cargo) ?  $request->coverage_cargo : null;
          $profile->coverage_general = isset($request->coverage_general) ?  $request->coverage_general : null;
          $profile->coverage_workers_comp = isset($request->coverage_workers_comp) ?  $request->coverage_workers_comp : null;
          $profile->insurance_agent = isset($request->insurance_agent) ?   $request->insurance_agent  : null;
          $profile->insurance_phone = $request->insurance_phone;
          $profile->insurance_ext = $request->insurance_ext;
          $profile->insurance_email = $request->insurance_email;
          $profile->insurance_fax = $request->insurance_fax;
          $profile->save();

          if ($request->hasFile('insurance_certificate')) {
               $file_type = "step_6_file";
               $this->onboarding_files($request->insurance_certificate, $file_type, $profile->id);
          }

          return response()->json([
               'message' =>'succss'
          ]);
     }
     
     public function save_onboarding_profile_step_8(Request $request){
         
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->update(array(
               'steps_completed' => 7,
          ));
          return response()->json([
               'message' =>'succss'
          ]);
     }
     
     public function update_profile(Request $request){
          $request->validate([
               'phone' => ['required', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
          ]);
          User::where('id',auth()->user()->id)->update(array(
               'name' => $request->firstname.' '.$request->lastname,
                'phone' => $request->phone, 
          ));
          return redirect()->back()->with('success', 'Profile Updated Successfully');
     }

     public function update_company_profile(Request $request){
          $request->validate([
               'company_phone' => ['required', 'regex:/^\(\d{3}\) \d{3}-\d{4}$/'],
          ]);
          Company::where('user_id',auth()->user()->id)->update(array(
                'email' => $request->company_address,
               'phone' => $request->company_phone, 
          ));
          return redirect()->back()->with('success', 'Profile Updated Successfully');
    }
         
     public function get_cities($state){
          $cities = City::where('state_id', $state)->orderBy('name','ASC')->get();
          return response()->json(['cities' => $cities]);
     }
     
     
      public function show_onboarding_profile(){
          $onboarding_profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          // dd($profile);
          if ($onboarding_profile != null) {
               $onboarding_file =  OnboardProfileFiles::where('form_id', $onboarding_profile->id);
          } else {
               $onboarding_file = null;
          }
          // dd($onboarding_file->get());
          // dd($onboarding_file->where('file_type','step_6_file')->get());
          $onboarding_refrnces = OnboardPrefredRefrence::where('form_id', $onboarding_profile->id)->first();
          $onboarding_canada_areas = OnboardPrefredAreas::where('form_id', $onboarding_profile->id)->where('all_areas_of_canada', '!=', null)->get();
          $onboarding_unitedstates_areas = OnboardPrefredAreas::where('form_id', $onboarding_profile->id)->where('all_areas_of_usa', '!=', null)->get();

          $onboard_lanes = OnboardPrefredLanes::where('form_id', $onboarding_profile->id)->get();
          return view('Global.show-onboarding-profile', get_defined_vars());
     }


     public function update_onboarding_profile_step_1(Request $request)
     {
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->user_id = Auth::user()->id;
          $profile->company_type = $request->company_type;
          $profile->year_founded = $request->year_founded;
          $profile->scac = $request->scac;
          
          if($request->has('own_by'))
          {
              $profile->own_by = $request->own_by;
              if($request->own_by == "Minorityowned"){
                  $profile->minority_type = $request->minority_type;
                  $profile->is_certified_msdsc = $request->is_certified_msdsc;
              }else{
                   $profile->minority_type  = null;
                  $profile->is_certified_msdsc = null;
              }
              
          }else{
               $profile->own_by = null;
               $profile->minority_type  = null;
               $profile->is_certified_msdsc = null;
          }
          
         
           if ($request->has_factory_company == "true") {
               $profile->has_factory_company = 'yes';
               $profile->factory_name = $request->factory_name;
               $profile->street = $request->street;
               $profile->city = $request->city;
               $profile->state = $request->state;
               $profile->postal_code = $request->postal_code;
               $profile->phone_num = $request->phone_num;
               $profile->extansion = $request->extansion;
          }else{
               $onboardfiles =  OnboardProfileFiles::where('form_id',$profile->id)->where('file_type', 'step_1_file')->get();
               if(count($onboardfiles) > 0){
                   foreach($onboardfiles as $onboardfile){
                       
                        if (File::exists(public_path('assets/images/onboarding_files/'. $onboardfile->file_name))) {
                             File::delete(public_path('assets/images/onboarding_files/'. $onboardfile->file_name));
                         }
                       $onboardfile->delete();
                   }
               }
               $profile->has_factory_company = 'no';
               $profile->factory_name = null ;
               $profile->state = null ;
               $profile->street = null;
               $profile->city = null;
               $profile->postal_code = null;
               $profile->phone_num = null;
               $profile->extansion = null;
          }
          $profile->save();

          if ($request->hasFile('factoring_company_files')) {
               $file_type = "step_1_file";
               $this->onboarding_files($request->factoring_company_files, $file_type, $profile->id);
          }
          // $profile->save();
          return response()->json([
               'message' => 'succss'
          ]);
     }


     public function update_onboarding_profile_step_2(Request $request){
         
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          
          $profile->officer_name = $request->officer_name;
          $profile->officer_phone = $request->officer_phone;
          $profile->officer_ext = $request->officer_ext;
          $profile->officer_email = $request->officer_email;

          $profile->officer_title = $request->officer_title;
          $profile->officer_fax = $request->officer_fax;
          $profile->officer_is_primary = $request->officer_is_primary;
          $profile->accounting_name = $request->accounting_name;
          $profile->accounting_phone = $request->accounting_phone;
          $profile->accounting_ext = $request->accounting_ext;
          $profile->accounting_email = $request->accounting_email;
          $profile->accounting_title = $request->accounting_title;

          $profile->accounting_fax = $request->accounting_fax;
          $profile->accounting_is_primary = $request->accounting_is_primary;
          $profile->operation_name = $request->operation_name;
          $profile->operation_phone = $request->operation_phone;
          $profile->operation_ext = $request->operation_ext;
          $profile->operation_email = $request->operation_email;
          $profile->operation_title = $request->operation_title;
          $profile->operation_fax = $request->operation_fax;
          $profile->operation_is_primary = $request->operation_is_primary;

          $profile->safety_name = $request->safety_name;
          $profile->safety_phone = $request->safety_phone;
          $profile->safety_ext = $request->safety_ext;
          $profile->safety_email = $request->safety_email;
          $profile->safety_title = $request->safety_title;
          $profile->safety_fax = $request->safety_fax;
          $profile->safety_is_primary = $request->safety_is_primary;
          $profile->emergency_name = $request->emergency_name;
          $profile->emergency_phone = $request->emergency_phone;
          $profile->emergency_ext = $request->emergency_ext;
          $profile->emergency_email = $request->emergency_email;
          $profile->emergency_title = $request->emergency_title;
          $profile->emergency_fax = $request->emergency_fax;
          $profile->emergency_is_primary = $request->emergency_is_primary;
          $profile->save();
                OnboardPrefredRefrence::where('form_id',$profile->id)->delete();
          if ($request->has('name') && $request->name != null) {
               $refrences = new OnboardPrefredRefrence;
               $refrences->name = $request->name;
               $refrences->company = $request->company;
               $refrences->company_phone = $request->company_phone;
               $refrences->company_ext = $request->company_ext;
               $refrences->form_id = $profile->id;
               $refrences->save();
               // }
          }

          return response()->json([
               'message' => 'succss'
          ]);
     }

     public function update_onboarding_profile_step_3(Request $request){
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->number_of_power_units = $request->number_of_power_units;
          $profile->number_of_owner_operators = $request->number_of_owner_operators;
          $profile->number_of_company_drivers = $request->number_of_company_drivers;
          $profile->number_of_teams = $request->number_of_teams;
          $profile->on_board_contractors = $request->on_board_contractors;
        //   $profile->equip_number_of_power_units = $request->equip_number_of_power_units;
        //   $profile->equip_number_of_owner_operators = $request->equip_number_of_owner_operators;
        //   $profile->equip_number_of_company_drivers = $request->equip_number_of_company_drivers;
        //   $profile->equip_number_of_teams = $request->equip_number_of_teams;
        //   $profile->equip_board_comm = $request->equip_board_comm;
        //   $profile->dangerous_goods = $request->dangerous_goods;
        //   $profile->have_hazmat_certification = $request->have_hazmat_certification;
        //   $profile->certified_radio_active = $request->certified_radio_active;
          $profile->save();
        //   $file_type = "step_3_file";
        //   if($request->hasFile('hammar_certificate_file')){
        //       $this->onboarding_files($request->hammar_certificate_file, $file_type, $profile->id);
        //   }

          return response()->json([
               'message' => 'succss'
          ]);
     }


     public function update_onboarding_profile_step_4(Request $request){
          // dd($request->all());
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          
          $OnboardPrefredAreas = OnboardPrefredAreas::where('form_id', $profile->id)->delete();
          $OnboardPrefredLanes = OnboardPrefredLanes::where('form_id', $profile->id)->delete();
          
          
          if ($request->has('origin') && $request->origin[0] != null) {

               foreach ($request->origin as $key => $lanes) {
                    $prefered_lanes = new OnboardPrefredLanes;
                    $prefered_lanes->form_id = $profile->id;
                    $prefered_lanes->origin = $lanes;
                    $prefered_lanes->destination = $request->destination[$key];
                    $prefered_lanes->save();
               }
          } 
         
          if ($request->has('canada_maxico') && $request->canada_maxico[0] != null){

               foreach ($request->canada_maxico as $key => $areas) {
                    $prefered_areas = new OnboardPrefredAreas();
                    $prefered_areas->areas_canada_maxico = 'yes';
                    $prefered_areas->form_id =  $profile->id;
                    $prefered_areas->all_areas_of_canada = $areas;
                    $prefered_areas->save();
                }
          }
          
          if($request->has('united_states_zones') && $request->united_states_zones[0] != null) {

                foreach ($request->united_states_zones as $usa_zoness) {
                    $prefered_areas = new OnboardPrefredAreas();
                    $prefered_areas->areas_united_states = 'yes';
                    $prefered_areas->form_id =  $profile->id;
                    $prefered_areas->all_areas_of_usa = $usa_zoness;
                    $prefered_areas->save();
                }
          }
 
          return response()->json([
               'message' => 'succss'
          ]);
          
     }


     public function update_onboarding_profile_step_6(Request $request){
          
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->doc_name = $request->doc_name;
          $profile->doc_type = $request->doc_type;
          $profile->doc_description = $request->doc_description;
          $profile->save();

          if ($request->hasFile('doc_file')) {
              $onboardfiles =  OnboardProfileFiles::where('form_id',$profile->id)->where('file_type', 'step_6_file')->get();
               if(count($onboardfiles) > 0){
                   foreach($onboardfiles as $onboardfile){
                       
                        if (File::exists(public_path('assets/images/onboarding_files/'. $onboardfile->file_name))) {
                             File::delete(public_path('assets/images/onboarding_files/'. $onboardfile->file_name));
                         }
                       $onboardfile->delete();
                   }
               }
               
               
               $file_type = "step_6_file";
               $this->onboarding_files($request->doc_file, $file_type, $profile->id);
          }

          return response()->json([
               'message' =>'succss'
          ]);
     }

     public function update_onboarding_profile_step_7(Request $request){
         
          $profile = OnboardingProfile::where('user_id', Auth::user()->id)->first();
          $profile->coverage_general = $request->coverage_general;
          $profile->coverage_workers_comp = $request->coverage_workers_comp;

          $profile->coverage_auto = isset($request->coverage_auto) ? $request->coverage_auto : null ;
          $profile->coverage_cargo = isset($request->coverage_cargo) ?  $request->coverage_cargo : null;
          $profile->coverage_general = isset($request->coverage_general) ?  $request->coverage_general : null;
          $profile->coverage_workers_comp = isset($request->coverage_workers_comp) ?  $request->coverage_workers_comp : null;
          $profile->insurance_agent = $request->insurance_agent;
          $profile->insurance_phone = $request->insurance_phone;
          $profile->insurance_ext = $request->insurance_ext;
          $profile->insurance_email = $request->insurance_email;

          $profile->insurance_fax = $request->insurance_fax;
          $profile->save();
          if ($request->hasFile('insurance_certificate')) {
              
              $onboardfiles =  OnboardProfileFiles::where('form_id',$profile->id)->where('file_type', 'step_7_file')->get();
               if(count($onboardfiles) > 0){
                   foreach($onboardfiles as $onboardfile){
                       
                        if (File::exists(public_path('assets/images/onboarding_files/'. $onboardfile->file_name))) {
                             File::delete(public_path('assets/images/onboarding_files/'. $onboardfile->file_name));
                         }
                       $onboardfile->delete();
                   }
               }
              
               $file_type = "step_7_file";
               $this->onboarding_files($request->insurance_certificate, $file_type, $profile->id);
          }

          return response()->json([
               'message' =>'succss'
          ]);  
     }


    public function on_boarding_proflie_notify()
    {
        return view('Global.on-boarding-proflie-notify');
    }
    




}
