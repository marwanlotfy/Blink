<?php

namespace Blink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImagesMessage extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $table = 'chat_images_messages';

    protected $with = ['images'];

    protected $fillable = [
        'caption'
    ];

    public function images()
    {
        return $this->hasMany('\Blink\Models\ChatImage');
    }

    public function message()
    {
        return $this->morphOne('\Blink\Models\Message', 'messageable');
    }
}
