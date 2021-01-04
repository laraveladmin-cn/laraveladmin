<?php
/**
 * 保险公司模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firm extends Model
{

    use BaseModel; //基础模型
    use SoftDeletes; //软删除
    //数据表名称
    protected $table = 'firms';
    protected $tableComment = '保险公司';
    //批量赋值白名单
    protected $fillable = [
       'name',
       'full_name',
       'type',
       'url',
       'logo',
       'uname_rule',
       'password_rule',
       'default_password',
       'account_day_by_sign_at',
       'account_day_by_end_at',
       'url_rule',
       'url_rule_tpl',
       'description',
       'order',
       'account_at_merge',
       'service_api',
       'insure_notify',
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'type'=>[
            "1"=>'寿险',
            "2"=>'财险'
         ],
        'uname_rule'=>[
            "0"=>'无规则',
            "1"=>'代理人工号',
            "2"=>'身份证号',
            "3"=>'手机号码'
         ],
        'password_rule'=>[
            "0"=>'无规则',
            "1"=>'身份证后6位',
            "2"=>'固定值'
         ],
        'url_rule'=>[
            "0"=>'无规则',
            "1"=>'账号模板规则'
         ],
        'service_api'=>[
            "guobao"=>'国宝'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'name' => '',
        'type' => [1],
        'url' => '',
        'logo' => '',
        'uname_rule' => 0,
        'password_rule' => 0,
        'default_password' => '',
        'account_day_by_sign_at' => 0,
        'account_day_by_end_at' => 0,
        'url_rule' => 0,
        'url_rule_tpl' => '',
        'order' => 0,
        'account_at_merge' => 0,
        'service_api' => '',
        'insure_notify'=>''
    ];

    //字段名称
    protected $fieldsName = [
        'name'=>'名称',
        'full_name'=>'全称',
        'type'=>'类型',
        'url'=>'公司网站',
        'logo'=>'品牌LOGO',
        'uname_rule'=>'代理账号规则',
        'password_rule'=>'代理账号密码规则',
        'default_password'=>'固定密码值',
        'account_day_by_sign_at'=>'签单日期计算业务月份',
        'account_day_by_end_at'=>'交回执日期计算业务月份',
        'url_rule'=>'链接规则',
        'url_rule_tpl'=>'链接规则模板',
        'description'=>'描述',
        'order'=>'排序',
        'account_at_merge'=>'合并预计结算月份开关',
        'service_api'=>'对接服务',
        'insure_notify'=>'投保须知',
        'id'=>'ID',
    ];

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getTypeAttribute($value)
    {
        $field = $this->getFieldsMap('type')->toArray();
        unset($field[0]);
        return multiple($value,$field);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = multipleToNum($value);
    }

    /**
     * 筛选条件选项
     */
    public function scopeOptionsMap($q,$obj=false){
        if($obj){
            return self::get(['id','name']);
        }else{
            return self::pluck('name','id');
        }
    }

    /* 保险公司-支持的银行 */
    public function banks(){
        return $this->belongsToMany('App\Models\Bank');
    }

    /**
     * 品牌拥有的险种
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(){
        return $this->hasMany('App\Models\Product');
    }


}
