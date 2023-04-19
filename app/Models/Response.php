<?php
/**
 * 接口响应模型
 */
namespace App\Models;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Response
 *
 * @property int $id ID
 * @property int $menu_id 接口ID@required|exists:menus,id
 * @property string $name 结果字段@required|alpha_dash
 * @property string $description 描述$textarea
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Response commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Response getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Response getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Response getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Response getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Response getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Response getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Response getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Response getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Response getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Response ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Response insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Response mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Response newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Response newQuery()
 * @method static \Illuminate\Database\Query\Builder|Response onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Response options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Response optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Response query()
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Response whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Response withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Response withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Menu|null $menu
 */
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
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }

}
