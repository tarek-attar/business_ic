<?php
/*
namespace App\Http\Controllers\Admin;

use App\Models\Group_chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupChatsController extends Controller
{
    public function index()
    {
        $group_chats = Group_chat::orderByDesc('id')->paginate(10);
        return view('admin.group_chats.index', compact('group_chats'));
    }

    public function show($id)
    {
        $chat = Group_chat::findOrFail($id);
        return view('admin.group_chats.show', compact('chat'));
    }
    public function edit($id)
    {
        $chat = Group_chat::findOrFail($id);
        return view('admin.group_chats.edit', compact('chat'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'notic' => 'required',

        ]);

        $chat = Group_chat::findOrFail($id);

        $chat->update([
            'notic' => $request->notic,
        ]);

        return redirect()->route('admin.group_chats.index')->with('msg', 'Group Chat Note updated successfully')->with('type', 'success');
    }
}
 */
