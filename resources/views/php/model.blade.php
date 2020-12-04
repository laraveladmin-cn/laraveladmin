{!! $php !!}
<?php use \Illuminate\Support\Str; ?>
/**
 * {{$table_comment}}模型
 */
namespace {{$namespace}};
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
@if (in_array('treeModel',$table_types))
use App\Models\Traits\TreeModel;
@endif
@if (in_array('softDeletes',$table_types))
use Illuminate\Database\Eloquent\SoftDeletes;
@endif
@if (in_array('excludeTop',$table_types))
use App\Models\Traits\ExcludeTop;
@endif

class {{$name}} extends Model
{

    use BaseModel; //基础模型
@if (in_array('treeModel',$table_types))
    use TreeModel; //树状结构
@endif
@if (in_array('softDeletes',$table_types))
    use SoftDeletes; //软删除
@endif
@if (in_array('excludeTop',$table_types))
    use ExcludeTop; //排除根节点
@endif
    //数据表名称
    protected $table = '{{$table}}';
@if($connection)
    //数据库连接
    protected $connection = '{{$connection}}';
@endif
@if(!in_array('timestamps',$table_types))
    //无需更新时间字段
    public $timestamps = false;
@endif
@if(in_array('noId',$table_types))
    //没有主键ID
    protected $primaryKey = '';
@endif
    //批量赋值白名单
    protected $fillable = [{!! $fillable !!}];
    //输出隐藏字段
    protected $hidden = [{!! $delete !!}];
    //日期字段
    protected $dates = [{!! $dates !!}];
    //字段值map
    protected $fieldsShowMaps = [{!! $fieldsShowMaps !!}];
    //字段默认值
    protected $fieldsDefault = [{!! $fieldsDefault !!}];
    //字段说明
    protected $fieldsName = [{!! $fieldsName !!}];

@foreach($checkboxs as $key=>$field)
    /**
     * 获取多选值
     * @param $value
     * @return array
     */
    public function {{Str::camel('get_'.$field['Field'])}}Attribute($value)
    {
        $field = $this->getFieldsMap('{{$field['Field']}}')->toArray();
        unset($field[0]);
        return multiple($value,$field);
    }

    /**
     * 设置多选值
     * @param $value
     * @return array
     */
    public function {{Str::camel('set_'.$field['Field'])}}Attribute($value)
    {
        $this->attributes['{{$field['Field']}}'] = multipleToNum($value);
    }
@endforeach

@foreach($passwords as $key=>$field)
    /**
     * 设置密码
     * @param  $value
     * @return  array
     */
    public function {{Str::camel('set_'.$field['Field'])}}Attribute($value)
    {
        $this->attributes['{{$field['Field']}}'] = bcrypt($value);
    }
@endforeach

@foreach($table_relations as $table_relation)
    /**
     * @return \Illuminate\Database\Eloquent\Relations\{{Str::studly($table_relation['relation'])}}
     */
    public function {{$table_relation['name']}}(){
        return $this->{{$table_relation['relation']}}('App\Models\{{$table_relation['model']}}');
    }

@endforeach
}
