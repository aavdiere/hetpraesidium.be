<?php

require_once 'core/init.php';

if (Session::exists('home')) {
	echo '
		<div style="text-align: center;">
			<h3 style="color: rgb(128, 0, 0);">Opmerkingen</h3>
			<p>' . Session::flash('home') . '</p>
		</div>
	';
}
if (Session::exists('index')) {
	echo '
		<div style="text-align: center;">
			<h3 style="color: rgb(128, 0, 0);">Opmerkingen</h3>
			<p>' . Session::flash('index') . '</p>
		</div>
	';
}

?>

<div style="text-align: center;">
	<h1>
		Het Praesidium heet u welkom!
	</h1>
</div>

<?php
show();
?>

<?php require_once 'core/includes/footer.php'; ?>