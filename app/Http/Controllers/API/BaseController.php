<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
    
    
    
     public function saveToken(Request $request)
    {   
        
         $validate = Validator::make($request->all(), [
            'token' => "required",
            ]);
            
        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }

        $UserDeviceToken = UserDeviceToken::where('device_token' , $request->token)->where('user_id',auth()->user()->id)->first();
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