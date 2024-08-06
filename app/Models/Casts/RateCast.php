<?php

namespace App\Models\Casts;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * 佣金率值放大缩小处理
 */
class RateCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value/10000;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return intval($value*10000);
    }
}
