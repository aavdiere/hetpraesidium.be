<?php
ob_start();
session_start();

require_once '../globals.php';

$GLOBALS['config']['remember']['cookie_expiry'] = 2629740;
$GLOBALS['config']['session']['session_name'] = 'user';

spl_autoload_register(function($class) {
	require_once '../core/classes/' . $class . '.php';
});

$dir = scandir('../core/functions'); array_shift($dir); array_shift($dir);

for ($i=0; $i < count($dir); $i++) { 
	require_once '../core/functions/'.$dir[$i];
}

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
		Redirect::to();
	} else {
		$user = new User();
	}
} else {
	$user = new User();
}

$temp = werkgroep();
// var_dump($temp); exit();
if (!hasPermission(array('admin'), 'or', false) && hasPermission(array('voorzitter'), 'or', false) && curPage(true) !== 'activiteiten.php?print=y&filter='.$temp[0]) {
	Redirect::to('activiteiten.php?print=y&filter='.$temp[0]);
} else {
	if (!hasPermission(array('voorzitter'), 'or', false)) {
		hasPermission(array('admin'), 'or', '../index.php');
	}
	if (curPage(true) !== 'activiteiten.php?print=y&filter='.$temp[0] && !hasPermission(array('admin'), 'or', false)) {
		Redirect::to('activiteiten.php?print=y&filter='.$temp[0]);
	}
}
// hasPermission(array('admin', 'kka'), 'or', '../index.php');

$codes = array();
$DB = DB::getInstance();
$tables = $DB->query('SHOW TABLES')->results();
foreach ($tables as $key => $table) {
	if (strpos($table->Tables_in_praes_main, 'activiteiten') !== false) {
		if ($table->Tables_in_praes_main !== 'activiteiten') {
			$codes[] = "<a href='?year=" . substr($table->Tables_in_praes_main, 12) . "'>" . substr($table->Tables_in_praes_main, 12) . "</a>";
		}
	}
}

$werkgroepen = objectToArray_werkgroepen($DB->get('werkgroepen', array('werkgroep', '!=', 'KERN'))->results());
$werkgroepen[count($werkgroepen)] = 'LOS';
asort($werkgroepen);

require_once 'core/includes/header.php';

?>