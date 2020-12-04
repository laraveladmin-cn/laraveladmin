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

class Role extends Model
{
    use TreeModel; //树状结构
    use SoftDeletes,BaseModel; //软删除

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
            "0" => '否',
            "1" => '是'
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
        'tmp_id' => '模板ID',
        'name' => '名称',
        'is_tmp' => '是否模板',
        'description' => '描述',
        'parent_id' => '父级ID',
        //'level' => '层级',
        //'left_margin' => '左边界',
        //'right_margin' => '右边界',
        //'created_at' => '创建时间',
        //'updated_at' => '修改时间',
        //'deleted_at' => '删除时间',
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
    public function scopeMain($query,$self='='){
        $user_id = Arr::get(Auth::user(),'id'); //当前用户ID
        $query->haveByUserId($user_id,$self);
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
     * 判断是否是超级管理员
     * @param $query
     * @return mixed
     */
    public function scopeIsSuper($query){
        return LifeData::remember('_is_super',function ()use($query){
            return !!$query->my()->where('id',1)->value('id');
        });
    }



    public function scopeGetRoleIds($query){
        return LifeData::remember('_role_ids',function ()use($query){
            return !!$query->main()->pluck('id')->toArray();
        });
    }

    /**
     * 通过用户ID查询拥有的角色
     * @param $query
     * @param $user_id
     */
    public function scopeHaveByUserId($query,$user_id,$self='='){
        if($user_id==Arr::get(Auth::user(),'id')){
            $admin_id = Arr::get(Auth::user(),'admin.id');
        }else{
            $admin_id = Admin::where('user_id',$user_id)->value('id');
        }
        //查询用户的角色
        $roles = Role::whereHas('admin_roles', function ($q) use ($admin_id) {
            $q->where('admin_id', $admin_id);
        })->get(['id', 'left_margin', 'right_margin']);
        if($roles->contains('id',1)){ //超级管理员
            return $query;
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
