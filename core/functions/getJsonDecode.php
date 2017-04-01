<?php
function getJsonDecode($json = null, $logic = false) {
	$json = json_decode($json, true);
	$string = array();
	foreach ($json as $werkgroep => $command) {
		if ($command == 1) {
			$string[] = $werkgroep;
		}
	}
	if ($logic) {
		return $string;
	}
	return $string = implode(', ', $string);
}
?>