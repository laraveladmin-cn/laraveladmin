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
    //数据表Name
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
            "1"=>'Life insurance',
            "2"=>'Property insurance'
         ],
        'uname_rule'=>[
            "0"=>'No rules',
            "1"=>'Agent number',
            "2"=>'ID number',
            "3"=>'Phone number'
         ],
        'password_rule'=>[
            "0"=>'No rules',
            "1"=>'Last 6 digits of ID card',
            "2"=>'Fixed value'
         ],
        'url_rule'=>[
            "0"=>'No rules',
            "1"=>'Account template rules'
         ],
        'service_api'=>[
            "guobao"=>'National treasure'
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

    //字段Name
    protected $fieldsName = [
        'name'=>'Name',
        'full_name'=>'Full name',
        'type'=>'Type',
        'url'=>'Company website',
        'logo'=>'Brand logo',
        'uname_rule'=>'Agent account rules',
        'password_rule'=>'Proxy account password rules',
        'default_password'=>'Fixed password value',
        'account_day_by_sign_at'=>'Business month calculated by signing date',
        'account_day_by_end_at'=>'Business month calculated by return receipt date',
        'url_rule'=>'Link rules',
        'url_rule_tpl'=>'Link rules模板',
        'description'=>'Describe',
        'order'=>'Sort',
        'account_at_merge'=>'Consolidated expected settlement month',
        'service_api'=>'Docking services',
        'insure_notify'=>'Insurance notice',
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
