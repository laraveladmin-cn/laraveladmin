<?php


namespace App\Services;

use App\Facades\ClientAuth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use \App\Models\Menu;

class RouteService
{
    public static $routes = 'routes/route.json';
    protected static $pager = '\App\Http\Controllers\Open\IndexController@index';
    protected static $pager404 = '\App\Http\Controllers\Open\IndexController@page404';
    protected static $api404 = '\App\Http\Controllers\Open\IndexController@api404';
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
            if($except){
                if(is_array($except[0])){
                    $except = collect($except)->pluck('name');
                }
                $methods = $methods->except($except);
            }
            if($only){
                if(is_array($only[0])){
                    if(!self::$env){
                        self::$env = config('app.env');
                    }
                    $only = collect($only)->filter(function ($item){
                        $env = Arr::get($item,'env', self::$env);
                        $del = Arr::get($item,'_is_deleted',0);
                        $disabled = Arr::get($item,'disabled',0);
                        return $env==self::$env && !$del && !$disabled;
                    })->values()
                        ->pluck('name');
                }
                $methods = $methods->only($only);
            }
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
            $group['old_prefix'] = $prefix;
            $group['prefix'] = $route_prefix.$prefix;
            $group['middleware'] = collect(Arr::get($group,'middleware',[]))->map(function ($value){
                if($value=='auth'){
                    return 'auth.redirect';
                }else{
                    return $value;
                }
            })->toArray();
            Route::group($group,function()use($routesConfig,$key,$prefix,$group){
                $defClass = $group['namespace'].'\\IndexController';
                if($key!='none' && class_exists($defClass) && method_exists(new $defClass,'index')){
                    Route::get('/','IndexController@index');
                }
                //普通路由
                collect(Arr::get($routesConfig,'menus',[]))
                    ->map(function ($item){
                        $item = Menu::decodeValue($item);//兼容解码
                        return $item;
                    })
                    ->filter(function ($item)use ($key){
                        $use = Arr::get($item,'use',1);
                        $use = !is_array($use)?[$use]:$use;
                        return Arr::get($item,'group','')==$key &&
                            Arr::get($item,'url','') &&
                            Arr::get($item,'method','') &&
                            Arr::get($item,'disabled',0)==0 &&
                            Arr::get($item,'env',self::$env)==self::$env &&
                            in_array(1,$use);
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
                                self::getClass($value).'@'.
                                Str::camel(str_replace('-','_',Arr::get($path_arr,3,'index')));
                            $method = Arr::get($item,'method',0);
                            $route = [];
                            $methods = Menu::getFieldsMap('method');
                            $methods = collect($methods)->filter(function ($type,$val)use(&$route,$method){
                                if((is_numeric($method) && $method&$val) || (is_array($method) && in_array($val,$method))){
                                    return $type;
                                }
                            })->values()
                                ->toArray();
                            if($methods && count($methods)==1){
                                $type = $methods[0];
                                $route =  Route::$type($path, $action);
                            }else{
                                $route =  Route::match($methods,$path, $action);
                            }
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
                            Arr::get($item,'disabled',0)==0;
                    })
                    ->map(function ($item)use ($group){
                        $value = Str::replaceFirst($group['old_prefix'].'/','',$item['url']);
                        if($value){
                            $class = self::getClass($value);
                            $options = Arr::get($item,'options',[]);
                            $only = Arr::get($options, 'only');
                            if($only){
                                if(is_array(collect($only)->first())){
                                    $only[] = [
                                        'name'=>'index'
                                    ];
                                }else{
                                    $only[] = 'index';
                                }
                                $options['only'] = $only;
                            }
                            self::createResourceRoute($value,$class,$options);
                        }
                    });


            });
        });
    }

    /**
     * 获取类名
     * @param $value
     * @return string
     */
    public static function getClass($value){
        $str = Str::singular(Str::camel(str_replace('-','_',$value)));
        if(Str::endsWith($str,'ss')){
            $str = Str::replaceLast('ss','s',$str);
        }
        $str = collect(explode('/',$str))->filter()->map(function ($value){
            return ucfirst($value);
        })->implode('\\');
        return $str.'Controller';
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
                        $use = Arr::get($item,'use',2);
                        $use = !is_array($use)?[$use]:$use;
                        return
                            Arr::get($item,'group','')==$key &&
                            Arr::get($item,'is_page','')!=1 &&
                            Arr::get($item,'url','') &&
                            Arr::get($item,'disabled',0)==0 &&
                            Arr::get($item,'env',self::$env)==self::$env &&
                            Arr::get($item,'method','') &&
                            in_array(2,$use);
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
                                self::getClass($value).'@'.
                                Str::camel(str_replace('-','_',Arr::get($path_arr,3,'index')));
                            $method = Arr::get($item,'method',0);
                            $route = [];
                            $methods = Menu::getFieldsMap('method');
                            $methods = collect($methods)->filter(function ($type,$val)use(&$route,$method){
                                if((is_numeric($method) && $method&$val) || (is_array($method) && in_array($val,$method))){
                                   return $type;
                                }
                            })->values()
                                ->toArray();
                            if($methods && count($methods)==1){
                                $type = $methods[0];
                                $route =  Route::$type($path, $action);
                            }else{
                                $route =  Route::match($methods,$path, $action);
                            }
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
                $method = Arr::get($item,'method',[]);
                $url = Arr::get($item,'url','');
                return
                    Arr::get($item,'is_page','')==1 &&
                    $url &&
                    ((is_numeric($method) && $method&1) || (is_array($method) && in_array(1,$method)) || (!$method && Str::startsWith($url,'/'))) &&
                    Arr::get($item,'env',self::$env)==self::$env &&
                    Arr::get($item,'disabled',0)==0;
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
                    Arr::get($item,'disabled',0)==0;
            })
            ->map(function ($item){
                $name = Arr::get($item,'url','');
                if($name){
                    $options = Arr::get($item,'options',[]);
                    if($only = Arr::get($options,'only')){
                        if(is_array($only[0])){
                            $only = collect($only)->filter(function ($item){
                                $env = Arr::get($item,'env', self::$env);
                                $del = Arr::get($item,'_is_deleted',0);
                                $disabled = Arr::get($item,'disabled',0);
                                return $env==self::$env && !$del && !$disabled;
                            })->values()
                                ->pluck('name');
                        }
                        $only = collect($only)->intersect(['index','show'])->prepend('index')->values()->toArray();
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

    }

    /**
     *
     * @param bool $is_web
     */
    public static function any($is_web=true){
        if($is_web){
            Route::get('/web-api',self::$api404);
            Route::get('/web-api/{any}',self::$api404)->where('any','(.*)');
            Route::get('{any}',self::$pager404)->where('any','(.*)');
        }else{
            Route::get('{any}',self::$api404)->where('any','(.*)');
        }
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

    /**
     * 通过数据表菜单内容反向更新route.json文件
     */
    public static function upRouteJson(){
        $methods = RouteService::getResourceRoutes(['except'=>['index']]);
        $methods_count = collect($methods)->count();
        $fillable = collect(Menu::getFillables())->prepend('id')->prepend('deleted_at')->unique()->toArray();
        $default = collect(Menu::getFieldsDefault())->toArray();
        $maps = Menu::getFieldsMap();
        $_id = 1; //存储创建顺序
        //查询所有菜单
        $menus = collect(Menu::withTrashed()
            ->whereRaw(DB::raw('1 or id=1'))
            ->orderBy('left_margin','asc')
            ->get($fillable)
            ->all())
            ->map(function ($menu)use(&$_id){
                $is_del = $menu->deleted_at?1:0;
                $menu = collect($menu)->toArray();
                if($is_del){
                    $menu['_is_deleted'] = $is_del;
                }
                $menu['_id'] = $_id;
                $_id += 1;
                return $menu;
            });
        //筛选资源菜单
        $resource = $menus->filter(function ($menu){
            return $menu['resource_id']!=0;
        })->toArray();
        //资源菜单处理
        $resource = collect(listToTree($resource,'id','resource_id','children',-1))
            ->map(function ($menu)use($methods,$methods_count,$default,$maps){
                $flog = false;
                $children = collect(Arr::get($menu,'children',[]))->filter(function ($item){
                    return Str::is('_*',$item['item_name']);
                })->map(function ($item)use(&$flog){
                    $row = [
                        'id'=>$item['id'],
                        'name'=>Str::replaceFirst('_','',$item['item_name'])
                    ];
                    if(Arr::get($item,'_is_deleted')){
                        $row['_is_deleted'] = 1;
                        $flog = true;
                    }
                    if($env = Arr::get($item,'env')){
                        $row['env'] = $env;
                        $flog = true;
                    }
                    if($disabled = Arr::get($item,'disabled')){
                        $row['disabled'] = $disabled;
                        $flog = true;
                    }
                    return $row;
                });
                $children_count = $children->filter(function ($children){
                    return !Arr::get($children,'_is_deleted');
                })->count();
                $id = $menu['id'];
                $end_id = $id+$children_count;
                if($children_count!=$methods_count ||
                    $children->min('id')<$id ||
                    $children->max('id')>$end_id ||
                    $flog
                ){
                    $menu['options'] = ['only'=>$children->toArray()];
                }
                collect($default)->map(function ($val,$key)use (&$menu){
                    if($val===$menu[$key]){
                        unset($menu[$key]);
                    }
                });
                unset($menu['children']);
                unset($menu['resource_id']);
                $menu = collect($menu)->map(function ($value,$key)use($maps){
                    $map = Arr::get($maps, $key);
                    if ($map) {
                        if (!is_array($value)) {
                            $value = Arr::get($map, $value);
                        } else {
                            $value = collect($value)->map(function ($value) use ($map) {
                                return Arr::get($map, $value);
                            })->toArray();
                        }
                    }
                    return $value;
                });
                $menu['end_id'] = $end_id;
                return $menu;
            });
        //普通菜单处理
        $menus = $menus->filter(function ($menu){
            return $menu['resource_id']==0;
        })->map(function ($menu)use($default,$maps){
            collect($default)->map(function ($val,$key)use (&$menu){
                if($val===$menu[$key] && $key!='method'){
                    unset($menu[$key]);
                }
            });
            $menu = collect($menu)->map(function ($value,$key)use($maps){
                $map = Arr::get($maps, $key);
                if ($map) {
                    if (!is_array($value)) {
                        $value = Arr::get($map, $value);
                    } else {
                        $value = collect($value)->map(function ($value) use ($map) {
                            return Arr::get($map, $value);
                        })->toArray();
                    }
                }
                return $value;
            });
            return $menu;
        });
        //输出菜单数据
        $out_menus = json_decode(file_get_contents(base_path(self::$routes)),true);
        $out_menus['resource'] = $resource->values()->toArray();
        $out_menus['menus'] = $menus->values()->toArray();
        $out_menus['update_position'] = [];
        file_put_contents(base_path(self::$routes),json_encode($out_menus,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
    }

}
