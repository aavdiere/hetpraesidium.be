<?php

require_once 'core/init.php';

if (Input::exists('post', 'delete')) {
	if (Token::check(Input::get('token'))) {
		$DB->delete(Input::get('table'), array('transactie', '=', Input::get('transactie')));

		$results = $DB->get(Input::get('table'))->results();
		for ($i=0; $i < count($results); $i++) { 
			if ($i !== intval($results[$i]->transactie)) {
				$finance = new Finance();
				$finance->update(Input::get('table'), array(
					'transactie'	=>	$i
				), $results[$i]->transactie);
			}
		}

		Session::flash(Input::get('table'), 'Succesvol verwijderd');
		Redirect::to(Input::get('table') . ".php");
	}
}

if (Input::exists('post', 'edit')) {
	if (Token::check(Input::get('token')) || 1 == 1) {
		$input = $DB->get(Input::get('table'), array('transactie', '=', Input::get('transactie')))->first();
?>

		<div id="content">
			<div>
				<table class="activiteiten">
					<thead>
						<tr>
							<th>TRANSACTIE</th>
							<th>DATUM</th>
							<th>OPMERKING</th>
							<th>
								<?php
								if (Input::get('table') === 'activiteiten') {
									echo "WERKGROEP";
								}
								?>
							</th>
							<th>BANK</th>
							<th>KAS</th>
							<th>OPTIES</th>
						</tr>
					</thead>
					<tbody>
						<form action="<?php echo Input::get('table'); ?>.php" method="post" autocomplete="off">
							<tr>
								<td>
									<div>
										<input type="hidden" name="transactie" value="<?php echo $input->transactie; ?>"><?php echo $input->transactie; ?>
									</div>
								</td>
								<td>
									<input type="date" name="datum" value="<?php echo $input->datum; ?>">
								</td>
								<td>
									<textarea name="opmerking" id="opmerking"><?php echo str_replace('<br />', '', $input->opmerking); ?></textarea>
								</td>
								<td>
									<?php if (Input::get('table') === 'activiteiten') { ?>
										<select name="werkgroep">
											<?php
												foreach ($werkgroepen as $werkgroep) {
													?><option <?php if ($werkgroep === $input->werkgroep) { echo 'selected'; } ?> value="<?php echo $werkgroep ?>"><?php echo $werkgroep ?></option><?php
												}
											?>
										</select>
									<?php } ?>
									<label style="font-size: 12px;" for="startkapitaalAftrekken">Van Startkapitaal Aftrekken: </label>
									<input type="checkbox" name="startkapitaalAftrekken" id="startkapitaalAftrekken" <?php if ($input->startkapitaalAftrekken == 1) { echo "checked"; } ?> />
								</td>
								<td>
									<input type="number" step="any" name="bank" class="center money" value="<?php echo $input->bank; ?>">
								</td>
								<td>
									<input type="number" step="any" name="kas" class="center money" value="<?php echo $input->kas; ?>">
								</td>
								<td>
									<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
									<input type="hidden" name="table" value="<?php echo Input::get('table'); ?>">
									<input type="submit" name="submit" value="Edit">
								</td>
							</tr>
						</form>
					</tbody>
				</table>
			</div>
		</div>

<?php
	} else {
		Session::flash(Input::get('table'), 'There was a problem, please try again...');
		Redirect::to(Input::get('table') . '.php');
	}
}

require_once 'core/includes/footer.php';

?>