<?php

namespace Blink\Models;

use Blink\Events\NewChatCreated;
use Blink\Events\NewChatMessage;
use Blink\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Chat extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $table = 'chats';

    protected $messageFactory;

    public function __construct()
    {
        $this->messageFactory = new MessageFactory(new Message()); 
    }

    public function users()
    {
        return $this->belongsToMany(config("blink.defaults.user.model"),'chat_user')->withPivot(['banned']);
    }

    public function messages()
    {
        return $this->hasMany('\Blink\Models\Message');
    }

    public function lastMessage()
    {
        return $this->hasOne('\Blink\Models\Message')->latest();
    }

    public static function for($usersId)
    {
        $chats = self::with(['users','lastMessage'])->whereHas('users',function ($q) use($usersId)
        {
            return $q->whereIn('user_id',$usersId);

        })->orderBy('updated_at', 'desc')
        ->paginate(config("blink.chat.pages",25));

        return $chats;
    }

    public static function create($data)
    {
        $chat = new self();
        $chat->save();
        $chat->users()->attach($data['users']);
        event(new NewChatCreated($chat));
    }

    public function newMessage($data)
    {
        $message = $this->messageFactory->create($this,$data);
        $this->updated_at = $message->getTime();
        event(new NewChatMessage($message));
        $this->save();
    }

    public static function isParticipant($chatId,$usersId)
    {
        return DB::table('chat_user')->where('chat_id',$chatId)->where('user_id',$usersId)->first();
    }

    public static function isBanned($chatId,$usersId)
    {
        return DB::table('chat_user')->where('chat_id',$chatId)->where('user_id',$usersId)->where('banned',true)->first();
    }
}
