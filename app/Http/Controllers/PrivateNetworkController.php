<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Input;

class PrivateNetworkController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function private_network(Request $request)
    {

   $groups = Group::where('user_id',auth()->user()->id)->get();
   $contacts = Contact::where('user_id',auth()->user()->id)->count();

        if ($request->ajax()) {
            $data = Contact::where('user_id',auth()->user()->id)->select('*');
            return Datatables::of($data)
                 ->addIndexColumn()
                ->addColumn('inp_chk', function ($row) {
                    $inp_chk = '<input class="checkboxCustom" type="checkbox" id="list6" name="contact_id[]" value="' . $row->id . '">';
                    return $inp_chk;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex btnWrap"><a href="' . route(auth()->user()->type . '.private_network_deatil', ["id" => $row->id]) . '" class="fa fa-eye btn btn-outline-success"></a>';
                    $btn .= '<a href="' . route(auth()->user()->type . '.edit_contact', ["id" => $row->id]) . '" class="fa fa-pencil btn btn-outline-primary"></a>';
                    if (count($row->groups()->get()) < 1) {
                        $btn .= '<a href="' . route(auth()->user()->type . '.contact_delete', ["id" => $row->id]) . '" onclick="return confirm(`Are you sure you want to deleted it?`)" class="fa fa-trash-alt btn btn-outline-danger"></a></div>';
                    }
                    return $btn;
                })
                ->rawColumns(['inp_chk', 'action'])
                ->make(true);
        }

        return view('Global.private-network', get_defined_vars());
    }


    public function private_network_deatil($id)
    {
        $contact = Contact::find($id);
        return view('Contact.private-network-detail', get_defined_vars());
    }

    public function create_contact()
    {
        return view('Contact.create-contact');
    }

    public function create_contact_store(Request $request)
    {

        $request->validate([

           "email" => 'required|email|unique:contacts,email,NULL,id,user_id,' . auth()->user()->id, 
            "name" => "required",
            "legal_dot_number" => "required",
        ]);

        $email_check = Contact::where('email',$request->email)->where('user_id',auth()->user()->id)->first();

        if(isset($email_check))
        {
            return back()->with('error', 'Duplicate email found.')->withInput($request->input());
        }

        $contact =  new Contact();
        $contact->email                           = $request->email;
        $contact->name                            = $request->name;
        $contact->company_name                    = $request->company_name;
        $contact->city                            = $request->city;
        $contact->state                           = $request->state;
        $contact->zip_code                        = $request->zip_code;
        $contact->phone                           = $request->phone;
        $contact->ext                             = $request->ext;
        $contact->affiliat                       = $request->affiliat;
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $contact->trucker_id = $user->id;
        }

        $contact->user_id = auth()->user()->id;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mobile.fmcsa.dot.gov/qc/services/carriers/' . $request->legal_dot_number . '?webKey=07d4ca1bfa3cdd68071d3aae89050b1e4568ebe4',
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
        $response_D = json_decode($response, true);
      

        if(isset($response_D['content']) && gettype($response_D['content']) != "string" ){
            if (isset($response_D['content']) && $response_D['content'] != null) {
                if($response_D['content']['carrier']['commonAuthorityStatus'] == "A" || $response_D['content']['carrier']['contractAuthorityStatus'] == "A" || $response_D['content']['carrier']['brokerAuthorityStatus']  == "A" ){
                    $content =  $response_D['content'];
                    $contact->company_name                    = $content['carrier']['legalName'];
                    $contact->legal_power_units                = $content['carrier']['totalPowerUnits'];
                    $contact->legal_drivers                = $content['carrier']['totalDrivers'];
                    $contact->legal_dot_number                = $content['carrier']['dotNumber'];
                    $contact->safety_rating                = $content['carrier']['safetyRating'];
                    $contact->legal_us_state                  = $content['carrier']['phyCity'] . ' - ' . $content['carrier']['phyState'];
                }
            }
        }
        $contact->legal_us_number                 = $request->legal_us_number;
        $contact->legal_us_state       =  $request->legal_us_state;
        $contact->legal_canadian_authority_number = $request->legal_canadian_authority_number;

        $contact->save();

        return redirect()->route(auth()->user()->type . '.private_network')->with('success', 'Add Contact Successfully');
    }


    public function edit_contact($id)
    {
        $contact = Contact::find($id);
        return view('Contact.edit-contact', get_defined_vars());
    }

    public function contact_update(Request $request,Contact $contact)
    {
        
         $validate = Validator::make($request->all(), [
                "email" => 'required|email|unique:contacts,email,' . $contact->id . ',id,user_id,' . auth()->user()->id,
                "legal_dot_number" => "required",
            ]);
        
            if ($validate->fails()) {
                // Handle validation errors (you can return them to the view or return a response)
                return redirect()->back()->withErrors($validate)->withInput();
            }
        // $request->validate([
        //     "email" => 'required|unique:contacts,email,'.$contact->id,
        //     "legal_dot_number" => "required",
        // ]); 
        // dd($contact->email);
        
        $contact->email                           = $request->email;
        $contact->name                            = $request->name;
        $contact->company_name                    = $request->company_name;
        $contact->city                            = $request->city;
        $contact->state                           = $request->state;
        $contact->zip_code                        = $request->zip_code;
        $contact->phone                           = $request->phone;
        $contact->ext                             = $request->ext;
        $contact->affiliat                       = $request->affiliat;
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $contact->trucker_id = $user->id;
        }

        $contact->user_id = auth()->user()->id;

        $curl = curl_init();


        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mobile.fmcsa.dot.gov/qc/services/carriers/' . $request->legal_dot_number . '?webKey=07d4ca1bfa3cdd68071d3aae89050b1e4568ebe4',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $response_D = json_decode($response, true);
            if (isset($response_D['content']) && $response_D['content'] != null || isset($response_D['content']) && gettype($response_D['content']) != "string" ) {
                if($response_D['content']['carrier']['commonAuthorityStatus'] == "A" || $response_D['content']['carrier']['contractAuthorityStatus'] == "A" || $response_D['content']['carrier']['brokerAuthorityStatus']  == "A" ){
                    $content =  $response_D['content'];
                    $contact->company_name                    = $content['carrier']['legalName'];
                    $contact->legal_power_units                = $content['carrier']['totalPowerUnits'];
                    $contact->legal_drivers                = $content['carrier']['totalDrivers'];
                    $contact->legal_dot_number                = $content['carrier']['dotNumber'];
                    $contact->safety_rating                = $content['carrier']['safetyRating'];
                    $contact->legal_us_state                  = $content['carrier']['phyCity'] . ' - ' . $content['carrier']['phyState'];
                }
            }
        $contact->legal_us_number                 = $request->legal_us_number;
        $contact->legal_us_state       =  $request->legal_us_state;
        $contact->legal_canadian_authority_number = $request->legal_canadian_authority_number;

        $contact->save();

        return redirect()->route(auth()->user()->type . '.private_network')->with('success', 'Update Contact Successfully');
    }


    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
            return redirect()->route(auth()->user()->type . '.private_network')->with('success', 'Contact Successfully Deleted');
        } else {
            return back()->with('error',  'Record Not Found');
        }
    }



    public function groups(Request $request)
    {

        $data = Group::where('user_id',auth()->user()->id)->select('*');
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('contact', function ($row) {
                    $contact = count($row->contacts);
                    return $contact;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex btnWrap"><a href="' . route(auth()->user()->type . '.groups_detail', [$row->id]) . '" class="fa fa-eye btn btn-outline-success"></a>';
                    $btn .= ' <a href="javascript:void(0)"  data-id="' . $row->id . '" data-name="' . $row->name . '" data-toggle="modal" data-target="#exampleModal" class="fa fa-pencil btn btn-outline-primary"></a>';
                    $btn .= ' <a   onclick="return confirm(`Are you sure?`)" href="' . route(auth()->user()->type . '.groups_delete', ["id" => $row->id]) . '"  class="fa fa-trash-alt btn btn-outline-danger"></a></div>';
                    return $btn;
                })
                ->rawColumns(['action', 'contact'])
                ->make(true);
        }

        return view('Contact.groups', get_defined_vars());
    }
    public function groups_store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:groups,name'
        ]);

        Group::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);

        return back()->with('success', "Group Create Successfully");
    }


    public function groups_delete($id)
    {
        $group = Group::find($id);
        if ($group) {
            $contact_grp = $group->contacts->pluck('id')->toArray();
            $group->contacts()->detach($contact_grp);
            $group->delete();
            //    dd($group);
            return back()->with('success', 'Group successfully Deleted');
        } else {
            return back()->with('error', 'Group not found');
        }
    }


    public function groups_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:groups,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->first(),
            ]);
        }

        $group = Group::find($id);
        if ($group) {
            $group->name = $request->name;
            $group->save();

            return response()->json([
                'status' => 1,
                'success' => 'Group Successfully Updated',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'error' => 'Something went wrong',
            ]);
        }
    }


    public function contact_remove_groups($contact_id)
    {
        $group = Group::find(4);
        $contact = Contact::find($contact_id);
        if ($contact) {
            $group_ids = $contact->groups()->get()->pluck('id')->toArray();
            $contact->groups()->detach($group_ids);
            return back()->with('success', 'Contact Remove Group successfully');
        } else {
            return back()->with('error', 'Group not found');
        }
    }
    public function group_remove_contact($group_id, $contact_id)
    {
        $group = Group::find($group_id);
        if ($group) {
            $group->contacts()->detach($contact_id);
            return back()->with('success', 'Contact Remove Group successfully');
        } else {
            return back()->with('error', 'Group not found');
        }
    }

    function contact_assign_group(Request $request)
    {

        $request->validate([
            'group_id' => 'required'
        ]);
        $group = Group::find($request->group_id);
        if ($group) {
            $contact = explode(',', $request->contact);
            $group->contacts()->syncWithoutDetaching($contact);
        }

        return back()->with('success', 'Add ' . $group->name . ' Successfully');
    }


    public function groups_detail($id, Request $request)
    {


        $group = Group::find($id);
        if ($group) {
            if ($request->ajax()) {

                $data = Contact::where('user_id', auth()->user()->id)->whereHas('groups', function ($query) use ($id) {
                    $query->where('groups.id', $id);
                });
                return Datatables::of($data)
                    ->addColumn('action', function ($row)  use ($id) {
                        $btn = '<a href="' . route(auth()->user()->type . ".group_remove_contact", ["group_id" => $id, "contact_id" => $row->id]) . '" class="edit btn btn-danger btn-sm">Remove Contact</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('Contact.groups-detail', get_defined_vars());
        } else {
            abort(404);
        }
    }
}
