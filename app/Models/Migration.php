<?php
/**
 * 模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;

class Migration extends Model
{
    protected $table = 'migrations'; //数据表名称
    protected $itemName='迁移记录';
    public $timestamps = false;
    use BaseModel; //软删除
    //批量赋值白名单
    protected $fillable = ['migration','batch'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = [];

}
