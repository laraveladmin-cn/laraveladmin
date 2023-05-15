<?php

namespace App\Http\Controllers\Open;

use AlibabaCloud\Client\AlibabaCloud;
use App\Facades\Option;
use App\Http\Controllers\Traits\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\AiPromptTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
        'ai_chat_id'=>'=',
        'id'=>'<' //id小于
    ];

    public $sizerDefault=[
        'ai_chat_id'=>0
    ];


    public $orderDefault=[
        'id'=>'desc'
    ];


    protected $timezone=null;
    public function __construct()
    {
        $request = Request::instance();
        $this->timezone = $request->header('TimeZone')?:$request->cookie('TimeZone');
    }

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
        $item['created'] = Carbon::createFromFormat('Y-m-d H:i:s',$item['created_at'],$this->timezone)
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
        $message_id = Arr::get($ai_chat,'message_id',0);
        $abstract = Arr::get($ai_chat,'abstract','');//摘要内容
        $memory_session_length= Option::get('memory_session_length',1);
        $has_system = false;
        $messages = collect($ai_chat->ai_messages()
            ->where('id','>',$message_id)
            ->where('role','<>',2)
            ->take($memory_session_length)
            ->orderBy('id','desc')
            ->get(['id','role','content']))
            ->sortBy('id')
            ->values()
            ->map(function ($item, $key)use($map_role,&$has_system) {
                $item_data = collect($item)->except('id')->toArray();
                if($item_data['role']==0){
                    $has_system = true;
                }
                if($item_data['role']==2){
                    $item_data['content'] = Str::limit($item_data['content'],30,'...');
                }
                $item_data['role'] = Arr::get($map_role,$item_data['role'],'user');
                return $item_data;
            });
        if(!$has_system){
            $content = $ai_chat->ai_messages()->where('role',0)->value('content');
            if($content){
                $messages = $messages->prepend([
                    'role'=>'system',
                    'content'=>$content
                ]);
            }
        }
        if($abstract){
            $messages = $messages->prepend([
                'role'=>'system',
                'content'=>$abstract
            ]);
        }
        $chat = OpenAI::chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages->toArray(),
            'temperature' => 1.0,
            'max_tokens' => 4096,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);
        $res = json_decode($chat,true);
        $content = Arr::get($res,'choices.0.message.content','');
        if($error = Arr::get($res,'error')){
            $content = json_encode($error,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        }
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
        $init_message = $this->initMessage($data);
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
        $this->summary($item,$answer);
        return Response::returns([
            $primaryKey => $item[$primaryKey],
            '_alert' => alert([
                'message' => trans('Creating a successful!') //创建成功
            ]),
            'question'=>$this->handleItem($item),
            'answer'=>$this->handleItem($answer),
            'init_message'=>$this->handleItem($init_message)
        ], HttpResponse::HTTP_CREATED);
    }

    /**
     * 总结对话摘要信息
     * @return void
     */
    protected function summary($item,$answer){
        $ai_chat = $item->ai_chat;
        $last_answer_id = Arr::get($answer,'id',0);
        $abstract_session_length = Option::get('abstract_session_length',0);
        $count= $ai_chat->ai_messages()->where('id','>',$last_answer_id)->count();
        $abstract_content = Option::get('abstract_content','');
        if($count >= $abstract_session_length && $abstract_session_length && $abstract_content){
            $messages = collect($ai_chat->ai_messages()
                ->where('role','>',0)
                ->where('id','>',$last_answer_id)
                ->orderBy('id','desc')
                ->get(['id','role','content']))
                ->sortBy('id')
                ->values();
            $max_id = $messages->max('id');
            $messages = $messages->map(function ($item, $key) {
                    $item_data = collect($item)->except('id')->toArray();
                    return $item_data;
                });
            //拼接摘要文案
            $messages = $messages->prepend([
                'role'=>'system',
                'content'=>$abstract_content
            ]);
            //生成摘要
            $abstract_str = OpenAI::chat([
                'model' => 'gpt-3.5-turbo',
                'documents' => $messages->toArray(),
                'max_tokens' => 4096,
                'temperature' => 1.0,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);
            $res = json_decode($abstract_str,true);
            $abstract = Arr::get($res,'choices.0.text','');
            if($error = Arr::get($res,'error')){
                $abstract = json_encode($error,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
            }
            $data = [
                'abstract_res'=>$abstract_str
            ];
            if($abstract){
                $data['abstract'] = $abstract;
                $data['message_id'] = $max_id;
            }
            $ai_chat->update($data);
        }

    }

    /**
     * 执行修改前查询到数据结果后对数据进行处理
     * @param $data
     * @param $item
     * @return mixed
     */
    protected function initMessage(&$data){
        $ai_message = null;
        $ai_prompt_template_id = Arr::get($data,'ai_prompt_template_id');
        if($ai_prompt_template_id && !AiMessage::query()
                ->where('ai_chat_id',$data['ai_chat_id'])
                ->value('id')){
            $ai_prompt_template = AiPromptTemplate::query()->find($ai_prompt_template_id);
            if($ai_prompt_template){
                $ai_message = AiMessage::query()->create([
                    'ai_chat_id'=>$data['ai_chat_id'],
                    'role'=>0,
                    'content'=>AiPromptTemplate::getPrompt(Arr::get($data,'ai_prompt_template',[]))
                ]);
            }
        }
        return $ai_message;
    }





}
