<?php

require_once 'core/init.php';

// hasPermission(array('admin'), 'and', 'kka.php');

$table = 'activiteiten';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}
if (Input::exists('get', 'filter')) {
	$data = $DB->get($table, array('werkgroep', '=', Input::get('filter')));
} else {
	$data = $DB->get($table);
}
$table = $data->table();
$data = $data->results();

if (Input::exists('post', 'submit')) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$array = array(
			'transactie'	=>	array(
				'required'	=> 	true,
				'format'	=> 	'numeric',
				'unique'	=>	'activiteiten'
			),
			'datum'			=>	array(
				'required'	=>	true,
				'format'	=>	'date'
			),
			'opmerking'		=>	array(
				'required'	=>	true
			),
			'werkgroep'		=>	array(
				'required'	=>	true,
				'not'		=>	'---'
			),
			'bank'			=>	array(
				'format'	=>	'numeric'
			),
			'kas'			=>	array(
				'format'	=>	'numeric'
			)
		);

		if (Input::exists('post', 'table')) {
			unset($array['transactie']['unique']);
		}

		$validation = $validate->check($_POST, $array);

		if ($validation->passed()) {

			if (Input::exists('post', 'table')) {
				$DB->delete(Input::get('table'), array('transactie', '=', Input::get('transactie')));
			}

			$bank = Input::get('bank');
			$kas = Input::get('kas');
			if (empty($bank)) {
				$_POST['bank'] = '0.00';
			}
			if (empty($kas)) {
				$_POST['kas'] = '0.00';
			}

			if (Input::get('startkapitaalAftrekken') === 'on') {
				$checkbox = 1;
			} else {
				$checkbox = 0;
			}

			$finance = new Finance();
			try {
				$finance->create('activiteiten', array(
					'transactie'	=>	Input::get('transactie'),
					'datum'			=>	Input::get('datum'),
					'opmerking'		=>	nl2br(Input::get('opmerking')),
					'werkgroep'		=>	Input::get('werkgroep'),
					'bank'			=>	Input::get('bank'),
					'kas'			=>	Input::get('kas'),
					'startkapitaalAftrekken'	=>	$checkbox
				));
			} catch (Exception $e) {
				Session::flash('activiteiten', $e);
				Redirect::to();
			}
			Session::flash('activiteiten', 'Transactie toegevoegd');
			Redirect::to('activiteiten.php#form');

		} else {
			$flash = '';
			foreach ($validation->errors() as $error) {
				$flash .= $error. "<br>";
			}
			Session::flash('activiteiten', $flash);
			Redirect::to();
		}


	}
}

$token = Token::generate();

?>

<div id="content">
	<div>
		<form action="" method="get">
			<div class="field">
				<?php
				if (!Input::exists('get', 'print')) {
					?>
					<?php
						if (Input::exists('get', 'year')) {
							echo '<input type="hidden" name="year" value="' . Input::get('year') . '" />';
						}
					?>
					<label>Filter: </label>
					<select name="filter">
						<option value='' selected>ALLES</option>
						<?php
							foreach ($werkgroepen as $werkgroep) {
								?><option <?php if (Input::exists('get', 'filter')) { if (Input::get('filter') === $werkgroep) { echo "selected"; } } ?> value='<?php echo $werkgroep; ?>'><?php echo $werkgroep ?></option><?php
							}
						?>
					</select>
					<input type="submit" value="Ga">
					<?php
				} else {
					echo "<h2>";
					if (Input::exists('get', 'filter')) {
						echo Input::get('filter');
					} else {
						echo "ALLES";
					}
					echo "</h2>";
				}
				?>
			</div>
		</form>
	</div>

	<div class="clear"></div>

	<?php
	if (Session::exists('activiteiten')) {
		echo "
			<div>
				<h3><center>Opmerkingen</center></h3>
				<p>" . Session::flash('activiteiten') . "</p>
			</div>
			<div class='clear'></div>
		";
	}
	?>

	<div>
		<table class="data">
			<thead>
				<tr>
					<th style="padding: 0 5px 0 5px; min-width: 20px;">N&deg;</th>
					<th>DATUM</th>
					<th style="min-width: 560px;">OPMERKING</th>
					<th>WERKGROEP</th>
					<th>BANK</th>
					<th>KAS</th>
					<?php
						if (Input::exists('get', 'filter') === false && Input::exists('get', 'print') === false && $user->hasPermission('master') && !Input::exists('get', 'year')) {
							echo "<th>OPTIES</th>";
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($data as $key => $result) {
						echo "
							<tr>
								<td>$result->transactie</td>
								<td>" . date('d-m-Y', strtotime($result->datum)) . "</td>
								<td>$result->opmerking</td>
								<td>$result->werkgroep</td>
								<td><p>";

								if (($bank = $result->bank) !== '0.00') {
									echo '', $bank;
								}

						echo "
								</p></td>
								<td>";

								if (($kas = $result->kas) !== '0.00') {
									echo '',  $kas;
								}

						echo 
								"</td>";
									
							if (!Input::exists('get', 'filter') && Input::exists('get', 'print') === false && $user->hasPermission('master') && !Input::exists('get', 'year')) {	
						echo "
									
								<td>
									<form action='edit.php' method='post'>
										<input type='hidden' name='transactie' value='" . $result->transactie . "'>
										<input type='hidden' name='table' value='" . $table . "'>
										<input type='hidden' name='token' value='" . $token . "'>
										<div id='submitbuttonsoptions'>
											<input type='submit' name='edit' value='Pas Aan'>
											<input type='submit' name='delete' value='Verwijder'>
										</div>
									</form>
								</td>";
							}
						echo "			
							</tr>
						";
						if ($key%5 == 0 && $key !== 0 && $key !== count($data) - 1 && !Input::exists('get', 'filter')) {
							$bank = countMoney($data, 'bank', 0, $key);
							$kas = countMoney($data, 'kas', 0, $key);
							$totaal = $bank + $kas;
							echo "
							<tr>
								<td colspan='4'></td>
								<td colspan='2' style='text-align: right'><b>Subtotaal: " . number_format($totaal, 2, '.', '') . "</b></td>
								<td></td>
							</tr>
							";
						}
					}
					echo "
							<tr>
								<td colspan='3'></td>
								<td style='text-align: right'><b>Subtotaal:</b></td>
								<td style='text-align: right'><p><b>" 	. number_format(countMoney($data, 'bank'), 2, '.', '') 	. "</b></p></td>
								<td style='text-align: right'><b>" 		. number_format(countMoney($data, 'kas'), 2, '.', '') 	. "</b></td>
							</tr>
							<tr>
								<td colspan='4'></td>
								<td style='text-align: right'><b>Totaal:</b></td>
								<td style='text-align: right'><b>" . number_format(countMoney($data, 'totaal'), 2, '.', '') . "</b></td>
							</tr>
					";

					if (!Input::exists('get', 'filter') && Input::exists('get', 'print') === false && $user->hasPermission('master') && !Input::exists('get', 'year')) {
				?>
						<form action="" method="post" autocomplete="off" id="form">
							<tr>
								<td>
									<div>
										<input type="hidden" name="transactie" value="<?php echo count($data); ?>"><?php echo count($data); ?>
									</div>
								</td>
								<td>
									<input type="date" name="datum" value="<?php echo date('Y-m-d'); ?>">
								</td>
								<td>
									<textarea name="opmerking"></textarea>
								</td>
								<td>
									<select name="werkgroep">
										<option selected value="---">---</option>
										<?php
											foreach ($werkgroepen as $werkgroep) {
												?><option value='<?php echo $werkgroep; ?>'><?php echo $werkgroep ?></option><?php
											}
										?>
									</select><br />
									<label style="font-size: 12px;" for="startkapitaalAftrekken">Van Startkapitaal Aftrekken: </label>
									<input type="checkbox" name="startkapitaalAftrekken" id="startkapitaalAftrekken" />
								</td>
								<td>
									<input type="number" step="any" name="bank" class="center money">
								</td>
								<td>
									<input type="number" step="any" name="kas" class="center money">
								</td>
								<td>
									<input type="hidden" name="token" value="<?php echo $token ?>">
									<input type="submit" name="submit" value="Voeg toe">
								</td>
							</tr>
						</form>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'core/includes/footer.php'; ?>