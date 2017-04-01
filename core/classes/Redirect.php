<?php
class Redirect {
	public static function to($location = null, $get = false, $hash = null) {
		if ($location) {
			if (is_numeric($location)) {
				switch($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include 'core/includes/errors/404.php';
						exit(); 
						break;
				}
			}
		} else {
			$location = substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
			if ($get) {
				$get = '?';
				$x = 0;
				foreach ($_GET as $key => $value) {
					$get .= $key . '=' . $value;
					$x++;
					if ($x < count($_GET)) {
						$get .= '&';
					}
				}
			} else {
				$get = '';
			}
		}
		if ($hash) {
			$hash = '#' . $hash;
		}
		ob_start();
		header('Location: ' . $location . $get . $hash);
		exit();
	}
}
?>