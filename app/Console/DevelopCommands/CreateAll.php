<?php

namespace App\Console\DevelopCommands;


use App\Console\BaseCommand;
use App\Models\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAll extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:all
    {table : The name of model}
    {module?}
    {--c|connection= : The database connection to use}
    {--no_dump}
    {--only=}
    {--has_prefix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all resources';

    protected function migrationPath($migration){
        return database_path('migrations/'.(explode('_',$migration)[0])).'/'.$migration.'.php';
    }

    protected function hasOnly($key){
        $only = $this->option('only');
        if(!$only){
            return true;
        }
        return in_array($key,explode(',',$only));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $no_prefix_table = $this->argument('table');
        $has_prefix = false;
        if($this->hasOption('has_prefix') && $this->option('has_prefix')){
            $connection = $this->option('connection') ?: config('database.default');
            $data['connection'] = $connection==config('database.default') ? '': $connection;
            $prefix = config('database.connections.'.$connection.'.prefix');
            $no_prefix_table = Str::replaceFirst($prefix,'',$no_prefix_table);
            $has_prefix = true;
        }
        $in_console = app()->runningInConsole();
        //生成迁移
        if($this->hasOnly('migration')){
            $migration = Migration::where('migration','like','%create_'.$table.'_table')->value('migration');
            if($migration &&
                file_exists($migration_file = $this->migrationPath($migration)) &&
                (!$in_console ||
                    !$this->confirm(
                        trans_path('Is the ":file" file already overwritten?',$this->transPath,['file'=>$migration_file])
                        //'迁移文件已经存在,是否继续生成? [y|N]'
                    ))
            ){
                $this->info(
                    trans_path('The ":file" file already exists',$this->transPath,['file'=>$migration_file])
                    //$migration_file.'文件已经存在!'
                );
            }else{
                if($migration){
                    Migration::where('migration',$migration)->delete();
                }
                $dir = database_path('migrations/'.date('Y'));
                is_dir($dir) OR mkdir($dir,0755,true); //创建目录
                $this->call('migrate:generate',[
                    '--tables'=>$table,
                    '--ignore'=>true,
                    '--path'=>$dir,
                    '--no-interaction'=>true
                ]);
                if($migration){
                    Migration::where('migration',$migration)->delete();
                    Storage::disk('migrations')->delete(substr($migration,0,4).'/'.$migration.'.php');
                }
                //获取生成结果进行处理
                $migration_file = trim(str_replace(['Created:',$dir.'/','.php'],'',collect(explode("\n",Artisan::output()))->first(function ($value){
                    return str_contains($value,'Created:');
                })));
                $migration_file and Migration::firstOrCreate(['migration'=>$migration_file],['migration'=>$migration_file,'batch'=>0]);
                $migration = Migration::query()->latest('id')->value('migration');
                $file = $this->migrationPath($migration);
                $content = file_get_contents($file);
                if(Str::contains($content,'timestamps()->comment')){
                    $content = Str::replace('timestamps()->comment','timestamps();//->comment',$content);
                    file_put_contents($file,$content);
                }
                $this->info(
                    trans_path('File ":file" created successfully',$this->transPath,['file'=>$file])
                    //$this->migrationPath($migration).' 创建成功'
                );
            }
        }

        //生成模型
        if($this->hasOnly('model')){
            $this->call('create:model',[
                'table'=>$table,
                '--no_dump'=>true,
                '--has_prefix'=>$has_prefix
            ]);
        }

        $module = $this->argument('module')?:'admin';
        $modelName = Str::studly($module).'/'.Str::studly($this->getClassName(Str::singular($no_prefix_table)));
        //生成控制器
        if($this->hasOnly('controller')){
            $this->call('create:controller',[
                'name'=>$modelName,
                '--no_dump'=>true
            ]);
        }

        //生成列表视图
        if($this->hasOnly('index')){
            $this->call('create:view',[
                'controller'=>$modelName,
                'template'=>'index'
            ]);
        }

        //生成编辑视图
        if($this->hasOnly('edit')){
            $this->call('create:view',[
                'controller'=>$modelName,
                'template'=>'edit'
            ]);
        }
        if(!($this->hasOption('no_dump') && $this->option('no_dump'))){
            app('composer')->dumpAutoloads(); //自动加载文件
        }

    }

    /**
     * 处理ss表名结尾问题
     * @param $value
     */
    protected function getClassName($value){
        if(Str::endsWith($value,'ss')){
            $value = Str::replaceLast('ss','s',$value);
        }
        return Str::singular($value);
    }
}
