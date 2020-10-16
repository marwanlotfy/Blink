<?php

namespace Blink\Http\Controllers;

use Blink\Models\Chat;
use Blink\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Blink\Factories\MessageFactory;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    protected $avaliableTypes;

    public function __construct()
    {
        $this->avaliableTypes = ['text', 'images'];
    }

    public function index($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        $messages = Message::getMessagesIn($chat);
        return response()->json($messages,200);
    }

    public function getMedia($messageId)
    {
        
    }

    public function store($chatId,Request $request)
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

        $data = $request->all();

        $chat = Chat::findOrFail($chatId);

        if ($request->has('images')) {
            $imagePaths = [];
            foreach($request->images as $uploadedFile){
                $filename = time().$uploadedFile->getClientOriginalName();
                $filename = rtrim(strtr(base64_encode($filename), '+/', '-_'), '=');
                $uploadedFile->storeAs(config('blink.storage')."/chat/$chatId/image/", $filename);
                $imagePaths[]=config('app.url')."/chat/$chatId/image/".$filename;
            }
            $data['images'] = $imagePaths;
        }

        $chat->newMessage($data);

        return response()->json(['success'=>true],201);
    }
}
