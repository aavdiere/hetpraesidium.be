<?php
require_once 'core/init.php';

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		
		$flash = '';
		$validate = new Validate();
		$validation = $validate->check(array(
			'username'	=> array('required' => true),
			'password'	=> array('required' => true)
		));

		if ($validation->passed()) {
			$user = new User();

			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if ($login) {
				Redirect::to('index.php');
			} else {
				$flash = 'Sorry, logging in failed...';
			}
		} else {
			foreach ($validation->errors() as $error) {
				$flash .= $error . '<br>';
			}
		}
		Session::flash('login', $flash);
		Redirect::to();
	}
}

?>
<div>
	<div class="left-div">
	   <h3>Log In</h3>
		<p>
			<form action="" method="post">
				<div class="field">
					<label for="username">Gebruikersnaam</label>
					<input type="text" name="username" id="username">
				</div>

				<div class="field">
					<label for="password">Wacthwoord</label>
					<input type="password" name="password" id="password">
				</div>

				<div class="field">
					<label for="remember" style="cursor: pointer;"> Remember me</label>
					<input type="checkbox" name="remember" id="remember" checked>
				</div>

				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<div class="field">
					<input type="submit" value="Log in">
				</div>
			</form>
		</p>
	</div>
	<div class="right-div">
		<?php
			if (Session::exists('login')) {
				echo '
					<h3 style="color: rgb(128, 0, 0);">Opmerkingen</h3>
					<p>' . Session::flash('login') . '</p>
				';
			}
		?>
	</div>
	<div style='clear:both;'>&nbsp;</div>
</div>

<?php require_once 'core/includes/footer.php'; ?>