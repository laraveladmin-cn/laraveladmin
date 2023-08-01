<?php
/**
 * 对话消息模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use ZW\Laravel\Eloquent\Custom\SoftDeletes;

class MainCustomersessionconversation extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'main_customersessionconversation';
    protected $connection='pgsql_business';
    //没有主键ID
    protected $itemName = '对话消息';
    //批量赋值白名单
    protected $fillable = [
       'human',
       'ai',
       'customer_session_id',
       'user_id',
       'is_deleted'
    ];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at','updated_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'is_deleted'=>[
            "0"=>'否',
            "1"=>'是'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'customer_session_id' => 0,
        'user_id' => 0,
        'is_deleted' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'id',
        'human' => '用户输入',
        'ai' => 'AI回答',
        'customer_session_id' => '会话',
        'user_id' => '用户',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'is_deleted' => '是否已删除'
    ];

    const DELETED_VALUE = true;//软删除值 不设置默认为1
    const UN_DELETED_VALUE = false;//未删除值 不设置默认为o




    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function main_customersession(){
        return $this->belongsTo('App\Models\MainCustomersession','customer_session_id');
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function main_customer(){
        return $this->belongsTo('App\Models\MainCustomer','user_id');
    }

}
