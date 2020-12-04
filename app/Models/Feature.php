<?php
/**
 * 功能模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'features';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'icon',
       'color',
       'description'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [
        'name' => '',
        'icon' => '',
        'color' => '',
        'description' => ''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'name' => '名称',
        'icon' => '图标',
        'color' => '颜色',
        'description' => '描述',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];



}
