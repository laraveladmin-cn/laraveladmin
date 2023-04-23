<?php
/**
 * 后台用户-角色关联模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;

/**
 * App\Models\AdminRole
 *
 * @property int $admin_id 用户ID
 * @property int $role_id 角色ID
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminRole whereRoleId($value)
 * @mixin \Eloquent
 */
class AdminRole extends Model
{
    use BaseModel;

    protected $table = 'admin_role'; //数据表名称
    protected $itemName='后台用户权限关联';
    public $timestamps = false;
    public $incrementing = false;
    //批量赋值白名单
    protected $fillable = ['admin_id','role_id'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];

}
