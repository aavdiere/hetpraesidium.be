<?php

require_once 'core/init.php';
$contacts = new Contacts();

$table = 'members';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}

if (Input::exists('get', 'filter')) {
	$data = $contacts->get($table, Input::get('filter'));
} else {
	$data = $contacts->get($table);
}

?>

<div class="content">
	<?php
	if (Session::exists('contacts')) {
		echo "
			<div>
				<h3><center>Opmerkingen</center></h3>
				<p>" . Session::flash('contacts') . "</p>
			</div>
			<div class='clear'></div>
		";
	}
	?>
</div>

<div class='clear'></div>

<div class="content">
	<div>
		<h1 style="text-align: center; margin: 0;">Praesidiumleden</h1>
		<div class="clear"></div>
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
								foreach (objectToArray_werkgroepen($DB->get('werkgroepen')->results()) as $werkgroep) {
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
		<div style="font-family: monospace; white-space: pre; text-align: left;">
			<table border="1">
				<thead>
					<tr>
						<th>Naam</th>
						<th>E-Mail</th>
						<th>GSM</th>
						<th>Werkgroep</th>
					</tr>
				</thead>
				<tbody>
					<?php

					foreach ($data as $key => $value) {
						echo "<tr>
								<td>".(htmlspecialchars_decode($value->name))."</td>
								<td>$value->email</td>
								<td>$value->gsm</td>
								<td>" . getJsonDecode($value->werkgroep) . "</td>
							</tr>";
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
</div>