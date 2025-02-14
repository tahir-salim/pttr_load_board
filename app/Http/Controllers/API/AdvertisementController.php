<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    public function advertisement(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'page_name' => 'required',

        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }
 
        $advertisement = Advertisement::select('page_name','image','url')->where('status', 1)->where('position', 'mobile_app')->where('page_name',$request->page_name)->first();
        if($advertisement){
             $advertisement->image = asset($advertisement->image);
             $advertisement->page_name = strtoupper(str_replace('_',' ', $advertisement->page_name));

            return $this->formatResponse(
                'success',
                'Addvertisement fetch successfully',
                $advertisement,
                200
            );
        }else{
            return $this->formatResponse(
                'error',
                'Adds not Found',
                [],
                200
            );
            
        }
    }
}
