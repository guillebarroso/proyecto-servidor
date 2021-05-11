<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {

//        $info_mensaje =  Chat::create([
//            'sender_user_id' => $request->input('sender_user_id'),
//            'reciever_user_id' => $request->input('reciever_user_id'),
//            'message' => $request->input('message'),
//        ]);

        $sender_user_id = $request->input('sender_user_id');
        $reciever_user_id = $request->input('reciever_user_id');
        $message = $request->input('message');
        event(new MessageSent($sender_user_id, $reciever_user_id, $message));

        Chat::create([
            'sender_user_id' => $request->input('sender_user_id'),
            'reciever_user_id' => $request->input('reciever_user_id'),
            'message' => $request->input('message'),
        ]);

        return ["succes"=> true];

    }

    public function readMessages(Request $request)
    {
        $sender_user_id = $request->input('sender_user_id');
        $reciever_user_id = $request->input('reciever_user_id');

        $chat = DB::table('chats')
            ->where('sender_user_id', '=', $sender_user_id)
            ->orWhere('sender_user_id','=',$reciever_user_id)
            ->where('reciever_user_id', '=', $reciever_user_id)
            ->orWhere('reciever_user_id','=',$sender_user_id)
            ->select('message', 'sender_user_id', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chat, 200);

    }
}
