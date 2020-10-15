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

    protected $with = ['sender','messageInfos','messageable'];

    public $timestamps = true;

    protected $table = 'chat_messages';

    protected $fillable = [
        'messageable_id',
        'messageable_type',
        'chat_id',
        'sender_id',
    ];

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
        return parent::create([
            'messageable_id' => $messagble->id,
            'messageable_type' => get_class($messagble),
            'sender_id' => 1, // for now
            // 'sender_id' => Auth::user()->id,
            'chat_id' => $chat->id,
        ]);
    }

    public function getTime()
    {
        return $this->updated_at;
    }
}
