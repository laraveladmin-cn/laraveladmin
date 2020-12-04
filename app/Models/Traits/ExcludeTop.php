<?php
/**
 * 使用 PhpStorm 创建.
 * 创建人: zhang
 * 日期: 16-5-25
 * 时间: 下午10:47
 */

namespace App\Models\Traits;



trait ExcludeTop {
    public static function bootExcludeTop()
    {
        static::addGlobalScope(new ExcludeTopScope);
    }

} 