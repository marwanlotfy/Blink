<?php

namespace Blink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TextMessage extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $with = ['reciever'];

    protected $table = 'chat_text_messages';

    protected $fillable = [
        'body'
    ];

    public function message()
    {
        return $this->morphOne('\Blink\Models\Message', 'messageable');
    }

}
