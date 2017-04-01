<?php
function curPage($get = false) {
	if ($get === false) {
		return substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
	} else {
		$_temp = '';
		if (!empty($_SERVER['QUERY_STRING'])) {
			$_temp = '?';
		}
		return substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'], "/")+1) . $_temp . $_SERVER['QUERY_STRING'];
	}
}
?>