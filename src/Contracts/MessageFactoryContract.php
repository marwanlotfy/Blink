<?php

namespace Blink\Contracts;

use Blink\Models\Chat;
use Blink\Models\Message;

interface MessageFactoryContract
{
    public function create(Chat $chat,array $data) : Message;
}