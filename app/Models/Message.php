<?php
/**
 * 聊天室模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'messages';
    //没有主键ID
    protected $itemName = '聊天室';
    //批量赋值白名单
    protected $fillable = [
       'chat_id',
       'role',
       'conternt'
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
        'chat_id' => 0,
        'role' => 0,
        'conternt' => ''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'chat_id' => '聊天室ID',
        'role' => '角色',
        'conternt' => '内容',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];




    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chat(){
        return $this->belongsTo('App\Models\Chat');
    }

}
