<?php

namespace Blink\Http\Controllers;

use Blink\Models\Chat;
use Blink\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Chat $chat)
    {
        $messages = Message::getMessagesIn($chat);
        return response()->json($messages,200);
    }
}
