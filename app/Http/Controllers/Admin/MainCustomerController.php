<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\MainCustomer;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class MainCustomerController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'MainCustomer';

    public $showIndexFields=[
        'main_customerrole'=>[
            'id','name'
        ]

    ];
    public $sizer=[
        'name|mobile'=>'like'
    ];

    /**
     * 验证规则
     * @return    array
     */
    protected function getValidateRule($id=0)
    {
        return $this->getImportValidateRule($id,Request::all());
    }

    /**
     * 验证规则
     * @return  array
     */
    protected function getImportValidateRule($id = 0, $item){
        $validate = ['mobile'=>'required','email'=>'nullable|email','is_active'=>'in:0,1','role_id'=>'required|exists:main_customerrole,id'];
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param  $id
    * @param  $data
    * @return  mixed
    */
    protected function handleEditReturn($id,&$data){
        $data['maps']['main_customerrole_id'] = mapOption($data['row'],'main_customerrole_id');
        return $data;
    }


}
