<?php

namespace Blink\Factories;

use Blink\Models\Chat;
use Blink\Models\Message;
use Blink\Models\ChatImage;
use Blink\Models\TextMessage;
use Blink\Models\AudioMessage;
use Blink\Models\ImagesMessage;
use Blink\Models\LocationMessage;
use Blink\Exceptions\BlinkException;
use Blink\Contracts\MessageFactoryContract;

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
            case 'images':
                $this->createImagesMessage($data['caption'],$data['images']);
                break;
            case 'location':
                $this->createLocationMessage($data['latitude'],$data['longitude']);
                break;
            case 'audio':
                $this->createAudioMessage($data['audio']);
                break;
            
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

    private function createImagesMessage(?string $caption,array $images)
    {
        $this->messageable = ImagesMessage::create(['caption'=>$caption]);
        foreach ($images as $image) {
            $attributes[]=[
                'images_message_id' => $this->messageable->id,
                'path' => $image,
            ];
        }
        ChatImage::insert($attributes);
        return $this;
    }

    private function createAudioMessage(string $audio)
    {
        $this->messageable = AudioMessage::create(['path'=>$audio]);
        return $this;
    }

    private function createLocationMessage(float $latitude,float $longitude)
    {
        $this->messageable = LocationMessage::create(['latitude'=>$latitude,'longitude'=>$longitude]);
        return $this;
    }
}
