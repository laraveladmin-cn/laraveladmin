<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * App\Facades\Option
 * @mixin \App\Services\OptionRepository
 */
class Option extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'option';
    }
}
