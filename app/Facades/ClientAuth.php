<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * App\Facades\ClientAuth
 * @mixin \App\Services\ClientAuth
 */
class ClientAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'app_client';
    }
}
