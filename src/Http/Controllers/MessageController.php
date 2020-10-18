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
        $this->avaliableTypes = ['text', 'images','location','audio'];
    }

    public function index($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        $messages = Message::getMessagesIn($chat);
        return response()->json($messages,200);
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
            'caption' => 'nullable|string',
            'images' => 'required_if:type,images|array',
            'images.*' => 'required_if:type,images|file|mimes:jpeg,bmp,png',
            'latitude' => 'required_if:type,location|numeric',
            'longitude' => 'required_if:type,location|numeric',
            'audio' =>'required_if:type,audio|mimes:audio/mpeg,mpga,mp3,wav,aac',
        ]);

        $data = $request->all();

        $chat = Chat::findOrFail($chatId);

        if ($request->type == 'images') {
            $data['caption'] = $data['caption'] ?? null;
            $data['images'] = $this->uploadMedia($chatId,...$request->images);
        }elseif ($request->type == 'audio'){
            $data['audio'] = $this->uploadMedia($chatId,$request->audio)[0];
        }

        $chat->newMessage($data);

        return response()->json(['success'=>true],201);
    }

    public function uploadMedia( $chatId ,...$mediaFiles) : array
    {
        foreach($mediaFiles as $key => $uploadedFile){
            $ext = $uploadedFile->getClientOriginalExtension();
            $filename = time().$uploadedFile->getClientOriginalName();
            $filename = rtrim(strtr(base64_encode($filename), '+/', '-_'), '=');
            $filename .= '.'.$ext;
            Storage::disk(config('blink.storage.driver'))->put("/chat/$chatId/".$filename,request()->file($key));
            $uploadedFiles[]=config('app.url')."/api/chat/$chatId/".$filename;
        }

        return $uploadedFiles;
    }
}
