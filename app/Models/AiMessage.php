<?php
/**
 * 聊天室模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiMessage extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'ai_messages';
    //没有主键ID
    protected $itemName = '对话消息';
    //批量赋值白名单
    protected $fillable = [
       'ai_chat_id',
       'role',
       'content'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'role'=>[
            "0"=>'系统',
            "1"=>'用户',
            "2"=>'回答'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'ai_chat_id' => 0,
        'role' => 0,
        'content' => ''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'ai_chat_id' => '聊天室ID',
        'role' => '角色',
        'content' => '内容',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];




    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ai_chat(){
        return $this->belongsTo('App\Models\AiChat');
    }

}
