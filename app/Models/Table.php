<?php
/**
 * 模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;

class Table extends Model
{

    use BaseModel; //基础模型

    protected $table = 'tables'; //数据表名称
    //没有主键ID
    protected $primaryKey = '';
    //批量赋值白名单
    protected $fillable = [];
    //字段默认值
    protected $fieldsDefault = [];
    protected $fieldsName = [];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];



}
