<?php
/**
 * 接口响应模型
 */
namespace App\Models;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    protected $itemName='响应说明';
    //数据表名称
    protected $table = 'responses';
    //批量赋值白名单
    protected $fillable = ['menu_id','name','description'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = ['menu_id' => 0,'name' => '','description' => ''];



    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function memu(){
        return $this->belongsTo('App\Models\Memu');
    }

}
