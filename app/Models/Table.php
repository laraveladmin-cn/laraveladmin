<?php
/**
 * 模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;

/**
 * App\Models\Table
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Table commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Table getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Table getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Table getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Table getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Table getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Table getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Table getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Table getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Table getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Table ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Table insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Table mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Table optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @mixin \Eloquent
 */
class Table extends Model
{

    use BaseModel; //基础模型
    protected $itemName='数据表';
    protected $table = 'tables'; //数据表名称
    //没有主键ID
    protected $primaryKey = '';
    public $incrementing = false;
    //批量赋值白名单
    protected $fillable = [];
    //字段默认值
    protected $fieldsDefault = [];
    protected $fieldsName = [];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];



}
