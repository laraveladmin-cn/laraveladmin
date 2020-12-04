<?php
/**
 * 配置模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Arr;

class Config extends Model
{
    use SoftDeletes,BaseModel; //软删除

    protected $table = 'configs'; //数据表名称
    //批量赋值白名单
    protected $fillable = [
        'name',
        'description',
        'key',
        'value',
        'type',
        'itype',
        'options'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    //字段值map
    protected $fieldsShowMaps = [
        'type'=>[
            '1'=>'字符串',
            '2'=>'json',
            '3'=>'数字'
        ],
        'itype'=>[
            '1'=>'input',
            '2'=>'textarea',
            '3'=>'markdown',
            '4'=>'json',
            '5'=>'switch'
        ]
    ];

    //字段默认值
    protected $fieldsDefault = [
        'type'=>1,
        'name'=>'',
        'description'=>'',
        'key'=>'',
        'itype'=>1,
        'options'=>''
    ];

    //字段说明值
    protected $fieldsName = [
        'type'=>'类型',
        'name'=>'名称',
        'key'=>'键名称',
        'itype'=>'输入框类型',
        'options'=>'组件属性',
        'description'=>'描述',
        //'created_at' => '创建时间',
        //'updated_at' => '修改时间',
        //'deleted_at' => '删除时间'
        'id' => 'ID',
    ];

    /**
     * 组件属性
     * @param $value
     * @return bool|string
     */
    public function getOptionsAttribute($value){
        return json_decode($value,true)?:[];
    }
    public function setOptionsAttribute($value){
        $this->attributes['options'] = json_encode($value);
    }

    /**
     * 值
     * @param $value
     * @return bool|string
     */
    public function getValueAttribute($value){
        $type = Arr::get($this->attributes,'type',1);
        if($type==2){
            return json_decode($value,true);
        }elseif ($type==3){
            return $value-0; //数字类型
        }
        return $value;
    }

    /**
     * 值
     * @param $value
     * @return bool|string
     */
    public function setValueAttribute($value){
        $type = Arr::get($this->attributes,'type',1);
        if(!isset($this->attributes['type'])){
        }elseif($type==2){
            $value = json_encode($value);
        }elseif ($type==3){
            $value = ($value?:0)-0;
        }
        $this->attributes['value'] = $value;
    }

}
