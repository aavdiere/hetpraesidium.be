<?php

require_once 'core/init.php';

$table = 'kka';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}
$data = $DB->get($table);
$table = $data->table();
$data = $data->results();

if (Input::exists('post', 'submit')) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$array = array(
			'transactie'	=>	array(
				'required'	=> 	true,
				'format'	=> 	'numeric',
				'unique'	=>	'kka'
			),
			'datum'			=>	array(
				'required'	=>	true,
				'format'	=>	'date'
			),
			'opmerking'		=>	array(
				'required'	=>	true
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
				$finance->create('kka', array(
					'transactie'	=>	Input::get('transactie'),
					'datum'			=>	Input::get('datum'),
					'opmerking'		=>	nl2br(Input::get('opmerking')),
					'bank'			=>	Input::get('bank'),
					'kas'			=>	Input::get('kas'),
					'startkapitaalAftrekken'	=>	$checkbox
				));
			} catch (Exception $e) {
				Session::flash('kka', $e);
				Redirect::to();
			}
			Session::flash('kka', 'Transactie toegevoegd');
			Redirect::to('kka.php#form');

		} else {
			$flash = '';
			foreach ($validation->errors() as $error) {
				$flash .= $error. "<br>";
			}
			Session::flash('kka', $flash);
			Redirect::to();
		}


	}
}

$token = Token::generate();

?>

<div id="content">

	<?php
	if (Session::exists('kka')) {
		echo "
			<div>
				<h3><center>Opmerkingen</center></h3>
				<p>" . Session::flash('kka') . "</p>
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
					<th style='width: 0px; border: 0; padding: 0;'></th>
					<th>BANK</th>
					<th>KAS</th>
					<?php
						if (Input::exists('get', 'filter') === false && Input::exists('get', 'print') === false && ($user->hasPermission('master') || $user->hasPermission('kka')) && !Input::exists('get', 'year')) {
							echo "<th>OPTIES</th>";
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($data as $key => $result) {
						if ($key !== 0) {
							echo "
								<tr>
									<td>K$result->transactie</td>
									<td>" . date('d-m-Y', strtotime($result->datum)) . "</td>
									<td>$result->opmerking</td>
									<td style='width: 0px; border: 0; padding: 0;'></td>
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
										
								if (!Input::exists('get', 'filter') && Input::exists('get', 'print') === false && ($user->hasPermission('master') || $user->hasPermission('kka')) && !Input::exists('get', 'year')) {	
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
					}
					echo "
							<tr>
								<td colspan='2'></td>
								<td style='text-align: right'><b>Subtotaal:</b></td>
								<td style='width: 0px; border: 0; padding: 0;'></td>
								<td style='text-align: right'><p><b>" 	. number_format(countMoney($data, 'bank'), 2, '.', '') 	. "</b></p></td>
								<td style='text-align: right'><b>" 		. number_format(countMoney($data, 'kas'), 2, '.', '') 	. "</b></td>
							</tr>
							<tr>
								<td colspan='4'></td>
								<td style='text-align: right'><b>Totaal:</b></td>
								<td style='text-align: right'><b>" . number_format(countMoney($data, 'totaal'), 2, '.', '') . "</b></td>
							</tr>
					";

					if (!Input::exists('get', 'filter') && Input::exists('get', 'print') === false && ($user->hasPermission('master') || $user->hasPermission('kka')) && !Input::exists('get', 'year')) {
				?>
						<form action="" method="post" autocomplete="off" id="form">
							<tr>
								<td>
									<div>
										<input type="hidden" name="transactie" value="<?php echo count($data); ?>">K<?php echo count($data); ?>
									</div>
								</td>
								<td>
									<input type="date" name="datum" value="<?php echo date('Y-m-d'); ?>">
								</td>
								<td>
									<textarea name="opmerking"></textarea>
								</td>
								<td>
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

<?php require_once 'core/includes/footer.php' ?>