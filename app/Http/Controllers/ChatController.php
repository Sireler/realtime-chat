<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $users = User::all();

        $toUserId = $request->get('to');
        $fromUserId = Auth::user()->id;

        $messages = Message::with(['toUser', 'fromUser'])
            ->where('from_id', $fromUserId)
            ->where('to_id', $toUserId)
            ->orWhere('from_id', $toUserId)
            ->where('to_id', $fromUserId)
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('chat', [
            'users' => $users,
            'messages' => $messages,
            'to' => $toUserId,

        ]);
    }
}
