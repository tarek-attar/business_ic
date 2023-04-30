<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChatMessageText;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatMessageTextController extends Controller
{
    public function index()
    {
        $group_chat = ChatRoom::where('type', 'public')->get();
        $group_chat_ids = $group_chat->pluck('id')->toArray();

        $chats = ChatMessage::whereNotIn('chat_room_id', $group_chat_ids)->orderByDesc('id')->paginate(10);
        return view('admin.chats.index', compact('chats'));
    }
    /* public function create()
    {
        return view('admin.chats.create');
    } */
    /* public function store(Request $request)
    {
        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message' => 'required',
            'chat_name' => 'required',
        ]);

        ChatMessageText::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'chat_name' => $request->chat_name,
            'notic' => $request->notic,
        ]);

        return redirect()->route('admin.chats.index')->with('msg', 'ChatMessageText created successfully')->with('type', 'success');
    } */
    public function show($id)
    {
        $chat = ChatMessage::findOrFail($id);
        return view('admin.chats.show', compact('chat'));
    }
    public function edit($id)
    {
        $chat = ChatMessage::findOrFail($id);
        return view('admin.chats.edit', compact('chat'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            /* 'sender_id' => 'required',
            'receiver_id' => 'required',
            'message' => 'required',
            'chat_name' => 'required', */
            'notic' => 'required',

        ]);

        $chat = ChatMessage::findOrFail($id);

        $chat->update([
            /* 'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'chat_name' => $request->chat_name, */
            'notic' => $request->notic,
        ]);

        return redirect()->route('admin.chats.index')->with('msg', 'ChatMessage Note updated successfully')->with('type', 'success');
    }
}
