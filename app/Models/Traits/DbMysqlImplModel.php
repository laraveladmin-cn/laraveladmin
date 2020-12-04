<?php
/**
 * Created by PhpStorm.
 * User: randy
 * Date: 14-11-29
 * Time: 上午10:00
 */

namespace App\Models\Traits;



use Illuminate\Support\Facades\DB;

class DbMysqlImplModel  implements DbMysqlModel{
    protected $connection=null;
    /**
     * DB connect
     *
     * @access public
     *
     * @return resource connection link
     */
    public function connect($connection)
    {
        // TODO: Implement connect() method.
        $this->connection = $connection;
    }

    /**
     * Disconnect from DB
     *
     * @access public
     *
     * @return viod
     */
    public function disconnect()
    {
        // TODO: Implement disconnect() method.
    }

    /**
     * Free result
     *
     * @access public
     * @param resource $result query resourse
     *
     * @return viod
     */
    public function free($result)
    {
        // TODO: Implement free() method.
    }

    /**
     * Execute simple query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return resource|bool query result
     */
    public function query($sql,$args = array())
    {
        $all_sql = $this->buildSQL(func_get_args());
        return DB::connection($this->connection)->delete($all_sql);
    }

    /**
     * Insert query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false last insert id
     */
    public function insert($sql, $args = array())
    {
        /**
         * insert into 表名(id,name,age) values(null,'张三',29)
         * insert into 表名 set id = null, name='张三',age=29
         */

        /**
         * 'INSERT INTO ?T SET ?%', $this->tableName, $data             $data = >array('name'=>'张三','age'=>29)
         *
         *
         * 'INSERT INTO 表名 SET  name='张三',age=29'
         */

        $params = func_get_args();
        return $params[2];
    }

    /**
     * Update query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false affected rows
     */
    public function update($sql, $args = array())
    {
        $all_sql = $this->buildSQL(func_get_args());
        return DB::connection($this->connection)->update($all_sql);
    }

    /**
     * Get all query result rows as associated array
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAll($sql,  $args = array())
    {
        $all_sql = $this->buildSQL(func_get_args());
        return DB::connection($this->connection)->select($all_sql);
    }

    /**
     * Get all query result rows as associated array with first field as row key
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAssoc($sql,  $args = array())
    {
        // TODO: Implement getAssoc() method.
    }

    /**
     * Get only first row from query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array
     */
    public function getRow($sql, $args = array())
    {
        $all_sql = $this->buildSQL(func_get_args());
        $rows =  DB::connection($this->connection)->select($all_sql);
        return $rows ? (array) $rows[0] : [];
    }

    /**
     * @param $params ,包含第一个参数的所有参数
     */
    private function  buildSQL($params){
        $sql = array_shift($params); //这是去掉sql后的所有参数
        $sqls = preg_split('/\?[TFN]/',$sql); //这是sql的分割后的数组
        $all_sql = "";
        foreach($sqls as $k=>$sql1){ //将两个数组按照位置合并成一个字符串
            isset($params[$k]) and $all_sql .= "$sql1".$params[$k];
        }
        return $all_sql;
    }

    /**
     * Get first column of query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array one level data array
     */
    public function getCol($sql,  $args = array())
    {
        // TODO: Implement getCol() method.
    }

    /**
     * Get one first field value from query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments   count()
     *
     * @return string field value
     */
    public function getOne($sql,  $args = array())
    {
        $all_sql = $this->buildSQL(func_get_args());
        $rows =  DB::connection($this->connection)->select($all_sql);
        $row = $rows ? (array) $rows[0] : []; //得到第一行.
        return  array_shift($row);//将唯一的一个值弹出
    }


} 