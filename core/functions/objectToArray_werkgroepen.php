<?php
function objectToArray_werkgroepen($array = array()) {
	$list = array();
	foreach ($array as $key => $value) {
		$list[] = $value->werkgroep;
	}
	return $list;
}
?>