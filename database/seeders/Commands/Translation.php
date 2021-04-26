<?php
/**
 * 翻译菜单名称数据
 */

namespace Database\Seeders\Commands;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ShaoZeMing\LaravelTranslate\Facade\Translate;

class Translation extends Seeder
{
    protected $transPath='commands'; //翻译路径
    protected $routesConfig=[]; //路由数据
    protected $local=''; //本地语言默认设置
    protected $routeJsonPath = '';//路由文件位置
    protected $frontJsonPath = '';//输出翻译文件位置
    protected $langMap = [ //地区语言对应语种代码
        'zh-TW'=>'hk', //繁体中文
        'zh-HK'=>'hk',//繁体中文
        'zh-CN'=>'zh',//简体中文
        'zh'=>'zh',//简体中文
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
        $this->transMenu();
        //$this->TransAll();
    }

    public function transMenu(){
        if(app()->environment() != 'local'){ //仅开发环境执行
            $this->command->info(
                trans_path('This command can only be executed in the development environment',$this->transPath)
            );
            return ;
        }
        $this->local = str_replace('_','-',config('app.locale','en'));//当前默认设置使用地区语言
        /*if($this->local=='en'){ //默认是英文跳过翻译
            $this->command->info(
                trans_path('The application language is not set to English to execute',$this->transPath)
                //应用的语言不是设置为英语时才可执行
            );
            return ;
        }*/
        $this->lang = Arr::get($this->langMap,$this->local,explode('-',$this->local)[0]);//语言代码
        $this->routeJsonPath = base_path('routes/route.json');
        $this->frontJsonPath = resource_path('lang/'.config('app.locale','en').'/front.json');
        $routes_json = file_get_contents($this->routeJsonPath);
        $front_json = json_decode(file_get_contents($this->frontJsonPath),true);
        $this->outMenus = Arr::get($front_json,'_shared.menus',[]);
        $this->routesConfig = json_decode($routes_json,true);
        collect(['menus','resource'])->each(function ($key){
            $this->routesConfig[$key] = collect(Arr::get($this->routesConfig,$key,[]))->map(function ($item){
                collect(['name','description','item_name'])->each(function ($key)use(&$item){
                    $name = Arr::get($item,$key);
                    if($name && !$this->isEnglish($name)){
                        while (true) {
                            try {
                                $new = Str::ucfirst(trim(Translate::setFromAndTo($this->lang ,'en')->translate($name)));
                                break;
                            }catch (\Exception $exception){
                                $this->command->error(trans_path('Failed to translate ":old"',$this->transPath,['old'=>$name]));
                                //return ;
                                sleep(1);
                            }
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
        if(!Arr::get($front_json,'_shared')){
            $front_json['_shared'] = [];
        }
        $front_json['_shared']['menus'] = $this->outMenus;
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
     * 循环翻译更多语言
     */
    public function transAll(){
        //发布语言
        collect(config('laravel_admin.locales',[]))->map(function ($local){
            $local_path = resource_path("lang/{$local}");
            $exists = is_dir($local_path);
            if(!$exists){
                Artisan::call("lang:publish",["locales"=>$local]);
            }
            if(!is_dir($local_path)){
                mkdir(resource_path("lang/{$local}"));
            }
            if(!$exists){
                $validate_path = base_path("node_modules/vee-validate/dist/locale/{$local}.json");
                $validate_data = new \stdClass();
                if(file_exists($validate_path)){
                    $validate_data = json_decode(file_get_contents($validate_path),true)?:$validate_data;
                }
                $data = [
                    'validations'=>$validate_data
                ];
                file_put_contents($local_path.'/front.json',json_encode( $data ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
            }
        });
        $local = config('app.locale','en');
        $local = str_replace('_','-',$local);//当前默认设置使用地区语言
        $local_path = resource_path(str_replace('-','_',"lang/{$local}"));
        $files = scandir($local_path);
        collect($files)->map(function ($file)use($local_path,$local){
            $file_path = "{$local_path}/{$file}";
            if(is_file($file_path)){
                if(Str::endsWith($file,'.php')){
                    if(in_array($file,['_shared.php'])){
                        $this->outPutFileCopy($file_path,$file,$local);
                    }else{

                    }
                }elseif(Str::endsWith($file,'.json')){
                    $data = json_decode(file_get_contents($file_path),true)?:[];
                    $this->outPutData($data,$file,$local);
                }
            }
        });
        $local_path1 = resource_path(str_replace('-','_',"lang/{$local}.json"));
        $data = json_decode(file_get_contents($local_path1),true)?:[];
        $this->outPutData($data,'',$local,false);
    }
    public function outPutFileCopy($file_path,$file,$local){
        collect(config('laravel_admin.locales',[]))
            ->filter(function ($value)use($local){ //排除本地文件
                return str_replace('_','-',$value)!=$local;
            })->map(function ($lang)use($file_path,$file,$local){
                $lang = str_replace('_','-',$lang);
                $file_path1 = resource_path(str_replace('-','_',"lang/{$lang}")."/{$file}");
                if(!file_exists($file_path1)){
                    copy($file_path,$file_path1);
                }
            });
    }

    public function outPutData($data,$file,$local,$lang_prefix=true){
        collect(config('laravel_admin.locales',[]))
            ->filter(function ($value)use($local){ //排除本地文件
            return str_replace('_','-',$value)!=$local;
        })->map(function ($lang)use($data,$file,$local,$lang_prefix){
            $lang = str_replace('_','-',$lang);
            if($lang_prefix){
                $file_path = resource_path(str_replace('-','_',"lang/{$lang}")."/{$file}");
            }else{
                $file_path = resource_path(str_replace('-','_',"lang/{$lang}.json"));
            }
            $data_back = array_merge(array(), $data);
            if(file_exists($file_path)){
                $old_data = json_decode(file_get_contents($file_path),true)?:[];
            }else{
                $old_data = [];
            }
            $_lang = Arr::get($this->langMap,$lang,explode('-',$lang)[0]);
            $_local = Arr::get($this->langMap,$local,explode('-',$local)[0]);
            $data_back = $this->handelData($data_back,$old_data,$_lang,$_local);
            file_put_contents($file_path,json_encode( $data_back ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
        });
    }

    public function handelData(&$data,&$old_data,&$lang,&$local){
        if(is_array($data)){
            foreach ($data as $key=>&$value){
                if(is_array($value)){
                    $old_data1 = Arr::get($old_data,$key,[]);
                    $value = $this->handelData($value,$old_data1,$lang,$local);
                }else{
                    $new = Arr::get($old_data,$key);
                    if(!$new){
                        if($lang=='en' && $local!=$lang){
                            $value = $key;
                        }elseif($local!=$lang){
                            while (true) {
                                try {
                                    $new = trim(Translate::setFromAndTo($local ,$lang)->translate($value));
                                    if($this->isEnglish($new)){
                                        $new = Str::ucfirst($new);
                                    }
                                    $this->command->info(trans_path('From ":old" to ":new"',$this->transPath,['old'=>$value,'new'=>$new]));
                                    $value = $new;
                                    break;
                                }catch (\Exception $exception){
                                    $this->command->error(trans_path('Failed to translate ":old" into ":lang"',$this->transPath,['old'=>$value,'lang'=>$lang]));
                                    //unset($data[$key]);
                                    sleep(1);
                                }
                            }
                        }
                    }else{
                        $value = $new;
                    }
                }
            }
        }
        return $data;
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
