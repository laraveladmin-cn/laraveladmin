<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\MainCustomerarticle;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class MainCustomerarticleController extends Controller
{
    use ResourceController;

    public $sizer=[
        'title|input'=>'like'
    ];


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'MainCustomerarticle';

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
            'title'=>'required',
            'input'=>'required',
            'options'=>'required',
            'prompt'=>'required',
            'content'=>'required'
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
        return $data;
    }


}
