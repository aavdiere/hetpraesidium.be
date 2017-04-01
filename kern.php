<?php require_once 'core/init.php' ?>

<?php

if (Input::exists('post', 'addEvent')) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'year' => array(
				'unique' => Input::get('event') . 'Event'
			)
		));

		if ($validation->passed()) {
			$DB->insert(Input::get('event') . 'Event', array(
				'year' => Input::get('year')
			));
			Redirect::to('');
		} else {
			Session::flash('galabal', '<span style="color: red;">Event bestaat al</span>');
		}
	}
}

if (Input::exists('post', 'newEvent')) {
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'event' => array(
			'required' => true,
			'unique' => 'events'
		)
	));

	if ($validation->passed()) {
		$DB->insert('events', array(
			'event' => strtolower(implode('', explode(' ', Input::get('event')))),
			'full' => Input::get('event')
		));
		$DB->query('CREATE TABLE ' . strtolower(implode('', explode(' ', Input::get('event')))) . 'Event (
			id int(11) AUTO_INCREMENT,
			year int(11),
			PRIMARY KEY (id)
		)');
		$DB->insert('pages', array('page' => 'show.php?event='.strtolower(implode('', explode(' ', Input::get('event'))))));
		Redirect::to('');
	} else {
		Session::flash('galabal', '<span style="color: red;">Event naam is verplicht of bestaat al</span>');
	}
}

if (Input::exists('post', 'deleteEvent')) {
	$DB->delete('events', array('event', '=', Input::get('event')));
	$DB->delete('pages', array('page', '=', 'show.php?event=' . Input::get('event')));
	$DB->query('DROP TABLE '.Input::get('event').'Event');
	Redirect::to('index.php');
}

if ($user->isLoggedIn() && $user->hasPermission('editor')) {
	?>

	<?php if (Session::exists('galabal')) { ?>
		<div>
			<h3>Errors</h3>
			<p style="text-align: center;"><?php echo Session::flash('galabal'); ?></p>
		</div>
	<?php } ?>

	<div>
		<h3>Voeg event toe</h3>
		<p>
			<h2>Nieuw Event</h2>
			<p>
				<form method="post">
					<label for="event_new">Event naam: </label>
					<input type="text" id="event_new" name="event" />
					<input type="submit" name="newEvent" />
				</form>
			</p>
			<h2>Nieuwe Editie</h2>
			<p>
				<form action="" method="post">
					<label for="event">Event</label>
					<select name="event" id="event">
						<?php
							$events = $DB->get('events')->results();
							foreach ($events as $event) {
								echo "<option value='$event->event'>$event->event</option>";
							}
						?>
					</select>
					<label for="year">Jaar</label>
					<select name="year" id="year">
						<?php
							for ($i=2014; $i < 2100; $i++) { 
								echo "<option value='$i'>$i</option>";
							}
						?>
					</select>
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
					<input type="submit" name="addEvent" />
				</form>
			</p>
			<h2>Verwijder Event</h2>
			<p>
				<form method="post">
					<label for="eventr">Event</label>
					<select name="event" id="eventr">
						<?php
							$events = $DB->get('events')->results();
							foreach ($events as $event) {
								echo "<option value='$event->event'>$event->event</option>";
							}
						?>
					</select>
					<input type="submit" name="deleteEvent" value="Delete">
				</form>
			</p>
		</p>
	</div>

	<?php
}

?>

<?php show(); ?>

<?php require_once 'core/includes/footer.php' ?>