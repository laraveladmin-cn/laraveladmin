<?php

namespace App\Swoole\Coroutine;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Swoole\Coroutine;
use \SwooleTW\Http\Coroutine\Context as BaseContext;
use SwooleTW\Http\Server\Sandbox;

class Context extends BaseContext
{

    public static $instances=[
        StartSession::class,
        'config',
        'session',
        'session.store',
        'auth',
        'auth.driver',
     /*   'tymon.jwt',
        'tymon.jwt.auth',
        'tymon.jwt.parser',
        'tymon.jwt.claim.factory',
        'tymon.jwt.manager',*/
        'life_data',
        'option',
        'telegram_bot',
        'NestedSetsService',
        'DbMysqlModel',
    ];
    public static $instances_more=[
        'router',
        'cookie'
    ];

    /**
     * Set data by current coroutine id.
     *
     * @param string $key
     * @param $value
     */
    public static function setData(string $key, $value)
    {
        $cid = static::getRequestedCoroutineId();
        if($cid>0 && !isset(static::$data[$cid])){
            Coroutine::defer(function ()use($cid){ //协程结束时释放数据
                if(Coroutine::getuid()==$cid){ //主协程结束时释放数据
                    self::clear();
                }
            });
        }
        static::$data[$cid][$key] = $value;
    }
    /**
     * Set app container by current coroutine id.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     */
    public static function setApp(Container $app)
    {
        $cid = static::getRequestedCoroutineId();
        if($cid>0 && !isset(static::$data[$cid])){
            Coroutine::defer(function ()use($cid){
                if(Coroutine::getuid()==$cid){ //主协程结束时释放数据
                    self::clear();
                }
            });
        }
        static::$apps[static::getRequestedCoroutineId()] = $app;
    }

    public static function coroutineUseObj($abstract,$object){
        $uid = static::getRequestedCoroutineId();
        if($uid<=0 || !is_string($abstract)){
            return $object;
        }
        $instances = array_merge(static::$instances,static::$instances_more);//config('swoole_http.instances',[]);
        $base_instances = ['swoole_response','request'];
        if(in_array($abstract,$instances) || in_array($abstract,$base_instances)){
            $key = '_'.$abstract;
            if(in_array($abstract,$base_instances)){
                $new_object = BaseContext::getData($key);
            }else{
                $new_object = static::getData($key);
            }
            if(!$new_object){
                //$new_object = clone $object;
                $new_object = $object;
                static::setData($key, $new_object);
            }
            $object = $new_object;
        }
        return $object;
    }

    public static function getDataAll()
    {
        return static::$data[static::getRequestedCoroutineId()] ?? [];
    }

    public static function requestInstances(){
        return array_merge(
            static::$instances,
            static::$instances_more,
            [
                'swoole_response',
                'request'
            ]);
    }

    public static function closeClients($app,$config){
        $connections = $config->get('database.connections');
        collect($connections)->each(function ($item,$connection_name)use($app){
            $driver = Arr::get($item,'driver');
            if($driver=='swoole-mysql'){
                $connection = $app['db']->connection($connection_name);
                if($connection && method_exists($connection,'close')){
                    $connection->close();
                }
            }
        });
        if($config->get('database.redis.client')=='swoole-phpredis'){
            $connections = $app['redis']->connections();
            collect($connections)->each(function ($item,$connection_name)use($app){
                $connection = $app['redis']->connection($connection_name);
                if($connection && method_exists($connection,'close')){
                    $connection->close();
                }
            });
        }
    }

}
