<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Models\Bank;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;

class FirmController extends Controller
{
    use ResourceController;
    public function __construct()
    {
        //统计长期险种数量
        $this->showIndexFieldsCount['products AS products_count_is_long_time'] = function ($q){
            $q->where('is_long_time',1);
        };
    }

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Firm';

    /**
     * 列表页面查询字段
     * @var array
     */
    public $showIndexFields=[
        'id','name','logo','url','description','updated_at',
        'products_count_status'=>[]
    ];

    /**
     * Index页面字段名称显示多条数据统计值
     * @var array
     */
    public $showIndexFieldsCount=[
        'products','banks'
    ];


    /**
     * 允许筛选条件规则
     * @var array
     */
    protected $sizer = [
        'name' => 'like',
        'banks.bank_id'=>'='
    ];

    /**
     * 编辑页面查询字段
     * @var array
     */
    public $editFields = [
        'banks'=>['banks.id']
    ];

    /**
     * 允许的更多非本表字段的排序字段
     * @var array
     */
    public $allowOrderMore=[
        'products_count_is_long_time'
    ];


    /**
     * 单条数据提交验证规则
     * @return  array
     */
    protected function getValidateRule()
    {
        $id = Request::input('id', 0);
        return [
            'name' => 'required|alpha|unique:firms,name,' . $id . ',id,deleted_at,NULL',
            'logo' => 'nullable',
            'account_day_by_sign_at' => 'sometimes|integer|between:0,31',
            'account_day_by_end_at' => 'sometimes|integer|between:0,31',
            'order' => 'nullable|integer',
            'url' => 'nullable|url'
        ];
    }

    /**
     * 批量导入单条数据验证
     * @param $id
     * @param $item
     * @return array
     */
    protected function getImportValidateRule($id,$item){
        $validate = [
            'name' => 'required|alpha|unique:firms,name,' . $id . ',id,deleted_at,NULL',
            'full_name'=>'required|alpha|unique:banks,full_name,'.$id.',id,deleted_at,NULL',
            'logo' => 'nullable|url',
            'account_day_by_sign_at' => 'sometimes|integer|between:0,31',
            'account_day_by_end_at' => 'sometimes|integer|between:0,31',
            'order' => 'nullable|integer',
            'url' => 'nullable|url'
        ];
        if(!$id && isset($item['full_name'])){
            $validate['full_name'] = 'required|alpha|unique:banks,full_name,'.$item['full_name'].',full_name,deleted_at,NULL';
        }
        return $validate;
    }

    /**
     * 编辑页面数据返回处理
     * @param $id
     * @param $data
     * @return mixed
     */
    protected function handleEditReturn($id,&$data){
        //查询所有银行
        $data['maps']['bank_ids'] = Bank::optionsMap();
        return $data;
    }


    /**
     * excel导出数据查询字段
     * @var array
     */
    public $exportFields = [
        'banks'=>[
            'banks.id','name'
        ]
    ];

    /**
     * 导出字段名称
     * @var array
     */
    public $exportFieldsName = [
        'name'=>'Name', //名称
        'full_name'=>'Full name', //全称
        'type'=>'Type', //类型
        'url'=>'Company website', //公司网站
        'logo'=>'Brand logo', //品牌LOGO
        'uname_rule'=>'Agent account rules', //代理账号规则
        'password_rule'=>'Proxy account password rules', //代理账号密码规则
        'default_password'=>'Fixed password value', //固定密码值
        'account_day_by_sign_at'=>'Business month calculated by signing date', //签单日期计算业务月份
        'account_day_by_end_at'=>'Business month calculated by return receipt date', //交回执日期计算业务月份
        'url_rule'=>'Link rules', //链接规则
        'url_rule_tpl'=>'Link rules template', //链接规则模板
        'description'=>'Describe', //描述
        'order'=>'Sort', //排序
        'account_at_merge'=>'Consolidated expected settlement month', //合并预计结算月份开关
        'service_api'=>'Docking services', //对接服务
        'insure_notify'=>'Insurance notice', //投保须知
        'banks.$index.name'=>'Withholding Bank',//'代扣银行', //一对多属性获取
        'id'=>'ID',
    ];








}
