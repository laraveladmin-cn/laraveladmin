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
        $use_config = array_merge(
            $config, $options, Arr::pull($config, 'options', [])
        );
        $connector = function () use ($use_config) {
            return $this->createClient($use_config);
        };
        return new PhpRedisConnection($connector(), $connector, $use_config);
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
