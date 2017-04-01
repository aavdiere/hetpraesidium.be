<?php

require_once 'core/init.php';
hasPermission(array('voorzitter'));
if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'datum' 		=> array(
				'required'		=>	true,
				'unique_link'	=>	array(
					'moment',
					'praesidiumlokaal'
				)
			),
			'moment' 	=> array(
				'required'	=>	true,
				'not'		=>	'---'
			),
			'werkgroep'	=> array(
				'required'	=>	true,
				'not'		=>	'---'
			)
		));

		if ($validation->passed()) {
			$DB = DB::getInstance();
			$query = $DB->insert('praesidiumlokaal', array(
				'datum'		=>	date('Y-m-d', strtotime(Input::get('datum'))),
				'moment'	=>	Input::get('moment'),
				'werkgroep'	=>	Input::get('werkgroep')
			));

			if ($query) {
				Session::flash('reserveren', 'Reservatie succesvol');
			} else {
				Session::flash('reserveren', 'Er was een probleem met de reservatie, probeer opnieuw');
			}
		} else {
			$flash = '';
			foreach ($validation->errors() as $error) {
				$flash .= $error. "<br>";
			}
			Session::flash('reserveren', $flash);
		}

		Redirect::to();
	}
}
$DB = DB::getInstance();
$rows = $DB->get('praesidiumlokaal', array(), 'ORDER BY datum ASC')->results();

$werkgroepen = objectToArray_werkgroepen($DB->get('werkgroepen')->results());
asort($werkgroepen);

if (Session::exists('reserveren')) {
	echo '
		<div style="text-align: center;">
			<h3 style="color: rgb(128, 0, 0);">Opmerkingen</h3>
			<p>' . Session::flash('reserveren') . '</p>
		</div>
	';
}

?>

<div>
	<h3>Reserveren</h3>
	<p>
		<form action="" method="post">
			<table class="reservation">
				<thead>
					<tr>
						<td>Dag</td>
						<td>Moment</td>
						<td>Werkgroep</td>
					</tr>
				</thead>
				<tbody>
					<?php

					foreach ($rows as $row) {
						echo "
							<tr>
								<td>".date('d-m-Y', strtotime($row->datum))."</td>
								<td>$row->moment</td>
								<td>$row->werkgroep</td>
								<td>";

								if ($user->hasPermission('voorzitter') && (in_array($row->werkgroep, werkgroep()) || $user->hasPermission('admin'))) {
									echo "<a href='delete.php?id=$row->id'><img src='images/delete.png' style='width: 10px; height: 10px;' /></a>";
								}

						echo	"</td>
							</tr>
						";
					}

					?>
					<tr>
						<td>
							<div class="field">
								<label for="datum"></label>
								<input type="date" name="datum" id="datum">
							</div>
						</td>
						<td>
							<div class="field">
								<label for="moment"></label>
								<select name="moment" id="moment">
									<option selected>---</option>
									<option  value="MIDDAG">MIDDAG</option>
									<option  value="AVOND">AVOND</option>
								</select>
							</div>
						</td>
						<td>
							<div class="field">
								<label for="werkgroep"></label>
								<select name="werkgroep" id="werkgroep">
									<option selected>---</option>
									<?php
										foreach ($werkgroepen as $key => $werkgroep) {
											if (in_array($werkgroep, werkgroep()) || $user->hasPermission('admin')) {
												echo "<option value='" . $werkgroep . "'>" . $werkgroep . "</options>";
											}
										}
									?>
								</select>
							</div>
						</td>
						<td>
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
							<input type="submit" value="Reserveer">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</p>
</div>

<?php require_once 'core/includes/footer.php'; ?>