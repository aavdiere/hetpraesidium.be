<?php
class DB {
	private static $_instance = null;
	private $_pdo,
			$_query,
			$_table,
			$_error = false,
			$_results,
			$_count = 0;

	private function __construct() {
		try {
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query($sql, $params = array()) {
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			if (count($params)) {
				$x = 1;
				foreach ($params as $key => $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		return $this;
	}

	public function action($action, $table, $where = array(), $orderby = null) {
		$orderby = trim($orderby);
		$this->_table = $table;
		if (count($where) === 3) {
			$operators = array('=', '<', '>', '<=', '>=', '!=', 'LIKE');

			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];

			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM `{$table}` WHERE {$field} {$operator} ? {$orderby}";

				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		} else if (count($where) === 7) {
			$operators = array('=', '<', '>', '<=', '>=');

			$field[0]		= $where[0];
			$operator[0]	= $where[1];
			$value[0]		= $where[2];
			$logic_gate		= $where[3];
			$field[1]		= $where[4];
			$operator[1]	= $where[5];
			$value[1]		= $where[6];

			if (in_array($operator[0], $operators) && in_array($operator[1], $operators)) {
				$sql = "{$action} FROM `{$table}` WHERE {$field[0]} {$operator[0]} ? {$logic_gate} {$field[1]} {$operator[1]} ? {$orderby}";

				if (!$this->query($sql, array($value[0], $value[1]))->error()) {
					return $this;
				}
			}
		} else if (count($where) === 0) {
			$sql = "{$action} FROM `{$table}` {$orderby}";

			if (!$this->query($sql)->error()) {
				return $this;
			}
		}
		return false;
	}

	public function get($table, $where = array(), $orderby = null) {
		return $this->action('SELECT *', $table, $where, $orderby);
	}

	public function delete($table, $where = array()) {
		return $this->action('DELETE', $table, $where);
	}

	public function results() {
		return $this->_results;
	}

	public function insert($table, $fields = array()) {
		$keys = array_keys($fields);
		$values = '';
		$x = 1;

		foreach ($fields as $key => $field) {
			$values .= '?';
			if ($x < count($fields)) {
				$values .= ', ';
			}
			$x++;
		}

		$sql = "INSERT INTO `{$table}` (`" . implode('`,`', $keys) . "`) VALUES ({$values})";
		
		if (!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	public function update($table, $id, $fields = array()) {
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "`{$name}` = ?";
			if ($x < count($fields)) {
				$set .= ", ";
			}
			$x++;
		}

		$sql = "UPDATE `{$table}` SET {$set} WHERE `id` = {$id}";
		// var_dump($sql);

		if (!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	public function first() {
		$_temp = $this->results();
		return $_temp[0];
	}

	public function error() {
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}

	public function emptyTable($tables = array(), $logic = 'and') {
		$_x = 0;
		$_y = 0;
		foreach ($tables as $table) {
			if ($this->get($table)->count() === 0) {
				$_x++;
			}
			$_y++;
		}
		switch ($logic) {
			case 'and':
				if ($_x === $_y) {
					return true;
				} else {
					return false;
				}
				break;

			case 'or':
				if ($_x > 0) {
					return true;
				} else {
					return false;
				}
				break;
		}
	}

	public function table() {
		return $this->_table;
	}
}
?>