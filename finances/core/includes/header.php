<!DOCTYPE html>
<html>
<head>
	<title>Financi&euml;n | Praesidium</title>
	<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="core/stylesheet/screen.css">
	<script type="text/javascript" src="../core/js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('body').css({"min-width": $('.data').css('width')});
		})
	</script>
</head>
<body>

<div id="menu">
	<ul id="qm0" class="qmmc">
		<li>
			<a <?php if (curPage() === 'activiteiten.php'	) { echo "style='background-color:rgb(255, 255, 255); color:rgb(0, 0, 0); border-color:rgb(255, 0, 0);'"; } ?> href='activiteiten.php'>
				Activiteiten
			</a>
		</li>
		<li>
			<a <?php if (curPage() === 'kka.php'			) { echo "style='background-color:rgb(255, 255, 255); color:rgb(0, 0, 0); border-color:rgb(255, 0, 0);'"; } ?> href='kka.php'>
				Kleine Kunst Avond - KKA
			</a>
		</li>
		<li>
			<a <?php if (curPage() === 'galabal.php'		) { echo "style='background-color:rgb(255, 255, 255); color:rgb(0, 0, 0); border-color:rgb(255, 0, 0);'"; } ?> href='galabal.php'>
				Galabal
			</a>
		</li>
		<li>
			<a <?php if (curPage() === 'tickets.php'		) { echo "style='background-color:rgb(255, 255, 255); color:rgb(0, 0, 0); border-color:rgb(255, 0, 0);'"; } ?> href='tickets.php'>
				Tickets
			</a>
		</li>
		<li>
			<a <?php if (curPage() === 'algemeen.php'		) { echo "style='background-color:rgb(255, 255, 255); color:rgb(0, 0, 0); border-color:rgb(255, 0, 0);'"; } ?> href='algemeen.php'>
				Algemeen
			</a>
		</li>
		<?php
			if (!Input::exists('get', 'print')) {
		?>
			<li>
				<a href="#" class="qmparent">Meer</a>
				<ul>
					<?php
						foreach ($codes as $key => $code) {
							echo "<li>$code</li>";
						}
					?>
					<li><a href="config.php">Config</a></li>
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
					<li>
						<a href="../index.php">Terug</a>
					</li>
				</ul>
			</li>
		<?php
			}
		?>

		<li class="qmclear">
			&nbsp;
		</li>
	</ul>
</div>

<div class="clear"></div>