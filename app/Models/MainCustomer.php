<?php
/**
 * 用户模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Str;

class MainCustomer extends Model
{

    use BaseModel; //基础模型
    //数据表名称
    protected $table = 'main_customer';
    //没有主键ID
    protected $itemName = '用户';
    //批量赋值白名单
    protected $fillable = [
       'mobile',
       'nickname',
       'avatar',
       'name',
       'email',
       'is_active',
       'last_login',
       'role_id'
    ];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at','updated_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'is_active'=>[
            "0"=>'无效',
            "1"=>'有效'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'mobile' => '',
        'nickname' => '',
        'avatar' => '',
        'name' => '',
        'email' => '',
        'is_active' => 1,
        'role_id' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'id',
        'mobile' => '手机号(含区号)',
        'nickname' => '昵称',
        'avatar' => '头像',
        'name' => '真实姓名',
        'email' => '电子邮箱',
        'is_active' => '状态',
        'last_login' => '最后登录日期',
        'role_id' => '用户角色',
        'created_at' => '创建时间',
        'updated_at' => '修改时间'
    ];




    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function main_customerrole(){
        return $this->belongsTo('App\Models\MainCustomerrole','role_id');
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function main_customeroauths(){
        return $this->hasMany('App\Models\MainCustomeroauth','user_id');
    }

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getLastLoginAttribute($value)
    {
        return $value?Str::limit($value,19,''):null;
    }

}
