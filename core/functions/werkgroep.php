<?php
function werkgroep() {
	$user = new User();
	$_werkgroep = getJsonDecode($user->data()->werkgroep, true);
	foreach ($_werkgroep as $_key => $_value) {
		if ($_value === 'KERN') {
			unset($_werkgroep[$_key]);
		}
	}
	if (!isset($_werkgroep[0])) {
		$_werkgroep[0] = null;
	}
	return $_werkgroep;
}
?>