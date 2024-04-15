<?php
/**
 * 角色模型
 */
namespace App\Models;
use App\Facades\LifeData;
use App\Models\Traits\TreeModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;

/**
 * App\Models\Role
 *
 * @property int $id ID
 * @property int $tmp_id 模板ID
 * @property string $name 名称@required
 * @property int $is_tmp 设置模板:0-否,1-是
 * @property string|null $description 描述$textarea
 * @property int $parent_id 父级ID@sometimes|required|exists:roles,id
 * @property int $level 层级
 * @property int $left_margin 左边界
 * @property int $right_margin 右边界
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminRole[] $admin_roles
 * @property-read int|null $admin_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin[] $admins
 * @property-read int|null $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $childrens
 * @property-read int|null $childrens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu[] $menus
 * @property-read int|null $menus_count
 * @property-read Role|null $parent
 * @property-read Role|null $tmp
 * @method static \Illuminate\Database\Eloquent\Builder|Role children($node, $self = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Role commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Role getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Role getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Role getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Role getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Role getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Role getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Role getRoleIds()
 * @method static \Illuminate\Database\Eloquent\Builder|Role getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Role getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Role getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Role getTreeField()
 * @method static \Illuminate\Database\Eloquent\Builder|Role haveByUserId($user_id, $self = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Role ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Role insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Role isSuper()
 * @method static \Illuminate\Database\Eloquent\Builder|Role main($self = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Role mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Role my()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role onlyChildren()
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role optionalParent($node = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Role options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Role optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Role parents(bool $node, bool $self = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIsTmp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereLeftMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRightMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTmpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 * @mixin \Eloquent
 */
class Role extends Model
{
    use TreeModel; //树状结构
    use SoftDeletes,BaseModel; //软删除
    protected $itemName='角色';
    //批量赋值白名单
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'tmp_id',
        'is_tmp'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * 字段值map
     * @var array
     */
    public $fieldsShowMaps = [
        'is_tmp' => [
            "0" => 'No',
            "1" => 'Yes'
        ]
    ];

    //字段默认值
    protected $fieldsDefault = [
        'name'=>'',
        'parent_id' => 0,
        'tmp_id'=>0,
        'is_tmp'=>0
    ];
    protected $fieldsName = [
        'tmp_id' => 'Template ID',
        'name' => 'Name',
        'is_tmp' => 'Template',
        'description' => 'Describe',
        'parent_id' => 'Parent ID',
        //'level' => '层级',
        //'left_margin' => '左边界',
        //'right_margin' => '右边界',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At',
        'id' => 'ID',
    ];

    /* 所属模板 */
    public function tmp(){
        return $this->belongsTo('App\Models\Role');
    }

    /* 角色-权限菜单 */
    public function menus(){
        return $this->belongsToMany('App\Models\Menu');
    }

    /* 角色-用户 */
    public function admins(){
        return $this->belongsToMany('App\Models\Admin','admin_role','role_id','admin_id');
    }

    public function admin_roles(){
        return $this->hasMany('App\Models\AdminRole');
    }

    /**
     * 我拥有的角色
     */
    public function scopeMain($query,$self='=',$use_tmp_id=false){
        $user_id = Arr::get(Auth::user(),'id'); //当前用户ID
        $query->haveByUserId($user_id,$self,$use_tmp_id);
        return $query;
    }

    /**
     * 我的角色,不包含子角色
     * @param $query
     * @return mixed
     */
    public function scopeMy($query){
        $user = Auth::user();
        $admin = $user->admin;
        $admin_id = Arr::get(Auth::user(),'admin.id'); //当前用户ID
        return $query->whereHas('admin_roles', function ($q) use ($admin_id) {
            $q->where('admin_id', $admin_id);
        });
    }

    /**
     * 只有我的子角色
     * @param $query
     * @return mixed
     */
    public function scopeOnlyChildren($query){
        return $query->main()->whereNotIn('id',Role::my()->pluck('id'));
    }

    /**
     * 判断YesNoYes超级管理员
     * @param $query
     * @return mixed
     */
    public function scopeIsSuper($query){
        return LifeData::remember('_is_super',function ()use($query){
            return !!$query->my()->where('id',1)->value('id');
        });
    }



    public function scopeGetRoleIds($query,$use_tmp_id=false){
        return LifeData::remember($use_tmp_id?'_role_ids':'_role_ids_1',function ()use($query,$use_tmp_id){
            return $query->main('=',$use_tmp_id)
                ->where('status',1)
                ->pluck('id')
                ->toArray();
        });
    }

    /**
     * 通过用户ID查询拥有的角色
     * @param $query
     * @param $user_id
     */
    public function scopeHaveByUserId($query,$user_id,$self='=',$use_tmp_id=false){
        if($user_id==Arr::get(Auth::user(),'id')){
            $admin_id = Arr::get(Auth::user(),'admin.id');
        }else{
            $admin_id = Admin::query()
                ->where('user_id',$user_id)
                ->value('id');
        }
        //查询用户的角色
        $roles = collect(Role::query()->whereHas('admin_roles', function ($q) use ($admin_id) {
            $q->where('admin_id', $admin_id);
        })->get(['id','tmp_id', 'left_margin', 'right_margin']));
        if($roles->contains('id',1)){ //超级管理员
            return $query;
        }
        $tmp_ids = [];
        if($use_tmp_id){
            $roles = $roles->filter(function ($role)use(&$tmp_ids){
                $tmp_id = $role['tmp_id'];
                if($tmp_id){
                    $tmp_ids[] = $role['tmp_id'];
                }
                return !$tmp_id;
            });
        }
        if($tmp_ids){
            $tmp_ids = collect($tmp_ids)
                ->unique()
                ->values()
                ->toArray();
            $tmp_roles = collect(Role::query()
                ->whereIn('id',$tmp_ids)
                ->get(['id', 'left_margin', 'right_margin'])
            )->toArray();
            $roles = $roles->merge($tmp_roles)
                ->keyBy('id')
                ->values();
        }
        $query->where(function($q)use($roles,$self){
            $q->whereRaw('false');
            //查询所有包含自己及子节点
            foreach ($roles as $role) {
                $q->orWhere(function ($query) use ($role,$self) {
                    $query->where('left_margin', '>'.$self, $role['left_margin'])
                        ->where('right_margin', '<'.$self, $role['right_margin']);
                });
            }
        });
        return $query;
    }






}
