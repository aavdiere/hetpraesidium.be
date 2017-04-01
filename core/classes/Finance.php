<?php
class Finance {
	private $_db;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
	}

	public function update($table, $fields = array(), $id = null) {
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if ($x < count($fields)) {
				$set .= ", ";
			}
			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE transactie = {$id}";
		if (!$this->_db->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	public function create($table, $fields = array()) {
		if (!$this->_db->insert($table, $fields)) {
			throw new Exception("Er was een probleem... Gelieve opnieuw te proberen.");
		}
	}
}
?>