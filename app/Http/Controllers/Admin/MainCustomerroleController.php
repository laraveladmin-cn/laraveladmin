<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\MainCustomerrole;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class MainCustomerroleController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'MainCustomerrole';

    public $sizer=[
        'name|code'=>'like'
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
        $validate = ['name'=>'required','code'=>'required'];
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param  $id
    * @param  $data
    * @return  mixed
    */
    protected function handleEditReturn($id,&$data){
        return $data;
    }


}
