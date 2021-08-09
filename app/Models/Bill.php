<?php
/**
 * 账单模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'bills';
    //批量赋值白名单
    protected $fillable = [
       'member_id',
       'donation_id',
       'amount',
       'status'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'status'=>[
            "0"=>'No cash withdrawal',
            "1"=>'Withdrawn cash'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'member_id' => 0,
        'donation_id' => 0,
        'amount' => 0.00,
        'status' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'member_id' => 'Member ID',
        'donation_id' => 'Donation ID',
        'amount' => 'Amount of money',
        'status' => 'State',
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
    public function donation(){
        return $this->belongsTo('App\Models\Donation');
    }

}
