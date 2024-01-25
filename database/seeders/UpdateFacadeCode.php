<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UpdateFacadeCode extends Seeder
{
    protected $codes = [
     /*   'facade'=>[
            'class'=>\Illuminate\Support\Facades\Facade::class,
            'codes'=>[
                [
                    'old'=><<<'str'
        public static function __callStatic($method, $args)
        {
            $instance = static::getFacadeRoot();

            if (! $instance) {
                throw new RuntimeException('A facade root has not been set.');
            }

            return $instance->$method(...$args);
        }
    str,
                    'new'=><<<'str'
        public static function __callStatic($method, $args)
        {
            $instance = static::getFacadeRoot();
            $abstract = static::getFacadeAccessor();
            $instance = \App\Swoole\Coroutine\Context::coroutineUseObj($abstract,$instance);

            if (! $instance) {
                throw new RuntimeException('A facade root has not been set.');
            }

            return $instance->$method(...$args);
        }
    str
                ],
                [
                    'old'=><<<'str'
        public static function getFacadeApplication()
        {
            return static::$app;
        }
    str,
                    'new'=><<<'str'
        public static function getFacadeApplication()
        {
            if($now_app = \App\Swoole\Coroutine\Context::getApp()){
                return $now_app;
            }
            return static::$app;
        }
    str
                ],
                [
                    'old'=><<<'str'
    static::$app->
    str,
                    'new'=><<<'str'
    self::getFacadeApplication()->
    str
                ]
            ]
        ],*/
        'response'=>[
            'class'=>\SwooleTW\Http\Transformers\Response::class,
            'codes'=>[
                [
                    'old'=><<<'str'
            $this->swooleResponse->end($illuminateResponse->output);
str,
                  'new'=><<<'str'
            $this->swooleResponse->end($illuminateResponse->getOutput());
str
                ]
            ]
        ],
        'container'=>[
            'class'=>\Illuminate\Container\Container::class,
            'codes'=>[
                [
                    'old'=><<<'str'
        if (isset($this->instances[$abstract]) && ! $needsContextualBuild) {
            return $this->instances[$abstract];
        }
str,
                    'new'=><<<'str'
        if (isset($this->instances[$abstract]) && ! $needsContextualBuild) {
            $object = $this->instances[$abstract];
            return \App\Swoole\Coroutine\Context::coroutineUseObj($abstract,$object);
        }
str
                ],
                [
                    'old'=><<<'str'
        array_pop($this->with);

        return $object;
str,
                    'new'=><<<'str'
        array_pop($this->with);
        
        if(class_exists('\App\Swoole\Coroutine\Context')){
            return \App\Swoole\Coroutine\Context::coroutineUseObj($abstract,$object);
        }
        return $object;
str
                ],
                [
                    'old'=><<<'str'
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }
str,
                    'new'=><<<'str'
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        $instance = static::$instance;
        if($new_instance = \App\Swoole\Coroutine\Context::getApp()){
            return $new_instance;
        }
        return $instance;
    }
str
                ]
            ]
        ],
        'auth'=>[
            'class'=>\Illuminate\Support\Facades\Auth::class,
            'codes'=>[
                [
                    'old'=><<<'str'
    static::$app->
    str,
                    'new'=><<<'str'
    self::getFacadeApplication()->
    str
                ]
            ]
        ]
    ];

    public function run()
    {
        collect($this->codes)->each(function ($file_item){
            $this->updateFile($file_item);
        });
        $this->upFacadeFile();
    }

    protected function upFacadeFile(){
        $class = \Illuminate\Support\Facades\Facade::class;
        $file = (new \ReflectionClass($class))->getFileName();
        $code = file_get_contents(database_path('/seeders/templates/Facade.php.txt'));
        file_put_contents($file,$code);
    }



    protected function updateFile($file_item){
        $class = $file_item['class'];
        $file = (new \ReflectionClass($class))->getFileName();
        $code = file_get_contents($file);
        $this->buildCode($code,$file_item['codes'],$file);
        file_put_contents($file,$code);
    }

    protected function buildCode(&$code,$codes,$file){
        collect($codes)->each(function ($item)use(&$code,$file){
            $str = $item['old'];
            $up_str = $item['new'];
            if(Str::contains($code,$str)){
                $code = Str::replace($str,$up_str,$code);
            }else if(!Str::contains($code,$up_str)){
                $this->command->warn($file.'中没有找到对应代码:'.PHP_EOL.$str);
            }
        });
    }
}
