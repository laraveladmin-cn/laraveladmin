<?php
/**
 * 菜单-角色关联模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;

class MenuRole extends Model
{
    protected $table = 'menu_role'; //数据表名称
    protected $itemName='菜单角色关联';
    public $timestamps = false;
    use BaseModel; //软删除

    //批量赋值白名单
    protected $fillable = ['role_id','menu_id'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];

}
