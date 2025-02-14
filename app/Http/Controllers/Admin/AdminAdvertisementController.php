<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class AdminAdvertisementController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Advertisement::select("*")->orderBy('created_at','Desc')->orderBy('page_name', 'Asc');
            return DataTables::of($data)->addIndexColumn()->addColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })->addIndexColumn()
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<a class="badge badge-success" onclick="return confirm(`Are you sure you want to In-Active Advertisement`)" href="' . route(auth()->user()->type . ".change_advertisements_status", [$row->id]) . '" tile="" >Active</a>';
                } else {
                    return '<a class="badge badge-danger" onclick="return confirm(`Are you sure you want to Active Advertisement`)" href="' . route(auth()->user()->type . ".change_advertisements_status", [$row->id]) . '" tile="">InActive</a>';
                }
            })
            ->addColumn('page_name', function ($row) {
                    return $row->page_name != null ? strtoupper(str_replace('_',' ', $row->page_name)) : '-';
            })
            ->addColumn('position', function ($row) {
                    return $row->position != null ? strtoupper(str_replace('_',' ', $row->position)) : '-';
            })
            ->addColumn('image', function ($row) {
                if($row->image != null){
                    $img = '<a href="' .asset($row->image).'" target="_blank"><img src="' .asset($row->image).'" style="width:100px; height:100px;"></img></a>';
                }else{
                    $img = 'Image Not Found';
                }
                return $img;
            })
            ->addColumn('url', function ($row) {
                if($row->url != null){
                    $url = '<a href="' .$row->url.'" target="_blank">'.$row->url.'</a>';
                }else{
                    $url = '-';
                }
                return $url;
            })
            ->addColumn('action', function ($row) {
                    $btn = '';
                    if(auth()->user()->parent_id == null){
                        $btn .= '<a class="fa fa-pencil btn btn-outline-primary" href="' . route("super-admin.advertisements.edit", [$row->id]) . '" tile=""></a>';
                        $btn .= '<a class="fa fa-trash-alt btn btn-outline-danger" href="' . route('super-admin.advertisements.destroy', [$row->id]) . '" onclick="return confirm(`Are you sure you want to delete it?`)"  tile=""></a>';
                    }else{
                        $btn = '';
                    }
                return '<div class="d-flex btnWrap">'.$btn.'</div>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('page_name') != 0) {
                        $instance->where('page_name', $request->get('page_name'));
                    }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = str_replace(" ","_",$request->get('search'));
                        $w->orWhere('id', 'LIKE', "%$search%")
                        ->orWhere('page_name', 'LIKE', "%$search%")
                        ->orWhere('position', 'LIKE', "%$search%")
                        ->orWhere('url', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['type','status', 'image', 'url' , 'action'])
            ->make(true);
        }

        return view('Admin.Advertisement.index', get_defined_vars());
    }

    public function change_advertisements_status($id)
    {
        $adv = Advertisement::find($id);
        if ($adv->status == 1) {
            $adv->status = 0;
            $adv->save();
        }elseif($adv->status == 0){
            $adv->status = 1;
            $adv->save();
        }
         else {
            return back()->with('error', 'Advertisment ID Not Found');
        }
        return back()->with('success', 'Status Changed Successfully');
    }



    public function create()
    {
        return view('Admin.Advertisement.create');
    }



    public function store(Request $request)
    {
        $dimensions = [
            ['dashboard' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 1200, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header3' =>
                        ['width' => 1200, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['search_truck' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header5' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['search_loads' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['my_shipments' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['carrier_detail' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipment_status_tracking' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_active' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_bid_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_history' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_requests_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_tracking' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['shipment_overview' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 600],
                    ],]
                ],
            ],
            ['edit_a_shipment' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 850, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['private_network' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 300, 'height' => 600],
                    ],
                    ['center_header5' =>
                        ['width' => 300, 'height' => 600],
                    ],]
                ],
            ],
            ['private_network_detail' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ]]
                ],
            ],
            ['edit_private_network' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ]]
                ],
            ],
            ['groups' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 800, 'height' => 100],
                    ],]
                ],
            ],
            ['groups_details' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['create_contact' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['edit_tracking_request' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['new_tracking_request' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['create_tracking_request' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['tracking_detail' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['live_chat_support' =>
                ['position' =>[
                    ['center_header1' =>
                        ['width' => 600, 'height' => 600],
                    ],
                    ['center_header2' =>
                        ['width' => 600, 'height' => 600],
                    ],]
                ],
            ],
            ['tools' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['feedbacks_form' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['bottom_footer1' =>
                        ['width' => 800, 'height' => 100],
                    ],
                    ['bottom_footer2' =>
                        ['width' => 800, 'height' => 100],
                    ],]
                ],
            ],
            ['my_shipment_bid_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['user_profile' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['user_management' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['user_management_create' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['Billings' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['Billing_details' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['compnay_profile' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['my_shipment_request_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['all_notifications' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['help_center' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 600],
                    ],
                    ['center_header5' =>
                        ['width' => 600, 'height' => 600],
                    ],]
                ],
            ],
            ['post_a_shipment' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 850, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['app1' =>
                ['position' =>[
                    ['mobile_app' =>
                        ['width' => 600, 'height' => 130],
                    ],
                   ],
                ],
            ],
            ['app2' =>
                ['position' =>[
                    ['mobile_app' =>
                        ['width' => 600, 'height' => 130],
                    ],
                   ],
                ],
            ],
        ];
        
        $width = array();
        $height = array();
        
        foreach($dimensions as $key => $dimension){
          if(isset($dimension[$request->page_name])){
            foreach($dimension[$request->page_name]['position']  as $position){
              if(isset($position[$request->position])){
                array_push($width, $position[$request->position]['width'] ?? 'L');
                array_push($height, $position[$request->position]['height'] ?? 'L');
              }
            }
          }
        }
        // dd($width);
        // dd($width[0],$height[0],$request->image);
        $request->validate([
            'page_name' => 'required',
            'position' => 'required',
            'url' => 'required',
            'image'=>'required|mimes:jpg,jpeg,png,bmp,gif|dimensions:max_width='.$width[0].',max_height='.$height[0].'',
            ],
            [
            'image.dimensions' => 'Image should be '. $width[0] . ' * ' . $height[0]    
            ]);

            $advertisment =  Advertisement::where('page_name', $request->page_name)->where('position', $request->position)->first();

            $imageName = '';
            if($advertisment){
                    if($request->page_name == "dashboard"){
                        if ($image = $request->file('image')){
                        $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                        $image->move('assets/advertisements/uploads/', $imageName);
                    }
    
                    Advertisement::create([
                        'page_name' => $request->page_name,
                        'position' => $request->position,
                        'url' => $request->url,
                        'image'=> 'assets/advertisements/uploads/'.$imageName,
                    ]);
                    $success ='Advertisement Created Successfully!';    
                }else{
                    return back()->withInput()->with('error','Already Exist this Advertisement ID '. $advertisment->id );
                }
                


                // if ($image = $request->file('image')){
                //     if(\File::exists(public_path($advertisment->image))){
                //         \File::delete(public_path($advertisment->image));
                //     }
                //     $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                //     $image->move('assets/advertisements/uploads/', $imageName);
                //     $advertisment->image = 'assets/advertisements/uploads/'. $imageName;
                // }
                // $advertisment->page_name  = $request->page_name;
                // $advertisment->position  = $request->position;
                // $advertisment->url  = $request->url;
                // $advertisment->save();

                // $success ='Advertisement Updated Successfully!';
            }
            else{
                if ($image = $request->file('image')){
                    $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                    $image->move('assets/advertisements/uploads/', $imageName);
                }

                Advertisement::create([
                    'page_name' => $request->page_name,
                    'position' => $request->position,
                    'url' => $request->url,
                    'image'=> 'assets/advertisements/uploads/'.$imageName,
                ]);
                $success ='Advertisement Created Successfully!';
            }



        return redirect()->route('super-admin.advertisements.list')->with('success',$success);
    }

    public function edit($id)
    {
        $advertisement = Advertisement::find($id);
        // dd($package);
        return view('Admin.Advertisement.edit',get_defined_vars());
    }

    public function update(Request $request,$id)
    {
        
         $dimensions = [
            ['dashboard' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 1200, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header3' =>
                        ['width' => 1200, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['search_truck' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header5' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['search_loads' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['my_shipments' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['carrier_detail' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipment_status_tracking' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_active' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_bid_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_history' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_requests_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['my_shipments_tracking' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]

                ],
            ],
            ['shipment_overview' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 600],
                    ],]
                ],
            ],
            ['edit_a_shipment' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 850, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['private_network' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 300, 'height' => 600],
                    ],
                    ['center_header5' =>
                        ['width' => 300, 'height' => 600],
                    ],]
                ],
            ],
            ['private_network_detail' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ]]
                ],
            ],
            ['edit_private_network' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ]]
                ],
            ],
            ['groups' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 800, 'height' => 100],
                    ],]
                ],
            ],
            ['groups_details' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['create_contact' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['edit_tracking_request' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['new_tracking_request' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['create_tracking_request' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['tracking_detail' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['live_chat_support' =>
                ['position' =>[
                    ['center_header1' =>
                        ['width' => 600, 'height' => 600],
                    ],
                    ['center_header2' =>
                        ['width' => 600, 'height' => 600],
                    ],]
                ],
            ],
            ['tools' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['feedbacks_form' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['bottom_footer1' =>
                        ['width' => 800, 'height' => 100],
                    ],
                    ['bottom_footer2' =>
                        ['width' => 800, 'height' => 100],
                    ],]
                ],
            ],
            ['my_shipment_bid_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['user_profile' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['user_management' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['user_management_create' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['Billings' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['Billing_details' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['compnay_profile' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['my_shipment_request_activity' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['all_notifications' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['help_center' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['top_header3' =>
                        ['width' => 600, 'height' => 130],
                    ],
                    ['center_header4' =>
                        ['width' => 600, 'height' => 600],
                    ],
                    ['center_header5' =>
                        ['width' => 600, 'height' => 600],
                    ],]
                ],
            ],
            ['post_a_shipment' =>
                ['position' =>[
                    ['top_header1' =>
                        ['width' => 850, 'height' => 130],
                    ],
                    ['top_header2' =>
                        ['width' => 600, 'height' => 130],
                    ],]
                ],
            ],
            ['app1' =>
                ['position' =>[
                    ['mobile_app' =>
                        ['width' => 600, 'height' => 130],
                    ],
                   ],
                ],
            ],
            ['app2' =>
                ['position' =>[
                    ['mobile_app' =>
                        ['width' => 600, 'height' => 130],
                    ],
                   ],
                ],
            ],
        ];
        $width = array();
        $height = array();
        
        foreach($dimensions as $key => $dimension){
          if(isset($dimension[$request->page_name])){
            foreach($dimension[$request->page_name]['position']  as $position){
              if(isset($position[$request->position])){
                array_push($width, $position[$request->position]['width'] ?? 'L');
                array_push($height, $position[$request->position]['height'] ?? 'L');
              }
            }
          }
        }
        
        $request->validate([
            'page_name' => 'required',
            'position' => 'required',
            'url' => 'required',
            'image'=>'sometimes|mimes:jpg,jpeg,png,bmp,gif|dimensions:max_width='.$width[0].',max_height='.$height[0].'',
            ],
            [
            'image.dimensions' => 'Image should be '. $width[0] . ' * ' . $height[0]    
            ]);

            $advertisment =  Advertisement::where('id', '!=',  $id)->where('page_name', $request->page_name)->where('position', $request->position)->first();

            $imageName = '';
            if($advertisment){

                return back()->withInput()->with('error','Already Exist this Advertisement ID '. $advertisment->id);
                // if ($image = $request->file('image')){
                //     if(\File::exists(public_path($advertisment->image))){
                //         \File::delete(public_path($advertisment->image));
                //     }
                //     $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                //     $image->move('assets/advertisements/uploads/', $imageName);
                //     $advertisment->image = 'assets/advertisements/uploads/'. $imageName;
                // }
                // $advertisment->page_name  = $request->page_name;
                // $advertisment->position  = $request->position;
                // $advertisment->url  = $request->url;
                // $advertisment->save();
            }
            else{
                $advertisment = Advertisement::find($id);
                if ($image = $request->file('image')){
                    if(\File::exists(public_path($advertisment->image))){
                        \File::delete(public_path($advertisment->image));
                    }

                    $imageName = time().'-'.uniqid().'.'.$image->getClientOriginalExtension();
                    $image->move('assets/advertisements/uploads/', $imageName);
                    $advertisment->image = $imageName != null ? 'assets/advertisements/uploads/'.$imageName : $advertisment->image;
                }

                $advertisment->page_name  = $request->page_name;
                $advertisment->position  = $request->position;
                $advertisment->url  = $request->url;
                $advertisment->save();
            }

        return redirect()->route('super-admin.advertisements.list')->with('success','Advertisement Updated Successfully!');
    }

    public function destroy($id)
    {
        $advertisment = Advertisement::find($id);
        if(\File::exists(public_path($advertisment->image))){
            \File::delete(public_path($advertisment->image));
         }
        $advertisment->delete();
        return redirect()->route('super-admin.advertisements.list')->with('success','Advertisement Deleted Successfully!');
    }
}
