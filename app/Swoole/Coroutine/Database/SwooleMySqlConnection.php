<?php

namespace App\Swoole\Coroutine\Database;

use Closure;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Database\MySqlConnection as BaseConnection;
use Illuminate\Support\Arr;
use Swoole\Coroutine;
use Swoole\Database\PDOConfig;
use Swoole\Database\PDOPool;

class SwooleMySqlConnection extends BaseConnection
{
    /**
     * pdo 连接池
     * @var null
     */
    protected $pool = null;

    /**
     * 正在使用中的pdo
     * @var array
     */
    protected $useing_pool_pdos = [];

    /**
     * 只读 pdo 连接池
     * @var null
     */
    protected $read_pool = null;

    /**
     * 正在使用中的只读 pdo
     * @var array
     */
    protected $read_useing_pool_pdos = [];

    /**
     * 获取连接池key
     * @param $only_read
     * @return string
     */
    protected function getPoolKey($only_read = false){
        return $only_read?'read_pool':'pool';
    }

    /**
     * 创建连接池
     * @param $only_read
     * @return $this
     */
    public function createPDOPool($only_read = false){
        $config = $this->config;
        $all_config = config('database.connections.'.$config['name']);
        if($only_read && isset($all_config['read'])){ //读数据库
            $read = $all_config['read'];
            $config = array_merge($config, $read);
        }
        $key = $this->getPoolKey($only_read);
        if(isset($config['host']) && $config['host'] && is_array($config['host'])){ //多主机
            $hosts = $config['host'];
            $this->$key = [];
            foreach ($hosts as $index=>$host){
                $config['host'] = $host;
                $pdo_config = (new PDOConfig)
                    ->withHost($config['host'])
                    ->withPort($config['port'])
                    ->withDbName($config['database'])
                    ->withCharset($config['charset'])
                    ->withUsername($config['username'])
                    ->withPassword($config['password']);
                if($config['unix_socket']){
                    $pdo_config = $pdo_config->withUnixSocket($config['unix_socket']);
                };
                $this->$key[] = new PDOPool($pdo_config,Arr::get($config,'pool_size',64));
            }
        }else{
            $pdo_config = (new PDOConfig)
                ->withHost($config['host'])
                ->withPort($config['port'])
                ->withDbName($config['database'])
                ->withCharset($config['charset'])
                ->withUsername($config['username'])
                ->withPassword($config['password']);
            if($config['unix_socket']){
                $pdo_config = $pdo_config->withUnixSocket($config['unix_socket']);
            };
            $this->$key = new PDOPool($pdo_config,Arr::get($config,'pool_size',64));
        }

        return $this;
    }


    /**
     * 获取连接池
     * @param $only_read
     * @return mixed
     */
    public function getPool($only_read = false){
        $key = $this->getPoolKey($only_read);
        if(!$this->$key){
            $this->createPDOPool($only_read);
        }
        return $this->$key;
    }


    /**
     * 获取连接池中的pdo
     * @param $only_read
     * @return mixed
     */
    public function getPoolPdo($only_read = false){
        $key = $this->getPoolKey($only_read);
        $this->getPool($only_read);
        if(is_array($this->$key)){
            $keys = array_keys($this->$key);
            $index = array_rand($keys); //随机获取连接池主机
            $pdo = $this->$key[$index]->get();
            return [
                'pool_index'=>$index,
                'pdo'=>$pdo,
            ];
        }
        return $this->$key->get();
    }

    /**
     * 去除PDOStatement强制校验,兼容PDOStatementProxy
     * 重写方法兼容swoole连接池pdo
     * Configure the PDO prepared statement.
     *
     * @param  \PDOStatement  $statement
     * @return \PDOStatement
     */
    //protected function prepared(PDOStatement|PDOStatementProxy $statement)
    protected function prepared($statement)
    {
        $statement->setFetchMode($this->fetchMode);

        $this->event(new StatementPrepared(
            $this, $statement
        ));

        return $statement;
    }

    /**
     * 获取正在使用中的pdo
     * @param $only_read
     * @return mixed
     */
    protected function getUseingPoolPdo($only_read = false){
        $cid = Coroutine::getCid();
        $key = $only_read?'read_useing_pool_pdos':'useing_pool_pdos';
        if(!isset($this->$key[$cid])){
            $pdo = $this->getPoolPdo($only_read);
            $this->$key[$cid] = $pdo;
            Coroutine::defer(function ()use($key,$cid,$only_read){ //协程结束时释放数据库pdo资源
                if(isset($this->$key[$cid])){
                    $pdo = $this->$key[$cid];
                    if(is_array($pdo)){ //多主机连接池
                        $this->getPool($only_read)[$pdo['pool_index']]->put($pdo['pdo']);
                        //echo ($only_read?'只读':'写入').$cid.'=>'.$pdo['pool_index']."\n";
                    }else{
                        $this->getPool($only_read)->put($pdo);
                        //echo ($only_read?'只读':'写入').$cid."\n";
                    }
                    unset($this->$key[$cid]);
                }
            });
        }
        if(is_array($this->$key[$cid])){
            return $this->$key[$cid]['pdo'];
        }
        return $this->$key[$cid];
    }



    /**
     * Get the current PDO connection.
     *
     * @return \PDO
     */
    public function getPdo()
    {
        if(Coroutine::getuid()>0){ //协程应用调度
           return $this->getUseingPoolPdo();
        }
        if ($this->pdo instanceof Closure) {
            return $this->pdo = call_user_func($this->pdo);
        }

        return $this->pdo;
    }


    /**
     * Get the current PDO connection used for reading.
     *
     * @return \PDO
     */
    public function getReadPdo()
    {
        if ($this->transactions > 0) {
            return $this->getPdo();
        }

        if ($this->readOnWriteConnection ||
            ($this->recordsModified && $this->getConfig('sticky'))) {
            return $this->getPdo();
        }
        if(Coroutine::getuid()>0) { //协程应用调度
            return $this->getUseingPoolPdo(true);
        }
        if ($this->readPdo instanceof Closure) {
            return $this->readPdo = call_user_func($this->readPdo);
        }

        return $this->readPdo ?: $this->getPdo();
    }


}
