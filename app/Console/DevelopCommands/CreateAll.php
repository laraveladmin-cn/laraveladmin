<?php

namespace App\Console\DevelopCommands;


use App\Models\Migration;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:all {table : The name of model} {module?} {--c|connection= : The database connection to use} {--no_dump}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成所有资源';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $in_console = app()->runningInConsole();
        //生成迁移
        $migration = Migration::where('migration','like','%create_'.$table.'_table')->value('migration');
        if($migration &&
            (!$in_console ||
            !$this->confirm('迁移文件已经存在,是否继续生成? [y|N]'))
        ){
            $this->info($migration.'文件已经存在!');
        }else{
            $dir = database_path('migrations/'.date('Y'));
            is_dir(dirname($dir)) OR mkdir(dirname($dir),0755,true); //创建目录
            $this->call('migrate:generate',[
                '--tables'=>$table,
                '--ignore'=>true,
                '--path'=>$dir
            ]);
            if($migration){
                Migration::where('migration',$migration)->delete();
                Storage::disk('migrations')->delete(substr($migration,0,4).'/'.$migration.'.php');
            }
        }


        //生成模型
        $this->call('create:model',[
            'table'=>$table,
            '--no_dump'=>true
        ]);

        $module = $this->argument('module')?:'admin';
        $modelName = Str::studly($module).'/'.Str::studly(Str::singular($table));
        //生成控制器
        $this->call('create:controller',[
            'name'=>$modelName,
            '--no_dump'=>true
        ]);
        //生成列表视图
        $this->call('create:view',[
            'controller'=>$modelName,
            'template'=>'index'
        ]);

        //生成编辑视图
        $this->call('create:view',[
            'controller'=>$modelName,
            'template'=>'edit'
        ]);
        if(!($this->hasOption('no_dump') && $this->option('no_dump'))){
            app('composer')->dumpAutoloads(); //自动加载文件
        }

    }
}
