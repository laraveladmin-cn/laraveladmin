<?php
/**
 * 菜单-角色关联模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;

/**
 * App\Models\MenuRole
 *
 * @property int $role_id 角色ID
 * @property int $menu_id 菜单ID
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuRole whereRoleId($value)
 * @mixin \Eloquent
 */
class MenuRole extends Model
{
    protected $table = 'menu_role'; //数据表名称
    protected $itemName='菜单角色关联';
    public $timestamps = false;
    use BaseModel; //软删除

    //批量赋值白名单
    protected $fillable = ['role_id','menu_id'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];

}
