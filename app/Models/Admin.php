<?php
/**
 * 后台用户模型
 */
namespace App\Models;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        'user_id' => '用户ID',
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
