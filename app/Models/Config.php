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
    protected $itemName='系统设置';
    protected $table = 'configs'; //数据表Name
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
            '1'=>'Character string',
            '2'=>'json',
            '3'=>'Number'
        ],
        'itype'=>[
            '1'=>'input',
            '2'=>'textarea',
            '3'=>'markdown',
            '4'=>'json',
            '5'=>'switch',
            '6'=>'number'
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
        'type'=>'Type',
        'name'=>'Name',
        'key'=>'Key name',
        'itype'=>'Input box type',
        'options'=>'Component properties',
        'description'=>'Describe',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At'
        'id' => 'ID',
    ];

    /**
     * Component properties
     * @param $value
     * @return bool|string
     */
    public function getOptionsAttribute($value){
        return json_decode($value,true)?:new \stdClass();
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
            return $value-0; //NumberType
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
