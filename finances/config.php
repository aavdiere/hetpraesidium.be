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

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
		Redirect::to();
	} else {
		$user = new User();
	}
} else {
	$user = new User();
}

// hasPermission(array('admin'), 'or');

$DB = DB::getInstance();

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
		$year = Input::get('year');
		if ($validation->passed() && $_POST['read'] === 'on') {
			$sql = "ALTER TABLE activiteiten RENAME TO `activiteiten".$year."`; ALTER TABLE galabal RENAME TO `galabal".$year."`; ALTER TABLE kka RENAME TO `kka".$year."`; ALTER TABLE tickets RENAME TO `tickets".$year."`; CREATE TABLE `activiteiten` (  `transactie` int(11) NOT NULL,  `datum` date NOT NULL,  `opmerking` text NOT NULL,  `werkgroep` text NOT NULL,  `bank` decimal(10,2) DEFAULT NULL,  `kas` decimal(10,2) DEFAULT NULL, `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',  PRIMARY KEY (`transactie`)) ENGINE=InnoDB DEFAULT CHARSET=latin1; CREATE TABLE `galabal` (  `transactie` int(11) NOT NULL,  `datum` date NOT NULL,  `opmerking` text NOT NULL,  `bank` decimal(10,2) NOT NULL,  `kas` decimal(10,2) NOT NULL, `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',  PRIMARY KEY (`transactie`)) ENGINE=InnoDB DEFAULT CHARSET=latin1; CREATE TABLE `kka` (  `transactie` int(11) NOT NULL,  `datum` date NOT NULL,  `opmerking` text NOT NULL,  `bank` decimal(10,2) NOT NULL,  `kas` decimal(10,2) NOT NULL, `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',  PRIMARY KEY (`transactie`)) ENGINE=InnoDB DEFAULT CHARSET=latin1; CREATE TABLE `tickets` (  `transactie` int(11) NOT NULL,  `datum` date NOT NULL,  `opmerking` text NOT NULL,  `bank` decimal(10,2) NOT NULL,  `kas` decimal(10,2) NOT NULL, `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',  PRIMARY KEY (`transactie`)) ENGINE=InnoDB DEFAULT CHARSET=latin1; INSERT INTO kka (`transactie`, `datum`, `opmerking`, `bank`, `kas`) VALUES ('', '', '', '', ''); INSERT INTO galabal (`transactie`, `datum`, `opmerking`, `bank`, `kas`) VALUES ('', '', '', '', ''); INSERT INTO tickets (`transactie`, `datum`, `opmerking`, `bank`, `kas`) VALUES ('', '', '', '', '');";
			
			$DB->query($sql);
			Session::flash('deleteSite', '<span class="nl"><b>Gegevens succesvol verwijderd.</b></span>');
			Redirect::to('', true, 'reset');
		} else {
			Session::flash('deleteSite', '<span class="nl"><b>Alle velden zijn verplicht. Gelieve te herladen</b></span>');
			Redirect::to('', true, 'reset');
		}
	}
}

$GLOBALS['config']['session']['token'] = Token::generate();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Config | Het Praesidium</title>
	<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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
		#warning {
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			color: #04569A;
		}
	</style>
</head>

<body>

<div id="head">
	<h1>Welcome</h1>
	<p>
		Configuratiebestand voor <a href="../finances/">http://www.hetpraesidium.be/finances/</a>
		<br />
		<a href="mailto:achim.ac.vandierendonck@gmail.com">2014 <?php if (date('Y') > 2014) { echo " - " . date('Y'); } ?> &copy; Achim Vandierendonck</a>
	</p>
</div>

<div id="reame">
	<h2>Readme</h2>
	<p>
		Gelieve de lijsten af te drukken met Chrome op het einde van het jaar!
	</p>
	<p>
		Indien vragen of problemen, je kan mij altijd bereiken via mijn e-mailadres: <a href="mailto:achim.ac.vandierendonck@gmail.com">achim.ac.vandierendonck@gmail.com</a> of je kan altijd langsgaan bij mevrouw Blontrock van het economaat.
	</p>
</div>

<div id="berekeningen">
	<h2>Berekeningen</h2>
	<p>
		De eerste transactie die ingegeven moet worden is het huidige startkapitaal die op de rekening staat. Als voorbeeld kan je het jaar 2013 - 2014 bekijken. Bij het ingeven van een transactie is er een optie om dat bedrag van het vorige jaar af te trekken. Dit is in 2013 - 2014 3 keer gebeurd. Het gaat dan om betalingen die eigelijk het vorige jaar gebeurd moesten zijn, maar die slechts dit jaar betaald zijn. Als voorbeeld is er bijvoorbeeld het springkasteel die in 2012 - 2013 gehuurd is maar slechts in 2013 - 2014 betaald is. De kosten worden dan als volgt berekend: eerst wordt er het opgetelde bedrag van alle transacties die van het vorige jaar afgetrokken worden, van het startkapitaal afgetrokken, dan wordt dat bedrag van het eindtotaal van dat jaar afgetrokken om tot een bedrag te komen dat de winst van dat jaar representeerd.
	</p>
</div>

<div id="reset">
	<h2>Reset Site</h2>
	<div>
		<div id="warning">
				!!!!!!!!!! !Dit zal de huidige tabels exporteren en een nieuwe, lege tabel aanmaken! !!!!!!!!!!
		</div>
		<div class="clear"></div>
		<div>
			<?php
				if (Session::exists('deleteSite')) {
					echo Session::flash('deleteSite');
				} else if ($DB->emptyTable(array('activiteiten', 'galabal', 'kka'))) {
					echo '<span class="nl">Gegevens zijn al verwijderd.</span>';
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
							<span class="nl">Ik heb de waarschuwing gelezen en ik weet wat ik doe.</span>
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

<div style="text-align: right;"><a href="#top" class="nl">Naar het begin</a></div>

<ul id="foot">
	<li><a href="index.php">Het Praesidium - Finances</a></li> -
	<li><a href="mailto:achim.ac.vandierendonck@gmail.com">2014 &copy; Achim Vandierendonck</a></li>
</ul>

</body>
</html>