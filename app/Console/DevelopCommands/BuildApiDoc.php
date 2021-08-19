<?php

namespace App\Console\DevelopCommands;


use App\Console\BaseCommand;
use App\Facades\LifeData;
use App\Models\Menu;
use App\Models\Param;
use App\Models\Response;
use App\Services\RouteService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BuildApiDoc extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:api-doc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic scan to generate Api document data';

    protected $params = [];
    protected $responses = [];
    protected $now_at = '';
    protected $group = [];
    protected $common_responses = [];
    protected $mapsRelations = [];
    protected $table = '';
    protected $controller='';
    protected $menu_id = 0;
    protected $sizer = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('request')->offsetSet('json',1);
        Auth::loginUsingId(1); //模拟超管用户登录
        $this->now_at = Carbon::now()->toDateTimeString();
        $this->group = Arr::get(json_decode(file_get_contents(base_path('routes/route.json')),true),'group',[]);
        $file = storage_path('developments/api-doc.json');
        $data = json_decode(file_get_contents($file),true)?:[];
        $file1 = storage_path('developments/api-doc-common.json');
        $data1 = json_decode(file_get_contents($file1),true)?:[];
        $common_responses = Arr::get($data1,'common_responses',[]);
        collect(Arr::get($data1,'common_responses_list',[]))->each(function ($item)use(&$common_responses){
            $common_responses[] = $item;
            $common_responses[] = [
                'name'=>'list.'.$item['name'],
                'description'=>$item['description']
            ];
        });
        $this->common_responses = collect($common_responses)->keyBy('name')->toArray();
        $menus = collect(Arr::get($data,'menus',[]))
            ->keyBy('id')
            ->toArray();
        collect(Menu::where('method','<>',0)
            //->where('resource_id','<',1)
            //->where('method','&',1)
            //->where('id','>=',9)
            //->where('id','<=',16)
            //->where('id','=',13)
            ->with(['parent'=>function($q){
            $q->select([
                'id',
                'name',
                'item_name'
            ]);
        }])->get())->map(function ($menu)use(&$menus){
            //扫描菜单接口
            $item = Arr::get($menus,$menu['id']);
            if(!$item){
                $item = [
                    'id'=> $menu['id'],
                    config('laravel_admin.trans_prefix').'name'=>Menu::trans($menu,'name'),
                    'params'=>[],
                    'body_params'=>[],
                    'responses'=>[]
                ];
            };
            $responses_data = collect(Arr::get($item,'responses',[]))->keyBy('name')->toArray();
            $params_data = collect(Arr::get($item,'params',[]))->keyBy('name')->toArray();
            $route_params_data = collect(Arr::get($item,'route_params',[]))->keyBy('name')->toArray();
            $body_params_data = collect(Arr::get($item,'body_params',[]))->keyBy('name')->toArray();
            //获取路由响应数据
            $action = $menu['action'];
            $is_list = 0;

            if(!$action){
                $urls = explode('/',Arr::get($menu,'url',''));
                $value = Arr::get($urls,2,'');
                if($value){
                    $method = Arr::get($urls,3,'');
                    if($menu['resource_id']>0 && in_array($method,['excel','{id}',''])){ //资源列表接口
                        if($method=='excel'){
                            $method = 'export';
                            $is_list=2;
                        }elseif($method=='{id}' && in_array(1,$menu['method'])){
                            $method = 'edit';
                        }elseif($method=='{id}' && in_array(4,$menu['method'])){
                            $method = 'update';
                        }elseif($method=='' && in_array(2,$menu['method'])){
                            $method = 'create';
                        }elseif($method=='' && in_array(8,$menu['method'])){
                            $method = 'delete';
                        }
                    }elseif($method=='list'){
                        $is_list = 1;
                    }
                    $method = $method?:'index';
                    $action = RouteService::getClass($value).'@'.$method;
                }else{
                    $action = 'IndexController@index';
                }
            }
            $group = $menu['group'];//组
            if($menu['resource_id']>0){
                $group = $menu->resource['group'];
            }
            $namespace = Arr::get($this->group,$group.'.namespace','');
            $actions = explode('@',$action);
            $class = $namespace.'\\'.$actions[0];
            $method = $actions[1];
            $this->menu_id = $menu['id'];
            if(!class_exists($class)){
                dd($class,collect($menu)->toArray());
            }
            $this->controller = new $class();
            LifeData::clear();
            if(method_exists( $this->controller,'getSizer')){
                $this->sizer = $this->controller->getSizer();
            }else{
                $this->sizer = [];
            }
            $responses = [];
            try {
                if($method=='edit' && $menu['resource_id']>0){ //编辑查看页面
                    if(!isset($route_params_data['id'])){
                        $route_params_data['id'] = [
                            "name"=>'id',
                            "type"=> 2,
                            "title"=> 'ID',
                            "description"=> "数据ID",
                            "example"=> "0",
                            "validate"=> "正整数"
                        ];
                    }
                    $responses = $this->controller->$method(0);
                }elseif($method=='delete' && $menu['resource_id']>0){
                    if(!isset($body_params_data['ids[]'])){
                        $body_params_data['ids[]'] = [
                            "name"=>'ids[]',
                            "type"=> 2,
                            "title"=> 'ID',
                            "description"=> "数据ID;单条数据还可使用'ids'作为key",
                            "example"=> "1",
                            "validate"=> "正整数"
                        ];
                    }
                }elseif(in_array(1,$menu['method'])){
                    $responses = $this->controller->$method();
                }
            }catch (\Exception $exception){
                return; //出错跳过处理
            }


            if(is_object($responses)){
                if($responses instanceof \Illuminate\Database\Eloquent\Collection ||
                    $responses instanceof \Illuminate\Pagination\LengthAwarePaginator ||
                    $responses instanceof \Illuminate\Support\Collection){
                    $responses = collect($responses)->toArray();
                }else{
                    try {
                        $responses = $responses->getData(true);
                    }catch (\Exception $exception){
                        return; //出错跳过处理
                    }
                }
            }
            if(is_array($responses)){
                $responses = collect($responses)->toArray();
                if($model = $this->getRelationModel()){
                    $this->table = $model->getModel()->getTable()?:'';
                }else{
                    $this->table = Arr::get($responses,'excel.sheet','');
                }
                $this->mapsRelations = Arr::get($responses,'mapsRelations',[]);
                $this->eachArray($responses,$responses_data);

                //请求参数
                collect(Arr::get($responses,'options',[]))->each(function ($option,$key)use(&$params_data){
                    collect($option)->each(function ($value,$k)use(&$params_data,$key){
                        if(is_array($value)){
                            foreach ($value as $kk=>$v){
                                $name = $key.'['.$k.']['.$kk.']';
                                if(!isset($params_data[$name])){
                                    $k2 = collect(explode('.',$k))->filter();
                                    $field = $k2->pop();
                                    $k2 = $k2->implode('.');
                                    $title = $this->getFieldName($field,$k2)?:'未命名';
                                    $validate = '';
                                    if(Str::endsWith($field,'_at') && isset($this->sizer[$k]) && in_array($exp = Arr::get($this->sizer[$k],$kk),['>=','>','<','<='])){
                                        if(Str::contains($exp,'>')){
                                            $title .='开始';
                                        }else{
                                            $title .='结束';
                                        }
                                        $validate = '时间日期格式';
                                    }
                                    $params_data[$name] = [
                                        "name"=> $name,
                                        "type"=> $this->getType($k),
                                        "title"=> $title,
                                        "description"=> "",
                                        "example"=> $v,
                                        "validate"=> $validate
                                    ];
                                }
                            }
                        }else{
                            $name = $key.'['.$k.']';
                            if(!isset($params_data[$name])){
                                $title = [];
                                collect(explode('|',$k))->each(function ($k)use(&$title){
                                    $k2 = collect(explode('.',$k))->filter();
                                    $field = $k2->pop();
                                    $k2 = $k2->implode('.');
                                    if($k=='_key'){
                                        $title[]= '关键字搜索组默认使用key';
                                    }else{
                                        $title[] = $this->getFieldName($field,$k2);
                                    }
                                });
                                $title = collect($title)->filter()->implode('或')?:'未命名';
                                $params_data[$name] = [
                                    "name"=> $name,
                                    "type"=> $this->getType($k),
                                    "title"=> $key=='order'?$title.'排序':$title,
                                    "description"=> $key=='order'?"asc-升序,desc-降序":"",
                                    "example"=> $value,
                                    "validate"=> ""
                                ];
                            }
                        }

                    });
                });
                if(isset($responses['options'])){
                    $params_data['page'] = [
                        "name"=>'page',
                        "type"=> 2,
                        "title"=> '页码',
                        "description"=> "页码",
                        "example"=> "1",
                        "validate"=> "正整数"
                    ];
                    $params_data['per_page'] = [
                        "name"=>'per_page',
                        "type"=> 2,
                        "title"=> '每页数据条数',
                        "description"=> "每页多少条",
                        "example"=> "15",
                        "validate"=> "正整数;最大值为200"
                    ];
                }

            }
            if($menu['resource_id']>0 && $method=='export'){ //导出数据接口
                $responses_data['data.$index.$index'] = ['name'=>'data.$index.$index','description'=>'excel数据项'];
                collect(Arr::get($responses,'data.1',[]))->each(function ($value,$index)use (&$responses_data){
                    $key = 'data.$index.'.$index;
                    $responses_data[$key] = ['name'=>$key,'description'=>$value];
                });
            }
            $item['responses'] = collect($responses_data)->values()->toArray();


            if($is_list){
                $params_data = collect(Arr::get($menus,$menu['resource_id'].'.params',[]))
                    ->keyBy('name')
                    ->merge($params_data)
                    ->toArray();
                unset($params_data['where[_key]']);
                if($is_list==2){
                    unset($params_data['per_page']);
                    if(isset($params_data['page'])){
                        $params_data['page']['example'] = '';
                    }
                }
            }
            $item['params'] = collect($params_data)->values()->toArray();
            $item['route_params'] = collect($route_params_data)->values()->toArray();
            $item['body_params'] = collect($body_params_data)->values()->toArray();
            /*if($item['id']==13){
                dd(json_encode($item['responses'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
            }*/
            $menus[$item['id']] = $item;

        });
        DB::table('params')->truncate();
        DB::table('responses')->truncate();
        collect($menus)->map(function ($menu){
            collect(['params','body_params','route_params'])->each(function ($value,$key)use ($menu){
                collect(Arr::get($menu,$value,[]))->each(function ($param)use ($menu,$key){
                    $param['menu_id'] = $menu['id'];
                    $param['use'] = $key;
                    $param['created_at'] = $param['updated_at']  = $this->now_at;
                    $this->params[] = $param;
                });
            });
            collect(Arr::get($menu,'responses',[]))->each(function ($param)use ($menu){
                $param['menu_id'] = $menu['id'];
                $param['created_at'] = $param['updated_at']  = $this->now_at;
                $this->responses[] = $param;
            });
        });
        Param::insertReplaceAll($this->params);
        Response::insertReplaceAll($this->responses);
        $data['menus'] = collect($menus)->values()->toArray();
        file_put_contents($file,json_encode( $data ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
    }

    /**
     * 循环遍历数据
     */
    protected function eachArray($data,&$responses_data,$prefix=''){
        foreach ($data as $key=>$value){
            $is_maps = Str::startsWith($prefix,'maps.');
            if($is_maps && is_numeric($key) && is_array($value)){
                break;
            }
            $is_where = Str::startsWith($prefix,'options.where.');
            if(is_numeric($key) && $key>0 && !$is_maps){
                break;
            }
            $k = (is_numeric($key) && !$is_maps && !$is_where)?$prefix.'$index':$prefix.$key;
            if(!isset($responses_data[$k]) && !isset($this->common_responses[$k])){
                if(!is_array($value)){
                    if(Str::startsWith($k,'excel.exportFields.')){ //导出字段响应描述
                        $k1 = str_replace('excel.exportFields.','',$k);
                        $k2 = collect(explode('.',$k1))->filter();
                        $field = $k2->pop();
                        $k2 = $k2->implode('.');
                        $description = $this->getFieldName($value,$k2,true);
                    }elseif(Str::startsWith($k,'maps.')){ //数据字典项描述
                        $k1 = collect(explode('.',str_replace('maps.','',$prefix)))->filter();
                        $field = $k1->pop();
                        $k1 = $k1->implode('.');
                        $description = $this->getMapValue($field,$value,$k1);
                    }elseif(Str::startsWith($k,'options.') && ($prefix=='options.where.' || $prefix=='options.order.')){ //条件筛选,排序说明
                        if(Str::contains($key,'|')){
                            $title = [];
                            collect(explode('|',$key))->each(function ($k)use(&$title){
                                $k2 = collect(explode('.',$k))->filter();
                                $field = $k2->pop();
                                $k2 = $k2->implode('.');
                                if($k=='_key'){
                                    $title[]= '关键字搜索组默认使用key';
                                }else{
                                    $title[] = $this->getFieldName($field,$k2);
                                }
                            });
                            $title = collect($title)->filter()->implode('或')?:'';
                            $description = $title;
                        }else{
                            $k1 = collect(explode('.',$key));
                            $field = $k1->pop();
                            $k1 = $k1->implode('.');
                            $description = $this->getFieldName($field,$k1);
                        }
                    }elseif(Str::startsWith($k,'list.data.$index.') || Str::startsWith($k,'data.$index.') ){
                        $k1 = collect(explode('.',str_replace('.$index','',str_replace('data.$index.','',str_replace('list.data.$index.','',$k)))));
                        $field = $k1->pop();
                        $k1 = $k1->implode('.');
                        $description = $this->getFieldName($field,$k1);
                    }elseif(Str::startsWith($k,'row.')){
                        $k1 = collect(explode('.',str_replace('row.','',$k)));
                        $field = $k1->pop();
                        $k1 = $k1->implode('.');
                        $description = $this->getFieldName($field,$k1);
                    }else{
                        $description = '';
                    }
                }
                else{
                    //maps字段说明
                    if(Str::startsWith($k,'maps.') || Str::startsWith($k,'options.where.')){
                        //获取模型中的字段备注名称
                        $k1 = str_replace('options.where.','',str_replace('maps.','',$prefix));
                        $description = $this->getFieldName($key,$k1);
                    }elseif((Str::startsWith($k,'list.data.$index') || Str::startsWith($k,'data.$index')) && method_exists($this->controller,'getModel')){
                        $k1 = str_replace('data.$index.','',str_replace('list.data.$index.','',$k));
                        if($k1=='list.data.$index' || $k1=='data.$index'){
                            $k1 = '';
                        }
                        if(!Str::contains($k1,'.pivot')){
                            $description = $this->getItemName($k1);
                        }else{
                            $description = '';
                        }
                    }elseif(Str::startsWith($k,'row.')){
                        $k1 = str_replace('row.','',$k);
                        if($model=$this->getRelationModel($k1)){
                            $description = $model->getItemName();
                        }else{
                            $description = '';
                        }
                    }else{
                        $description = '';
                    }
                }
                $responses_data[$k] = ['name'=>$k,'description'=>$description];
            }
            if(is_array($value)){
                $this->eachArray($value,$responses_data,$k.'.');
            }
        }


    }

    /**
     * 获取字段备注
     * @param $field
     * @param string $related
     * @param bool $is_value
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    protected function getFieldName($field,$related='',$is_value=false){
        if(method_exists($this->controller,'getModel') && !Str::contains($related,'.pivot')){
            //获取模型中的字段备注名称
            $table = $this->table;
            $model = $this->controller->getModel();
            $item_name = '';
            collect(explode('.',$related))->filter()->each(function ($k,$index)use(&$model,&$table,&$item_name,$related){
                try {
                    $true_model = $model->getModel()->$k();
                    $table = $true_model->getModel()->getTable();
                    $model = $true_model->getRelated();
                    $item_name=  $model->getItemName();
                }catch (\Exception $exception){
                    return false;
                }
            });
            if($is_value){
                $value1 = $field;
            }else{
                $fields = ['created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
                'id' => 'ID'
                ];
                $value1 = Arr::get($fields,$field,'');
                $value1 = $value1?trans_path($value1):$model->getFieldsName($field);
            }
            $description = $item_name.trans_path($value1, '_shared.tables.' . $table. '.fields');

        }else{
            $description = '';
        }
        return $description;
    }

    /**
     * 获取map映射值备注
     */
    protected function getMapValue($field,$value,$related=''){
        if(method_exists($this->controller,'getModel')){
            //获取模型中的字段备注名称
            $table = $this->table;
            $model = $this->controller->getModel();
            collect(explode('.',$related))->filter()->each(function ($k,$index)use(&$model,&$table,$related){
                try {
                    $true_model = $model->getModel()->$k();
                    $table = $true_model->getModel()->getTable();
                    $model = $true_model->getRelated();
                }catch (\Exception $exception){
                    return false;
                }
            });
            $description = trans_path($value, '_shared.tables.' . $table . '.maps.'.$field);
        }else{
            $description = '';
        }
        return $description;
    }

    /**
     * 获取关系对象名称
     * @param string $related
     * @return string
     */
    protected function getItemName($related=''){
        if(!method_exists($this->controller,'getModel')){
            return '';
        }
        $model = $this->controller->getModel();
        $is_collect = false;
        $k1 = str_replace('.$index','',$related);
        collect(explode('.',$k1))->filter()->each(function ($k,$index)use(&$model,&$is_collect,$related){
            try {
                $true_model = $model->getModel()->$k();
                $is_collect = Str::contains(get_class($true_model),'Many');
                $model = $true_model->getRelated();
            }catch (\Exception $exception){
                return false;
            }
        });
        return $model->getItemName().'对象'.(($is_collect && !Str::endsWith($related,'.$index'))?'集合':'');
    }

    /**
     * 获取关系模型
     * @param string $related
     * @return |null
     */
    public function getRelationModel($related=''){
        if(!method_exists($this->controller,'getModel')){
            return null;
        }
        $model = $this->controller->getModel();
        collect(explode('.',$related))->filter()->each(function ($k,$index)use(&$model,$related){
            try {
                $true_model = $model->getModel()->$k();
                $model = $true_model->getRelated();
            }catch (\Exception $exception){
                $model = null;
                return false;
            }
        });
        return $model;
    }

    /**
     * 获取参数类型
     */
    public function getType($key){
        $k1 = collect(explode('.',$key))->filter();
        $field = $k1->pop();
        $k1 = $k1->implode('.');
        $model = $this->getRelationModel($k1);
        if(!$model){
            return 1;
        }
        if($field=='id'){
            return 2;
        }
        $type = gettype($model->getFieldsDefault($field));
        if($type=='double' || $type=='integer'){
            return 2;
        }elseif($type=='boolean'){
            return 3;
        }else{
            return 1;
        }

    }

}
