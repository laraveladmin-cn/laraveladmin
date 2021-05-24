<?php
/**
 * 相关技术栈模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technology extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表Name
    protected $table = 'technologys';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'url',
       'logo',
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
        'url' => '',
        'logo' => '',
        'description' => ''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'name' => 'Name',
        'url' => 'Link address',
        'logo' => 'Logo image',
        'description' => 'Describe',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At'
    ];



}
