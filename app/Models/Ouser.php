<?php
/**
 * 三方用户模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Arr;

class Ouser extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'ousers';
    //批量赋值白名单
    protected $fillable = ['user_id','type','open_id','data'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'type'=>[
            "1"=>'qq', //QQ三方登录
            "2"=>'weixin', //微信移动应用登录
            "3"=>'weibo', //微博三方登录
            "4"=>'weixinweb', //微信网页登录
            "5"=>'official' //微信公众号登录
        ],
        'type_show'=>[
            [
                'name'=>'QQ',
                'class'=>'primary',
                'icon'=>'qq',
                'type'=>1
            ], //QQ三方登录
            [
                'name'=>'新浪微博',
                'class'=>'danger',
                'icon'=>'weibo',
                'type'=>3
            ], //微博三方登录
            [
                'name'=>'微信移动端',
                'class'=>'warning',
                'icon'=>'weixin',
                'type'=>2
            ], //微信移动应用登录
            [
                'name'=>'微信',
                'class'=>'success',
                'icon'=>'weixin',
                'type'=>4
            ], //微信网页登录
           [
                'name'=>'微信公众号',
                'class'=>'info',
                'icon'=>'weixin',
                'type'=>5
            ] //微信公众号登录
        ]
    ];
    //字段默认值
    protected $fieldsDefault = ['user_id' => 0,'type' => 0,'open_id' => ''];


    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getDataAttribute($value)
    {
        return json_decode($value,true);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }


    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
