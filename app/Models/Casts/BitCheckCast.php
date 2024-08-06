<?php

namespace App\Models\Casts;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * 二进制位表示多选选项
 */
class BitCheckCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $field = $model->getFieldsMap($key)->toArray();
        unset($field[0]);
        return multiple($value,$field);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return multipleToNum($value);
    }
}
