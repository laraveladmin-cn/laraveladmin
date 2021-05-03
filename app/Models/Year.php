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
    //数据表Name
    protected $table = 'years';
    //批量赋Value白名单
    protected $fillable = [
       'name',
       'value',
       'description'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段Valuemap
    protected $fieldsShowMaps = [];
    //字段默认Value
    protected $fieldsDefault = [
        'name' => '',
        'value' => 0
    ];
    //字段说明Value
    protected $fieldsName = [
        'id' => 'ID',
        'name' => 'Name',
        'value' => 'Value',
        'description' => 'Describe',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At'
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
