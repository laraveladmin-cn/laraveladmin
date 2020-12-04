<?php
/**
 * MySQL DB connection interface
 *
 * @author Willfred di Vampo <divampo@gmail.com>
 * @date 2012-04-02
 * @package MediaCore
 * @category Db
 * @namespace MediaCore\Lib\Db\connectors
 * @copyright Copyright (c), 2012
 *
 * 仅仅是一个规范...操作数据库的规范...
 */

namespace App\Models\Traits;


interface  DbMysqlModel {
	/**
	 * DB connect
	 *
	 * @access public
	 *
	 * @return resource connection link
	 */
	public function connect($connection);

	/**
	 * Disconnect from DB
	 *
	 * @access public
	 *
	 * @return viod
	 */
	public function disconnect();

	/**
	 * Free result
	 *
	 * @access public
	 * @param resource $result query resourse
	 *
	 * @return viod
	 */
	public function free($result);

	/**
	 * Execute simple query
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return resource|bool query result
	 */
	public function query($sql,  $args = array());

	/**
	 * Insert query method
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return int|false last insert id
	 */
	public function insert($sql,  $args = array());

	/**
	 * Update query method
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return int|false affected rows
	 */
	public function update($sql,  $args = array());

	/**
	 * Get all query result rows as associated array
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return array associated data array (two level array)
	 */
	public function getAll($sql,  $args = array());

	/**
	 * Get all query result rows as associated array with first field as row key
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return array associated data array (two level array)
	 */
	public function getAssoc($sql,  $args = array());

	/**
	 * Get only first row from query
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return array associated data array
	 */
	public function getRow($sql, $args = array());

	/**
	 * Get first column of query result
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return array one level data array
	 */
	public function getCol($sql,  $args = array());

	/**
	 * Get one first field value from query result
	 *
	 * @access public
	 * @param string $sql SQL query
	 * @param array $args query arguments
	 *
	 * @return string field value
	 */
	public function getOne($sql,  $args = array());
}
