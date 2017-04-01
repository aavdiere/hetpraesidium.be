<?php

require_once 'core/init.php';

if(Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$array = array(
			'username' => array(
				'required' 	=> true,
				'min'		=> 2,
				'max' 		=> 255,
				'unique' 	=> 'users'
			),
			'password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'
			),
			'name' => array(
				'required' => true,
				'min' 	=> 2,
				'max' 	=> 255,
				'not_unique' => 'members',
				'unique' => 'users'
			)
		);
		
		$validation = $validate->check($_POST, $array);

		if ($validation->passed()) {

			$user = new User();

			$salt = Hash::salt(32);

			$DB = DB::getInstance();
			$werkgroepen = $DB->get('members', array('name', '=', Input::get('name')))->first()->werkgroep;
			$werkgroepen = getJsonDecode($werkgroepen, true);
			if (in_array('KERN', $werkgroepen)) {
				$groep = 2;
				if (in_array('KKA', $werkgroepen)) {
					$groep = 3;
				}
				if (in_array('TECHNIEK', $werkgroepen)) {
					$groep = 4;
				}
				if (in_array('KKA', $werkgroepen) && in_array('TECHNIEK', $werkgroepen)) {
					$groep = 5;
				}
				if (in_array('PRAESES', $werkgroepen)) {
					$groep = 6;
				}
				if (in_array('SECRETARIS', $werkgroepen)) {
					$groep = 7;
				}
			} else {
				$groep = 1;
			}

			try {
				$user->create(array(
					'username' 	=> Input::get('username'),
					'password' 	=> Hash::make(Input::get('password'), $salt),
					'salt' 		=> $salt,
					'name' 		=> Input::get('name'),
					'joined' 	=> date('Y-m-d H:i:s'),
					'group' 	=> $groep,
					'werkgroep'	=> getJsonEncode($werkgroepen)
				));
				$email = $DB->get('members', array('name', '=', Input::get('name')))->first()->email;
				$string = Input::get('username') . ' --- ' . Input::get('name') . ' --- ' . $email . ' --- ' . Input::get('password') . "\n";
				//file_put_contents('config/confidential/.txt', $string, FILE_APPEND); // Gebruikt om juiste opslag van wachtwoord te testen
				Session::flash('home', 'You have been registered and can now log in!');
				Redirect::to('index.php');

			} catch(Exception $e) {
				die($e->getMessage());
			}
		} else {
			$error_string = '';
			foreach($validation->errors() as $error) {
				$error_string .= $error."<br>";
			}
			Session::flash('register', $error_string);
			Redirect::to();
		}
	}
}

?>

<div>
	<div class="left-div">
		<h3>Registreer</h3>
		<p>
			<form action="" method="post">
				<div class="field">
					<label for="username">Gebruikersnaam</label>
					<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
				</div>

				<div class="field">
					<label for="password">Wachtwoord</label>
					<input type="password" name="password" id="password" >
				</div>

				<div class="field">
					<label for="password_again">Herhaal wachtwoord</label>
					<input type="password" name="password_again" id="password_again" >
				</div>

				<div class="field">
					<label for="name">Naam</label>
					<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>" placeholder="Zie Praesidiumkaart">
				</div>

				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<div class="field">
					<input type="submit" value="Registreer">
				</div>
			</form>
		</p>
	</div>
	<div class="right-div">
		<?php
			if (Session::exists('register')) {
				echo '
						<h3 style="color: rgb(128, 0, 0);">Opmerkingen</h3>
						<p>' . Session::flash('register') . '</p>
				';
			}
		?>
	</div>
	<div style='clear:both;'>&nbsp;</div>
</div>

<?php require_once 'core/includes/footer.php'; ?>