<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required' ,'min:14']
        ],[
            'phone.min' => 'Phone Number is Invalid',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
        ]);

        $user->sendEmailVerificationNotification();

        return $user;
    }

    public function pricing()

    {
        $packages = Package::all();
        // dd($packages);
        return view('auth.pricing',get_defined_vars());
    }

    public function signUpForm1(Request $request,$id)
    {
        // dd($id);
        session()->forget(['seatsData', 'companyData', 'ownerPackage', 'userData', 'allAmount']);
        $ownerPackage = ['package_id'=>$id];
        session()->put('ownerPackage', $ownerPackage);
        
      
        if ($request->first_name) {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required' ,'min:14']
        ],[
            'phone.min' => 'Phone Number is Invalid',
        ]);
            $userData = [
                'first_name' => $request->first_name,
                'last_name'=>$request->last_name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'seats' => $request->seats == null ?  0 : $request->seats
            ];
                // $check_email = User::where('email', $request->email)->first();

                // if($check_email != null){
                //     return redirect()->back()->with('error','Email is already registred.');
                // }
            session()->put('userData', $userData);

            // dd(session()->get('userData'));

            return redirect()->route('signup_step2');
        }

        return view('auth.signup-form-1');
    }

    public function signUpForm2(Request $request)
    {
        if(session()->get('userData') == null){
            return redirect()->route('pricing');
        }
        $userData = session()->get('userData');

        return view('auth.signup-form-2', get_defined_vars());
    }

    public function lcNumber(Request $request)
    {
        if ($request->ajax()) {
            if ($request->mc_no != null) {
                
                if(Company::where('mc',$request->mc_no)->first()){
                        return response()->json(['error' => 'Company MC Number Already Exist On This Portal']);
                }

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://mobile.fmcsa.dot.gov/qc/services/carriers/docket-number/' . $request->mc_no . '?webKey=07d4ca1bfa3cdd68071d3aae89050b1e4568ebe4',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'content-type: application/json',
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $products = json_decode($response, true);
                if ($products == null || $products['content'] == [] || gettype($products['content']) == "string") {
                    return response()->json(['error' => 'record not found']);
                } else {
                    if($products['content'][0]['carrier']['commonAuthorityStatus'] == "A" || $products['content'][0]['carrier']['brokerAuthorityStatus'] == "A" || $products['content'][0]['carrier']['contractAuthorityStatus'] == "A"){
                        $company = [
                            'company_name' => $products['content'][0]['carrier']['legalName'],
                            'mc' => $request->mc_no,
                            'dot' => $products['content'][0]['carrier']['dotNumber'],
                            'zip_code' => $products['content'][0]['carrier']['phyZipcode'],
                            'address' => $products['content'][0]['carrier']['phyStreet'] . ', ' . $products['content'][0]['carrier']['phyCity'] . ', ' . $products['content'][0]['carrier']['phyState'] . ', ' . $products['content'][0]['carrier']['phyCountry'],
                            'city' => $products['content'][0]['carrier']['phyCity'],
                            'state' => $products['content'][0]['carrier']['phyState'],
                            'country' => $products['content'][0]['carrier']['phyCountry'],
                        ];

                        session()->put('companyData', $company);
                        return response()->json(['status' => 1, 'company' => $company]);

                    }else{
                         return response()->json(['error' => 'record not found']);
                    }

                }
            } elseif ($request->dot_no != null) {
    
                if(Company::where('dot',$request->dot_no)->first()){
                        return response()->json(['error' => 'Company DOT Number Already Exist On This Portal']);
                }
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://mobile.fmcsa.dot.gov/qc/services/carriers/' . $request->dot_no . '?webKey=07d4ca1bfa3cdd68071d3aae89050b1e4568ebe4',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'content-type: application/json',
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $products = json_decode($response, true);
                // dd($response,$products);
                    // dd($products);
                if ($products == null || $products['content'] == null || gettype($products['content']) == "string") {
                    return response()->json(['error' => 'record not found']);

                } else {
                        
                    if( $products['content']['carrier']['commonAuthorityStatus'] == "A" || $products['content']['carrier']['brokerAuthorityStatus'] == "A" || $products['content']['carrier']['contractAuthorityStatus'] == "A"){
                         
                         $cl = curl_init();
                          curl_setopt_array($cl, array(
                          CURLOPT_URL => 'https://mobile.fmcsa.dot.gov/qc/services/carriers/' . $request->dot_no . '/docket-numbers?webKey=07d4ca1bfa3cdd68071d3aae89050b1e4568ebe4',
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => '',
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 0,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => 'GET',
                          CURLOPT_HTTPHEADER => array(
                           'content-type: application/json',
                           ),
                        ));
                        
                        $resp_get_mc = curl_exec($cl);
                        curl_close($cl);
                        $resp_get_mcs = json_decode($resp_get_mc, true);
                            if ($resp_get_mcs == null || $resp_get_mcs['content'] == null || gettype($resp_get_mcs['content']) == "string") {
                                return response()->json(['error' => 'MC Number Not Found']);
                            }
                            
                         $company = [
                            'company_name' => $products['content']['carrier']['legalName'],
                            'dot' => $request->dot_no,
                            'mc' => isset($resp_get_mcs['content'][0]) ? $resp_get_mcs['content'][0]['docketNumber'] : null,
                            'zip_code' => $products['content']['carrier']['phyZipcode'],
                            'address' => $products['content']['carrier']['phyStreet'] . ', ' . $products['content']['carrier']['phyCity'] . ', ' . $products['content']['carrier']['phyState'] . ', ' . $products['content']['carrier']['phyCountry'],
                            'city' => $products['content']['carrier']['phyCity'],
                            'state' => $products['content']['carrier']['phyState'],
                            'country' => $products['content']['carrier']['phyCountry'],
                        ];

                        session()->put('companyData', $company);
                        return response()->json(['status' => 1, 'company' => $company]);
                    }else{
                         return response()->json(['error' => 'record not found']);
                    }
                }
            } else {
                return response()->json(['error' => 'record not found']);
            }
        }
    }

    public function signUpForm3(Request $request)
    {   
         if(session()->get('companyData') == null){
               return redirect()->route('pricing');
         }
        $request->validate([
            'company_email' => ['required','email','unique:companies,email'],
            'company_phone' => ['required','min:14'],
        ],
        [
         'company_phone.min' => 'Company Phone No is Invalid',
        ]);
        $companyData = session()->get('companyData', []);
        $companyPhone = $request->company_phone;
        $companyEmail = $request->company_email;
        $companyData['company_phone'] = $companyPhone;
        $companyData['company_email'] = $companyEmail;
        session()->put('companyData', $companyData);
        // dd( session()->get('userData'),session()->get('companyData'));
        if(session()->get('userData')['seats'] == 0){
               return redirect()->route('signup_step4');
        }
        return view('auth.signup-form-3');

    }

    public function signUpForm4(Request $request)
    {
        if(session()->get('companyData') == null){
               return redirect()->route('pricing');
         }
         
         
        $request->validate([
            'user.*.first_name' => 'required',
            'user.*.last_name' => 'required',
            'user.*.email' => ['required','email', 'unique:users,email'],
            'user.*.phone' => ['required','min:14', 'unique:users,phone'],
            'user.*.password' => ['required','min:8'],
        ],[
            'user.*.phone.min' => 'Phone Number is Invalid',
        ]);
        $array = [];

        $userData = session('userData');
        if($userData['seats'] != 0){
            foreach ($request->user as $item) {
                $seatsData = ['name' => $item['first_name'] . ' ' . $item['last_name'],
                    'email' => $item['email'],
                    'password' => $item['password'],
                    'phone' => $item['phone']];
    
                if($userData['email'] == $item['email']){
                    return back()->with(['error' => 'duplicate email found '.($item['email'])]);
                }
                array_push($array, $seatsData);
            }
    
    
            session()->put('seatsData', $array);
        }

        $packageId = session('ownerPackage');
        $seats = session('seatsData');
        if($seats == null){
              session()->put('seatsData', ['seat' => false]);
              $seats = session('seatsData');
        }
        $package = Package::find($packageId['package_id']);
        $promoOwnerAmount = $package->promo_owner_amount;
        $promoUserAmount = $package->promo_user_amount;
        $regularOwnerAmount = $package->regular_owner_amount;
        $regularUserAmount = $package->regular_user_amount;
        if(!isset($seats['seat'])){
            $totalPromoAmount = $promoOwnerAmount + ($promoUserAmount * count($seats));
            $totalRegularAmount = $regularOwnerAmount + ($regularUserAmount * count($seats));
        }else{
            $totalPromoAmount = $promoOwnerAmount;
            $totalRegularAmount = $regularOwnerAmount;
        }
        // dd($totalPromoAmount);

        return view('auth.signup-form-4',get_defined_vars());

    }
}
