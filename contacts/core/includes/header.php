<!DOCTYPE html>
<html>
<head>
	<title>Contacts | Praesidium</title>
	<link rel="stylesheet" type="text/css" href="core/stylesheet/screen.css">
	<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>
	
<?php
	if (!Input::exists('get', 'print')) {
?>
	<div id="menu">
		<ul id="qm0" class="qmmc">
			<li>
				<a <?php if (curPage() === 'contacts.php'	) { echo "style='background-color:rgb(255, 255, 255); color:rgb(0, 0, 0); border-color:rgb(255, 0, 0);'"; } ?> href="contacts.php">Contacten</a>
			</li>
			<li>
				<a <?php if (curPage() === 'cards.php'	) { echo "style='background-color:rgb(255, 255, 255); color:rgb(0, 0, 0); border-color:rgb(255, 0, 0);'"; } ?> href="cards.php">Ledenkaarten</a>
			</li>
			<li>
				<a href="#" class="qmparent">Meer</a>
				<ul>
					<?php
						foreach ($codes as $key => $code) {
							echo "<li>$code</li>";
						}
					?>
					<li>
						<?php
						if (Input::exists('get', 'filter')) {
							if (Input::exists('get', 'year')) {
								$url = "?year=" . Input::get('year') . "&filter=" . Input::get('filter') . "&print=y";
							} else {
								$url = "?filter=" . Input::get('filter') . "&print=y";
							}
						} else {
							if (Input::exists('get', 'year')) {
								$url = "?year=" . Input::get('year') . "&print=y";
							} else {
								$url = "?print=y";
							}
						}
						?>
						<a href="<?php echo $url; ?>">Print</a>
					</li>
					<li><a href="../index.php">Terug</a></li>
				</ul>
			</li>
			<li class="qmclear">
				&nbsp;
			</li>
		</ul>
	</div>
	<div class="clear"></div>
<?php
	}
?>