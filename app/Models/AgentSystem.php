<?php
/**
 * 经代系统模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentSystem extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'agent_systems';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'full_name',
       'url',
       'user_name',
       'password',
       'ip',
       'mac'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [
        'name' => '',
        'full_name' => '',
        'url' => '',
        'user_name' => '',
        'password' => '',
        'ip' => '',
        'mac' => ''
    ];
    //字段默认值
    protected $fieldsName = [
        'id' => 'ID',
        'name' => '名称',
        'full_name' => '全称',
        'url' => '网站地址',
        'user_name' => '用户名',
        'password' => '密码',
        'ip' => '绑定IP',
        'mac' => '服务器唯一标识',
        //'created_at' => '创建时间',
        //'updated_at' => '修改时间',
        //'deleted_at' => '删除时间'
    ];



}
