<?php

namespace Blink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatImage extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $table = 'chat_images';

    protected $fillable = [
        'path',
        'images_message_id'
    ];

    protected $hidden = ['images_message_id','id','deleted_at','created_at','updated_at'];

    public function imagesMessage()
    {
        return $this->belongsTo('\Blink\Models\ImagesMessage');
    }
}
