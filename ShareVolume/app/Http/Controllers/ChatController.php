<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function showUsers(Request $request)
    {
        $user_id = $request->input('user_id');

//        $chat = DB::table('chats')
//            ->where('sender_user_id', '=', $user_id)
//            ->orWhere('reciever_user_id','=',$user_id)
//            ->select('reciever_user_id', 'sender_user_id')
//            ->distinct()
//            ->get();

        $first = DB::table('chats')
            ->where('sender_user_id', '=', $user_id)
            ->select('reciever_user_id as user')
            ->distinct();

        $users = DB::table('chats')
            ->where('reciever_user_id','=',$user_id)
            ->select('sender_user_id as user')
            ->distinct()
            ->union($first)
            ->get();

        return response()->json($users, 200);

    }


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
            ->where('reciever_user_id', '=', $reciever_user_id)
            ->orWhere('sender_user_id','=',$reciever_user_id)
            ->Where('reciever_user_id','=',$sender_user_id)
            ->select('message', 'sender_user_id', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chat, 200);

    }
}
