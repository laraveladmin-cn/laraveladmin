<?php
/**
 * 模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;

class Log extends Model
{
    //日志记录存放1年
    public $past_due = 3600*24*365;

    use BaseModel,SoftDeletes; //基础模型

    protected $table = 'logs'; //数据表名称
    //批量赋值白名单
    protected $fillable = [
        'menu_id',
        'user_id',
        'location',
        'ip',
        'parameters',
        'return'
    ];
    //字段默认值
    protected $fieldsDefault = [
        'menu_id' => 0,
        'user_id' => 0,
        'location' => '',
        'ip' => ''
    ];
    protected $fieldsName = [
        'menu_id' => 'Menu ID',
        'user_id' => 'User ID',
        'location' => 'Position',
        'ip' => 'IP address',
        'parameters' => 'Request parameters',
        'return' => 'Return data',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At',
        'id' => 'ID',
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * 日志用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }


    /**
     * 日志对应菜单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }


}
