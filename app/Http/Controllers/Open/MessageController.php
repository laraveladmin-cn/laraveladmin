<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class MessageController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'Message';

    public $sizer=[
        'id'=>'>',
        'user_id'=>'=',
        'type'=>'=',
        'title'=>'like',
        'title|content'=>'like'
    ];

    public $orderDefault=[
        'id'=>'asc'
    ];

    /**
     * 绑定模型
     *
     * @return mixed
     */
    protected function bindModel()
    {
        if ( ! $this->bindModel ) {
            $this->bindModel = $this->newBindModel()
                ->main();
        }

        return $this->bindModel;
    }

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
            'user_id'=>'nullable|exists:users,id',
            'type'=>'required|in:0,1,2',
            'title'=>'required'
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
