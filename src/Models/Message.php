<?php

namespace Blink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $with = ['sender','messageable'];

    public $timestamps = true;

    protected $table = 'chat_messages';

    protected $hidden = ['chat_id','sender_id','updated_at','messageable_id','messageable_type','deleted_at'];

    protected $fillable = [
        'messageable_id',
        'messageable_type',
        'chat_id',
        'sender_id',
    ];

    protected $appends = ['type'];

    public function chat()
    {
        return $this->belongsTo('\Blink\Models\Chat');
    }

    public function sender()
    {
        return $this->belongsTo(config("blink.defaults.user.model"),'sender_id');
    }

    public function messageInfos()
    {
        return $this->hasMany('\Blink\Models\MessageInfo');
    }

    public function messageable()
    {
        return $this->morphTo();
    }

    public static function getMessagesIn(Chat $chat)
    {
        return self::where('chat_id',$chat->id)->orderBy('id', 'desc')->paginate(config('blink.message.page',25));
    }

    public function create(Chat $chat,$messagble) : self
    {
        $senderId = Auth::user()->id;
        $message = parent::create([
            'messageable_id' => $messagble->id,
            'messageable_type' => get_class($messagble),
            'sender_id' => $senderId,
            'chat_id' => $chat->id,
        ]);
        $notifiedUsers = [];

        foreach($chat->users as $user){
            if ($senderId != $user->id) {
                $notifiedUsers[] = $user->id;
            }
        }

        MessageInfo::infromUsers($message->id,$notifiedUsers);

        return $message;
    }

    public function getTime()
    {
        return $this->updated_at;
    }

    public function getTypeAttribute()
    {
        switch (get_class($this->messageable)) {
            case TextMessage::class:
                return "text";
                break;
            case ImagesMessage::class:
                return "images";
                break;
            case LocationMessage::class:
                return "Location";
                break;
        }
    }
}
