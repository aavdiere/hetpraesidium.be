<?php require_once 'core/init.php'; ?>

<?php
if (Input::exists('post', 'delete')) {
	$DB->delete(Input::get('event') . 'Event', array('year', '=', Input::get('year')));
	Redirect::to('index.php');
}
?>

<?php require_once 'core/includes/footer.php'; ?>