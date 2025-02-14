<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function sendMessage(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'message' => 'required',

        ]);

        if ($validate->fails()) {
            return $this->formatResponse('error', $validate->errors()->first());
        }
        $chat = new chat();
        $chat->sender_id = Auth::id();
        $chat->reciever_id = $id;
        $chat->save();

        $message = $this->send_message_to_user([
            'id' => $id,
            'message' => $request->message,
        ]);

        return $this->formatResponse(
            'success',
            'message send successfully',
            $request->message,
            200
        );

    }
}
