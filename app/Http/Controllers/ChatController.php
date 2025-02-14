<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request, $id)
    {
        $auth = Auth::user();
        $user = User::find($id);
        $send_notification = [];
        $send_notification['title'] =  $auth->name;
        $send_notification['body'] = $request->message;
        
        if($auth->type == 'super-admin'){
            $send_notification['user_id'] = [$user->id];
            $send_notification['admin_id_from'] = $auth->id;
            $send_notification['to_user_id'] = $user->id;
            $send_notification['url'] = '/live-support/1';
        }else{
            $send_notification['user_id'] = [$user->id];
            $send_notification['from_user_id'] = $auth->id;
            $send_notification['to_user_id'] = $user->id;
            $send_notification['url'] =  '/live-support/?id='.$auth->id;
        }
        $send_notification['type_id'] = $auth->id;
        $send_notification['type'] = "Chat";
        send_notification($send_notification);
        if($auth->type == 'super-admin' && $auth->parent_id == 1 || $auth->type == 'super-admin' && $auth->parent_id == null){
            $chat = new chat;
            $chat->sender_id = 1;
            $chat->reciever_id = $id;
            $chat->save();
        }else{
            $chat = new chat;
            $chat->sender_id = Auth::id();
            $chat->reciever_id = $id;
            $chat->save();
        }
        
        
        $this->send_message_to_user([
            'id' => $id,
            'message' => $request->message,
        ]);
        return response()->json([
            'message' => 'succeess'
        ]);

    }
}
