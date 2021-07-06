<?php
/**
 * 会员模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use App\Models\Traits\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{

    use BaseModel; //基础模型
    use TreeModel; //树状结构
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'members';
    //批量赋值白名单
    protected $fillable = [
       'user_id',
       'parent_id'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [
        'user_id' => 0,
        'parent_id' => 0,
        'level' => 0,
        'left_margin' => 0,
        'right_margin' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'user_id' => '用户ID',
        'parent_id' => '推荐人ID',
        'level' => '层级',
        'left_margin' => '左边界',
        'right_margin' => '右边界',
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
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donations(){
        return $this->hasMany('App\Models\Donation');
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bills(){
        return $this->hasMany('App\Models\Bill');
    }

}
