<?php

namespace App\Models\Casts;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * 字符串拆解
 */
class StrSplitCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value?explode(',',$value):[];
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value?implode(',',$value):'';
    }
}
