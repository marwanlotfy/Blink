<?php

namespace Blink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $table = 'chats';

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
        parent::create($data)->users()->attach($data);
    }
}
