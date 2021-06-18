<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Support\Facades\Request;

class BankController extends Controller
{
    use ResourceController;
    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Bank';


    protected $sizer=[
        'name'=>'like',
        'firms.firm_id'=>'='
    ];
    /**
     * Index页面字段名称显示
     * @var array
     */
    public $showIndexFields=[
        'banks.id',
        'name',
        'full_name',
        'order',
        'created_at',
        'updated_at'
    ];

    /**
     * Index页面字段名称显示多条数据统计值
     * @var array
     */
    public $showIndexFieldsCount=[
        'firms'
    ];



    /**
     * 验证规则
     * @return  array
     */
    protected function getValidateRule(){
        $id = Request::input('id',0);
        return [
            'name'=>'required',
            'full_name'=>'required|alpha|unique:banks,full_name,'.$id.',id,deleted_at,NULL',
            'order'=>'sometimes|integer',
        ];
    }

    protected function getImportValidateRule($id,$item){
        $validate = [
            'name'=>'sometimes|required',
            'full_name'=>'required|alpha|unique:banks,full_name,'.$id.',id,deleted_at,NULL',
            'order'=>'sometimes|integer',
        ];
        if(!$id && isset($item['full_name'])){
            $validate['full_name'] = 'required|alpha|unique:banks,full_name,'.$item['full_name'].',full_name,deleted_at,NULL';
        }
        return $validate;
    }

}
