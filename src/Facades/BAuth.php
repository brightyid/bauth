<?php

namespace Brighty\BAuth\Facades;

use Illuminate\Support\Facades\Facade;

class BAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bauth';
    }
}