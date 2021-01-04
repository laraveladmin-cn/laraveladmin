<?php
/**
 * 银行模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'banks';
    protected $tableComment = '银行';

    //批量赋值白名单
    protected $fillable = [
        'name',
        'full_name',
        'order'
    ];
    //输出隐藏字段
    protected $hidden = [
        'deleted_at'
    ];
    //日期字段
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [
        'name' => '',
        'full_name'=>'',
        'order' => 0
    ];

    //字段名称
    protected $fieldsName = [
        'name'=>'名称',
        'full_name'=>'全称',
        'order'=>'排序',
        'id'=>'ID',
    ];

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
    /* 保险公司-支持的银行 */
    public function firms(){
        return $this->belongsToMany('App\Models\Firm');
    }


}
