<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/5/24
 * 时间: 15:36
 */

namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class ExcludeTopScope implements Scope
{
   public function apply(Builder $builder, Model $model)
   {
       $level_key = $model->getAttribute('level_key')?: 'level' ;
       $builder->where($level_key,'>',1);
   }


}