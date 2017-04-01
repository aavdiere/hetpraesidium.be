<?php
function getJsonEncode($groep = null, $string = null) {
	$DB = DB::getInstance();
	if ($string === 'csv') {
		$groepen = explode(" ::: ", $groep);
	} else {
		$groepen = $groep;
	}
	$werkgroepen = objectToArray_werkgroepen($DB->get('werkgroepen')->results());
	$werkgroepen[] = 'SECRETARIS';
	$werkgroepen[] = 'PRAESES';
	foreach ($groepen as $key => $groep) {
		if (!in_array(strtoupper($groep), array_map('strtoupper', $werkgroepen))) {
			unset($groepen[$key]);
		}
	}
	$array = array();
	foreach ($werkgroepen as $key => $werkgroep) {
		if (in_array(strtoupper($werkgroep), array_map('strtoupper', $groepen))) {
			$array[strtoupper($werkgroep)] = 1;
		} else {
			$array[strtoupper($werkgroep)] = 0;
		}
		
	}
	return json_encode($array);
}
?>