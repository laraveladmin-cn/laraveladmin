<?php
/**
 * 捐赠记录模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'donations';
    //批量赋值白名单
    protected $fillable = [
       'member_id',
       'sponsor_id',
       'from',
       'amount'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'from'=>[
            "1"=>'微信',
            "2"=>'支付宝',
            "3"=>'转账'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'member_id' => 0,
        'sponsor_id' => 0,
        'from' => 0,
        'amount' => 0.00
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'member_id' => '会员ID',
        'sponsor_id' => '赞助商ID',
        'from' => '来源',
        'amount' => '捐赠金额',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];



    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(){
        return $this->belongsTo('App\Models\Member');
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sponsor(){
        return $this->belongsTo('App\Models\Sponsor');
    }


    public function bills(){
        return $this->hasMany('App\Models\Bill');
    }
}
