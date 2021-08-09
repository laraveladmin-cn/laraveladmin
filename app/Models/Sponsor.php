<?php
/**
 * Sponsor模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'sponsors';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'url',
       'logo'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [];
    //字段默认值
    protected $fieldsDefault = [];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'name' => 'Sponsor',
        'url' => 'Link',
        'logo' => 'Logo Icon',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At'
    ];



    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donations(){
        return $this->hasMany('App\Models\Donation');
    }

}
