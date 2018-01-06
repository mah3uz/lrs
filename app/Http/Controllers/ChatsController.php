<?php

namespace App\Http\Controllers;

use Redis;
use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /**
         * Show chats
         *
         * @return \Illuminate\Http\Response
         */
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        $redis = Redis::connection();
        $redis->publish('message', $message);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }
}
