<?php
/**
 * 移动端应用模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'apps';
    //没有主键ID
    protected $itemName = '移动端应用';
    //批量赋值白名单
    protected $fillable = [
       'type',
       'name',
       'description',
       'url',
       'version',
       'forced_update',
       'operate_id'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'type'=>[
            1=>'安卓应用',
            2=>'IOS应用'
        ],
        'forced_update'=>[
            '否',
            '是'
        ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'type' => 1,
        'name' => '',
        'description' => '',
        'url' => '',
        'version' => '',
        'forced_update' => 0,
        'operate_id' => 0
    ];
    //字段说明
    protected $fieldsName = [
        'id' => 'ID',
        'type' => '类型',
        'name' => '名称',
        'description' => '描述',
        'url' => '应用程序下载地址',
        'version' => '版本号',
        'forced_update' => '是否强制更新',
        'operate_id' => '操作人',
        'created_at' => '创建时间',
        'updated_at' => '修改时间',
        'deleted_at' => '删除时间'
    ];

    /**
     * 操作者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operate(){
        return $this->belongsTo(User::class,'operate_id');
    }


}
