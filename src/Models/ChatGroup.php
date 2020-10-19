<?php

namespace Blink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatGroup extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $table = 'chat_groups';

    protected $fillable = [
        'chat_id',
        'created_by',
        'name',
        'icon',
        'description',
    ];

    protected $hidden =['deleted_at','updated_at'];

    public function chat()
    {
        return $this->hasOne('\Blink\Models\Chat');
    }

    public function admins()
    {
        return $this->belongsToMany(config("blink.defaults.user.model"),'chat_group_admin');
    }
}
