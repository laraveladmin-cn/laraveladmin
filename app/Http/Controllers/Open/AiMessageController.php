<?php

namespace App\Http\Controllers\Open;

use App\Facades\Option;
use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;

class AiMessageController extends Controller
{
    use ResourceController;

    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'AiMessage';

    public $sizer=[
        'ai_chat_id'=>'='
    ];

    public $sizerDefault=[
        'ai_chat_id'=>0
    ];


    public $orderDefault=[
        'id'=>'desc'
    ];

//    public $per_page=2;

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
        $data['maps']['chat_id'] = mapOption($data['row'],'chat_id');

        return $data;
    }
    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleIndexReturn(&$data)
    {
        $data['robot_head_url'] = Option::get('robot_head_url','/dist/img/chatgpt_logo.png');
        $data['system_head_url'] = config('laravel_admin.logo');
        $data['system_name'] = config('app.name');
        $data['robot_name'] = 'chatgpt';
        return $data;
    }

    /**
     * 列表页面返回数据前对数据处理
     * @param $data
     * @return mixed
     */
    protected function handleListReturn(&$data, $obj)
    {
        $data = collect($data)->toArray();
        $data['data'] = collect($data['data'])
            ->sortBy('id')
            ->values()
            ->map(function ($item, $key) {
                $item = collect($item)->toArray();
                $item['created'] = Carbon::createFromFormat('Y-m-d H:i:s',$item['created_at'])
                    ->diffForHumans();
                return $item;
            })
            ->toArray();
        return $data;
    }


}
