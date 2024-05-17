<?php
/**
 * 地区模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use App\Models\Traits\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{

    use BaseModel; //基础模型
    use TreeModel; //树状结构
    use SoftDeletes; //软删除
    //数据表Name
    protected $table = 'areas';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'parent_id'
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
        'parent_id' => 0,
        'level' => 0,
        'left_margin' => 0,
        'right_margin' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'Zone ID',
        'name' => 'Name',
        'parent_id' => 'Parent ID',
        'level' => 'Hierarchy',
        'left_margin' => 'Left border',
        'right_margin' => 'Right border',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At'
    ];



}
