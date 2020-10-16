<?php

namespace Blink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageInfo extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $with = ['reciever'];

    protected $table = 'chat_message_info';

    protected $fillable = [
        'delivered',
        'seen',
        'message_id',
        'reciever_id',
    ];

    public function message()
    {
        return $this->belongsTo('\Blink\Models\Message');
    }

    public function reciever()
    {
        return $this->belongsTo(config("blink.defaults.user.model"),'reciever_id');
    }

    public static function infromUsers($messageId,$users)
    {
        $arry = [];
        foreach($users as $user){
            $arry[] = [ 
                'message_id' =>  $messageId,
                'reciever_id' => $user,
            ];
        }
        self::insert($arry);
    }

}
