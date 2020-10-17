<?php

namespace Blink;

use Blink\Exceptions\BlinkException;
use Blink\Models\Chat;
use Illuminate\Support\Facades\DB;

trait HasChats
{
    public function chats()
    {
        return $this->belongsToMany(Chat::class,'chat_user')->withPivot(['banned']);
    }

    public function unBannedChats()
    {
        return $this->chats()->where('banned',false);
    }

    public function bannedChats()
    {
        return $this->chats()->where('banned',true);
    }

    public function leaveChat(int $chatId)
    {
        try {
            return DB::table('chat_user')->where('chat_id',$chatId)->where('user_id',$this->id)->delete();
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage());
        }
    }
}