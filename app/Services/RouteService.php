<?php


namespace App\Services;

use App\Facades\ClientAuth;
use Illuminate\Support\Arr;
use \Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use \App\Models\Menu;

class RouteService
{
    public static $routes = 'routes/route.json';
    protected static $pager = '\App\Http\Controllers\Open\IndexController@index';
    protected static $pager404 = '\App\Http\Controllers\Open\IndexController@page404';
    protected static $web_route_prefix = '';
    protected static $named=[];
    protected static $env = '';
    /**
     * 通过 PhpStorm 创建.
     * 创建人: zhangshiping
     * 日期: 16-5-5
     * 时间: 上午10:26
     * 自定义辅助函数
     */

    public static function getResourceRoutes(array $options = [])
    {
        //控制器默认路由注册
        $methods = collect([
            'index' => [ //列表页面
                'route' => '',
                'method' => [
                    'name' => 'index',
                    'type' => 'get'
                ]
            ],
            'list' => [ //翻页json数据
                'route' => 'list',
                'method' => [
                    'name' => 'list',
                    'type' => 'get'
                ]
            ],
            'export' => [
                'route' => 'excel',
                'method' => [
                    'name' => 'export',
                    'type' => 'get'
                ]
            ],
            'import' => [
                'route' => 'import',
                'method' => [
                    'name' => 'import',
                    'type' => 'post'
                ]
            ],
            'show' => [ //查看数据
                'route' => '{id}',
                'method' =>  [
                    'name' => 'edit',
                    'type' => 'get'
                ]
            ],
            'create' => [ //编辑或新增数据
                'route' => '',
                'method' => [
                    'name' => 'create',
                    'type' => 'post'
                ]
            ],
            'update' => [ //编辑或新增数据
                'route' => '{id}',
                'method' =>  [
                    'name' => 'update',
                    'type' => 'put'
                ]
            ],
            'delete' => [ //删除数据
                'route' => '',
                'method' => [
                    'name' => 'delete',
                    'type' => 'delete'
                ]
            ],

        ]);
        if ($options) {
            $except = Arr::get($options, 'except');
            $only = Arr::get($options, 'only');
            $except AND $methods = $methods->except($except);
            $only AND $methods = $methods->only($only);
        }
        return $methods;
    }

    /**
     * 创建资源路由
     * @param $name
     * @param $controller
     * @param array $options
     */
    public static function createResourceRoute($name, $controller, array $options = [])
    {
        //控制器默认路由注册
        $methods = self::getResourceRoutes($options);
        //路由注册
        $methods->map(function ($item,$key) use ($name, $controller) {
            $type = Arr::get($item, 'method.type', []);
            if ($type && is_string($type)) {
                $route = $item['route']?$name . '/' . $item['route']:$name;
                Route::$type($route, $controller . '@' . $item['method']['name']);
            } else {
                foreach ($type as $type1) {
                    $route = $item['route']?$name . '/' . $item['route']:$name;
                    Route::$type1($route, $controller . '@' . $item['method']['name']);
                }
            }
        });
    }

    /**
     * api路由
     * @param string $route_prefix
     */
    public static function routeRegisterApi($route_prefix=''){
        self::$env = config('app.env');
        //Api使用web模式不注册
        if(!$route_prefix && config('laravel_admin.web_api_model')=='web' && !config('laravel_admin.with_api')){
            return ;
        }
        $routesConfig = json_decode(file_get_contents(base_path(self::$routes)),true);
        collect(Arr::get($routesConfig,'group',[]))->map(function ($group,$key)use($routesConfig,$route_prefix){
            $prefix = $group['prefix'];
            $group['prefix'] = $route_prefix.$prefix;
            $group['middleware'] = collect(Arr::get($group,'middleware',[]))->map(function ($value){
                if($value=='auth'){
                    return 'auth.redirect';
                }else{
                    return $value;
                }
            })->toArray();
            Route::group($group,function()use($routesConfig,$key,$prefix,$group){
                if($key!='none'){
                    Route::get('/','IndexController@index');
                }
                //普通路由
                collect(Arr::get($routesConfig,'menus',[]))
                    ->map(function ($item){
                        $item = Menu::decodeValue($item);//兼容解码
                        return $item;
                    })
                    ->filter(function ($item)use ($key){
                        $use = Arr::get($item,'use','api');
                        $use = is_string($use)?[$use]:$use;
                        return Arr::get($item,'group','')==$key &&
                            Arr::get($item,'url','') &&
                            Arr::get($item,'method','') &&
                            Arr::get($item,'disabled','')==0 &&
                            Arr::get($item,'env',self::$env)==self::$env &&
                            in_array('api',$use);
                    })
                    ->map(function ($item){
                        $path_arr = explode('/',Arr::get($item,'url',''));
                        $value = Arr::get($path_arr,2,'');
                        unset($path_arr[1]);
                        $path = implode('/',$path_arr);
                        if($route_parameters = Arr::get($item,'route_parameters',[])){
                            $path .= '/'.collect($route_parameters)->map(function ($item){
                                    return '{'.$item.'}';
                                })->implode('/');
                        }
                        if($value){
                            $action = Arr::get($item,'action','')?:
                                ucfirst(Str::camel(str_replace('-','_',$value))).'Controller@'.
                                Str::camel(str_replace('-','_',Arr::get($path_arr,3,'index')));
                            $method = Arr::get($item,'method',0);
                            $route = [];
                            $methods = Menu::getFieldsMap('method');
                            collect($methods)->each(function ($type,$val)use(&$route,$method,$path,$action){
                                if($method&$val){
                                    $route =  Route::$type($path, $action);
                                }
                            });
                            if($route && $as = Arr::get($item,'as','')){
                                self::name($route,$as);
                            }
                            if($route && $middleware1 = Arr::get($item,'middleware','')){
                                $route->middleware($middleware1);
                            }
                        }
                    });
                //资源路由注册
                collect(Arr::get($routesConfig,'resource',[]))
                    ->map(function ($item){
                        $item = Menu::decodeValue($item);//兼容解码
                        return $item;
                    })
                    ->filter(function ($item)use ($key){
                        return Arr::get($item,'group','')==$key &&
                            Arr::get($item,'url','') &&
                            Arr::get($item,'env',self::$env)==self::$env &&
                            Arr::get($item,'disabled','')==0;
                    })
                    ->map(function ($item){
                        $value = Arr::get(explode('/',Arr::get($item,'url','')),2,'');
                        if($value){
                            $class = ucfirst(Str::singular(Str::camel(str_replace('-','_',$value)))).'Controller';
                            self::createResourceRoute($value,$class,Arr::get($item,'options',[]));
                        }
                    });


            });
        });
    }

    /**
     * 页面路由注册
     */
    public static function routeRegisterWeb(){
        self::$web_route_prefix = getRoutePrefix('web');
        self::$env = config('app.env');
        //页面返回
        $routesConfig = json_decode(file_get_contents(base_path(self::$routes)),true);
        //web页面接口
        collect(Arr::get($routesConfig,'group',[]))->map(function ($group,$key) use ($routesConfig){
            Route::get($group['prefix']?:'/',self::$pager);
            $middleware = collect(Arr::get($group,'middleware',[]));
            if($middleware->contains('auth')){
                $middleware = $middleware->push('auth.redirect');
            }
            $group['middleware'] = $middleware->toArray();
            $group['prefix'] = self::$web_route_prefix.Arr::get($group,'prefix','');
            Route::group($group,function()use($routesConfig,$key,$group){
                //普通路由
                collect(Arr::get($routesConfig,'menus',[]))
                    ->map(function ($item){
                        $item = Menu::decodeValue($item);//兼容解码
                        return $item;
                    })
                    ->filter(function ($item)use ($key){
                        $use = Arr::get($item,'use','api');
                        $use = is_string($use)?[$use]:$use;
                        return
                            Arr::get($item,'group','')==$key &&
                            Arr::get($item,'is_page','')!=1 &&
                            Arr::get($item,'url','') &&
                            Arr::get($item,'disabled','')==0 &&
                            Arr::get($item,'env',self::$env)==self::$env &&
                            Arr::get($item,'method','') &&
                            in_array('web',$use);
                    })
                    ->map(function ($item){
                        $path_arr = explode('/',Arr::get($item,'url',''));
                        $value = Arr::get($path_arr,2,'');
                        unset($path_arr[1]);
                        $path = implode('/',$path_arr);
                        if($route_parameters = Arr::get($item,'route_parameters',[])){
                            $path .= '/'.collect($route_parameters)->map(function ($item){
                                    return '{'.$item.'}';
                                })->implode('/');
                        }
                        if($value){
                            $action = Arr::get($item,'action','')?:
                                ucfirst(Str::camel(str_replace('-','_',$value))).'Controller@'.
                                Str::camel(str_replace('-','_',Arr::get($path_arr,3,'index')));
                            $method = Arr::get($item,'method',0);
                            $route = [];
                            $methods = Menu::getFieldsMap('method');
                            collect($methods)->each(function ($type,$val)use(&$route,$method,$path,$action){
                                if($method&$val){
                                    $route =  Route::$type($path, $action);
                                }
                            });
                            if($route && $as = Arr::get($item,'as','')){
                                self::name($route,$as);
                            }
                            if($route && $middleware1 = Arr::get($item,'middleware','')){
                                $route->middleware($middleware1);
                            }
                        }
                    });
            });
        });


        //普通路由
        collect(Arr::get($routesConfig,'menus',[]))
            ->map(function ($item){
                $item = Menu::decodeValue($item);//兼容解码
                return $item;
            })
            ->filter(function ($item){
                return
                    Arr::get($item,'is_page','')==1 &&
                    Arr::get($item,'url','') &&
                    Arr::get($item,'method','')==1 &&
                    Arr::get($item,'env',self::$env)==self::$env &&
                    Arr::get($item,'disabled','')==0;
            })
            ->map(function ($item){
                $route = Arr::get($item,'url','');
                if($route){
                    $route = Route::get($route,self::$pager);
                    if($as = Arr::get($item,'as','')){
                        self::name($route,$as);
                    }
                }
            });

        //资源路由注册
        collect(Arr::get($routesConfig,'resource',[]))
            ->map(function ($item){
                $item = Menu::decodeValue($item);//兼容解码
                return $item;
            })
            ->filter(function ($item){
                return Arr::get($item,'url','') &&
                    Arr::get($item,'env',self::$env)==self::$env &&
                    Arr::get($item,'disabled','')==0;
            })
            ->map(function ($item){
                $name = Arr::get($item,'url','');
                if($name){
                    $options = Arr::get($item,'options',[]);
                    if($only = Arr::get($options,'only')){
                        $only = collect($only)->intersect(['index','show'])->toArray();
                    }else{
                        $only = ['index','show'];
                    }
                    $options['only'] = $only;
                    collect(self::getResourceRoutes($options))->map(function ($item)use($name){
                        $route = $item['route']?$name . '/' . $item['route']:$name;
                        Route::get($route,self::$pager);
                    });
                }
            });
        //接口
        if(config('laravel_admin.web_api_model')=='web'){
            self::routeRegisterApi(self::$web_route_prefix);
        }
        //404页面
        Route::get('{any}',self::$pager404)->where('any','(.*)');
    }

    /**
     * 当前路由前缀
     */
    public static function currentUrlPrefix(){
        $model = ClientAuth::isApi()?'api':'web';
        return getRoutePrefix($model);
    }

    protected static function name($route,$name){
       if(isset(self::$named[$name])){
           $route->name($name);
           self::$named[$name] = $route;
       };
    }

}
