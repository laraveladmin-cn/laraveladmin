<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Ouser;
use App\Services\SessionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\AiChat;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class AiChatController extends Controller
{
    use ResourceController;


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'AiChat';

    public $sizer=[
        'name'=>'like'
    ];

    public $order=[
        'id'=>'desc'
    ];


    /**
     * 绑定模型
     * @return mixed
     */
    protected function bindModel()
    {
        if (!$this->bindModel) {
            $fullTextSearch = $this->existFullTextSearch();
            if($fullTextSearch){ //全文搜索时优先进行搜索获取搜索结果对象
                $this->bindModel = $this->newBindModel()
                    ->search(Arr::get($fullTextSearch,'val',''));
            }else{
                $this->bindModel = $this->newBindModel()->main();
            }
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

    /**
     * 执行修改前查询到数据结果后对数据进行处理
     * @param $data
     * @param $item
     * @return mixed
     */
    protected function handlePostEditFindReturn(&$data,$item){
        $request = Request::instance();
        $open_id = $request->header('Open-Id')?:$request->cookie('Open-Id');
        $data['client_id'] = SessionService::getId();
        $data['ouser_id'] = $open_id?:0;
        $data['user_id'] = Arr::get(Auth::user(),'id',0);
        return $data;
    }


}
