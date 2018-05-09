<?php

namespace Kdes70\Chatter\Facades;

use Illuminate\Support\Facades\Facade;

class Chatter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chatter';
    }
}