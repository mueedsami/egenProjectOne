<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    // Show all user chats
    public function index()
    {
        $chats = Chat::with(['user', 'messages' => function ($q) {
            $q->latest()->limit(1);
        }])->latest()->paginate(20);

        return view('admin.chats.index', compact('chats'));
    }

    // Show one chat thread
    public function show(Chat $chat)
    {
        $chat->load(['user', 'messages.sender']);
        return view('admin.chats.show', compact('chat'));
    }

    // Admin sends a message
    public function send(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $msg = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($msg))->toOthers();

        return response()->json(['success' => true, 'message' => $msg]);
    }
}
