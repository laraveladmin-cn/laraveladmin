<?php
/**
 * 后台用户-角色关联模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;

class AdminRole extends Model
{
    use BaseModel;

    protected $table = 'admin_role'; //数据表名称

    public $timestamps = false;
    //批量赋值白名单
    protected $fillable = ['admin_id','role_id'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];

}
