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

        if (! $request->has('to')) {
            return redirect()->route('chat', ['to' => 1]);
        }

        $users = User::all();

        $fromUserId = Auth::user()->id;

        $userTo = User::find($request->get('to'));

        $messages = Message::with(['toUser', 'fromUser'])
            ->where('from_id', $fromUserId)
            ->where('to_id', $userTo->id)
            ->orWhere('from_id', $userTo->id)
            ->where('to_id', $fromUserId)
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('chat', [
            'users' => $users,
            'messages' => $messages,
            'userTo' => $userTo

        ]);
    }
}
