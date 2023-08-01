<?php
/**
 * 对话模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use ZW\Laravel\Eloquent\Custom\SoftDeletes;

class MainCustomersession extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'main_customersession';
    protected $connection='pgsql_business';
    //没有主键ID
    protected $itemName = '对话';
    //批量赋值白名单
    protected $fillable = [
       'title',
       'summary',
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
        'title' => '',
        'user_id' => 0,
        'is_deleted' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'id',
        'title' => '标题',
        'summary' => '会话摘要',
        'user_id' => '用户',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'is_deleted' => '是否已删除'
    ];
    const DELETED_VALUE = true;//软删除值 不设置默认为1
    const UN_DELETED_VALUE = false;//未删除值 不设置默认为o
    protected $casts = [
        'id' => 'string'
    ];
    public $incrementing = false;
    protected $keyType = 'string';


    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function main_customer(){
        return $this->belongsTo('App\Models\MainCustomer','user_id');
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function main_customersessionconversations(){
        return $this->hasMany('App\Models\MainCustomersessionconversation','customer_session_id');
    }

}
