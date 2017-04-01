<?php require_once 'core/init.php'; ?>

<div style="text-align: center;">
	<?php
		if (Session::exists('home')) {
		echo '
			<div style="text-align: center;">
				<h3 style="color: rgb(128, 0, 0);">Opmerkingen</h3>
				<p>' . Session::flash('home') . '</p>
			</div>
		';
	}
	?>
	<p style="display: inline-block;">Selecteer een lijst</p>
</div>