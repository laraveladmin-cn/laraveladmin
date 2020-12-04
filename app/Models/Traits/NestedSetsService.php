<?php
/**
 * Class for managing DB Tree
 *
 * @author Willfred di Vampo <divampo@gmail.com>
 * @date 2012-10-26
 * @package MediaCore
 * @category NestedSets
 * @namespace MediaCore\Lib\NestedSets
 * @copyright Copyright (c), 2012
 */
namespace App\Models\Traits;

use Illuminate\Support\Arr;

/**
 * @package MediaCore
 */
class NestedSetsService {
	/**
	 * @access private
	 * @var MediaCore\Lib\Db\Db an instance of Db class for manipulating with database
	 */
	private $Db;
	/**
	 * @access private
	 * @var string table name
	 */
	private $tableName = '';
	/**
	 * @access private
	 * @var string left key field name
	 */
	private $leftKey = 'left_key';
	/**
	 * @access private
	 * @var string right key field name
	 */
	private $rightKey = 'right_key';
	/**
	 * @access private
	 * @var string parent id field name
	 */
	private $parentKey = 'parent_id';
	/**
	 * @access private
	 * @var string current id field name
	 */
	private $primaryKey = 'id';
	/**
	 * @access private
	 * @var string depth level field name
	 */
	private $levelKey = 'level';
	/**
	 * @ignore
	 * TODO
	 * @var string root id field name
	 */
	private $multi = 'root_id';
	/**
	 * @ignore
	 * TODO
	 * @var string multiple use flag
	 */
	private $type = 'M';

	/**
	 * @ignore
	 * @static
	 * @var array cache array for items
	 */
	private static $cache = array();

	/**
	 * Class constructor
	 *
	 * @access public
	 * @param \MediaCore\Lib\Db\Db $Db an instance of Db class for manipulating with database
	 * @param string $table_name table name
	 * @param string|null $left_key left key field name
	 * @param string|null $right_key right key field name
	 * @param string|null $parent_key parent id field name
	 * @param string|null $primary_key current id field name
	 * @param string|null $level_key depth level field name
	 *
	 * @return void
	 */
	public function __construct(DbMysqlModel $Db, $table_name='', $left_key = null, $right_key = null, $parent_key = null, $primary_key = null, $level_key = null) {
        $this->Db = $Db;
		$this->tableName = $table_name;
		if ($left_key !== null) { $this->leftKey = $left_key; }
		if ($right_key !== null) { $this->rightKey = $right_key; }
		if ($parent_key !== null) { $this->parentKey = $parent_key; }
		if ($primary_key !== null) { $this->primaryKey = $primary_key; }
		if ($level_key !== null) { $this->levelKey = $level_key; }
	}

    /**
     * @param $table_name
     * @param null $left_key
     * @param null $right_key
     * @param null $parent_key
     * @param null $primary_key
     * @param null $level_key
     */
    public function init($table,array $fields,$connection=''){
        $this->tableName = $table; //表名
        $this->primaryKey = $fields['primary_key'] ?: $this->primaryKey; //主键
        $this->leftKey = $fields['left_key'] ?: $this->leftKey; //左边界
        $this->rightKey = $fields['right_key'] ?: $this->rightKey; //右边界
        $this->parentKey = $fields['parent_key'] ?: $this->parentKey; //父节点
        $this->levelKey = $fields['level_key'] ?: $this->levelKey; //层级
		$this->Db->connect($connection);
    }



	/**
	 * Get whole tree
	 *
	 * @access public
	 *
	 * @return array Full list of tree items
	 */
	public function getTree() {
		return $this->Db->getAll('SELECT * FROM ?T ORDER BY ?F', $this->tableName, $this->leftKey);
	}

	/**
	 * Get current branch
	 *
	 * @access public
	 * @param int $id current id
	 *
	 * @return false|array items list
	 */
	public function getBranch($id) {
		$item = $this->getItem($id);
		if (!$item) {
			return false;
		}

		return $this->Db->getAll('SELECT * FROM ?T WHERE ?F > ?N AND ?F < ?N ORDER BY ?F ASC', $this->tableName, $this->rightKey, (int)$item[$this->leftKey], $this->leftKey, (int)$item[$this->rightKey], $this->leftKey);
	}

	/**
	 * Get path to current item (current included)
	 *
	 * @access public
	 * @param int $id current id
	 *
	 * @return false|array items list
	 */
	public function getPath($id) {
		$item = $this->getItem($id);
		if (!$item) {
			return false;
		}

		return $this->Db->getAll('SELECT * FROM ?T WHERE ?F <= ?N AND ?F >= ?N ORDER BY ?F ASC', $this->tableName, $this->leftKey, (int)$item[$this->leftKey], $this->rightKey, (int)$item[$this->rightKey], $this->leftKey);
	}

	/**
	 * Get descendants for current
	 *
	 * @access public
	 * @param int $id current id
	 *
	 * @return false|array list id
	 */
	public function getDescendants($id) {
		$item = $this->getItem($id);
		if (!$item) {
			return false;
		}

		return $this->Db->getAll('SELECT * FROM ?T WHERE ?F >= ?N AND ?F <= ?N ORDER BY ?F', $this->tableName, $this->leftKey, (int)$item[$this->leftKey], $this->rightKey, (int)$item[$this->rightKey], $this->leftKey);
	}

	/**
	 * Get child for current
	 *
	 * @access public
	 * @param int $id current id
	 *
	 * @return false|array items list
	 */
	public function getChilds($id) {
		return $this->Db->getAll('SELECT * FROM ?T WHERE ?F = ?N ORDER BY ?F ASC', $this->tableName, $this->parentKey, (int)$id, $this->leftKey);
	}


	/**
	 * Insert new item
	 *
	 * @access public
	 * @param int $parent_id parent node id
	 * @param array $data extra data
	 * @param string $position new item position (top|bottom)
	 *
	 * @return false|int inserted item id
	 */
	public function insert($parent_id, array $data = array(), $position = 'top') {
		$parent = $this->getItem($parent_id);

		// If parent is root
		if (!$parent) {
			$parent_id = 0;

			// If insert is at the end then left key choose as
			// maximum right key + 1, level - 1
			$level = 1;
			if ($position == 'top') {
				$key = 1;
			} else {
				$key = (int)$this->Db->getOne('SELECT MAX(?F) FROM ?T', $this->rightKey, $this->tableName) + 1;
			}
		} else {
			$tmp = $this->Db->getRow(
				'SELECT ?F, ?F, ?F FROM ?T WHERE ?F = ?N',
				$this->rightKey,
				$this->leftKey,
				$this->levelKey,
				$this->tableName,
				$this->primaryKey,
				(int)$parent_id
			);
			$key = $position == 'top' ? Arr::get($tmp,$this->leftKey,0) + 1: Arr::get($tmp,$this->rightKey,0);
			$level = Arr::get($tmp,$this->levelKey,0) + 1;
		}

		// Update tree keys to create gap
		$res = $this->Db->update(
			'UPDATE ?T SET ?F = ?F + 2, ?F = IF(?F >= ?N, ?F + 2, ?F) WHERE ?F >= ?N',
			$this->tableName,
			$this->rightKey,
			$this->rightKey,
			$this->leftKey,
			$this->leftKey,
			(int)$key,
			$this->leftKey,
			$this->leftKey,
			$this->rightKey,
			(int)$key
		);
        if($res===false)return false;

		$data[$this->parentKey] = (int)$parent_id;
		$data[$this->leftKey] = (int)$key;
		$data[$this->rightKey] = (int)$key + 1;
		$data[$this->levelKey] = (int)$level;

		// Create new node
		return $this->Db->insert('INSERT INTO ?T SET ?%', $this->tableName, $data);
	}

	/**
	 * Delete current item WITH ALL DESCENDANTS
	 *
	 * @access public
	 * @param int $id current id
	 *
	 * @return bool execution state
	 */
	public function delete($id) {
		$item = $this->getItem($id);
		if (!$item) {
			return false;
		}

		$skew = $item[$this->rightKey] - $item[$this->leftKey] + 1;
		// delete node
		$this->Db->query(
			'DELETE FROM ?T WHERE ?F >= ?N AND ?F <= ?N',
			$this->tableName,
			$this->leftKey,
			(int)$item[$this->leftKey],
			$this->rightKey,
			(int)$item[$this->rightKey]
		);

		// Update keys for a displacement
		$this->Db->update(
			'UPDATE ?T SET ?F = IF(?F > ?N, ?F - ?N, ?F), ?F = ?F - ?N WHERE ?F > ?N',
			$this->tableName,

			$this->leftKey,
				$this->leftKey,
				(int)$item[$this->leftKey],
				$this->leftKey,
				(int)$skew,
				$this->leftKey,

			$this->rightKey,
				$this->rightKey,
				(int)$skew,

			$this->rightKey,
				(int)$item[$this->rightKey]
		);

		return true;
	}


	/**
	 * Move current item to the subordinate of parent
	 *
	 * @access public
	 * @param int $id current item id
	 * @param int $parent_id parent item id
	 * @param string $position move to position (top|bottom)
	 *
	 * @return bool execution state
	 */
	public function moveUnder($id, $parent_id, $position = 'bottom') {
		$item = $this->getItem($id);
		if (!$item) {
			return false;
		}

		$parent = $this->getItem($parent_id);

		// if position is root node
		if (!$parent) {
			$level = 1;
			// if moving to the beginning of the list
			if ($position == 'top') {
				$near_key = 0;
			} else {
				// else choose max value of right key
				$near_key = (int)$this->Db->getOne('SELECT MAX(?F) FROM ?T', $this->rightKey, $this->tableName);
			}
		} else {
			$level = $parent[$this->levelKey] + 1;
			// depending on order of movement get left or right key
			if ($position == 'top') {
				$near_key = $parent[$this->leftKey];
			} else {
				$near_key = $parent[$this->rightKey] - 1;
			}
		}

		// move item
		return $this->move($id, $parent_id, $near_key, $level);
	}

	/**
	 * Move current item near
	 *
	 * @access public
	 * @param int $id current item id
	 * @param int $near_id news item id
	 * @param string $position move to position (after|before)
	 *
	 * @return bool execution state
	 */
	public function moveNear($id, $near_id, $position = 'after') {
		$item = $this->getItem($id);
		if (!$item) {
			return false;
		}

		$near = $this->getItem($near_id);
		if (!$near) {
			return false;
		}

		$level = $near[$this->levelKey];

		// depending on order of movement get left or right key
		if ($position == 'before') {
			$near_key = $near[$this->leftKey] - 1;
		} else {
			$near_key = $near[$this->rightKey];
		}

		// move item
		return $this->move($id, $near[$this->parentKey], $near_key, $level);
	}

	/**
	 * Move current item process
	 *
	 * @access private
	 * @param int $id current id
	 * @param int $parent_id parent item id
	 * @param int $near_key BEFORE ITEM key id
	 *
	 * @return bool execution state
	 */
	private function move($id, $parent_id, $near_key, $level) {
		$item = $this->getItem($id);
		if (!$item) {
			return false;
		}

		// check possibility
		if ($near_key >= $item[$this->leftKey] && $near_key <= $item[$this->rightKey]) {
			return false;
		}

		// Determine the displacement of the keys moving structure and level shifting
		$skew_tree = $item[$this->rightKey] - $item[$this->leftKey] + 1;
		$skew_level = $level - $item[$this->levelKey];
		// move up on the tree
		if ($item[$this->rightKey] < $near_key) {
			// Determine the displacement of the keys for the tree
			$skew_edit = $near_key - $item[$this->leftKey] + 1 - $skew_tree;

			// move node and update tree
			$this->Db->update('
				UPDATE ?T
				SET
					?F = IF(
						?F <= ?N,
						?F + ?N,
						IF(
							?F > ?N,
							?F - ?N, ?F
						)
					),
					?F = IF(
						?F <= ?N,
						?F + ?N,
						?F
					),
					?F = IF(
						?F <= ?N,
						?F + ?N,
						IF(
							?F <= ?N,
							?F - ?N,
							?F
						)
					),
					?F = IF(
						?F = ?N,
						?N,
						?F
					)
				WHERE
					?F > ?N
					AND ?F <= ?N',

				$this->tableName,

				$this->leftKey,
					$this->rightKey,
					(int)$item[$this->rightKey],
					$this->leftKey,
					(int)$skew_edit,

						$this->leftKey,
						(int)$item[$this->rightKey],
						$this->leftKey,
						(int)$skew_tree,
						$this->leftKey,

				$this->levelKey,
					$this->rightKey,
					(int)$item[$this->rightKey],
					$this->levelKey,
					(int)$skew_level,
					$this->levelKey,

				$this->rightKey,
					$this->rightKey,
					(int)$item[$this->rightKey],
					$this->rightKey,
					(int)$skew_edit,

						$this->rightKey,
						(int)$near_key,
						$this->rightKey,
						(int)$skew_tree,
						$this->rightKey,

				$this->parentKey,
					$this->primaryKey,
					(int)$id,
					(int)$parent_id,
					$this->parentKey,

				$this->rightKey,
				(int)$item[$this->leftKey],

				$this->leftKey,
				(int)$near_key
			);
		} else { // move down on the tree
			// Determine the displacement of the keys for the tree
			$skew_edit = $near_key - $item[$this->leftKey] + 1;

			// move node and update tree
			$this->Db->update('
				UPDATE ?T
				SET
					?F = IF(
						?F >= ?N,
						?F + ?N,
						IF(
							?F < ?N,
							?F + ?N,
							?F
						)
					),
					?F = IF(
						?F >= ?N,
						?F + ?N,
						?F
					),
					?F = IF(
						?F >= ?N,
						?F + ?N,
						IF(
							?F > ?N,
							?F + ?N,
							?F
						)
					),
					?F = IF(
						?F = ?N,
						?N,
						?F
					)
					WHERE
						?F > ?N
						AND ?F < ?N',

				$this->tableName,

				$this->rightKey,
					$this->leftKey,
					(int)$item[$this->leftKey],
					$this->rightKey,
					(int)$skew_edit,

						$this->rightKey,
						(int)$item[$this->leftKey],
						$this->rightKey,
						(int)$skew_tree,
						$this->rightKey,

				$this->levelKey,
					$this->leftKey,
					(int)$item[$this->leftKey],
					$this->levelKey,
					(int)$skew_level,
					$this->levelKey,

				$this->leftKey,
					$this->leftKey,
					(int)$item[$this->leftKey],
					$this->leftKey,
					(int)$skew_edit,

						$this->leftKey,
						(int)$near_key,
						$this->leftKey,
						(int)$skew_tree,
						$this->leftKey,

				$this->parentKey,
					$this->primaryKey,
					(int)$id,
					(int)$parent_id,
					$this->parentKey,

				$this->rightKey,
				(int)$near_key,

				$this->leftKey,
				(int)$item[$this->rightKey]
			);
		}

		return true;
	}


	/**
	 * @ignore
	 * Get current item data
	 *
	 * @access private
	 * @param int $id current id
	 *
	 * @return array item data
	 */
	private function getItem($id) {
		return $this->Db->getRow('SELECT ?F, ?F, ?F, ?F FROM ?T WHERE ?F = ?N', $this->parentKey, $this->leftKey, $this->rightKey, $this->levelKey, $this->tableName, $this->primaryKey, (int)$id);
	}

}
