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
    //数据表Name
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
    //字段Name
    protected $fieldsName = [
        'id' => 'ID',
        'uid' => 'Unique identification',
        'firm_id' => 'Insurance company ID',
        'classify_id' => 'First level classification ID',
        'classify2_id' => 'Secondary classification ID',
        'pclassify_id' => 'Insurance group ID',
        'name' => 'Name',
        'is_long_time' => 'Long term insurance',
        'class' => 'Category',
        'buy_type' => 'Purchase method',
        'pay_type' => 'Payment method',
        'attr' => 'Product attributes',
        'pdf_url' => 'Document address',
        'company_no' => 'Insurance company document number',
        'no' => 'Document number',
        'status' => 'State',
        'issue_at' => 'Release time',
        'stop_at' => 'Closing date',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        //'deleted_at' => 'Deleted At'
    ];
    //字段值map
    protected $fieldsShowMaps = [
        'is_long_time'=>[
            "0"=>'Short-term',
            "1"=>'Long-term'
         ],
        'class'=>[
            "0"=>'Traditional products',
            "1"=>'New products'
         ],
        'buy_type'=>[
            "1"=>'Personal',
            "2"=>'Group'
         ],
        'pay_type'=>[
            "1"=>'One time payment',
            "2"=>'Payment by installments',
            "4"=>'Flexible payment'
         ],
        'attr'=>[
            "0"=>'Nothing',
            "1"=>'Student FPA',
            "2"=>'Exclusive products for women',
            "3"=>'Exclusive products for children',
            "4"=>'Exclusive products for the elderly',
            "5"=>'Aviation accident insurance'
         ],
        'status'=>[
            "0"=>'Halt the sales',
            "1"=>'On sale',
            "2"=>'Out of service'
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
