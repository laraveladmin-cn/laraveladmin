<?php
/**
 * 后台用户模型
 */
namespace App\Models;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Admin
 *
 * @property int $id ID
 * @property int $user_id 用户ID@required|exists:users,id|unique:admins,user_id
 * @property int $manage_users 管理普通用户
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Admin commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin main($self = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Admin mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Query\Builder|Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Admin optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereManageUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Admin withoutTrashed()
 * @mixin \Eloquent
 */
class Admin extends Model
{
    protected $table = 'admins'; //数据表名称
    use SoftDeletes,BaseModel; //软删除
    protected $itemName='后台用户';
    //批量赋值白名单
    protected $fillable = ['user_id'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    /**
     * 字段默认值
     * @var array
     */
    protected $fieldsDefault = [
        'user_id'=>0
    ];

    //字段默认值
    protected $fieldsName = [
        'user_id' => 'User ID',
        'id' => 'ID',
    ];


    /* 用户信息 */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    /* 角色信息 */
    public function roles(){
        return $this->belongsToMany('App\Models\Role','admin_role','admin_id','role_id');
    }


    /**
     * 我管理的用户
     */
    public function scopeMain($query,$self='='){
        //登录用户
        $user = Auth::user();
        //超级管理员
        if ($user && Role::isSuper()) {
            return $query;
        }
        $query->whereHas('roles',function ($q)use($self){
            $q->main($self);
        });
        return $query;

    }

}
