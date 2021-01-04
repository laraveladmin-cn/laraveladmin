<?php
/**
 * 险种模型
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\BaseModel;

class Product extends Model
{

    use BaseModel,SoftDeletes; //基础模型
    //数据表名称
    protected $table = 'products';
    protected $tableComment = '险种';
    //批量赋值白名单
    protected $fillable = [
       'uid',
       'firm_id',
       'classify_id',
       'classify2_id',
        'pclassify_id',
       'name',
       'is_long_time',
       'class',
       'buy_type',
       'pay_type',
       'attr',
       'pdf_url',
       'company_no',
       'no',
       'status',
       'issue_at',
       'stop_at'
    ];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
    //字段值map
    protected $fieldsShowMaps = [
        'is_long_time'=>[
            "0"=>'短期',
            "1"=>'长期'
         ],
        'class'=>[
            "0"=>'传统型产品',
            "1"=>'新型产品'
         ],
        'buy_type'=>[
            "1"=>'个人',
            "2"=>'团体'
         ],
        'pay_type'=>[
            "1"=>'一次性交费',
            "2"=>'分期交费',
            "4"=>'灵活交费'
         ],
        'attr'=>[
            "0"=>'无',
            "1"=>'学生平安险',
            "2"=>'女性专属产品',
            "3"=>'少儿专属产品',
            "4"=>'老年专属产品',
            "5"=>'航空意外险'
         ],
        'status'=>[
            "0"=>'停售',
            "1"=>'在售',
            "2"=>'停用'
         ]
    ];
    //字段默认值
    protected $fieldsDefault = [
        'uid' => '',
        'firm_id' => 0,
        'classify_id' => 0,
        'classify2_id' => 0,
        'pclassify_id'=>0,
        'name' => '',
        'is_long_time' => 1,
        'class' => 0,
        'buy_type' => 0,
        'pay_type' => [],
        'attr' => 0,
        'pdf_url' => '',
        'company_no' => '',
        'no' => '',
        'status' => 1
    ];

    /**
     * 获取多选值
     * @param  $value
     * @return  array
     */
    public function getPayTypeAttribute($value)
    {
        $field = $this->getFieldsMap('pay_type')->toArray();
        unset($field[0]);
        return multiple($value,$field);
    }

    /**
     * 设置多选值
     * @param  $value
     * @return  array
     */
    public function setPayTypeAttribute($value)
    {
        $this->attributes['pay_type'] = multipleToNum($value);
    }

    /**
     * 该险种属于某品牌
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firm(){
        return $this->belongsTo('App\Models\Firm');
    }


    /**
     * 险种一级分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classify()
    {
        return $this->belongsTo('App\Models\Classify');
    }

    /**
     * 险种二级分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classify2()
    {
        return $this->belongsTo('App\Models\Classify','classify2_id');
    }

    public function pclassify()
    {
        return $this->belongsTo('App\Models\Pclassify');
    }

    /**
     * 一个险种拥有多个年期可选
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function years(){
        return $this->belongsToMany('App\Models\Year');
    }


}
