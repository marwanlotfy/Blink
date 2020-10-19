<?php

namespace Blink;

use Blink\Exceptions\BlinkException;
use Blink\Models\Chat as ModelsChat;
use Blink\Models\ChatGroup;

class Blink
{
    private $chat;
    private $hasGroup;

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

    public function delete()
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
            $this->hasGroup = !!$this->chat->group;
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

    public function suspend()
    {
        try {
            $this->chat->banUsers();
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }
        return $this;
    }

    public function unSuspend()
    {
        try {
            $this->chat->unBanUsers();
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

    public function unBanUsers(...$users)
    {
        try {
            $this->chat->unBanUsers($users);
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }
        return $this;
    }

    public function markAsGroup(int $creatorId,string $groupName,string $description,string $icon)
    {
        try {
            if ($this->hasGroup) {
                throw new BlinkException("Already Marked With Group", 1);
            }
            ChatGroup::create([
                'chat_id' => $this->chat->id,
                'created_by' => $creatorId,
                'name' => $groupName,
                'icon' => $icon,
                'description' => $description
            ]);
            $this->hasGroup = true;
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }

        return $this;
    }

    public function makeGroupAdmin(...$users)
    {
        try {
            if($this->hasGroup){
                $this->chat->group->admins()->attach($users);
            }
        } catch (\Throwable $th) {
            throw new BlinkException($th->getMessage(), 1);
        }

        return $this;
    }
}
