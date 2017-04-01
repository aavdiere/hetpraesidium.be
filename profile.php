<?php

require_once 'core/init.php';

if (!$username = Input::get('user')) {
	Redirect::to('index.php');
} else {
	$user = new User($username);
	if (!$user->exists()) {
		Redirect::to(404);
	} else {
		$data = $user->data();

	}
?>
<div>
	<h3><?php echo escape($data->name); ?></h3>
	<p>Gebruikersnaam: <?php echo escape($data->username); ?></p>
	<p>Werkgroep: <?php echo getJsonDecode($data->werkgroep); ?></p>
</div>
	<?php
}
require_once 'core/includes/footer.php';
?>