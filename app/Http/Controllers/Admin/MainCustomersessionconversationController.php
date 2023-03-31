<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\MainCustomersessionconversation;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class MainCustomersessionconversationController extends Controller
{
    use ResourceController;

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'MainCustomersessionconversation';

    public $sizer=[
        'user_id'=>'=',
        'customer_session_id'=>'=',
        'human'=>'like',
    ];

    public $showIndexFields=[
        'main_customer'=>['id','name','nickname','mobile'],
        'main_customersession'=>['id','title']
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
        $validate = [
            'human'=>'required',
            'customer_session_id'=>'required|exists:main_customersession,id',
            'user_id'=>'required|exists:main_customer,id'
        ];
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param  $id
    * @param  $data
    * @return  mixed
    */
    protected function handleEditReturn($id,&$data){
        $data['maps']['main_customersession_id'] = mapOption($data['row'],'main_customersession_id');
        $data['maps']['main_customer_id'] = mapOption($data['row'],'main_customer_id');
        return $data;
    }


}
