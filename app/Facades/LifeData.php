<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * App\Facades\LifeData
 * @mixin \App\Services\LifeDataRepository
 */
class LifeData extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'life_data';
    }
}
