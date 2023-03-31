<?php
/**
 * 角色模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;

class MainCustomerrole extends Model
{

    use BaseModel; //基础模型
    //数据表名称
    protected $table = 'main_customerrole';
    //没有主键ID
    protected $itemName = '角色';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'code'
    ];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at','updated_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [
        'name' => ''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'id',
        'name' => '名称',
        'code' => '代码',
        'created_at' => '创建时间',
        'updated_at' => '修改时间'
    ];




    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function main_customers(){
        return $this->hasMany('App\Models\MainCustomer','role_id');
    }

}
