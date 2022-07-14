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
    //数据表Name
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
        'name' => 'Name',
        'full_name' => 'Full name',
        'url' => 'Website address',
        'user_name' => 'User name',
        'password' => 'Password',
        'ip' => 'Binding IP',
        'mac' => 'Server unique ID',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At'
    ];



}
