<?php
/**
 * 聊天室模型
 */
namespace App\Models;
use App\Services\SessionService;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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
       'content',
        'read_url'
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
         ],
        'role_en'=>[
            "0"=>'system',
            "1"=>'user',
            "2"=>'assistant'
        ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'ai_chat_id' => 0,
        'role' => 0,
        'content' => '',
        'read_url'=>''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'ai_chat_id' => '聊天室ID',
        'role' => '角色',
        'content' => '内容',
        'read_url'=>'内容阅读音频地址',
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

    public function scopeMain($q){
        $ai_chat_ids = AiChat::query()->main()->pluck('id')->toArray()?:[];
        $q->whereIn('ai_chat_id',$ai_chat_ids);
        return $q;
    }

}
