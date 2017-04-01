<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username'	=> array(
				'required' 	=> true,
				'min'		=> 2,
				'max'		=> 50
			)
		));

		if ($validation->passed()) {
			
			try {
				$user->update(array(
					'username'	=> Input::get('username')
				));

				Session::flash('home', 'Profiel ge&uuml;pdate.');
				Redirect::to('index.php');

			} catch (Exception $e) {
				die($e->getMessage());
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}

	}
}

?>

<div>
	<h3>Update Profiel</h3>
	<p>
		<form action="" method="post">
			<div class="field">
				<label for="username">Gebruikersnaam</label>
				<input type="text" name="username" id="username" value="<?php echo escape($user->data()->username); ?>">

				<input type="submit" value="Update">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			</div>
		</form>
	</p>
</div>

<?php require_once 'core/includes/footer.php'; ?>