<?php

namespace App\Console\Commands;

use App\Console\BaseCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class LinksInit extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:init {--f|force} {--relative}';

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
        collect($this->links())->merge($this->initLinks())->each(function ($target,$link)use($relative,$force){
            if (($force || $link==base_path('node_modules/admin-lte/build/less/variables.less')) && file_exists($link)) {
                $this->laravel->make('files')->delete($link);
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

            if ($relative) {
                $res = $this->laravel->make('files')->relativeLink($target, $link);
            } else {
                $res = $this->laravel->make('files')->link($target, $link);
            }
            if($res){
                $this->info(
                    trans_path(   'The ":link" link has been connected to ":target"',$this->transPath,['link'=>$link,'target'=>$target])
                );
            }else{
                $this->error(
                    trans_path(   'Failed to create file ":file"',$this->transPath,['file'=>$link])
                );
            }
        });
        $this->info( trans_path( 'The links have been created',$this->transPath));
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
                base_path('node_modules/admin-lte/build/less/variables.less') => '../../../../resources/less/variables.less', //主题配色变量

                public_path('bower_components/animate.css/animate.min.css') => '../../../node_modules/animate.css/animate.min.css', //动画样式
                public_path('bower_components/bootstrap/dist') => '../../../node_modules/bootstrap/dist',//bootstrap静态资源
                public_path('bower_components/bootstrap-colorpicker/dist') => '../../../node_modules/bootstrap-colorpicker/dist', //bootstrap颜色选择器静态资源
                public_path('bower_components/echarts/dist') => '../../../node_modules/echarts/dist',//echarts图表静态资源
                public_path('bower_components/editor.md') => '../../node_modules/editor.md',//editor.md编辑器静态资源
                public_path('bower_components/font-awesome') => '../../node_modules/font-awesome',
                public_path('bower_components/select2/dist') => '../../../node_modules/select2/dist',
                public_path('bower_components/xlsx/dist') => '../../../node_modules/xlsx/dist',
            ];
    }

}
