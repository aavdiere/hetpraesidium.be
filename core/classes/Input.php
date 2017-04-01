<?php

class Input {
	public static function exists($type = 'post', $value = null) {
		switch ($type) {
			case 'post':
				if ($value) {
					return (!empty($_POST[$value])) ? true : false;
				} else {
					return (!empty($_POST)) ? true : false;
				}
				break;

			case 'get':
				if ($value) {
					return (!empty($_GET[$value])) ? true : false;
				} else {
					return (!empty($_GET)) ? true : false;
				}
				break;

			default:
				return false;
				break;
		}
	}

	public static function get($item) {
		if (isset($_POST[$item])) {
			return $_POST[$item];
		} else if (isset($_GET[$item])) {
			return $_GET[$item];
		} else if (isset($_FILES[$item])) {
			return $_FILES[$item]['tmp_name'];
		}
		return '';
	}
}

?>