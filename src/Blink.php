<?php

namespace Blink;

use Blink\Exceptions\BlinkException;
use Blink\Models\Chat as ModelsChat;

class Blink
{
    private $chat;

    public function createChat(int ...$users)
    {
        if (count($users) == 1) {
            throw new BlinkException("Chat Users Must be More Than One User", 1);
        }
        try {
            $this->chat = ModelsChat::create(['users'=>$users]);
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }

        return $this;
    }

    public function deleteChat()
    {
        try {
            $this->chat->delete();
            $this->chat = null;
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }
        return $this;
    }

    public function getChat($chatId)
    {
        try {
            $this->chat = ModelsChat::findOrFail($chatId);
        }catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }

        return $this;
    }

    public function createTextMessage(string $body)
    {
        try {
            $this->chat->newMessage(['type'=>'text','body'=>$body]);
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }

        return $this;
    }

    public function suspendChat()
    {
        try {
            $this->chat->banUsers();
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }
        return $this;
    }

    public function banUsers(...$users)
    {
        try {
            $this->chat->banUsers($users);
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }
        return $this;
    }
}
