<?php

namespace App\Console\DevelopCommands;


use App\Console\DevelopCommands\Bases\BaseCreate;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CreateView extends BaseCreate
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:view {controller} {template} {output?} {--n|namespace=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自定义模板视图生成';
    protected $confirmName='视图';
    protected $type='vue';
    protected $tpl = 'html/edit';
    protected $baseNamespace = '';
    protected $composer_dump = false;
    /**
     * 绑定模型
     * @var
     */
    protected $bindModel;

    /**
     * 生成代码输出位置
     */
    protected function getOutputPath(){
        if($this->argument('output')){
            $this->outputPath = resource_path('js/pages/'.$this->argument('output'));
        }else{
            $this->outputPath = resource_path('js/pages/admin/'.Str::snake(basename($this->argument('controller'))).'s/'.Str::snake($this->argument('template')));
        }
    }

    /**
     * 创建控制器
     */
    protected function readyDatas(){
        $this->tpl = 'html/'.$this->argument('template');
        $data['model_namespace'] = false;

        if($this->option('namespace')){
            $controller = str_replace('/','\\',$this->argument('controller')).'Controller';
            $class = str_replace('/','',$this->argument('controller'));
        }else{
            $controller = 'App\\Http\\Controllers\\'.str_replace('/','\\',$this->argument('controller')).'Controller';
            $class = str_replace('/','',$this->argument('controller'));
        }
        $controller = new $controller();
        $this->bindModel = $controller->newBindModel(); //绑定模型
        $data = $this->bindModel->getTableInfo();
        $prefix = Str::start(Str::kebab(dirname($this->argument('controller'))),'/');
        $data['prefix'] = $prefix?Str::start($prefix,'/'):'';
        $data['table_fields'] = collect($data['table_fields'])->keyBy('Field')->toArray();
        $data['path'] = Str::singular($this->bindModel->getTable());
        if($this->argument('template')=='index'){
            $this->confirmName='列表视图';
            $fields = $controller->selectFields($controller->showIndexFields); //需要显示的字段
            $data['show_fields'] = collect($data['table_fields'])
                ->filter(function($item)use($fields){
                    return (!in_array($item['showType'],['password','hidden','delete']) &&
                    !in_array($item['Field'],['deleted_at'])) &&
                    (!$fields || in_array($item['Field'],$fields));
                })->keyBy('Field')->map(function($item){
                    $data = [
                        'name'=>$item['info'],
                        'order'=>true
                    ];
                    if(!in_array($item['showType'],['text',''])){
                        $data['type'] = $item['showType'];
                    }
                    return $data;
                });
        }else{
            $this->confirmName='编辑视图';
            $class = get_class($this->bindModel);
            $data['tableInfo'] = $class::getTableInfo(); //数据表信息
            $data['validates'] = collect($data['tableInfo']['table_fields'])->map(function($item){
                if($item['validator']){
                    if(str_contains($item['validator'],'unique:')){
                        $item['validator'] = preg_replace ('/unique\:(\w{1,})\,(\w{1,})/', 'unique:$1,$2,\'.\$id.\',id,deleted_at,NULL', $item['validator']);
                    }
                    $validator = collect(explode('|',$item['validator']))->filter(function ($value){
                        return !in_array(Arr::get(explode(',',$value),'0',''),['nullable','exists','sometimes','unique']);

                    })->implode('|');
                    $item['validator'] = $validator;
                }
                return $item;
            })->filter(function($item){
                return $item['validator'];
            })->pluck('validator','Field')->toArray();
        }
        $data['class'] = Str::snake($class);
        $this->datas = $data;
    }
}
