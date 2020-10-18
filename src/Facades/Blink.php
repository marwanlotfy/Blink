<?php

namespace Blink\Facades;

use Illuminate\Support\Facades\Facade;

class Blink extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'blink';
    }
}
