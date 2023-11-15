<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * App\Facades\Formatter
 * @mixin \App\Services\FormatterService
 */
class Formatter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'formatter';
    }
}
