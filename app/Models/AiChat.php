<?php
/**
 * 聊天室模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiChat extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'ai_chats';
    //没有主键ID
    protected $itemName = '聊天室';
    //批量赋值白名单
    protected $fillable = [
       'ouser_id',
       'user_id',
       'name',
        'client_id'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [
        'ouser_id' => 0,
        'user_id' => 0,
        'name' => '',
        'client_id'=>''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'ouser_id' => '三方登录用户ID',
        'user_id' => '用户ID',
        'name' => '聊天室名称',
        'client_id'=>'连接ID',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];




    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ouser(){
        return $this->belongsTo('App\Models\Ouser');
    }

    public function ai_messages(){
        return $this->hasMany('App\Models\AiMessage');
    }

}
