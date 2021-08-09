<?php
/**
 * 接口参数模型
 */
namespace App\Models;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Param extends Model
{
    protected $itemName='请求参数';
    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'params';
    //批量赋值白名单
    protected $fillable = ['menu_id','name','type','title','description','example','validate','use'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'type'=>["1"=>'Character string',"2"=>'Number',"3"=>'Boolean value'],
        'use'=>['URL parameter','Body parameter','Route parameter']
    ];
    //字段默认值
    protected $fieldsDefault = [
        'menu_id' => 0,
        'name' => '',
        'type' => 1,
        'title' => '',
        'description' => '',
        'example' => '',
        'validate' => '',
        'use'=>0
    ];



    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function memu(){
        return $this->belongsTo('App\Models\Memu');
    }

}
