<?php

namespace Blink\Http\Controllers;

use Blink\Models\Message;
use Illuminate\Http\Request;

class MessageInfoController extends Controller
{
    public function index($messageId)
    {
        $infos = Message::findOrFail($messageId)->messageInfos;
        return response()->json(['success'=>true,'data'=>$infos],200);
    }
}
