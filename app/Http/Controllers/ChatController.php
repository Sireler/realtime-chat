<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ChatController
 * @package App\Http\Controllers
 */
class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chat page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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

    /**
     * Post message from user and broadcasting
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMessage(Request $request)
    {
        $data = $request->all();

        $message = Message::create([
            'from_id' => Auth::user()->id,
            'to_id' => $data['to_id'],
            'content' => $data['content']
        ]);

        $message->load('fromUser');

        event(
            new MessageSent($message)
        );

        return response()->json([
            'content' => $message->content,
            'created_at' => $message->created_at->format('jS F Y H:i')
        ]);
    }

    /**
     * Load messages for infinite scrolling
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadMessages(Request $request)
    {
        $data = $request->all();

        $messages = Message::with(['toUser', 'fromUser'])
            ->where('from_id', $data['from'])
            ->where('to_id', $data['to'])
            ->orWhere('from_id', $data['to'])
            ->where('to_id', $data['from'])
            ->latest('created_at')
            ->offset($data['offs'])
            ->limit(5)
            ->get();

        // date format
        foreach ($messages as $message) {
            $message->formated_date = $message->created_at->format('jS F Y H:i');
        }

        return response()->json([
            'messages' => $messages
        ]);
    }
}
