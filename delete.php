<?php include 'core/init.php'; ?>

<?php hasPermission(array('voorzitter')); ?>

<?php

if (Input::exists('get')) {

	$validate = new Validate();
	$validation = $validate->check(array(
		'id' => array(
			'required'	=>	true
		)
	));

	if ($validation->passed()) {
		DB::getInstance()->delete('praesidiumlokaal', array('id', '=', Input::get('id')));
		Session::flash('reserveren', 'Reservatie succesvol verwijderd.');
	} else {
		Session::flash('reserveren', 'Er was een probleem, gelieve opnieuw te proberen.');
	}

	Redirect::to('reserveren.php');

}

?>

<?php include 'core/includes/footer.php'; ?>