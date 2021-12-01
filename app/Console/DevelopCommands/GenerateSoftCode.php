<?php
/**
 * 软著代码文档生成命令
 * 生成本项目包含的所有代码,用于软著提交
 */
namespace App\Console\DevelopCommands;

use App\Console\BaseCommand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateSoftCode extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:soft-code {--f|force} {--f|output}';

    /**
     * The console command description.
     * 生成软著代码,用于软件著作权申请
     * @var string
     */
    protected $description = 'Generate software code text for software copyright application';

    protected $output_file = 'soft_code.txt';

    protected $ignore=[
        '.',
        '..',
        '.env',
        '.env.example',
        '.git',
        '.DS_Store',
        '.editorconfig',
        'public',
        'storage',
        'vendor',
        'node_modules',
        'bootstrap/cache',
        'docker/mysql',
        'docker/nginx'
    ];

    protected $base_path='';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->option('output')){
            $this->output_file = $this->option('output');
        }
        if(!$this->option('force') && file_exists($this->output_file)){
            $this->warn(trans_path('The ":file" file already exists',$this->transPath,['file'=>$this->output_file]));
            return;
        }
        $this->ignore[] = $this->output_file;
        $this->base_path = base_path().'/';
        file_put_contents($this->output_file,'');
        $this->read($this->base_path);
        $this->info(trans_path('File ":file" created successfully',$this->transPath,['file'=>$this->output_file]));
    }

    public function read($path){
        $relative_path  = $relative_path1= Str::replaceFirst($this->base_path,'',$path);
        $type = mime_content_type ($path);
        if(Str::endsWith($relative_path,'/')){
            $relative_path1 = Str::replaceLast('/','',$relative_path);
        }
        if(is_link($path) || in_array($relative_path1,$this->ignore) || !(Str::startsWith($type,'text') || $type=='directory')){
            return;
        }

        if(is_dir($path)){
            $files = scandir($path);
            foreach ($files as $file){
                $path1 = $path.$file;
                if(in_array(Str::replaceFirst($this->base_path,'',$path1),$this->ignore) || in_array($file,['.','..'])){
                    continue;
                }
                if(is_dir($path1)){
                    $this->read($path1.'/');
                }else{
                    $text = Str::replaceFirst($this->base_path,'',$path1)."\r\n"
                        .file_get_contents($path1)."\r\n";
                    file_put_contents($this->output_file,$text,FILE_APPEND);
                }
            }
        }else{
            $text = $relative_path."\r\n"
                .file_get_contents($path)."\r\n";
            file_put_contents($this->output_file,$text,FILE_APPEND);
        }
    }





}
