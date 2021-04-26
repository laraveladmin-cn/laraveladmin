<?php

namespace App\Console\DevelopCommands;

use App\Console\DevelopCommands\Bases\BaseCreate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateController extends BaseCreate
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:controller {name} {model?} {--namespace} {--no_dump}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自定义模板控制器生成';
    public function __construct()
    {
        parent::__construct();
        $this->description = trans_path('Custom template controller generation',$this->transPath);
    }

    protected $type='php';
    protected $tpl = 'php/controller';
    protected $baseNamespace = 'App\Http\Controllers';

    protected function getOutputPath(){
        $this->outputPath = app_path('Http/Controllers/'.Str::studly($this->argument('name')).'Controller');
    }

    protected function defaultModel(){
        return 'Models\\'.Str::studly(basename($this->argument('name')));
    }

    /**
     * 获取数据表字段信息
     * param $table
     * 返回: mixed
     */
    public function getTableInfo(Model $tableModel){
        $connection = $tableModel->getConnectionName() ? : config('database.default');
        $prefix = $tableModel->getConnection()->getTablePrefix();
        $trueTable = $prefix.$tableModel->getTable();

        //数据表备注信息
        $data['comment'] =  DB::connection($connection)->select('SELECT TABLE_COMMENT FROM information_schema.`TABLES` WHERE TABLE_SCHEMA= :db_name AND TABLE_NAME = :tname',
            [
                'db_name'=>config('database.connections.'.$connection.'.database'),
                'tname'=>$trueTable
            ])[0]->TABLE_COMMENT;
        //数据表类型
        preg_match('/\$([A-Za-z0-9_,]{1,})/',$data['comment'],$table_types);
        $data['table_types'] = collect(explode(',',Arr::get($table_types,1)))->filter()->map(function($item){
            return Str::camel($item);
        })->toArray();
        //数据表关系
        preg_match('/\@([A-Za-z0-9_:|,]{1,})/',$data['comment'],$table_relations);
        $data['table_relations'] = collect(explode('|',Arr::get($table_relations,1)))->filter()->map(function($item){
            $item_array = explode(':',$item);
            $relation = lcfirst(Str::camel($item_array[0]));
            return [
                'name'=>in_array($relation,['hasMany','belongsToMany','hasManyThrough','morphMany']) ? Str::plural(Str::snake($item_array[1])) : Str::snake($item_array[1]),
                'relation'=>$relation,
                'model'=>Str::studly(Str::singular($item_array[1]))
            ];
        })->toArray();
        $table_comment = str_replace(Arr::get($table_types,0,''),'',$data['comment']);
        $table_comment = str_replace(Arr::get($table_relations,0,''),'',$table_comment);
        $data['table_comment'] = $table_comment;

        //字段信息
        $data['table_fields'] = collect(DB::connection($connection)->select('show full COLUMNS from `'.$trueTable.'`'))
            ->map(function($item){
                $comment = explode('@',$item->Comment);
                $item->validator = Arr::get($comment,'1',''); //字段验证
                $comment = explode('$',$comment[0]);
                $item->showType = in_array($item->Field,['created_at','updated_at']) ? 'time' : Arr::get($comment,'1',''); //字段显示类型
                $item->showType = in_array($item->Field,['deleted_at','left_margin','right_margin','level','remember_token']) ? 'hidden' :  $item->showType;
                $comment = explode(':',$comment[0]);
                $info = [
                    'created_at'=>trans_path('Created At',$this->transPath),//'创建时间',
                    'updated_at'=>trans_path('Updated At',$this->transPath)//'修改时间'
                ];
                $item->info = isset($info[$item->Field]) ? $info[$item->Field]: $comment[0]; //字段说明
                $item->info =  $item->info ?: $item->Field;
                $comment = explode(',',Arr::get($comment,'1',''));
                $item->values = collect($comment)->map(function($item){
                    return explode('-',$item);
                })->pluck('1','0')->filter(function($item){
                    return $item;
                })->toArray(); //字段值
                $item->showType = (!$item->showType && $item->values) ? 'radio' : $item->showType;
                $item->showType = !$item->showType ? 'text' : $item->showType;
                return collect($item)->toArray();
            })->toArray();
        return $data;
    }

    /**
     * 创建控制器
     */
    protected function readyDatas(){
        $name = $this->argument('name');
        $data['php'] = '<?php'; //模板代码
        $data['namespace']  = dirname($name)=='.'? $this->baseNamespace : $this->baseNamespace.'\\'.Str::studly(dirname($name)); //生成代码命名空间
        $data['name'] = basename($name); //控制器名称
        $data['model'] = str_replace('/','\\',$this->argument('model')) ?: $this->defaultModel(); //绑定模型名称
        $data['modelName'] = basename(str_replace('\\','/',$data['model'])); //模型名字
        $data['model_namespace'] = false;
        if($this->option('namespace')){
            $data['model_namespace'] = str_replace('/','\\\\',dirname($this->argument('model'))).'\\\\';
            $modelName = '\\'.$data['model'];
        }else{
            $modelName = '\\App\\'.$data['model'];
        }
        $model = new $modelName();
        $data['tableInfo'] = $this->getTableInfo($model); //数据表信息
        $data['validates'] = collect($data['tableInfo']['table_fields'])->map(function($item){
            if($item['validator']){
                if(str_contains($item['validator'],'unique:')){
                    $item['validator'] = preg_replace ('/unique\:(\w{1,})\,(\w{1,})/', 'unique:$1,$2,\'.\$id.\',id,deleted_at,NULL', $item['validator']);
                }
                return "'".$item['Field']."'=>'".$item['validator']."'";
            }
        })->filter(function($item){
            return $item;
        })->implode(",");
        $data['is_tree_model'] = isset($modelName::$isTreeModel);
        $data['has_unique'] = collect($data['tableInfo']['table_fields'])
            ->search(function($item, $key){
                return str_contains($item['validator'],'unique:');
            });
        $this->datas = $data;
    }
}
