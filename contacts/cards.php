<?php

require_once 'core/init.php';
hasPermission(array('admin'), 'or', 'contacts.php');

$month = date('m');

if ($month > 0 && $month < 9) {
	$year = (date('Y') - 1) . ' - ' . date('Y');
} else {
	$year = date('Y') . ' - ' . (date('Y') + 1);
}

$contacts = new Contacts();

$table = 'members';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}

$data = $contacts->get($table);

?>

<?php
if (!Input::exists('get', 'print')) {
	echo "
		<div>
			<h3><center>Opmerkingen</center></h3>
			<p><center>Stel de marges bij het afdrukken in op 10mm van elke kant. Gebruik Chrome om af te drukken aub!</center></p>
		</div>
		<div class='clear'></div>
	";
}
?>

<div class="cards">
	<div>
		<?php foreach ($data as $key => $value) { ?>
			<?php if ($key%8 == 0) { $x = 0; echo "<div>"; } ?>
				<div class="<?php if ($key%2 == 0) { echo 'left'; } else { echo 'right'; } ?>">
					<div>
						<img src="../images/logo.png">
					</div>
					<div>
						<?php echo $value->name; ?><br><br>
						<?php echo getJsonDecode($value->werkgroep); ?><br><br>
						<br><br>
						<?php echo $year; ?>
					</div>
					<div style="">
						HET PRAESIDIUM
					</div>
				</div>
			<?php $x++; if ($x == 8) { echo "</div>"; } ?>
		<?php } ?>
	</div>
</div>