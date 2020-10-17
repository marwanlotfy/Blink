<?php

namespace Blink\Facades;

use Blink\Exceptions\BlinkException;
use Blink\Models\Chat as ModelsChat;

class Chat  
{
    public static function create(int ...$users)
    {
        if (count($users) == 1) {
            throw new BlinkException("Chat Users Must be More Than One User", 1);
        }
        try {
            ModelsChat::create(['users'=>$users]);
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }
    }

    public static function delete(int $chatId)
    {
        try {
            $chat = ModelsChat::findOrFail($chatId);
            $chat->delete();
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }
    }
}
