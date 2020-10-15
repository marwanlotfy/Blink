<?php

namespace Blink\Http\Controllers;

use Blink\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::paginate(config("blink.chat.pages",25));
        return response()->json($chats,200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'users'=>'required|array',
            'users.*'=>'required|integer|exists:'.config("blink.defaults.user.table").',id'
        ]);
        Chat::create($request->all());
        return response()->json(['success'=>true],201);
    }
}
