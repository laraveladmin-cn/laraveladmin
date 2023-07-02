<?php
/**
 * 消息模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'messages';
    //没有主键ID
    protected $itemName = '消息';
    //批量赋值白名单
    protected $fillable = [
       'user_id',
       'type',
       'title',
       'content',
       'operate_id'
    ];
    //输出隐藏字段
    protected $hidden = [
        'deleted_at'
    ];
    //日期字段
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //字段值map
    protected $fieldsShowMaps = [
        'type'=>[
            '提醒',
            '消息',
            '重要'
        ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'user_id' => 0,
        'type' => 1,
        'title' => '',
        'content' => '',
        'operate_id' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'user_id' => '用户ID',
        'type' => '类型',
        'title' => '标题',
        'content' => '内容',
        'operate_id' => '操作者',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];

    /**
     * 所属用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * 操作者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operate(){
        return $this->belongsTo(User::class,'operate_id');
    }

    /**
     * 我管理的学员
     * @param $query
     * @return mixed
     */
    public function scopeMain($query){
        //登录用户
        $user = Auth::user();
        if(!$user){
            $query->where('user_id',0);
        }else{
            $query->where(function ($query)use($user){
                $query->orWhere('user_id','=',Arr::get($user,'id',0))
                    ->where('user_id',0);
            });
        }
        return $query;
    }


}
