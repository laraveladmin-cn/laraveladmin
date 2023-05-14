<?php

namespace App\Facades;

use \Illuminate\Support\Facades\Facade;

class AlibabaCloud extends Facade
{

    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'alibaba_cloud_apps.'.config('alibaba_cloud.default');
    }

    /**
     * 访问服务对象
     * @param string $name
     * @param array $arguments
     * @return \Illuminate\Foundation\Application|mixed
     */
    public static function app($name)
    {
        return app('alibaba_cloud_apps.'.$name);
    }
}
