<?php

namespace App\Swoole\Coroutine\Redis;
use Illuminate\Support\Arr;
use \Illuminate\Redis\Connectors\PhpRedisConnector as BasePhpRedisConnector;

class PhpRedisConnector extends BasePhpRedisConnector
{
    /**
     * Create a new clustered PhpRedis connection.
     *
     * @param  array  $config
     * @param  array  $options
     * @return \Illuminate\Redis\Connections\PhpRedisConnection
     */
    public function connect(array $config, array $options)
    {
        $connector = function () use ($config, $options) {
            return $this->createClient(array_merge(
                $config, $options, Arr::pull($config, 'options', [])
            ));
        };
        return new PhpRedisConnection($connector(), $connector, $config);
    }

    /**
     * Create a new clustered PhpRedis connection.
     *
     * @param  array  $config
     * @param  array  $clusterOptions
     * @param  array  $options
     * @return \Illuminate\Redis\Connections\PhpRedisClusterConnection
     */
    public function connectToCluster(array $config, array $clusterOptions, array $options)
    {
        $options = array_merge($options, $clusterOptions, Arr::pull($config, 'options', []));
        return new PhpRedisClusterConnection($this->createRedisClusterInstance(
            array_map([$this, 'buildClusterConnectionString'], $config), $options
        ));
    }
}
