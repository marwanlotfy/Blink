<?php

namespace Blink\Models;

use Blink\Events\NewChatCreated;
use Blink\Events\NewChatMessage;
use Blink\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $table = 'chats';

    protected $messageFactory;

    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory; 
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

    public static function create($data)
    {
        $chat = parent::create($data)->users()->attach($data);
        event(new NewChatCreated($chat));
    }

    public function newMessage($data)
    {
        $message = $this->messageFactory->create($this,$data);
        $this->updated_at = $message->getTime();
        event(new NewChatMessage($message));
        $this->save();
    }
}
