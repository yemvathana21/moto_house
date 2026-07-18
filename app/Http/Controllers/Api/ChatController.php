<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $conversations = Conversation::where('customer_id', $request->user()->id)
            ->with('latestMessage')
            ->orderByDesc('last_message_at')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'subject' => $c->subject,
                'status' => $c->status,
                'last_message' => $c->latestMessage?->message,
                'last_message_at' => $c->last_message_at?->toDateTimeString(),
                'unread_count' => $c->unreadCount(),
            ]);

        return response()->json(['conversations' => $conversations]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $conversation = Conversation::create([
            'customer_id' => $request->user()->id,
            'subject' => $data['subject'] ?? 'Support Request',
            'last_message_at' => now(),
        ]);

        $conversation->messages()->create([
            'sender_type' => get_class($request->user()),
            'sender_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'subject' => $conversation->subject,
                'status' => $conversation->status,
            ],
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $conversation = Conversation::where('customer_id', $request->user()->id)
            ->findOrFail($id);

        $conversation->messages()
            ->where('sender_type', '!=', get_class($request->user()))
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'message' => $m->message,
                'sender_type' => $m->sender_type === get_class($request->user()) ? 'customer' : 'admin',
                'read_at' => $m->read_at?->toDateTimeString(),
                'created_at' => $m->created_at->toDateTimeString(),
            ]);

        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'subject' => $conversation->subject,
                'status' => $conversation->status,
            ],
            'messages' => $messages,
        ]);
    }

    public function reply(Request $request, $id)
    {
        $conversation = Conversation::where('customer_id', $request->user()->id)
            ->where('status', 'open')
            ->findOrFail($id);

        $data = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message = $conversation->messages()->create([
            'sender_type' => get_class($request->user()),
            'sender_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'sender_type' => 'customer',
                'created_at' => $message->created_at->toDateTimeString(),
            ],
        ]);
    }
}
