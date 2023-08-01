<?php
/**
 * 文章模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use ZW\Laravel\Eloquent\Custom\SoftDeletes;

class MainCustomerarticle extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    protected $connection='pgsql_business';
    //数据表名称
    protected $table = 'main_customerarticle';
    //没有主键ID
    protected $itemName = '文章';
    //批量赋值白名单
    protected $fillable = [
       'title',
       'input',
       'options',
       'prompt',
       'content',
       'is_deleted'
    ];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at','updated_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'is_deleted'=>[
            "0"=>'否',
            "1"=>'是'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'title' => '',
        'input' => '',
        'prompt' => ''
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'id',
        'title' => '文章标题',
        'input' => '用户输入',
        'options' => '文章选项',
        'prompt' => '文章提示语',
        'content' => '文章内容',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'is_deleted' => '是否已删除'
    ];
    const DELETED_VALUE = true;//软删除值 不设置默认为1
    const UN_DELETED_VALUE = false;//未删除值 不设置默认为o
 /*   protected $casts = [
        'id' => 'string'
    ];
    public $incrementing = false;
    protected $keyType = 'string';*/



}
