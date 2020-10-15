<?php

namespace Blink\Factories;

use Blink\Contracts\MessageFactoryContract;
use Blink\Exceptions\BlinkException;
use Blink\Models\Chat;
use Blink\Models\Message;
use Blink\Models\TextMessage;

class MessageFactory implements MessageFactoryContract
{
    private $message;
    private $messageable;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function create(Chat $chat,array $data) : Message
    {
        switch ($data['type']) {
            case 'text':
                $this->createTextMessage($data['body']);
                break;
            // case 'images':
            //     $this->createImagesMessage($data);
            //     break;
            
            default:
                throw new BlinkException("can't create message without specify message type");
                break;
        }

        return $this->message->create($chat,$this->messageable);
    }

    private function createTextMessage(string $body)
    {
        $this->messageable = TextMessage::create(['body'=>$body]);
        return $this;
    }
}
