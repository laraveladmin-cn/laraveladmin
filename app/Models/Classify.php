<?php
/**
 * 险种分类模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use App\Models\Traits\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classify extends Model
{

    use BaseModel; //基础模型
    use TreeModel; //树状结构
    use SoftDeletes; //软删除
    //数据表Name
    protected $table = 'classifys';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'description',
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
        'name' => '',
        'parent_id' => 0,
        'level' => 0,
        'left_margin' => 0,
        'right_margin' => 0
    ];
    //字段默认值
    protected $fieldsName = [
        'name' => 'Name',
        'description' => 'Remarks',
        'parent_id' => 'Parent ID',
        'level' => 'Hierarchy',
        'left_margin' => 'Left border',
        'right_margin' => 'Right border',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At',
        'id' => 'ID',
    ];

    /**
     * 一级分类获取险种
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function firstProducts()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * 二级分类获取险种
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secondProducts()
    {
        return $this->hasMany('App\Models\Product',$this->getKeyName(),'classify2_id');
    }


}
