<?php
/**
 * 三方用户模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;

class MainCustomeroauth extends Model
{

    use BaseModel; //基础模型
    //数据表名称
    protected $table = 'main_customeroauth';
    //没有主键ID
    protected $itemName = '三方用户';
    //批量赋值白名单
    protected $fillable = [
       'type',
       'open_id',
       'union_id',
       'data',
       'user_id'
    ];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at','updated_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'type'=>[
            "1"=>'微信',
            "2"=>'QQ',
            "3"=>'微博',
            "4"=>'阿里',
            "5"=>'电子邮箱'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'type' => 0,
        'open_id' => '',
        'union_id' => '',
        'user_id' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'id',
        'type' => '类型',
        'open_id' => '用户唯一标识',
        'union_id' => 'extra第三方登陆ID',
        'data' => '用户信息',
        'user_id' => '用户',
        'created_at' => '创建时间',
        'updated_at' => '修改时间'
    ];




    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function main_customer(){
        return $this->belongsTo('App\Models\MainCustomer','user_id');
    }

}
