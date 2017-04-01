<?php

class Contacts {
	private $_db;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
	}

	public function get($table, $filter = null) {
		if ($filter === null) {
			return $this->_db->get($table)->results();
		} else {
			$results = $this->_db->get($table)->results();
			$_data = array();
			foreach ($results as $key => $result) {
				$array = (array)json_decode($result->werkgroep);
				if ($array[$filter] == 1) {
					$_data[] = $result;
				}
			}
			return $_data;
		}
	}
}

?>