<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		
		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'password_current'		=> array(
				'required'	=>	true,
				'min'		=>	6
			),
			'password_new'			=> array(
				'required'	=>	true,
				'min'		=>	6
			),
			'password_new_again'	=> array(
				'required'	=>	true,
				'min'		=>	6,
				'matches'	=>	'password_new'
			)
		));

		if ($validation->passed()) {
			
			if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				echo "Je huidige wachtwoord is verkeerd.";
			} else {
				$salt = Hash::salt(32);
				$user->update(array(
					'password'	=>	Hash::make(Input::get('password_new'),$salt),
					'salt'		=>	$salt
				));

				Session::flash('home', 'Wachtwoord aangepast.');
				Redirect::to('index.php');

			}

		} else {
			$flash = '';
			foreach ($validation->errors() as $error) {
				$flash .= $error. '<br>';
			}
			Session::flash('password', $flash);
			Redirect::to();
		}

	}
}

?>

<div>
	<div class="left-div">
		<h3>Wachtwoord Veranderen</h3>
		<p>
			<form action="" method="post">
				<div class="field">
					<label for="password_current">Huidig Wachtwoord</label>
					<input type="password" name="password_current" id="password_current">
				</div>

				<div class="field">
					<label for="password_new">Nieuw wachtwoord</label>
					<input type="password" name="password_new" id="password_new">
				</div>

				<div class="field">
					<label for="password_new_again">Herhaal nieuw wachtwoord</label>
					<input type="password" name="password_new_again" id="password_new_again">
				</div>

				<input type="submit" value="Wijzig">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			</form>
		</p>
	</div>
	<div class="right-div">
		<?php
			if (Session::exists('password')) {
				echo '
					<h3 style="color: rgb(128, 0, 0);">Opmerkingen</h3>
					<p>' . Session::flash('password') . '</p>
				';
			}
		?>
	</div>
	<div style='clear:both;'>&nbsp;</div>
</div>

<?php require_once 'core/includes/footer.php'; ?>