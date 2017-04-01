<?php

session_start();

require_once '../globals.php';

spl_autoload_register(function($class) {
	require_once '../core/classes/' . $class . '.php';
});

$dir = scandir('../core/functions'); array_shift($dir); array_shift($dir);
for ($i=0; $i < count($dir); $i++) { 
	require_once '../core/functions/'.$dir[$i];
}

$DB = DB::getInstance();

if (Input::exists('get', 'autocomplete')) {
	if (Token::checkAutocomplete(Input::get('token'))) {
		$term = htmlentities(trim(strip_tags(Input::get('term'))));
		$results = $DB->get('members', array('name', 'LIKE', '%'.$term.'%'), 'ORDER BY name ASC')->results();
		foreach ($results as $key => $result) {
			unset($results[$key]);
			$results[$key]['id'] = $result->id;
			$results[$key]['value'] = html_entity_decode($result->name);
			$results[$key]['label'] = html_entity_decode($result->name);
			$results[$key]['werkgroepen'] = html_entity_decode($result->werkgroep);
			$results[$key]['id'] = html_entity_decode($result->id);
		}
		echo json_encode($results);
		exit();
	}
}

if (Input::exists('get', 'phpinfo')) {
	phpinfo();
	exit;
}

if (Input::exists('post', 'deleteSite')) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'read' => array(
				'required' => true
			),
			'year' => array(
				'not' => '---',
				'required' => true
			)
		));

		if ($validation->passed() && $_POST['read'] === 'on') {
			$sql = "TRUNCATE users; TRUNCATE users_session; TRUNCATE praesidiumlokaal; ALTER TABLE members RENAME TO `members".$year."`; CREATE TABLE `members` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(255) NOT NULL,  `first_name` varchar(255) NOT NULL,  `last_name` varchar(255) NOT NULL,  `email` varchar(255) NOT NULL,  `gsm` varchar(255) NOT NULL,  `werkgroep` varchar(255) NOT NULL,  PRIMARY KEY (`id`));";
			
			$DB->query($sql);
			Session::flash('deleteSite', 'Gegevens succesvol verwijderd.');
			Redirect::to('', false, 'reset');
		} else {
			Session::flash('deleteSite', 'Alle velden zijn verplicht. Gelieve te herladen');
			Redirect::to('', false, 'reset');
		}
	}
}

if (Input::exists('post', 'initialize')) {
	if (Token::check(Input::get('token'))) {
		if (Input::exists('files', 'csv')) {
			if ($_FILES['csv']['type'] === 'application/vnd.ms-excel' && end(explode(".", $_FILES["csv"]['name'])) === 'csv') {
				$csv = new parseCSV();
				$csv->encoding('UTF-16', 'UTF-8');
				$csv->delimiter = ",";
				$csv->parse(Input::get('csv'));
				$data = $csv->data(true);

				foreach ($data as $key => $value) {
					$DB->insert('members', array(
						'id'			=>	$key + 1,
						'name'			=>	($value->{'Name'}),
						'first_name'	=>	($value->{'Given Name'}),
						'last_name'		=>	($value->{'Family Name'}),
						'email'			=>	$value->{'E-mail 1 - Value'},
						'gsm'			=>	$value->{'Phone 1 - Value'},
						'werkgroep'		=>	getJsonEncode($value->{'Group Membership'}, 'csv')
					));
				}
				Session::flash('initialize', 'Gegevens succesvol toegevoegd.');
				Redirect::to('', false, 'initialize');
			} else {
				Session::flash('initialize', 'Het bestand voldoet niet aan de eisen.');
				Redirect::to('', false, 'initialize');
			}
		} else {
			Session::flash('initialize', 'Alle velden zijn verplicht. Gelieve te herladen');
			Redirect::to('', false, 'initialize');
		}
	}
}

if (Input::exists('post', 'edit')) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		if (Input::exists('post', 'Add')) {
			$validation = $validate->check($_POST, array(
				'add' => array(
					'required' => true,
					'not' => '---'
				)
			));
			if ($validation->passed()) {
				$id = Input::get('id');
				$add = Input::get('add');
				$member = Input::get('member');
				$werkgroepen = $DB->get('members', array('id', '=', $id))->first()->werkgroep;
				$array = getJsonDecode($werkgroepen, true);
				$array[] = $add;
				if (in_array('KERN', $array)) {
					$groep = 2;
					if (in_array('KKA', $array)) {
						$groep = 3;
					}
					if (in_array('TECHNIEK', $array)) {
						$groep = 4;
					}
					if (in_array('KKA', $array) && in_array('TECHNIEK', $array)) {
						$groep = 5;
					}
					if (in_array('PRAESES', $array)) {
						$groep = 6;
					}
					if (in_array('SECRETARIS', $array)) {
						$groep = 7;
					}
				} else {
					$groep = 1;
				}
				$DB->update('members', $id, array('werkgroep' => getJsonEncode($array)));
				$id = $DB->get('users', array('name', '=', $member))->first()->id;
				$DB->update('users', $id, array(
					'werkgroep' => getJsonEncode($array),
					'group' => $groep
				));
				Session::flash('edit1', 'Permissie succesvol toegewezen.');
				Redirect::to('', false, 'permission');
			} else {
				Session::flash('edit', 'Alle velden zijn verplicht. Gelieve te herladen.');
				Redirect::to('', false, 'permission');
			}
		}
		if (Input::exists('post', 'Remove')) {
			$validation = $validate->check($_POST, array(
				'remove' => array(
					'required' => true,
					'not' => '---'
				)
			));
			if ($validation->passed()) {
				$id = Input::get('id');
				$remove = Input::get('remove');
				$member = Input::get('member');
				$werkgroepen = $DB->get('members', array('id', '=', $id))->first()->werkgroep;
				$array = getJsonDecode($werkgroepen, true);
				foreach ($array as $key => $value) {
					if ($value === $remove) {
						unset($array[$key]);
					}
				}
				if (in_array('KERN', $array)) {
					$groep = 2;
					if (in_array('KKA', $array)) {
						$groep = 3;
					}
					if (in_array('TECHNIEK', $array)) {
						$groep = 4;
					}
					if (in_array('PRAESES', $array)) {
						$groep = 5;
					}
					if (in_array('SECRETARIS', $array)) {
						$groep = 6;
					}
				} else {
					$groep = 1;
				}
				// var_dump($groep);
				$DB->update('members', $id, array('werkgroep' => getJsonEncode($array)));
				$id = $DB->get('users', array('name', '=', $member))->first()->id;
				$DB->update('users', $id, array(
					'werkgroep' => getJsonEncode($array),
					'group' => $groep
				));
				Session::flash('edit1', 'Permissie succesvol verwijderd.');
				Redirect::to('', false, 'permission');
			} else {
				Session::flash('edit', 'Alle velden zijn verplicht. Gelieve te herladen.');
				Redirect::to('', false, 'permission');
			}
		}
	}
}

if (Input::exists('post', 'editGroup')) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			Input::get('submit') => array(
				'required' => true,
				'not'	=> '---'
			)
		));
		if ($validate->passed()) {
			if (Input::get('submit') === 'remove') {
				$DB->delete('werkgroepen', array(
					'id', '=', Input::get('remove')
				));
				$results = $DB->get('members')->results();
				foreach ($results as $key => $result) {
					$data = getJsonDecode($result->werkgroep, true);
					$data = getJsonEncode($data);
					$DB->update('members', $result->id, array(
						'werkgroep' => $data
					));
					$id = $result->name;
					$fields = array(
						'werkgroep' => $data
					);
					$set = '';
					foreach ($fields as $name => $value) {
						$set .= "`{$name}` = ?";
						if ($x < count($fields)) {
							$set .= ", ";
						}
						$x++;
					}
					$sql = "UPDATE `users` SET {$set} WHERE `name` = '{$id}'";
					// var_dump($sql);
					$DB->query($sql, $fields);
				}
			} else if (Input::get('submit') === 'add') {
				$DB->insert('werkgroepen', array(
					'werkgroep' => escape(strtoupper(Input::get('add')))
				));
				$results = $DB->get('members')->results();
				foreach ($results as $key => $result) {
					$data = getJsonDecode($result->werkgroep, true);
					$data = getJsonEncode($data);
					$DB->update('members', $result->id, array(
						'werkgroep' => $data
					));
					$id = $result->name;
					$fields = array(
						'werkgroep' => $data
					);
					$set = '';
					foreach ($fields as $name => $value) {
						$set .= "`{$name}` = ?";
						if ($x < count($fields)) {
							$set .= ", ";
						}
						$x++;
					}
					$sql = "UPDATE `users` SET {$set} WHERE `name` = '{$id}'";
					// var_dump($sql);
					$DB->query($sql, $fields);
				}
			}
			Session::flash('edit2', 'Database succesvol ge&uuml;pdate.');
			Redirect::to('', false, 'groups');
		} else {
			Session::flash('edit2', 'Alle velden zijn verplicht. Gelieve te herladen.');
			Redirect::to('', false, 'groups');
		}
	}
}

if (Input::exists('post', 'update')) {
	if (Token::check(Input::get('token'))) {
		if (isset($_FILES['csv']) && !empty($_FILES['csv'])) {
			if ($_FILES['csv']['type'] === 'application/vnd.ms-excel') {
				$csv = new parseCSV();
				$csv->encoding('UTF-16', 'UTF-8');
				$csv->delimiter = ",";
				$csv->parse(Input::get('csv'));
				$data = $csv->data(true);

				// echo "<pre>", print_r($data), "</pre>"; exit();

				foreach ($data as $key => $value) {
					$DB->update('members', $key + 1, array(
						'name'			=>	$value->{'Name'},
						'first_name'	=>	$value->{'Given Name'},
						'last_name'		=>	$value->{'Family Name'},
						'email'			=>	$value->{'E-mail 1 - Value'},
						'gsm'			=>	$value->{'Phone 1 - Value'}
					));
				}

				Session::flash('update', 'Gegevens succesvol gewijzigd.');
				Redirect::to('', false, 'update');

			} else {
				Session::flash('update', 'Het bestand voldoet niet aan de eisen.');
				Redirect::to('', false, 'update');
			}
		} else {
			Session::flash('update', 'Alle velden zijn verplicht. Gelieve te herladen');
			Redirect::to('', false, 'update');
		}
	}
}

$GLOBALS['config']['session']['token'] = Token::generate();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Config | Het Praesidium</title>
	<meta http-equiv="imagetoolbar" content="no" />
	<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script type="text/javascript">
		function nocontext(e) {
	        var clickedTag = (e==null) ? event.srcElement.tagName : e.target.tagName;
	        if (clickedTag == "IMG") {
	            alert(alertMsg);
	            return false;
	        }
	    }
	    var alertMsg = "Image context menu is disabled";
	    document.oncontextmenu = nocontext;
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('img').each(function() {
				$(this).wrap('<a href="' + $(this).attr('src') + '"></a>');
			});
			$('h2, h3').each(function() {
				$(this).wrap('<a href="#' + $(this).parent().attr('id') + '"></a>');
			});
			$('#autocomplete').autocomplete({
				source: "?autocomplete=y&token=<?php echo Config::get('session/token'); ?>",
				minLength: 2,
				select: function(event, ui) {
					obj = JSON && JSON.parse(ui.item.werkgroepen) || $.parseJSON(ui.item.werkgroepen);
					var remove = new Array();
					var add = new Array();
					for (key in obj) {
						if (obj[key] == 1) {
							remove[remove.length] = key;
						};
						if (obj[key] == 0) {
							add[add.length] = key;
						};
					};
					$('#selectAdd').empty();
					$('#selectAdd').append('<option value="---">---</option>');
					$('#selectRemove').empty();
					$('#selectRemove').append('<option value="---">---</option>');
					add.forEach(function(entry) {
						$('#selectAdd').append('<option value="' + entry + '">' + entry + '</option>');
					});
					remove.forEach(function(entry) {
						$('#selectRemove').append('<option value="' + entry + '">' + entry + '</option>');
					});
					$('#id').val(ui.item.id);
				}
			});
			$('#autocomplete').on('change', function() {
				$('#selectAdd').html('<option value="---">---</option>');
				$('#selectRemove').html('<option value="---">---</option>');
			});
		});
	</script>

	<style type="text/css">
		html {
			background: #ddd;
		}
		body {
			margin: 1em 10%;
			padding: 1em 3em;
			font: 80%/1.4 tahoma, arial, helvetica, lucida sans, sans-serif;
			border: 1px solid #999;
			background: #eee;
			position: relative;
		}
		a:hover {
			color: #04569A;
			text-decoration: underline;
		}
		a {
			color: #024378;
			font-weight: bold;
			text-decoration: none;
		}
		img {
			max-width: 100%;
		}
		#head {
			margin-bottom: 1.8em;
			margin-top: 1.8em;
			padding-bottom: 0em;
			border-bottom: 1px solid #999;
			height: 125px;
		}
		.clear {
			width: 1px;
			height: 20px;
		}
		.utility {
			position: absolute;
			right: 4em;
			top: 134px;
			font-size: 0.85em;
		}
		ul.utility li {
			display: inline;
		}
		#menu ul, ul.utility, ul#foot li {
			list-style: none;
		}
		p {
			text-align: justify;
		}
		#menu ul li div {
			display: inline-block;
		}
		#menu ul li ul {
			list-style: square;
			display: none;
		}
		div#menu ul li div:hover > ul {
			display: block;
		}
		#foot {
			text-align: center;
			margin-top: 1.8em;
			border-top: 1px solid #999;
			padding-top: 1em;
			font-size: 0.85em;
		}
		ul#foot li {
			list-style: none;
			display: inline;
			margin: 0;
			padding: 0 0.2em;
		}
		.en {
			display: none;
		}
		#warning {
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			color: #04569A;
		}
		#autocomplete {
			width: 200px;
		}
		.ui-autocomplete {
		    max-height: 150px;
		    overflow-y: auto;
		    overflow-x: hidden;
		    padding-right: 5px;
		}
	</style>
</head>

<body>

<div id="head">
	<h1>Welcome</h1>
	<p>
		Configuratiebestand voor <a href="http://www.hetpraesidium.be/">http://www.hetpraesidium.be/</a>
		<br />
		<a href="mailto:achim.ac.vandierendonck@gmail.com">2014 <?php if (date('Y') > 2014) { echo " - " . date('Y'); } ?> &copy; Achim Vandierendonck</a>
	</p>
</div>

<ul class="utility">
	<li>Version 1.2</li>
	<li>Nederlandse Versie</li>
</ul>

<div id="menu">
	<h2>Menu</h2>
	<ul>
		<li>
			<a href="#readme">Readme</a>
		</li>
		<li>
			<div>
				<a href="#info">Belangrijke Informatie</a>
				<ul>
					<li>
						<a href="#general">Algemene Informatie</a>
					</li>
					<li>
						<a href="#photos">Foto's toevoegen aan de site</a>
					</li>
					<li>
						<a href="#loginData">Log In Gegevens</a>
					</li>
					<li>
						<a href="#google">Google ADMIN</a>
					</li>
				</ul>
			</div>
		</li>
		<li>
			<a href="#reset">Reset Site</a>
		</li>
		<li>
			<a href="#initialize">Initialiseer Nieuwe Site</a>
		</li>
		<li>
			<div>
				<a href="#edit">Pas Nieuwe Site Aan</a>
				<ul>
					<li>
						<a href="#update">Update Gebruikers</a>
					</li>
					<li>
						<a href="#permission">Machtigingen</a>
					</li>
					<li>
						<a href="#groups">Werkgroepen</a>
					</li>
				</ul>
			</div>
		</li>
	</ul>
</div>

<div id="readme">
	<h2>Readme</h2>
	<div>
		<p>
			Eerst en vooral gefeliciteerd met je nieuwe taak binnen het Praesidium, ik hoop dat je er het beste van maakt!
		</p>
		<p>
			Het nam veel tijd in beslag om de site te maken tot wat hij nu is, er is echter nog veel plaats voor verbetering. Maar... Er is altijd een 'maar'. Ik heb mijn hart en ziel in deze site gestoken, wel niet helemaal, maar je begrijpt wat ik bedoel. Ik vertrouw jou voor het komende jaar en misschien komende twee jaar toe met de site. Zoals je zal ondervinden, of al hebt ondervonden is deze site geschreven in de programeertaal PHP <i>(Hypertext Preprocessor)</i> en is deze, tot op dit moment, geschreven zonder enige uitleg van de broncode.
		</p>
		<p>
			Omwille daarvan zal het waarschijnlijk een heuse opdracht zal worden, moest er iemand iets aan de site veranderen. Het is daarom dat ik je vriendelijk vraag geen aanpassingen te doen aan de site tenzij je echt weet waar je mee bezig bent. Er bestaat een kans dat je bekend bent met PHP op een gematigde of gevorderde manier en dat je een idee hebt over een toekomstige site met meer functionaliteiten dan de huidige, dan <b>maak alsjeblieft deze aanpassingen</b> (met de nodige voorzorgsmaatregelen natuurlijk). Er bestaat echter een veel grotere kans dat dit de eerste keer is dat je de letters PHP hoort, in dat geval <b>breng de site alsjeblieft niet naar de knoppen</b>. Je kan mij altijd contacteren met vragen of voorstellingen voor aanpassingen aan de site, dan bestaat er een kans (als ik de tijd ervoor vind) dat ik die maak.
		</p>
		<p>
			Ik wens je veel succes en ik hoop dat je een wonderbaarlijk jaar hebt!
		</p>
		<p style="text-indent: 25px;">
			Achim Vandierendonck
		</p>
	</div>
</div>

<div style="text-align: right;"><a href="#top">Naar het begin</a></div>

<div id="info">
	<h2>Belangrijke Informatie</h2>
	<div id="general">
		<h3>Algemene Informatie</h3>
		<p>
			Voor algemene info over de site, ga naar <a href="?phpinfo=y">PHPInfo</a>.
		</p>
		<p>
			Het belangrijkste dat nu moet gedaan worden, is het maken van een ledenlijst. Dit kan het gemakkelijkste gedaan worden in Gmail. De secretaris heeft een overzicht over hoe de ledenlijst gemaakt moet worden, hij/zij vindt deze terug op het mail account van de secretaris (secretaris@hetpraesidium.be), maar om zeker te zijn, hier zijn de 'regeltjes' die moeten toegepast worden:
			<ul>
				<li>
					<p>
						Eerst en vooral moeten de gegevens van de KERN van het vorige jaar in een groep 'KERN jaar-jaar' geplaatst worden, vb. KERN 2012-2013.
					</p>
				</li>
				<li>
					<p>
						Daarna moeten alle contacten (behalve de KERN van het jaar ervoor) verwijderd worden. Dit kan gedaan worden door groep per groep alle contacten te selecteren (behalve de KERN groep die pas is aangemaakt!), op het groep-icoontje te klikken in de toolbar <img src="../images/config/group.png">, 'Mijn contactpersonen' te selecteren en alle andere groepen af te vinken. Bevestig.<br />
						<br /><img src="../images/config/group1.png" style="float: left; margin-right: 15px; display: block;">
						<p style="min-height: 232px;">Ga nu naar de pasgemaakte groep 'KERN jaar-jaar' (in dit geval KERN 2012-2013), selecteer alle contacten en vink alle groepen af behalve de huidige groep en bevestig.<br />
						Nu kan je alle contacten uit de groep 'Mijn Contactpersonen' verwijderen zonder de gegevens van de kern van het jaar ervoor verloren te laten gaan.</p>
					</p>
				</li>
				<li>
					<p>
						Nu kan je beginnen met de nieuwe contacten toe te voegen. In het geval dat er nieuwe werkgroepen aangemaakt moeten worden (vb. een groep voor het jaarboek) dan moet dit nu gebeuren.<br />
						Voeg de gegevens van de contacten toe in deze velden (Zorg ervoor dat het 'HELE PRAESIDIUM' bij ieder lid geselecteerd is EN de werkgroep waar dat lid bij hoort.)<br />
						<div style="text-align: center;"><img src="../images/config/addContact.png" style="display: inline-block;"></div>
					</p>
				</li>
				<li>
					<p>
						Als je alle contacten toegevoegd hebt, mag je met vreugde zeggen dat je het geflikt hebt!
					</p>
				</li>
			</ul>
		</p>
		<p>
			Nu kunnen de contacten van de groep 'HELE PRAESIDIUM' ge&euml;xporteerd worden naar een google csv file.
			<br />
			<div style="text-align: center;"><img src="../images/config/export.png" style="display: inline-block;"></div>
		</p>
	</div>
	<div id="photos">
		<h3>Foto's toevoegen aan de site</h3>
		<div>
			Download <a href="wondershare.zip">hier</a> het programma om foto's te uploaden. <br />
			Om foto's aan de site toe te voegen, kopieer de swf map (gemaakt met bovenstaande programma) in de map 'images/albums/swf/' en open het bestand 'album.php'. Kopieer de template en vul alle waarden binnen vierkante haken in en sla het bestand op.
		</div>
	</div>
	<div id="loginData">
		<h3>Log In Gegevens</h3>
		<div style="text-align: center;">
			<table style="width: 100%; max-width: 600px; display: inline-table;">
				<thead>
					<tr>
						<th>Beschrijving</th>
						<th>Host</th>
						<th>Gebruikersnaam</th>
						<th>Wachtwoord</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>FTP</td>
						<td><a href="http://hetpraesidium.be:2082/">http://hetpraesidium.be:2082/</a></td>
						<td>praes</td>
						<td>idium13!</td>
					</tr>
					<tr>
						<td>Database</td>
						<td><a>localhost</a> (database name: praes_main)</td>
						<td>praes_master</td>
						<td>(gv!FyNXk29qu;kF^$</td>
					</tr>
					<tr>
						<td>Config</td>
						<td><a href="http://www.hetpraesidium.be/config/">http://www.hetpraesidium.be/config/</a></td>
						<td>superuser</td>
						<td>Q{czCY+QVYFK[o9mS7HD</td>
					</tr>
					<tr>
						<td>PayPal</td>
						<td><a href="http://www.paypal.com/be/">http://www.paypal.com/be/</a></td>
						<td>karel.vanparys@sint-lodewijkscollege.be</td>
						<td>Praesidium_2014</td>
					</tr>
					<tr>
						<td>Ticketing</td>
						<td><a href="http://tickets.sint-lodewijkscollege.be/ADMIN/">http://tickets.sint-lodewijkscollege.be/ADMIN/</a></td>
						<td>kka</td>
						<td>kka14!</td>
					</tr>
					<tr>
						<td>Youtube</td>
						<td><a href="http://www.youtube.com/">http://www.youtube.com/</a></td>
						<td>hetpraesidium@gmail.com</td>
						<td>praesidiumkot</td>
					</tr>
					<tr>
						<td>Google ADMIN</td>
						<td><a href="http://admin.google.com">http://admin.google.com</a></td>
						<td>techniek@hetpraesidium.be</td>
						<td>Praesidium14.</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div style="text-align: right;"><a href="#top">Naar het begin</a></div>

<div id="google">
	<h2>Google ADMIN</h2>
	<div>
		Met google ADMIN kunnen nieuwe e-mailadressen aangemaakt worden met '@hetpraesidium.be' en kunnen alle wachtwoorden gereset worden op het einde van het jaar.
	</div>
</div>

<div id="reset">
	<h2>Reset Site</h2>
	<div>
		<div id="warning">
			!!!!!!!!!! !Opgepast: Dit zal alle gebruikers en gegevens verwijderen van de site! !!!!!!!!!!
		</div>
		<div class="clear"></div>
		<div>
			<?php
				if (Session::exists('deleteSite')) {
					echo Session::flash('deleteSite');
				} else if ($DB->emptyTable(array('members', 'users', 'users_session', 'praesidiumlokaal'))) {
					echo 'Gegevens zijn al verwijderd.';
				} else {
					?>
					<form method="post">
						<label for="year">Code Vorig Jaar</label>
						<select name="year" id="year">
							<option value="---">---</option>
							<?php
								for ($i=2013; $i < 2030; $i++) { 
									?><option value='<?php echo $i; ?>-<?php echo $i + 1; ?>'><?php echo $i; ?>-<?php echo $i + 1; ?></option><?php
								}
							?>
						</select>
						<input type="checkbox" name="read" id="read" />
						<label for="read" style="cursor: pointer;">
							Ik heb de waarschuwing gelezen en ik weet wat ik doe.
						</label><br />
						<input type="hidden" name="token" value="<?php echo Config::get('session/token'); ?>" />
						<input type="submit" name="deleteSite" />
					</form>
					<?php
				}
			?>
		</div>
	</div>
</div>

<div style="text-align: right;"><a href="#top">Naar het begin</a></div>

<div id="initialize">
	<h2>Initialiseer Nieuwe Site</h2>
	<div>
		<?php
			if (Session::exists('initialize')) {
				echo Session::flash('initialize');
				Redirect::to('', false, 'initialize');
			} else if (!$DB->emptyTable(array('members', 'users', 'users_session', 'praesidiumlokaal'))) {
				echo 'Gegevens zijn al toegevoegd. Reset de site eerst vooralleer een nieuwen te initialiseren.';
			} else {
				?>
					<form action="" method="post" enctype="multipart/form-data">
						<label for="file">Upload het csv-bestand hier:</label>
						<input type="file" name="csv" id="file" />
						<input type="hidden" name="token" value="<?php echo Config::get('session/token'); ?>" />
						<input type="submit" name="initialize" />
					</form>
				<?php
			}
		?>
	</div>
</div>

<div style="text-align: right;"><a href="#top">Naar het begin</a></div>

<div id="edit">
	<h2>Pas Nieuwe Site Aan</h2>
	<div id="update">
		<h3>Update Gebruikers</h3>
		<p>
			Hier kan je de lijst van gebruikers opnieuw invoeren. Let op: deze optie veranderd enkel de namen van de leden, niet hun werkgroep of machtiging. Om de werkgroep of machtingen van een gebruiker te veranderen zie: <a href="#permissions">Machtigingen</a> of <a href="#groups">Werkgroepen</a>. Dit is ook niet bedoeld om 1 gebruiker toe te voegen. <b>ENKEL om de gebruikers aan te passen.</b> Indien er een gebruiker toe gevoegd moet worden, zullen alle gebruikers eerst verwijderd moeten worden (zie: <a href="#reset">reset</a>) en opnieuw toegevoegd moeten worden (zie: <a href="#initialize">Initialiseer</a>).
		</p>
		<p>
			<?php
				if (Session::exists('update')) {
					echo '<b>', Session::flash('update'), '</b>';
				}
			?>
		</p>
		<div>
			<?php
				if ($DB->emptyTable(array('members'))) {
					echo 'Er moeten eerst leden toegevoegd worden.';
				} else {
					?>
						<form action="" method="post" enctype="multipart/form-data">
							<label for="file">Upload het csv-bestand hier:</label>
							<input type="file" name="csv" id="file" />
							<input type="hidden" name="token" value="<?php echo Config::get('session/token'); ?>" />
							<input type="submit" name="update" />
						</form>
					<?php
				}
			?>
		</div>
	</div>
	<div id="permission">
		<h3>Machtigingen</h3>
		<p>
			Nu moeten de permissities toegestemd worden aan de leden. Op dit moment moeten er slechts 3 gegeven worden, een voor de secretaris en een voor de praeses(sen). De triumviri tellen ook als praesessen.<br />
			De meters/peters van elke werkgroepen moeten de permissie van 'KERN' krijgen.
		</p>
		<p>
			<?php
				if (Session::exists('edit1')) {
					echo '<b>', Session::flash('edit1'), '</b>';
				} else if (Session::exists('edit')) {
					echo '<b>', Session::flash('edit'), '</b>';
				}
			?>
		</p>
		<div>
			<?php
				if ($DB->emptyTable(array('members'))) {
					echo 'Er moeten eerst leden toegevoegd worden.';
				} else {
					?>
					<form method="post">
						<input type="text" name="member" id="autocomplete" autocomplete="off" />
						<select name="add" id="selectAdd">
							<option value="---">---</option>
						</select>
						<button type="submit" name="Add" value="set" />Voeg Toe</button>
						<select name="remove" id="selectRemove">
							<option value="---">---</option>
						</select>
						<button type="submit" name="Remove" value="set" />Verwijder</button>
						<input type="hidden" name="token" value="<?php echo Config::get('session/token'); ?>" />
						<input type="hidden" name="edit" value="set" />
						<input type="hidden" name="id" id="id" value="" />
					</form>
					<?php
				}
			?>
		</div>
	</div>
	<div id="groups">
		<h3>Werkgroepen</h3>
		<p>
			Hier kan je de groepen aanpassen naar de groepen die in het Praesidium zijn, vb. als er een nieuwe groep voor het jaarboek is opgericht, en deze is al gemaakt in Gmail (in het .csv bestand), dan kan je deze hier toevoegen. Het is mogelijk dat de secretaris nieuwe groepen wenst, dan kan hij/zij dat hier doen, omdat de site gelinkt is met de financi&euml;nsite.
		</p>
		<p>
			<?php
				if (Session::exists('edit2')) {
					echo '<b>', Session::flash('edit2'), '</b>';
				}
			?>
		</p>
		<div>
			<form method="post">
				<label for="add">Voeg toe: </label>
				<input type="text" name="add" />
				<button type="submit" name="submit" value="add" />Voeg Toe</button>
				<select name="remove">
					<option value="---">---</option>
					<?php
						foreach ($DB->get('werkgroepen', array(), 'ORDER BY werkgroep ASC')->results() as $key => $result) {
							echo "<option value='" . $result->id . "'>" . $result->werkgroep . "</option>";
						}
					?>
				</select>
				<button type="submit" name="submit" value="remove" />Verwijder</button>
				<input type="hidden" name="token" value="<?php echo Config::get('session/token'); ?>" />
				<input type="hidden" name="editGroup" value="set" />
			</form>
		</div>
	</div>
</div>

</div>

<div style="text-align: right;"><a href="#top">Naar het begin</a></div>

<ul id="foot">
	<li><a href="../index.php">Het Praesidium</a></li> -
	<li><a href="mailto:achim.ac.vandierendonck@gmail.com">2014 &copy; Achim Vandierendonck</a></li>
</ul>

</body>
</html>