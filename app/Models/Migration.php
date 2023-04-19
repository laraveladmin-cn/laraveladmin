<?php
/**
 * 模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;

/**
 * App\Models\Migration
 *
 * @property int $id
 * @property string $migration
 * @property int $batch
 * @method static \Illuminate\Database\Eloquent\Builder|Migration commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Migration mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Migration optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Migration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Migration whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Migration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Migration whereMigration($value)
 * @mixin \Eloquent
 */
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
