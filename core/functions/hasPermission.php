<?php
function hasPermission($permissions = array(), $logic = 'and', $redirect = null) {
	$user = new User();
	$x = 0;
	foreach ($permissions as $permission) {
		if ($user->hasPermission($permission)) {
			$x++;
		}
	}
	if ($logic === 'and') {
		if ($x === count($permissions)) {
			return true;
		} else {
			if ($redirect === null) {
				Session::flash('home', 'You do not have the sufficiant permission to view this page...');
				Redirect::to('index.php');
			} else if ($redirect === false) {
				return false;
			} else {
				$_temp = explode('/', $redirect);
				$_temp = explode('.', $_temp[count($_temp) - 1]);
				Session::flash($_temp[0], 'You do not have the sufficiant permission to view this page...');
				Redirect::to($redirect);
			}
		}
	} else if ($logic === 'or') {
		if ($x > 0) {
			return true;
		} else {
			if ($redirect === null) {
				Session::flash('home', 'You do not have the sufficiant permission to view this page...');
				Redirect::to('index.php');
			} else if ($redirect === false) {
				return false;
			} else {
				$_temp = explode('/', $redirect);
				$_temp = explode('.', $_temp[count($_temp) - 1]);
				Session::flash($_temp[0], 'You do not have the sufficiant permission to view this page...');
				Redirect::to($redirect);
			}
		}
	}
	
}
?>