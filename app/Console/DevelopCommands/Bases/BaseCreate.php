<?php

namespace App\Console\DevelopCommands\Bases;

use App\Console\BaseCommand;
use Illuminate\Support\Str;

abstract class BaseCreate extends BaseCommand
{
    //数据
    protected $datas = [];
    //模板地址
    protected $tpl = '';

    //模板根目录
    protected $tpl_base_path = '';

    //生成代码类型
    protected $type='';

    //输出路径
    protected $outputPath='';

    //生成后自动加载
    protected $composer_dump = true;

    //渲染
    protected function render(){
        return view($this->tpl_base_path.$this->tpl,$this->datas)->render();
    }

    abstract protected function getOutputPath();

    /**
     * 生成代码
     */
    protected function create(){
        $this->getOutputPath();
        $file = $this->outputPath.'.'.$this->type;
        is_dir(dirname($file)) OR mkdir(dirname($file),0755,true); //创建目录
        if(file_exists($file)){ //如果文件存在
            $in_console = app()->runningInConsole();
            if(!$in_console || !$this->confirm(
                trans_path('Is the ":file" file already overwritten?',$this->transPath,['file'=>$file])
                //$this->confirmName.'文件已存在是否覆盖? [y|N]'
                )){
                $this->info(
                    trans_path('The ":file" file already exists',$this->transPath,['file'=>$file])
                    //$file.'文件已经存在!'
                );
                return ;
            }
        }
        if(file_put_contents($file, $this->render())){ //写入文件
            $this->info(
                trans_path('File ":file" created successfully',$this->transPath,['file'=>$file])
                //$file.' 创建成功'
            );
        }else{
            $this->info(
             trans_path('Failed to create file ":file"',$this->transPath,['file'=>$file])
                //$file.' 创建失败'
            );
        };
        $this->composer_dump and app('composer')->dumpAutoloads(); //自动加载文件
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->hasOption('no_dump') && $this->option('no_dump')){
            $this->composer_dump = false;
        }
        $this->readyDatas();
        $this->datas['startSymbol']='{{';
        $this->datas['endSymbol']='}}';
        $this->create();
    }

    /**
     * 准备数据
     * @return mixed
     */
    abstract protected function readyDatas();

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
