<?php
/**
 * 后台用户模型
 */
namespace App\Models;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    protected $table = 'admins'; //数据表名称
    use SoftDeletes,BaseModel; //软删除
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


    /* 用户信息 */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    /* 角色信息 */
    public function roles(){
        return $this->belongsToMany('App\Models\Role','admin_role','admin_id','role_id');
    }

}
