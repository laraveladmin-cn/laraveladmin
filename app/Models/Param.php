<?php
/**
 * 接口参数模型
 */
namespace App\Models;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Param
 *
 * @property int $id ID
 * @property int $menu_id 接口ID$select2@required|exists:menus,id
 * @property string $name 参数名称@required
 * @property int $type 类型:1-字符串,2-数字,3-布尔值
 * @property string $title 提示@required
 * @property string $description 描述$textarea
 * @property string $example 事例值
 * @property string $validate 验证规则说明
 * @property int $use 所属类型:0-url参数,1-body参数
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Param commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Param getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Param getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Param getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Param getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Param getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Param getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Param getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Param getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Param getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Param ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Param insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Param mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Param newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Param newQuery()
 * @method static \Illuminate\Database\Query\Builder|Param onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Param options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Param optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Param query()
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereExample($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Param whereValidate($value)
 * @method static \Illuminate\Database\Query\Builder|Param withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Param withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Menu|null $menu
 */
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
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }

}
