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
    protected $commandsJsonPath = '';//控制台命令描述
    protected $langMap = [ //地区语言对应语种代码
        'zh-TW'=>'hk', //繁体中文
        'zh-HK'=>'yue',//粤语中文
        'zh-CN'=>'zh',//简体中文
        'zh'=>'zh',//简体中文
        'ja'=>'jp',//日文
        'per'=>'per',//波斯文
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
        if(app()->environment() != 'local'){ //仅开发环境执行
            $this->command->info(
                trans_path('This command can only be executed in the development environment',$this->transPath)
            );
            return ;
        }
        $this->local = str_replace('_','-',config('app.locale','en'));//当前默认设置使用地区语言
        $this->lang = Arr::get($this->langMap,$this->local,explode('-',$this->local)[0]);//语言代码
        $this->frontJsonPath = resource_path('shared_lang/'.str_replace('_','-',config('app.locale','en')).'/front.json');
        $this->commandsJsonPath = storage_path('/developments/commands.json');
        $this->transMenu();
        $this->transModels();
        $this->transCommands();
        $this->TransAll();
    }

    /**
     * 翻译控制台命令说明
     */
    public function transCommands(){
        if(file_exists($this->commandsJsonPath)){
            $data = json_decode(file_get_contents($this->commandsJsonPath),true)?:[];
            $front_json = json_decode(file_get_contents($this->frontJsonPath),true);
            $old_data = Arr::get($front_json,'pages.admin.developments_index',[]);
            $data = collect($data)->map(function ($item)use(&$old_data){
                $name = $chinese = Arr::get($item,'name',Arr::get($item,'chinese'));
                if($name && !$this->isEnglish($name)){
                    $english = Arr::get($item,'english');
                    if(!$english){
                        while (true) {
                            try {
                                $new = Str::ucfirst(trim(Translate::setFromAndTo($this->lang,'en')->translate($name)));
                                break;
                            }catch (\Exception $exception){
                                $this->command->error(trans_path('Failed to translate ":old"',$this->transPath,['old'=>$name]));
                                $msg = $exception->getMessage();
                                $this->command->warn($exception->getMessage());
                                if($msg=='客户端IP非法'){
                                    $origin = Arr::get(json_decode(file_get_contents('http://www.httpbin.org/ip'),true),'origin');
                                    $origin and $this->command->info($origin);
                                }
                                sleep(1);
                            }
                        }
                        $this->command->info(trans_path('From ":old" to ":new"',$this->transPath,['old'=>$name,'new'=>$new]));
                        $english = $new;
                    }
                    if(!isset($old_data[$english])){
                        $old_data[$english] = $name;
                    }
                }else{
                    $english = $name;
                }
                unset($item['chinese']);
                unset($item['english']);
                $item['name'] = $english;
                //翻译参数处理
                if($parameters = Arr::get($item,'parameters',[])){
                    $item['parameters'] = collect($parameters)->map(function ($parameter)use(&$old_data){
                        collect(['title','name','map'])->map(function ($key)use(&$parameter,&$old_data){
                            $name = Arr::get($parameter,$key,'');
                            if($name && is_array($name)){
                                $parameter[$key] = collect($name)->map(function ($name)use(&$old_data){
                                    if($name && is_string($name)){
                                        $item = $this->transValue($name,$old_data);
                                    }
                                    return $item;
                                })->toArray();
                            }elseif($name && is_string($name)){
                                $parameter[$key] = $this->transValue($name,$old_data);
                            }
                        });
                        return $parameter;
                    })->toArray();
                }
                return $item;
            })->toArray();
            $front_json['pages']['admin']['developments_index'] = $old_data;
            file_put_contents($this->frontJsonPath,json_encode( $front_json ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
            file_put_contents($this->commandsJsonPath,json_encode( $data ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
        }
    }

    public function transValue($name,&$old_data){
        if($name && !$this->isEnglish($name)){
            while (true) {
                try {
                    $new = Str::ucfirst(trim(Translate::setFromAndTo($this->lang,'en')->translate($name)));
                    break;
                }catch (\Exception $exception){
                    $this->command->error(trans_path('Failed to translate ":old"',$this->transPath,['old'=>$name]));
                    $msg = $exception->getMessage();
                    $this->command->warn($exception->getMessage());
                    if($msg=='客户端IP非法'){
                        $origin = Arr::get(json_decode(file_get_contents('http://www.httpbin.org/ip'),true),'origin');
                        $origin and $this->command->info($origin);
                    }
                    sleep(1);
                }
            }
            $this->command->info(trans_path('From ":old" to ":new"',$this->transPath,['old'=>$name,'new'=>$new]));
            $english = $new;
            if(!isset($old_data[$english])){
                $old_data[$english] = $name;
            }
        }else{
            $english = $name;
        }
        return $english;
    }

    /**
     * 翻译转换所有模型
     */
    public function transModels(){
        $model_path = base_path('/app/Models');
        $files = scandir($model_path);
        $front_json = json_decode(file_get_contents($this->frontJsonPath),true);
        $tables = Arr::get($front_json,'_shared.tables',[]);
        collect($files)->map(function ($file)use($model_path,&$tables){
            $file_path = $model_path.'/'.$file;
            if(is_file($file_path) && Str::endsWith($file,'.php')
                // && $file=='Menu.php'
            ){
                $model_class = 'App\Models\\'.Str::replaceLast('.php','',$file);
                $model = new $model_class();
                $table = $model->getTable();
                $fields_name = $model_class::getFieldsName();
                $file_content = file_get_contents($file_path); //模型代码内容
                $table_data = Arr::get($tables,$table,[]);
                $fields = Arr::get($table_data,'fields',[]);
                $maps = Arr::get($table_data,'maps',[]);
                $index_content = '';
                $edit_content = '';
                $index_path = resource_path('/js/pages/admin/'.$table.'/index.vue');
                $edit_path = resource_path('/js/pages/admin/'.$table.'/edit.vue');
                if(file_exists($index_path)){
                    $index_content = file_get_contents($index_path);
                    if(!Str::contains($index_content,"lang_table:'{$table}'") && !Str::contains($index_content,"lang_table: '{$table}'")){
                        $index_content = str_replace('options:{',"options:{\n                    lang_table:'{$table}',",$index_content);
                        $index_content = str_replace('options: {',"options:{\n                    lang_table:'{$table}',",$index_content);
                    }
                }
                if(file_exists($edit_path)){
                    $edit_content = file_get_contents($edit_path);
                    if(!Str::contains($edit_content,"lang_table:'{$table}'") && !Str::contains($edit_content,"lang_table: '{$table}'")){
                        $edit_content = str_replace('options:{',"options:{\n                    lang_table:'{$table}',",$edit_content);
                        $edit_content = str_replace('options: {',"options:{\n                    lang_table:'{$table}',",$edit_content);
                    }
                }
                $at = [
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                    'deleted_at' => 'Deleted At'
                ];
                $at_keys = collect($at)->keys()->toArray();
                //翻译字段
                if(collect($fields_name)->count()){
                    collect($fields_name)->merge(collect($at)->map(function ($value){
                        return trans($value);
                    })->toArray())
                        ->each(function ($name,$key)use(&$file_content,&$fields,&$index_content,&$edit_content,$at,$at_keys){
                            if($name && is_string($name) && !$this->isEnglish($name)){
                                if(!in_array($key,$at_keys)){
                                    while (true) {
                                        try {
                                            $new = Str::ucfirst(trim(Translate::setFromAndTo($this->lang,'en')->translate($name)));
                                            break;
                                        }catch (\Exception $exception){
                                            $this->command->error(trans_path('Failed to translate ":old"',$this->transPath,['old'=>$name]));
                                            $msg = $exception->getMessage();
                                            $this->command->warn($exception->getMessage());
                                            if($msg=='客户端IP非法'){
                                                $origin = Arr::get(json_decode(file_get_contents('http://www.httpbin.org/ip'),true),'origin');
                                                $origin and $this->command->info($origin);
                                            }
                                            sleep(1);
                                        }
                                    }
                                    $this->command->info(trans_path('From ":old" to ":new"',$this->transPath,['old'=>$name,'new'=>$new]));
                                }else{
                                    $new = $at[$key];
                                }
                                //替换代码内容
                                $file_content = str_replace($name,$new,$file_content);
                                //列表页面视图翻译
                                if($index_content){
                                    $index_content = str_replace("\"'{$name}'\"","\"props.transField('{$new}')\"",$index_content);
                                    $index_content = str_replace("props.data.maps","props.maps",$index_content);
                                    $index_content = str_replace($name,$new,$index_content);
                                    $index_content = str_replace("请输入关键字","Please enter keywords",$index_content);
                                }
                                if($edit_content){
                                    $edit_content = str_replace("'{$name}'","props.transField('{$new}')",$edit_content);
                                    $edit_content = str_replace("\"{$name}\"","props.transField(\"{$new}\")",$edit_content);
                                    $edit_content = str_replace("props.data.maps","props.maps",$edit_content);
                                    $edit_content = str_replace('"提示信息"','$t("Prompt message")',$edit_content);
                                    $edit_content = str_replace("'提示信息'","\$t('Prompt message')",$edit_content);
                                    $edit_content = str_replace("快速填写","{{\$t('Quickly fill in')}}",$edit_content);
                                }
                                //翻译内容设置
                                if(!Arr::get($fields,$new)){
                                    $fields[$new] = $name;
                                }
                            }
                        });
                }
                //翻译值映射
                $fields_map = $model_class::getFieldsMap();
                if(collect($fields_map)->count()){
                    collect($fields_map)->each(function ($values,$key)use(&$file_content,&$maps){
                        $map = Arr::get($maps,$key,[]);
                        collect($values)->each(function ($name)use(&$file_content,&$map){
                            if($name && is_string($name) && !$this->isEnglish($name)){
                                while (true) {
                                    try {
                                        $new = Str::ucfirst(trim(Translate::setFromAndTo($this->lang,'en')->translate($name)));
                                        break;
                                    }catch (\Exception $exception){
                                        $this->command->error(trans_path('Failed to translate ":old"',$this->transPath,['old'=>$name]));
                                        $msg = $exception->getMessage();
                                        $this->command->warn($exception->getMessage());
                                        if($msg=='客户端IP非法'){
                                            $origin = Arr::get(json_decode(file_get_contents('http://www.httpbin.org/ip'),true),'origin');
                                            $origin and $this->command->info($origin);
                                        }
                                        sleep(1);
                                    }
                                }
                                $this->command->info(trans_path('From ":old" to ":new"',$this->transPath,['old'=>$name,'new'=>$new]));
                                //替换代码内容
                                $file_content = str_replace($name,$new,$file_content);
                                //翻译内容设置
                                if(!Arr::get($map,$new)){
                                    $map[$new] = $name;
                                }
                            }
                        });
                        $maps[$key]=$map;
                    });
                }
                $table_data['fields']=$fields;
                $table_data['maps']=$maps;
                $tables[$table]=$table_data;
                file_put_contents($file_path,$file_content);
                if($index_content){
                    file_put_contents($index_path,$index_content);
                }
                if($edit_content){
                    file_put_contents($edit_path,$edit_content);
                }
            }
        });
        if(!isset($front_json['_shared'])){
            $front_json['_shared'] = [];
        }
        $front_json['_shared']['tables'] = $tables;
        file_put_contents($this->frontJsonPath,json_encode( $front_json ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));

    }
    /**
     * 翻译菜单
     */
    public function transMenu(){
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
        $this->frontJsonPath = resource_path('shared_lang/'.str_replace('_','-',config('app.locale','en')).'/front.json');
        $routes_json = file_get_contents($this->routeJsonPath);
        $front_json = json_decode(file_get_contents($this->frontJsonPath),true);
        $this->outMenus = Arr::get($front_json,'_shared.menus',[]);
        $this->routesConfig = json_decode($routes_json,true);
        collect(['menus','resource'])->each(function ($key){
            $this->routesConfig[$key] = collect(Arr::get($this->routesConfig,$key,[]))->map(function ($item){
                collect(['name','description','item_name'])->each(function ($key)use(&$item){
                    $name = Arr::get($item,$key);
                    if($name && is_string($name) && !$this->isEnglish($name)){
                        while (true) {
                            try {
                                $new = Str::ucfirst(trim(Translate::setFromAndTo($this->lang ,'en')->translate($name)));
                                break;
                            }catch (\Exception $exception){
                                $this->command->error(trans_path('Failed to translate ":old"',$this->transPath,['old'=>$name]));
                                $msg = $exception->getMessage();
                                $this->command->warn($exception->getMessage());
                                if($msg=='客户端IP非法'){
                                    $origin = Arr::get(json_decode(file_get_contents('http://www.httpbin.org/ip'),true),'origin');
                                    $origin and $this->command->info($origin);
                                }
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
            $local_path = resource_path('lang/'.str_replace('_','-',"{$local}"));
            $local_path1 = resource_path('shared_lang/'.str_replace('_','-',"{$local}"));
            $exists = is_dir($local_path);
            if(!$exists){
                Artisan::call("lang:publish",["locales"=>$local]);
            }
            if(!is_dir($local_path)){
                mkdir($local_path);
            }
            if(!is_dir($local_path1)){
                mkdir($local_path1);
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
                file_put_contents($local_path1.'/front.json',json_encode( $data ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
            }
        });
        $local = config('app.locale','en');
        $local = str_replace('_','-',$local);//当前默认设置使用地区语言
        $local_path = resource_path("lang/".str_replace('_','-',"{$local}"));
        $files = scandir($local_path);
        collect($files)->map(function ($file)use($local_path,$local){
            $file_path = "{$local_path}/{$file}";
            if(is_file($file_path)){
                if(Str::endsWith($file,'.php')){
                    if(in_array($file,['_shared.php'])){
                        $this->outPutFileCopy($file_path,$file,$local);
                    }else{
                        $data = trans(Str::replaceLast('.php','',$file));
                        $this->outPutPhpFile($data,$file,$local);
                    }
                }elseif(Str::endsWith($file,'.json')){
                    $data = json_decode(file_get_contents($file_path),true)?:[];
                    $this->outPutData($data,$file,$local);
                }
            }
        });
        $local_path1 = resource_path("shared_lang/{$local}/front.json");
        $data = json_decode(file_get_contents($local_path1),true)?:[];
        $this->outPutData($data,'front.json',$local);

        $local_path1 = resource_path("lang/"."{$local}.json");
        $data = json_decode(file_get_contents($local_path1),true)?:[];
        $this->outPutData($data,'',$local,false);
    }

    /**
     * 输出PHP文件
     * @param $data
     * @param $file
     * @param $local
     * @param bool $lang_prefix
     */
    public function outPutPhpFile($data,$file,$local,$lang_prefix=true){
        collect(config('laravel_admin.locales',[]))
            ->filter(function ($value)use($local){ //排除本地文件
                return str_replace('_','-',$value)!=$local;
            })->map(function ($lang)use($data,$file,$local,$lang_prefix){
                $lang = str_replace('_','-',$lang);
                if($lang_prefix){
                    $file_path = resource_path("lang/".str_replace('_','-',"{$lang}")."/{$file}");
                }else{
                    $file_path = resource_path("lang/".str_replace('_','-',"{$file}"));
                }
                $data_back = array_merge(array(), $data);
                if(file_exists($file_path)){
                    $old_data = trans(Str::replaceLast('.php','',$file),[],$lang);;
                }else{
                    $old_data = [];
                }
                $_lang = Arr::get($this->langMap,$lang,explode('-',$lang)[0]);
                $_local = Arr::get($this->langMap,$local,explode('-',$local)[0]);
                $data_back = $this->handelData($data_back,$old_data,$_lang,$_local);
                $res = json_encode( $data_back ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)?:'{}';
                $str = '$str';
                $res = "<?php \n$str = <<<'str'\n{$res}\nstr;\nreturn json_decode($str,true);";
                file_put_contents($file_path,$res);
            });
    }





    /**
     * 直接拷贝文件
     * @param $file_path
     * @param $file
     * @param $local
     */
    public function outPutFileCopy($file_path,$file,$local){
        collect(config('laravel_admin.locales',[]))
            ->filter(function ($value)use($local){ //排除本地文件
                return str_replace('_','-',$value)!=$local;
            })->map(function ($lang)use($file_path,$file,$local){
                $lang = str_replace('_','-',$lang);
                $file_path1 = resource_path("lang/".str_replace('_','-',"{$lang}")."/{$file}");
                if(!file_exists($file_path1)){
                    copy($file_path,$file_path1);
                }
            });
    }

    /**
     * @param $data
     * @param $file
     * @param $local
     * @param bool $lang_prefix
     */
    public function outPutData($data,$file,$local,$lang_prefix=true){
        collect(config('laravel_admin.locales',[]))
            ->filter(function ($value)use($local){ //排除本地文件
                return str_replace('_','-',$value)!=$local;
            })->map(function ($lang)use($data,$file,$local,$lang_prefix){
                $lang = str_replace('_','-',$lang);
                if($lang_prefix){
                    $file_path = resource_path("shared_lang/".str_replace('_','-',"{$lang}")."/{$file}");
                }else{
                    $file_path = resource_path("lang/".str_replace('_','-',"{$lang}.json"));
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

    /**
     * 翻译数据
     * @param $data
     * @param $old_data
     * @param $lang
     * @param $local
     * @return mixed
     */
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
                                    if(is_string($new) && $this->isEnglish($new)){
                                        $new = Str::ucfirst($new);
                                    }
                                    $this->command->info(trans_path('From ":old" to ":new"',$this->transPath,['old'=>$value,'new'=>$new]));
                                    $value = $new;
                                    break;
                                }catch (\Exception $exception){
                                    $this->command->error(trans_path('Failed to translate ":old" into ":lang"',$this->transPath,['old'=>$value,'lang'=>$lang]));
                                    $msg = $exception->getMessage();
                                    $this->command->warn($exception->getMessage());
                                    if($msg=='客户端IP非法'){
                                        $origin = Arr::get(json_decode(file_get_contents('http://www.httpbin.org/ip'),true),'origin');
                                        $origin and $this->command->info($origin);
                                    }
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
