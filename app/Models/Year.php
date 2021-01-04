<?php
/**
 * 年期模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{

    use BaseModel,SoftDeletes; //基础模型
    //数据表名称
    protected $table = 'years';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'value',
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
        'value' => 0
    ];
    //字段说明值
    protected $fieldsName = [
        'id' => 'ID',
        'name' => '名称',
        'value' => '值',
        'description' => '描述',
        //'created_at' => '创建时间',
        //'updated_at' => '修改时间',
        //'deleted_at' => '删除时间'
    ];

    /**
     * 某种年期有多个险种
     */
    public function products(){
        return $this->belongsToMany('App\Models\Product');
    }
    /**
     * 筛选条件选项
     */
    public function scopeOptionsMap($q,$obj=false){
        if($obj){
            return self::get(['id','name']);
        }else{
            return self::pluck('name','id');
        }
    }


}
