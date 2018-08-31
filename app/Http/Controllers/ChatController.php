<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
        $fromUserId = Auth::user()->id;

        if (! $request->has('to')) {

            // Last messages for user
            $listUsers = Message::where('from_id', $fromUserId)
                ->orWhere('to_id', $fromUserId)
                ->orderBy('id', 'desc')
                ->distinct()
                ->get(['from_id', 'to_id']);

            $dialogs = $this->getLastUserMessages();

            return view('chat', [
                'dialogs' => $dialogs
            ]);
        }

        $users = User::all();

        $userTo = User::findOrFail($request->get('to'));

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

    /**
     *  Find user by name and show page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function findUser(Request $request)
    {
        if ($request->get('to')) {

            $user = User::where('name', $request->get('to'))->get();

            if ($user->isEmpty()) {
                session()->flash("find_status_not", "User {$request->to} not found");
            } else {
                session()->flash("find_status_found", "Try send a message to {$request->to}");
            }

            return view('find', compact('user'));
        }

        return redirect()->to('/chat');
    }

    /**
     *  Return users who wrote to current user
     *
     * @return mixed
     */
    protected function getLastUserMessages()
    {
        $currentUserId = Auth::user()->id;
        $listUsers = DB::select("select distinct from_id, to_id FROM messages where from_id = {$currentUserId} or to_id = {$currentUserId} order by id desc");
        $lastIds = [];

        foreach ($listUsers as $arr) {
            array_push($lastIds, $arr->from_id);
            array_push($lastIds, $arr->to_id);
        }

        $lastIds = array_unique($lastIds);

        $msg = User::whereIn('id', $lastIds)
            ->get();

        return $msg;
    }
}
