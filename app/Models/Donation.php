<?php
/**
 * 捐赠记录模型
 */
namespace App\Models;
use Carbon\Carbon;
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
       'amount',
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'from'=>[
            "1"=>'WeChat',
            "2"=>'Alipay',
            "3"=>'Transfer accounts'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'member_id' => 0,
        'sponsor_id' => 0,
        'from' => 0,
        'amount' => 0.00,
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'member_id' => 'Member ID',
        'sponsor_id' => 'Sponsor ID',
        'from' => 'Source',
        'amount' => 'Donation amount',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At'
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

    /**
     * 生成佣金
     */
    public function createBills(){
        if($this->bills()->count()===0){ //没有佣金记录
            $amount = $this->amount;
            if($amount){ //金额
                $member = $this->member;
                $bills = [];
                $now = Carbon::now()->toDateTimeString();
                //获取所有推荐人信息
                collect(Member::query()
                    ->parents($member) //向上所有推荐人
                    ->orderBy('right_margin') //从下级向上计算
                    ->get())
                    ->each(function ($member)use(&$amount,&$bills,$now){
                        $value = ceil($amount/2*100)/100;
                        $amount = $amount-$value;
                        if($value>0){
                            $bills[] = [
                                'member_id'=>$member['id'],
                                'donation_id'=>$this->id,
                                'amount'=>$value,
                                'status'=>0,
                                'created_at'=> $now,
                                'updated_at'=> $now
                            ];
                        }else{
                            return false;
                        }
                    });
                Bill::insertReplaceAll($bills);
            }
        }
    }
}
