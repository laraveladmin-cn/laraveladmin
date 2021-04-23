<?php
/**
 * 翻译菜单名称数据
 */

namespace Database\Seeders\Commands;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ShaoZeMing\LaravelTranslate\Facade\Translate;

class TranslationMenus extends Seeder
{
    protected $transPath='commands'; //翻译路径
    protected $routesConfig=[]; //路由数据
    protected $local=''; //本地语言默认设置
    protected $routeJsonPath = '';//路由文件位置
    protected $frontJsonPath = '';//输出翻译文件位置
    protected $langMap = [ //地区语言对应语种代码
        'zh-TW'=>'cht',
        'zh-HK'=>'cht',
        'zh-CN'=>'zh',
    ];
    protected $lang = 'en'; //当前语言
    protected $outMenus = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->local = Str::replaceFirst('_','-',config('app.locale','en'));//当前默认设置使用地区语言
        /*if($this->local=='en'){ //默认是英文跳过翻译
            $this->command->info(
                trans_path('The application language is not set to English to execute',$this->transPath)
                //应用的语言不是设置为英语时才可执行
            );
            return ;
        }*/
        $this->lang = Arr::get($this->langMap,$this->local,$this->local);//语言代码
        $this->routeJsonPath = base_path('routes/route.json');
        $this->frontJsonPath = resource_path('lang/'.config('app.locale','en').'/front.json');
        $routes_json = file_get_contents($this->routeJsonPath);
        $front_json = json_decode(file_get_contents($this->frontJsonPath),true);
        $this->outMenus = Arr::get($front_json,'pages.menus',[]);
        $this->routesConfig = json_decode($routes_json,true);
        collect(['menus','resource'])->each(function ($key){
            $this->routesConfig[$key] = collect(Arr::get($this->routesConfig,$key,[]))->map(function ($item){
                collect(['name','description','item_name'])->each(function ($key)use(&$item){
                    $name = Arr::get($item,$key);
                    if($name && !$this->isEnglish($name)){
                        try {
                            $new = trim(Str::ucfirst(Translate::setFromAndTo($this->lang ,'en')->translate($name)));
                        }catch (\Exception $exception){
                            $this->command->error(trans_path('Failed to translate ":old"',$this->transPath,['old'=>$name]));
                            return ;
                        }
                        $this->command->info(trans_path('From ":old" to ":new"',$this->transPath,['old'=>$name,'new'=>$new]));
                        $item[$key] = $new;
                        if(!isset($this->outMenus[$new])){
                            $this->outMenus[$new] = $name;
                        };
                    }
                });
                return $item;
            })->toArray();
        });
        if(!Arr::get($front_json,'pages')){
            $front_json['pages'] = [];
        }
        $front_json['pages']['menus'] = $this->outMenus;
        $res = file_put_contents($this->frontJsonPath,json_encode( $front_json ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
        if($res===false){
            $this->command->error(trans('On failure!'));
        };
        $res = file_put_contents($this->routeJsonPath,json_encode( $this->routesConfig ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
        if($res===false){
            $this->command->error(trans('On failure!'));
        };
        $this->command->info(trans('Execute successfully!'));
    }

    /**
     * 判断字符串是否为英语
     * @param $str
     * @return string
     */
    public function isEnglish($str){
        $mb = mb_strlen($str,'utf-8');
        $st = strlen($str);
        return $st==$mb;
    }

}
