<?php

namespace App\Console\DevelopCommands;

use App\Console\DevelopCommands\Bases\BaseCreate;
use Illuminate\Support\Facades\DB;

class CreateSeed extends BaseCreate
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:seed {model} {--namespace} {--no_dump}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom template data fill file generation';
    protected $type='php';
    protected $tpl = 'php/seed';
    protected $baseNamespace = '';
    /**
     * 绑定模型
     * @var
     */
    protected $bindModel;


    protected function getOutputPath(){
        $this->outputPath = database_path('seeders/'.class_basename($this->argument('model')).'TableSeeder');
    }

    /**
     * 创建迁徙文件
     */
    protected function readyDatas(){
        $data['model_namespace'] = false;
        if($this->option('namespace')){
            $model = str_replace('/','\\',$this->argument('model'));
        }else{
            $model = 'App\\'.str_replace('/','\\',$this->argument('model'));
        }
        $this->bindModel = new $model();
        $data['php'] = '<?php';
        $data['model'] = $model;
        $data['json'] = 'JSON';
        $data['class'] = class_basename($this->argument('model'));
        $connection = $this->bindModel->getConnectionName() ?: config('database.default');
        $prefix = config('database.connections.'.$connection.'.prefix');
        $trueTable = $prefix.$this->bindModel->getTable();
        $data['data'] = collect(DB::connection($connection)->select('SELECT * FROM `'.$trueTable.'`'))->map(function($item){
            return collect($item)->toArray();
        })->toJson(JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        $this->datas = $data;
    }
}
