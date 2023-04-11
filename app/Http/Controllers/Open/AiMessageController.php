<?php

namespace App\Http\Controllers\Open;

use App\Facades\Option;
use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use LaravelAdmin\LaravelOpenAi\Facades\OpenAI;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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
               return $this->handleItem($item);
            })
            ->toArray();
        return $data;
    }

    protected function handleItem($item){
        if(!$item){
            return $item;
        }
        $item = collect($item)->toArray();
        $item['created'] = Carbon::createFromFormat('Y-m-d H:i:s',$item['created_at'])
            ->diffForHumans();
        return $item;
    }

    /**
     * 执行修改前对数据进行处理
     * @param $data
     * @return mixed
     */
    protected function handlePostEditReturn(&$data)
    {
        $data['role'] = 1;
        return $data;
    }

    /**
     * 保存数据后对返回数据处理
     * @param $item
     * @param $data
     */
    protected function postAiContent($item, $data,$old_data=[])
    {
        //调用OpenAi接口
        $ai_chat = $item->ai_chat;
        $map_role = AiMessage::getFieldsMap('role_en');
        $messages = collect($ai_chat->ai_messages()
            ->take(Option::get('memory_session_length',1))
            ->orderBy('id','desc')
            ->get(['role','content']))
            ->map(function ($item, $key)use($map_role) {
                $item_data = collect($item)->toArray();
                $item_data['role'] = Arr::get($map_role,$item_data['role'],'user');
                return $item_data;
            })->toArray();
        $chat = OpenAI::chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);
        $res = json_decode($chat,true);
        $content = Arr::get($res,'choices.0.message.content','');
        $answer = null;
        if($content){
            $answer = AiMessage::query()->create([
                'ai_chat_id'=>$ai_chat->id,
                'role'=>2,
                'content'=>$content
            ]);
        }
        return $answer;
    }

    /**
     * 执行添加
     */
    public function create(\Illuminate\Http\Request $request)
    {
        $validate = $this->getValidateRule(0);
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return Response::returns([
                'errors' => $validator->errors()->toArray(),
                'message' => trans('The given data was invalid.') //提交数据无效
            ], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $id = $request->get('id');
        $this->bindModel OR $this->bindModel(); //绑定模型
        $data = $id ? $request->all() : $request->except('id');
        $data['operate_id'] = User::getOperateId();
        //处理修改时日期字段
        $data = $this->handDateFields($data, $this->importExcelDateFields);
        $data = $this->handlePostEditReturn($data);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data = $this->handlePostEditFindReturn($data,[]);
        //新增
        $item = $this->bindModel->create($data);
        if ($item === false) {
            return Response::returns(['alert' => alert([
                'message' => trans('Create a failure!') //创建失败
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR)], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        $this->saveRelation($item, $data);
        $this->handlePostEdit($item, $data,[]);
        $primaryKey = $this->newBindModel()->getKeyName() ?: 'id';
        $answer = $this->postAiContent($item, $data,[]);
        return Response::returns([
            $primaryKey => $item[$primaryKey],
            'alert' => alert([
                'message' => trans('Creating a successful!') //创建成功
            ]),
            'question'=>$this->handleItem($item),
            'answer'=>$this->handleItem($answer),
        ], HttpResponse::HTTP_CREATED);
    }


}
