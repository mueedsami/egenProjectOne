<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatController extends Controller
{
    // Show user's chat inbox (creates chat if not exists)
    public function index()
    {
        $chat = Chat::firstOrCreate(['user_id' => Auth::id()]);
        $chat->load('messages.sender');

        return view('chat.index', compact('chat'));
    }

    // Store message (user side)
    public function storeMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Either use chat_id if given, or create/find the user's chat automatically
        $chat = $request->chat_id
            ? Chat::findOrFail($request->chat_id)
            : Chat::firstOrCreate(['user_id' => Auth::id()]);

        // Make sure this user belongs to the chat
        if ($chat->user_id !== Auth::id() && $chat->admin_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Save the message
        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'message'   => $request->message,
        ]);

        // Broadcast event (admin will receive)
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    // Show a single chat thread
    public function show($id)
    {
        $chat = Chat::where('user_id', Auth::id())
            ->orWhere('admin_id', Auth::id())
            ->findOrFail($id);

        $chat->load('messages.sender');

        return view('chat.show', compact('chat'));
    }
}
