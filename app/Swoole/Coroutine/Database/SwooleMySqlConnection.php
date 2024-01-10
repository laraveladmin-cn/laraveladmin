<?php

namespace App\Swoole\Coroutine\Database;

use Closure;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Database\MySqlConnection as BaseConnection;
use Illuminate\Database\QueryException;
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
     * 兼容协程pdo只能传入纯字符串
     * Run a SQL statement.
     *
     * @param  string  $query
     * @param  array  $bindings
     * @param  \Closure  $callback
     * @return mixed
     *
     * @throws \Illuminate\Database\QueryException
     */
    protected function runQueryCallback($query, $bindings, Closure $callback)
    {
        if(Coroutine::getuid()>0){
            // To execute the statement, we'll simply call the callback, which will actually
            // run the SQL against the PDO connection. Then we can calculate the time it
            // took to execute and log the query SQL, bindings and time in our memory.
            try {
                return $callback((string) $query, $bindings); //字符串强制转换
            }

                // If an exception occurs when attempting to run a query, we'll format the error
                // message to include the bindings with SQL, which will make this exception a
                // lot more helpful to the developer instead of just the database's errors.
            catch (Exception $e) {
                throw new QueryException(
                    $query, $this->prepareBindings($bindings), $e
                );
            }
        }else{
            return parent::runQueryCallback($query, $bindings,$callback);
        }
    }


    /**
     * 获取连接池key
     * @param $only_read
     * @return string
     */
    protected function getPoolKey($only_read = false){
        return $only_read?'read_pool':'pool';
    }

    public function newPDOPool($config){
        $pdo_config = (new PDOConfig)
            ->withHost($config['host'])
            ->withPort($config['port'])
            ->withDbName($config['database'])
            ->withCharset($config['charset'])
            ->withUsername($config['username'])
            ->withPassword($config['password']);
        if(!isset($config['options'])){
            $config['options'] = [];
        }
        if(!isset($config['options'][\PDO::ATTR_STRINGIFY_FETCHES])){
            $config['options'][\PDO::ATTR_STRINGIFY_FETCHES] = false;
        }
        if(!isset($config['options'][\PDO::ATTR_EMULATE_PREPARES])){
            $config['options'][\PDO::ATTR_EMULATE_PREPARES] = false;
        }
        if(isset($config['options']) && $config['options'] && is_array($config['options'])){
            $pdo_config = $pdo_config->withOptions($config['options']);
        }
        if($config['unix_socket']){
            $pdo_config = $pdo_config->withUnixSocket($config['unix_socket']);
        };

        return new PDOPool($pdo_config,Arr::get($config,'pool_size',64));

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
                $this->$key[] = $this->newPDOPool($config);;
            }
        }else{
            $this->$key = $this->newPDOPool($config);
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

    public function close(){
        $pools = $this->read_pool;
        if($pools){
            $pools = is_array($pools)?$pools:[$pools];
            foreach ($pools as $pool){
                $pool->close();
            }
        }
        $pools = $this->pool;
        if($pools){
            $pools = is_array($pools)?$pools:[$pools];
            foreach ($pools as $pool){
                $pool->close();
            }
        }
    }


    /**
     * 获取连接池中的pdo
     * @param $only_read
     * @return mixed
     */
    public function getPoolPdo($only_read = false){
        $key = $this->getPoolKey($only_read);
        $this->getPool($only_read);
        $cid = Coroutine::getCid();
        if(is_array($this->$key)){
            $keys = array_keys($this->$key);
            mt_srand(); //重新播种
            $index = array_rand($keys); //随机获取连接池主机
            $pool = $this->$key[$index];
            $pdo = $pool->get();
            return [
                'pool_index'=>$index,
                'pdo'=>$pdo,
                'pool'=>$pool,
                'cid'=>$cid,
                'only_read'=>$only_read
            ];
        }
        $pool = $this->$key;
        return [
            'pdo'=>$pool->get(),
            'pool'=>$pool,
            'cid'=>$cid,
            'only_read'=>$only_read
        ];
    }


    public function getUseingPoolPdoInfo($only_read = false){
        $cid = Coroutine::getCid();
        $key = $this->getUseingPoolKey($only_read);
        if(!isset($this->$key[$cid])){
            $pdo = $this->getPoolPdo($only_read);
            $this->$key[$cid] = $pdo;
            Coroutine::defer(function ()use($key,$cid){ //协程结束时释放数据库pdo资源
                if(isset($this->$key[$cid])){
                    $pdo_info = $this->$key[$cid];
                    if(!Arr::get($pdo_info,'disable_auto_put')){
                        $this->pdoPutPool($pdo_info);
                    }
                }
            });
        }
        return $this->$key[$cid];
    }

    /**
     * 获取正在使用中的pdo
     * @param $only_read
     * @return mixed
     */
    public function getUseingPoolPdo($only_read = false){
        $pdo_info = $this->getUseingPoolPdoInfo($only_read);
        return $pdo_info['pdo'];
    }

    /**
     * 禁止自动放入连接池
     * @return void
     */
    public function disableAutoPut($pdo_info){
        $only_read = $pdo_info['only_read'];
        $cid = $pdo_info['cid'];
        $key = $this->getUseingPoolKey($only_read);
        if($this->$key[$cid]['only_read']){ //只读不能禁止释放
            return $this;
        }
        $this->$key[$cid]['disable_auto_put'] = true;
        return $this;
    }

    protected function getUseingPoolKey($only_read=false){
        return $only_read?'read_useing_pool_pdos':'useing_pool_pdos';
    }


    /**
     * pdo放回连接池
     * @return void
     */
    public function pdoPutPool($pdo_info){
        $pool = $pdo_info['pool'];
        $only_read = $pdo_info['only_read'];
        $cid = $pdo_info['cid'];
        $key = $this->getUseingPoolKey($only_read);
        if(isset($pdo_info['pool_index'])){ //多主机连接池
            $pool->put($pdo_info['pdo']);
            //$pool_index = $pdo_info['pool_index'];
            //echo ($only_read?'只读':'写入').$cid.'=>'.$pool_index."\n";
        }else{
            $pool->put($pdo_info['pdo']);
            //echo ($only_read?'只读':'写入').$cid."\n";
        }
        unset($this->$key[$cid]);
        return $this;
    }



    /**
     * Get the current PDO connection.
     *
     * @return \PDO
     */
    public function getPdo()
    {
        if ($this->pdo instanceof Closure) {
            $this->pdo = call_user_func($this->pdo);
        }

        if(Coroutine::getuid()>0){ //协程应用调度
            return $this->getUseingPoolPdo();
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

        if ((isset($this->readOnWriteConnection) && $this->readOnWriteConnection) ||
            ($this->recordsModified && $this->getConfig('sticky'))) {
            return $this->getPdo();
        }

        if ($this->readPdo instanceof Closure) {
            $this->readPdo = call_user_func($this->readPdo);
        }

        if($this->readPdo && Coroutine::getuid()>0){ //协程应用调度
            return $this->getUseingPoolPdo(true);
        }

        return $this->readPdo ?: $this->getPdo();
    }


}
