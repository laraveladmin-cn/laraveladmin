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

class AiChat extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'ai_chats';
    //没有主键ID
    protected $itemName = '对话';
    //批量赋值白名单
    protected $fillable = [
       'ouser_id',
       'user_id',
       'name',
        'client_id',
        'abstract',
        'message_id',
        'abstract_res'
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
        'name' => '新对话',
        'client_id'=>'',
        'abstract'=>'',
        'message_id'=>0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'ouser_id' => '三方登录用户ID',
        'user_id' => '用户ID',
        'name' => '聊天室名称',
        'client_id'=>'连接ID',
        'abstract'=>'摘要',
        'message_id'=>'已摘要到消息ID',
        'abstract_res'=>'摘要响应结果',
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

    public function scopeMain($q){
        $q->where(function ($q){
            $request = Request::instance();
            $open_id = $request->header('Open-Id')?:$request->cookie('Open-Id');
            $open_id = $open_id?:0;
            $client_id = SessionService::getId();
            $user_id = Arr::get(Auth::user(),'id',0);
            $q->where('client_id',$client_id);
            if($user_id){
                $q->orWhere('user_id',$user_id);
            };
            if($open_id){
                $q->orWhere('ouser_id',$open_id);
            };
        });
        return $q;
    }

}
