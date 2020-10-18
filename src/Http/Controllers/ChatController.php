<?php

namespace Blink\Http\Controllers;

use Blink\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::for([Auth::user()->id]);
        return response()->json($chats,200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        array_push($data,Auth::user()->id);
        $validator =Validator::make($data,[
            'users'=>'required|array',
            'users.*'=>'required|distinct|integer|exists:'.config("blink.defaults.user.table").',id'
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>'The given data was invalid.' , 'errors' => $validator->errors()],422);
        }
        if (Chat::isExist($request->users)) {
            return response()->json(['message'=>'chat_exist'], 409);
        }
        Chat::create($data);
        return response()->json(['success'=>true],201);
    }

    public function getMedia($chatId,$media)
    {
        return Storage::disk(config('blink.storage.driver'))->download("/chat/$chatId/$media");
    }
}
