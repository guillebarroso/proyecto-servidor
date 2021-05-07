<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {

        $info_mensaje =  Chat::create([
            'sender_user_id' => $request->input('sender_user_id'),
            'reciever_user_id' => $request->input('reciever_user_id'),
            'message' => $request->input('message'),
        ]);

        return response()->json($info_mensaje, 200);

    }

    public function readMessages(Request $request)
    {

        {

            $sender_user_id = $request->input('sender_user_id');
            $reciever_user_id = $request->input('reciever_user_id');

            $chat = DB::table('chats')
                ->where('sender_user_id', '=', $sender_user_id)
                ->where('reciever_user_id', '=', $reciever_user_id)
                ->select('messages')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($chat, 200);
        }

    }
}
