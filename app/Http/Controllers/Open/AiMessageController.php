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

    public $sizer=[
        'ai_chat_id'=>'='
    ];

    public $sizerDefault=[
        'ai_chat_id'=>0
    ];


    /**
     * 资源模型
     * @var  string
     */
    protected $resourceModel = 'AiMessage';

    public $orderDefault=[
        'id'=>'desc'
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
