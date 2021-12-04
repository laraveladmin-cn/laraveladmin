<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class LinksInit extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:init {--f|force} {--r|relative}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializing the creation of a soft connection';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $relative = $this->option('relative');
        $force = $this->option('force');
        $flog = false;
        collect($this->links())->merge($this->initLinks())->each(function ($target,$link)use($relative,$force,&$flog){
            if (($force || $link==base_path('node_modules/admin-lte/build/less/variables.less')) && file_exists($link)) {
                if(is_dir($link) && !is_link($link)){
                    $res = $this->laravel->make('files')->deleteDirectory($link);
                }else{
                    $res = $this->laravel->make('files')->delete($link);
                }
                if($res===false){
                    $this->error(
                        trans_path('Failed to delete file ":file"',$this->transPath,['file'=>$link])
                    );
                    return;
                }
            }
            if (file_exists($link)) {
                $this->error(
                    trans_path('The ":file" file already exists',$this->transPath,['file'=>$link])
                );
                return;
            }
            $dir = Arr::get(pathinfo($link),'dirname');
            if($dir && !is_dir($dir)){
                mkdir($dir,0755,true); //创建目录
            }
            if (is_link($link)) {
                $this->laravel->make('files')->delete($link);
            }

            if ($relative && !windows_os()) {
                if(!is_dir($target)){ //文件
                    if (! class_exists(SymfonyFilesystem::class)) {
                        throw new \RuntimeException(
                            trans_path(   'To enable support for relative links, please install the symfony/filesystem package',$this->transPath)
                        );
                    }
                    $relativeTarget = (new SymfonyFilesystem)->makePathRelative($target, dirname($link));
                    if(Str::endsWith($relativeTarget,'/')){
                        $relativeTarget = Str::replaceLast('/','',$relativeTarget);
                    }
                    $res = $this->laravel->make('files')->link($relativeTarget, $link);
                }else{
                    $res = $this->laravel->make('files')->relativeLink($target, $link);
                }
            } else {
                $res = $this->laravel->make('files')->link($target, $link);
            }
            if($res!==false){
                $this->info(
                    trans_path(   'The ":link" link has been connected to ":target"',$this->transPath,['link'=>$link,'target'=>$target])
                );
            }else{
                $flog = false;
                $this->error(
                    trans_path(   'Failed to create file ":file"',$this->transPath,['file'=>$link])
                );
            }
        });
        $flog and $this->info( trans_path( 'The links have been created',$this->transPath));
    }

    /**
     * Get the symbolic links that are configured for the application.
     *
     * @return array
     */
    protected function links()
    {
        return $this->laravel['config']['filesystems.links'] ??
            [public_path('storage') => storage_path('app/public')];
    }

    /**
     * Get the symbolic links that are configured for the application.
     *
     * @return array
     */
    protected function initLinks()
    {
        return $this->laravel['config']['filesystems.init_links'] ??
            [
                base_path('node_modules/admin-lte/build/less/variables.less') => resource_path('less/variables.less'), //主题配色变量

                public_path('bower_components/animate.css/animate.min.css') => base_path('node_modules/animate.css/animate.min.css'), //动画样式
                public_path('bower_components/bootstrap/dist') => base_path('node_modules/bootstrap/dist'),//bootstrap静态资源
                public_path('bower_components/bootstrap-colorpicker/dist') => base_path('node_modules/bootstrap-colorpicker/dist'), //bootstrap颜色选择器静态资源
                public_path('bower_components/echarts/dist') => base_path('node_modules/echarts/dist'),//echarts图表静态资源
                public_path('bower_components/editor.md') => base_path('node_modules/editor.md'),//editor.md编辑器静态资源
                public_path('bower_components/font-awesome') => base_path('node_modules/font-awesome'),
                public_path('bower_components/select2/dist') => base_path('node_modules/select2/dist'),
                public_path('bower_components/xlsx/dist') => base_path('node_modules/xlsx/dist'),
                public_path('bower_components/ionicons') => base_path('node_modules/ionicons/dist'),
            ];
    }

}
