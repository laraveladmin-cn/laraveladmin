<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BuildIndexHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:index.html {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '编译生成前端入口文件index.html';

    protected $fileName = 'index.html';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //开发环境无需生成index.html
        if($this->option('force') || config('app.env')=='production'){
            $indexHtml = view('index',[
                'time_str'=>'&time='.time()
            ])->render();
            file_put_contents(public_path($this->fileName),$indexHtml);
        }
        $this->checkEnvValue();

    }

    /**
     * 检查env配置
     */
    protected function checkEnvValue(){
        $path = base_path('.env');
        $env_str = file_get_contents($path);
        collect($_ENV)->each(function ($value,$key)use (&$env_str){
            if(Str::contains($value,'=')){
                $value = env($key,'');
                $env_str = Str::replaceFirst($key.'='.$value,$key.'="'.$value.'"',$env_str);
            }
        });
        file_put_contents($path,$env_str);
    }
}
