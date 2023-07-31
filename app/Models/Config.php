<?php
/**
 * 配置模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Arr;

/**
 * App\Models\Config
 *
 * @property int $id ID
 * @property string $name 名称
 * @property string $description 描述$textarea
 * @property string $key 键
 * @property bool|string $value 值
 * @property int $type 类型:1-字符串,2-json,3-数字
 * @property int $itype 输入类型:1-input,2-textarea,3-markdown
 * @property bool|string $options 组件属性
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @method static \Illuminate\Database\Eloquent\Builder|Config commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Config getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Config getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Config getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Config getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Config getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Config getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Config getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Config getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Config getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Config ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Config insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Config mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newQuery()
 * @method static \Illuminate\Database\Query\Builder|Config onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Config options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Config optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereItype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|Config withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Config withoutTrashed()
 * @mixin \Eloquent
 */
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
            '6'=>'number',
            '7'=>'upload',
            '8'=>'qiniu-upload',
            '9'=>'carousel-images' //轮播图
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
            $value = json_encode($value,JSON_UNESCAPED_UNICODE);
        }elseif ($type==3){
            $value = ($value?:0)-0;
        }
        $this->attributes['value'] = $value;
    }

}
