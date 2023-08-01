<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\MainCustomer;
use App\Models\MainCustomersession;
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
     * 默认排序
     * @var array
     */
    protected $orderDefault = [
        'created_at'=>'desc'
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

    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleIndexReturn(&$data)
    {
        if($customer_session_id = Request::input('where.customer_session_id')){
            $data['maps']['customer_session_id'] = collect(MainCustomersession::query()
                ->where('id','=',$customer_session_id)
                ->get(['id','title']))->toArray();
        }
        if($user_id = Request::input('where.user_id')){
            $data['maps']['user_id'] = collect(MainCustomer::query()
                ->where('id','=',$user_id)
                ->get(['id','name','mobile']))->toArray();
        }

        return $data;
    }


}
