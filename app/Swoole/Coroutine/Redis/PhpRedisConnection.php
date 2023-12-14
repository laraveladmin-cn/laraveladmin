<?php

namespace App\Swoole\Coroutine\Redis;

use Illuminate\Redis\Connections\PhpRedisConnection as BasePhpRedisConnection;
use Illuminate\Redis\Events\CommandExecuted;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Swoole\Coroutine;
use Swoole\Database\RedisConfig;
use Swoole\Database\RedisPool;


/**
 * @mixin \Redis
 */
class PhpRedisConnection extends BasePhpRedisConnection
{
    /**
     * redis 连接池
     * @var null
     */
    protected $pool = null;

    /**
     * 正在使用中的redis
     * @var array
     */
    protected $useing_pool_redies = [];

    /**
     * Run a command against the Redis database.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \RedisException
     */
    public function command($method, array $parameters = [])
    {
        try {
            $start = microtime(true);
//dd($method,...$parameters);
            $result = $this->client()->{$method}(...$parameters);

            $time = round((microtime(true) - $start) * 1000, 2);

            if (isset($this->events)) {
                $this->event(new CommandExecuted($method, $parameters, $time, $this));
            }
            if(Coroutine::getuid()>0){
                $cid = Coroutine::getCid();
                if(isset($this->useing_pool_redies[$cid])){
                    $redis = $this->useing_pool_redies[$cid];
                    $this->getPool()->put($redis);
                    unset($this->useing_pool_redies[$cid]);
                }
            }

            return $result;
        } catch (\RedisException $e) {
            if (Str::contains($e->getMessage(), 'went away')) {
                $this->client = $this->connector ? call_user_func($this->connector) : $this->client;
            }

            throw $e;
        }
    }

    /**
     * Get the underlying Redis client.
     *
     * @return mixed
     */
    public function client()
    {
        //协程调度
        if(Coroutine::getuid()>0){ //协程应用调度
            //redis连接池获取redis连接对象
            return $this->getUseingPoolRedis();
        }
        return $this->client;
    }

    /**
     * 创建连接池
     * @return $this
     */
    public function createRedisPool(){
        $config = $this->config;
        $pdo_config = (new RedisConfig())
            ->withHost($config['host'])
            ->withPort($config['port'])
            ->withAuth($config['password']?:'')
            ->withDbIndex($config['database'])
            ->withTimeout(Arr::get($config,'timeout',1))
            ->withReserved(Arr::get($config,'reserved',''))
            ->withRetryInterval(Arr::get($config,'retry_interval',0))
            ->withReadTimeout(Arr::get($config,'read_timeout',0));
        $this->pool = new RedisPool($pdo_config,Arr::get($config,'pool_size',64));
        return $this;
    }


    /**
     * 获取连接池
     * @return mixed
     */
    public function getPool(){
        if(!$this->pool){
            $this->createRedisPool();
        }
        return $this->pool;
    }


    /**
     * 获取连接池中的pdo
     * @return mixed
     */
    public function getPoolRedis(){
        $pool = $this->getPool();
        return $pool->get();
    }

    /**
     * 获取正在使用中的redis
     * @return mixed
     */
    protected function getUseingPoolRedis(){
        $cid = Coroutine::getCid();
        if(!isset($this->useing_pool_redies[$cid])){
            $redis = $this->getPoolRedis();
            $this->useing_pool_redies[$cid] = $redis;
        }
        return $this->useing_pool_redies[$cid];
    }


}
