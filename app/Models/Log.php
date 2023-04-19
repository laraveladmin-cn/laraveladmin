<?php
/**
 * 模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Log
 *
 * @property int $id ID
 * @property int $menu_id 菜单ID
 * @property int $user_id 用户ID
 * @property string $location 位置
 * @property string $ip IP地址
 * @property string|null $parameters 请求参数
 * @property string|null $return 返回数据
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Menu|null $menu
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Log commaMapValue($key)
 * @method static \Illuminate\Database\Eloquent\Builder|Log getClassName()
 * @method static \Illuminate\Database\Eloquent\Builder|Log getFieldsDefault($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Log getFieldsMap($key = '', $decode = false, $trans = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Log getFieldsName($key = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Log getFillables()
 * @method static \Illuminate\Database\Eloquent\Builder|Log getItemName()
 * @method static \Illuminate\Database\Eloquent\Builder|Log getTableComment()
 * @method static \Illuminate\Database\Eloquent\Builder|Log getTableInfo()
 * @method static \Illuminate\Database\Eloquent\Builder|Log getTableName()
 * @method static \Illuminate\Database\Eloquent\Builder|Log ignoreUpdateAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Log insertReplaceAll($datas)
 * @method static \Illuminate\Database\Eloquent\Builder|Log main($self = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Log mainDB()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Query\Builder|Log onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Log options(array $options = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Log optionsWhere($where = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Log withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Log withoutTrashed()
 * @mixin \Eloquent
 */
class Log extends Model
{
    //日志记录存放1年
    public $past_due = 3600*24*365;

    use BaseModel,SoftDeletes; //基础模型
    protected $itemName='日志';
    protected $table = 'logs'; //数据表名称
    //批量赋值白名单
    protected $fillable = [
        'menu_id',
        'user_id',
        'location',
        'ip',
        'parameters',
        'return'
    ];
    //字段默认值
    protected $fieldsDefault = [
        'menu_id' => 0,
        'user_id' => 0,
        'location' => '',
        'ip' => ''
    ];
    protected $fieldsName = [
        'menu_id' => 'Menu ID',
        'user_id' => 'User ID',
        'location' => 'Position',
        'ip' => 'IP address',
        'parameters' => 'Request parameters',
        'return' => 'Return data',
        //'created_at' => 'Created At',
        //'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At',
        'id' => 'ID',
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * 日志用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }


    /**
     * 日志对应菜单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }

    /**
     * 我管理的日志
     */
    public function scopeMain($query,$self='='){
        //登录用户
        $user = Auth::user();
        //超级管理员
        if ($user && Role::isSuper()) {
            return $query;
        }
        $query->whereHas('user.admin',function ($q)use ($self){
            $q->main($self);
        })->whereHas('menu',function ($q){
            $q->main();
        });
        return $query;

    }


}
