<?php

namespace App\Console\DevelopCommands;


use App\Console\BaseCommand;
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Auth::loginUsingId(1); //模拟超管用户登录
        $this->now_at = Carbon::now()->toDateTimeString();
        $this->group = Arr::get(json_decode(file_get_contents(base_path('routes/route.json')),true),'group',[]);
        $file = storage_path('developments/api-doc.json');
        $data = json_decode(file_get_contents($file),true)?:[];
        $common_responses = Arr::get($data,'common_responses',[]);
        collect(Arr::get($data,'common_responses_list',[]))->each(function ($item)use(&$common_responses){
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
            ->where('resource_id','<',1)
            ->whereRaw(DB::raw('url not like "%{%"'))
            ->where('method','&',1)
            //->where('id',9)
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
            $responses_data = collect($item['responses'])->keyBy('name')->toArray();
            $params_data = collect($item['params'])->keyBy('name')->toArray();
                //获取路由响应数据
            $action = $menu['action'];
            if(!$action){
                if($menu['resource_id']==-1){
                    $value = Arr::get(explode('/',Arr::get($menu,'url','')),2,'');
                    if($value){
                        $action = RouteService::getClass($value).'@index';
                    }
                }else{
                    $action = 'IndexController@index';
                }

            }
            $group = $menu['group'];//组
            $namespace = Arr::get($this->group,$group.'.namespace','');
            $actions = explode('@',$action);
            $class = $namespace.'\\'.$actions[0];
            $method = $actions[1];
            $this->menu_id = $menu['id'];
            if(!class_exists($class)){
                dd(collect($menu)->toArray());
            }
            $this->controller = new $class();

            try {
                $responses = $this->controller->$method();
            }catch (\Exception $exception){
                return;
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
                        return;
                    }
                }
            }
            if(is_array($responses)){
                $responses = collect($responses)->toArray();
                $this->table = Arr::get($responses,'excel.sheet','');
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
                                    $params_data[$name] = [
                                        "name"=> $name,
                                        "type"=> 1,
                                        "title"=> $this->getFieldName($k,$k2)?:'未命名',
                                        "description"=> "",
                                        "example"=> $v,
                                        "validate"=> ""
                                    ];
                                }
                            }
                        }else{
                            $name = $key.'['.$k.']';
                            if(!isset($params_data[$name])){
                                $k2 = collect(explode('.',$k))->filter();
                                $field = $k2->pop();
                                $k2 = $k2->implode('.');
                                $params_data[$name] = [
                                    "name"=> $name,
                                    "type"=> 1,
                                    "title"=> $this->getFieldName($k,$k2)?:'未命名',
                                    "description"=> "",
                                    "example"=> $value,
                                    "validate"=> ""
                                ];
                            }
                        }

                    });
                });

            }
            $item['responses'] = collect($responses_data)->values()->toArray();
            $item['params'] = collect($params_data)->values()->toArray();
            //dd(json_encode($item['params'],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));



            $menus[$item['id']] = $item;

        });
        DB::table('params')->truncate();
        DB::table('responses')->truncate();
        collect($menus)->map(function ($menu){
            collect(Arr::get($menu,'params',[]))->each(function ($param)use ($menu){
                $param['menu_id'] = $menu['id'];
                $param['use'] = 0;
                $param['created_at'] = $param['updated_at']  = $this->now_at;
                $this->params[] = $param;
            });
            collect(Arr::get($menu,'body_params',[]))->each(function ($param)use ($menu){
                $param['menu_id'] = $menu['id'];
                $param['use'] = 1;
                $param['created_at'] = $param['updated_at']  = $this->now_at;
                $this->params[] = $param;
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
            $is_where = Str::startsWith($prefix,'options.where.');
            if(is_numeric($key) && $key>0 && !$is_maps){
                break;
            }
            $k = (is_numeric($key) && !$is_maps && !$is_where)?$prefix.'$index':$prefix.$key;
            if(!Arr::get($responses_data,$k) && !Arr::get($this->common_responses,$k)){
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
                        $k1 = collect(explode('.',$key));
                        $field = $k1->pop();
                        $k1 = $k1->implode('.');
                        if(Str::contains($k1,'|')){
                            $description = '';
                        }else{
                            $description = $this->getFieldName($field,$k1);
                        }
                    }elseif(Str::startsWith($k,'list.data.$index.') || Str::startsWith($k,'data.$index.') ){
                        $k1 = collect(explode('.',str_replace('.$index','',str_replace('data.$index.','',str_replace('list.data.$index.','',$k)))));
                        $field = $k1->pop();
                        $k1 = $k1->implode('.');
                        $description = $this->getFieldName($field,$k1);
                    }else{
                        $description = '';
                    }
                }else{
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
            collect(explode('.',$related))->filter()->each(function ($k,$index)use(&$model,&$table,$related){
                try {
                    $true_model = $model->getModel()->$k();
                    $table = $true_model->getModel()->getTable();
                    $model = $true_model->getRelated();
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
                $value1 = Arr::get($fields,$field)?:$model->getFieldsName($field);
            }
            $description = trans_path($value1, '_shared.tables.' . $table. '.fields');
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

    protected function getItemName($related=''){
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

}
