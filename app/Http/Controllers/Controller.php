<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function formatResponse($status, $message = null, $data = null, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function send_message_to_user($data = [])
    {
        //    dd($data);
        $return_array = [];

        $Notification_types = array($data['id'] => Auth::id(), Auth::id() => $data['id']);
        foreach ($Notification_types as $firstkey => $secondKey) {
            $user = User::find($firstkey);
            $user_sec = User::find($secondKey);
            //  dd($user,$user_sec);

            $ch = curl_init();
            $carbon = Carbon::now();
            // echo $data['user_id'] . "\n" .Auth::id() . "    ";
            if(auth()->user()->parent_id != null && auth()->user()->parent_id == 1){
                $data_json = '{
                    "text": "' . $data['message'] . '",
                    "user_id":"1",
                    "user_name":"' . Auth::user()->name . '" , 
                    "date": "' . $carbon->format('d-M-Y | h:i A') . '" 
                }';
            }else{
                $data_json = '{
                    "text": "' . $data['message'] . '",
                    "user_id":"'.auth()->user()->id.'",
                    "user_name":"' . Auth::user()->name . '" , 
                    "date": "' . $carbon->format('d-M-Y | h:i A') . '" 
                }';
            }
            
            // dd($data_json);
            array_push($return_array, [$secondKey => $data_json]);
            curl_setopt($ch, CURLOPT_URL, "https://pttr-12c10-default-rtdb.firebaseio.com/user_id_" . $firstkey . "/messages/user_id_" . 1 . "/" . $carbon->format('YmdGis') . ".json");
            // dd($data,$text,$link,$User_id,$notification_id,$lead_type);
            $server_key = 'AIzaSyDUxKPRi3ec_FQxDv33hOssPfx7b75yi4c';
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key=' . $server_key
            );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch);
            // dd($res);
            curl_close($ch);
        }

        // dd($res);
        // $user = User::find($data['id']);
        // $this->send_notification_to_user(['user_id' => $data['id'], 'message' => Auth::user()->name . " Send You a message", 'url' => '/Conversation/' . $user_sec->id . '/' . $user_sec->name]);


        return $res;
    }
}
