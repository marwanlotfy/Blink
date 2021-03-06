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

    protected $table = 'chat_text_messages';

    protected $fillable = [
        'body'
    ];

    protected $hidden = ['id','updated_at','created_at','deleted_at'];

    public function message()
    {
        return $this->morphOne('\Blink\Models\Message', 'messageable');
    }

}
