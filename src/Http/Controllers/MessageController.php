<?php

namespace Blink\Http\Controllers;

use Blink\Factories\MessageFactory;
use Blink\Models\Chat;
use Blink\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MessageController extends Controller
{
    protected $avaliableTypes;

    public function __construct()
    {
        $this->avaliableTypes = ['text', 'images'];
    }

    public function index(Chat $chat)
    {
        $messages = Message::getMessagesIn($chat);
        return response()->json($messages,200);
    }

    public function store(Chat $chat,Request $request)
    {
        $request->validate([
            'type' => [
                'required',
                'string',
                Rule::in($this->avaliableTypes),
            ],
            'body' => 'required_if:type,text|string',
            'caption' => 'required_if:type,images|string',
            'images' => 'required_if:type,images|array',
            'images.*' => 'required_if:type,images|file|mimes:jpeg,bmp,png',
        ]);

        $chat->newMessage($request->all());

        return response()->json(['success'=>true],201);
    }
}
