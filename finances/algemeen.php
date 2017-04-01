<?php

require_once 'core/init.php';

$table = 'activiteiten';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}
$data = $DB->get($table)->results();
$temp = $DB->get($table, array('startkapitaalAftrekken', '=', '1'))->results();
$startkapitaal = countMoney($data, 'bank', 0, 0) + countMoney($data, 'kas', 0, 0) + countMoney($temp, 'totaal');
$bank_activiteiten = countMoney($data, 'bank');
$kas_activiteiten = countMoney($data, 'kas');
$totaal_activiteiten = countMoney($data, 'totaal');

$table = 'galabal';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}
$data = $DB->get($table)->results();
$temp = $DB->get($table, array('startkapitaalAftrekken', '=', '1'))->results();
$startkapitaal += countMoney($temp, 'totaal');
$bank_galabal = countMoney($data, 'bank');
$kas_galabal = countMoney($data, 'kas');
$totaal_galabal = countMoney($data, 'totaal');

$table = 'kka';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}
$data = $DB->get($table)->results();
$temp = $DB->get($table, array('startkapitaalAftrekken', '=', '1'))->results();
$startkapitaal += countMoney($temp, 'totaal');
$bank_kka = countMoney($data, 'bank');
$kas_kka = countMoney($data, 'kas');
$totaal_kka = countMoney($data, 'totaal');

$table = 'tickets';
if (Input::exists('get', 'year')) {
	$table .= Input::get('year');
}
$data = $DB->get($table)->results();
$temp = $DB->get($table, array('startkapitaalAftrekken', '=', '1'))->results();
$startkapitaal += countMoney($temp, 'totaal');
$bank_tickets = countMoney($data, 'bank');
$kas_tickets = countMoney($data, 'kas');
$totaal_tickets = countMoney($data, 'totaal');

$bank = $bank_galabal + $bank_activiteiten + $bank_tickets + $bank_kka;
$kas = $kas_galabal + $kas_activiteiten + $kas_tickets + $kas_kka;

$algemeentotaal = $totaal_kka + $totaal_galabal + $totaal_activiteiten + $totaal_tickets;
$balans = $algemeentotaal - $startkapitaal;

?>

<div id="content">
	<div>
		<table class="data">
			<thead>
				<tr>
					<th style="text-align: right;"><p style="margin: 0; margin-right: 5px;">Info</p></th>
					<th style="text-align: left;">Bedrag</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">Activiteiten (zonder galabal of kka)</p></td>
					<td style="text-align: left;">&euro; <?php echo $totaal_activiteiten; ?></td>
				</tr>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">Galabal</p></td>
					<td style="text-align: left;">&euro; <?php echo $totaal_galabal; ?></td>
				</tr>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">KKA</p></td>
					<td style="text-align: left;">&euro; <?php echo $totaal_kka; ?></td>
				</tr>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">Tickets</p></td>
					<td style="text-align: left;">&euro; <?php echo $totaal_tickets; ?></td>
				</tr>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">Bank</p></td>
					<td style="text-align: left;">&euro; <?php echo $bank; ?></td>
				</tr>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">Kas</p></td>
					<td style="text-align: left;">&euro; <?php echo $kas; ?></td>
				</tr>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">
						Algemeen Totaal
					</p></td>
					<td style="text-align: left;">&euro; <?php echo $algemeentotaal; ?></td>
				</tr>
				<tr>
					<td style="text-align: right;"><p style="margin-right: 5px;">
						Balans
					</p></td>
					<td style="text-align: left; <?php if ($balans < 0) { echo "color: red;"; } else { echo "color: green;"; } ?>">&euro; <?php echo $balans; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'core/includes/footer.php'; ?>