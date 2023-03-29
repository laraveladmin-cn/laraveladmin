<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class AiMessageController extends Controller
{
    use ResourceController;

    public $showIndexFields=[
        'ai_chat'=>[
            'user'=>['id','name','uname'],
            'ouser'=>['id','type','data'],
        ]
    ];


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'AiMessage';

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
        $data['maps']['ai_chat_id'] = mapOption($data['row'],'chat_id');
        return $data;
    }


}
