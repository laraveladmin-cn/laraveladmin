<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class ChatController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Chat';

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
        $validate = [];
        return $validate;
    }

    /**
    * 编辑页面数据返回处理
    * @param  $id
    * @param  $data
    * @return  mixed
    */
    protected function handleEditReturn($id,&$data){
        $data['maps']['user_id'] = mapOption($data['row'],'user_id');
        $data['maps']['ouser_id'] = mapOption($data['row'],'ouser_id');
        return $data;
    }


}
