<?php
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

hasPermission(array('admin', 'voorzitter'), 'or', '../index.php');

$codes = array();
$DB = DB::getInstance();
$tables = $DB->query('SHOW TABLES')->results();
foreach ($tables as $key => $table) {
	if (strpos($table->Tables_in_praes_main, 'members') !== false) {
		if ($table->Tables_in_praes_main !== 'members') {
			$codes[] = "<a href='?year=" . substr($table->Tables_in_praes_main, 7) . "'>" . substr($table->Tables_in_praes_main, 7) . "</a>";
		}
	}
}

require_once 'core/includes/header.php';

?>