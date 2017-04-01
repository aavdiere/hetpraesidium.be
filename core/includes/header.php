<?php $DB = DB::getInstance(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="imagetoolbar" content="no" />
	<title>Het Praesidium - Welkom</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="core/stylesheet/screen.css">
	<script type="text/javascript" src="core/js/jquery.js"></script>
	<script type="text/javascript" src="core/js/javascript.js"></script>
	<script src="core/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
		    selector: "textarea",
		    theme: "modern",
		    plugins: [
		        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
		        "searchreplace wordcount visualblocks visualchars code fullscreen",
		        "insertdatetime media nonbreaking save table contextmenu directionality",
		        "emoticons template paste textcolor moxiemanager"
		    ],
		    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		    toolbar2: "print preview media | forecolor backcolor emoticons",
		    image_advtab: true,
		    // templates: [
		    //     {title: 'Test template 1', content: 'Test 1'},
		    //     {title: 'Test template 2', content: 'Test 2'}
		    // ]
		});
	</script>
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
</head>
<body id="body">
	<div id="header">
		<div id="header_div">
			<div id="header_compartment">
				<div id="logo">
					<a href="index.php">
						<img id="logoimg" src="images/logopraesidiumsmallerWeb.png">
					</a>
				</div>

				<div id="banner">
					<div id="bannerdiv">
						<?php
							$images = images('diaHome/homeBanner');
							for ($i=2; $i < count($images); $i++) { 
								echo '<div class="crop"><img src="images/diaHome/homeBanner/'.$images[$i].'" alt="k1.jpg"></div>';
							}
						?>
					</div>
				</div>
				
			</div>
		</div>
		
		<div style="height: 10px;"></div>

		<div id="menu_compartment">
			<div>
				<ul id="menu_navigation" style="<?php
					if ($user->isLoggedIn()) {
						echo 'margin-left: -33px;';
					} else {
						echo 'margin-left: 4px;';
					}
				?>" class="menu">
					<li <?php if (curPage() === 'index.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="index.php">Home</a>
						</span>
					</li>
					<li <?php if (curPage() === 'kern.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="kern.php">KERN</a>
							<span class="menu_navigation_level_1_2">
								<ul>
									<?php
										$events = $DB->get('events')->results();
										foreach ($events as $event) {
											echo "
											<li>
												<a style='cursor: pointer;'>$event->full</a>
												<span class='menu_navigation_level_1_3'>
													<ul>
											";
											$years = $DB->get($event->event.'Event')->results();
											foreach ($years as $year) {
												$i = $year->year;
												$j = $event->event;
												echo "<li><a href='show.php?event=$j&year=$i'>$i</a></li>";
											}
											echo "
													</ul>
												</span>
											</li>
											";
										}
									?>
								</ul>
							</span>
						</span>
					</li>
					<li <?php if (curPage() === 'kka.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="kka.php">KKA</a>
						</span>
					</li>
					<li <?php if (curPage() === 'atnoon.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="atnoon.php">Middagactiviteiten</a>
						</span>
					</li>
					<li <?php if (curPage() === 'inteam.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="inteam.php">IN-TEAM</a>
						</span>
					</li>
					<li <?php if (curPage() === 'techniek.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="techniek.php">Techniek</a>
						</span>
					</li>
					<li <?php if (curPage() === 'mos.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="mos.php">MOS</a>
						</span>
					</li>
					<li <?php if (curPage() === 'melkherberg.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="melkherberg.php">Melkherberg</a>
						</span>
					</li>
					<li <?php if (curPage() === 'album.php') { echo "class='active'"; } ?>>
						<span class="menu_navigation_level_1_1">
							<a href="album.php">Foto's</a>
						</span>
					</li>
					<?php if ($user->isLoggedIn()) { ?>
						<li <?php if (curPage() === 'member.php') { echo "class='active'"; } ?>>
							<span class="menu_navigation_level_1_1">
								<a href="#">Leden</a>
								<span class="menu_navigation_level_1_2">
									<ul>
										<?php 
											if ($user->hasPermission('admin') || $user->hasPermission('kka')) {
												
											}
											if ($user->hasPermission('voorzitter')) {
												echo '<li><a href="finances/">Financiën</a></li>';
												echo '<li><a href="contacts/">Ledenlijst</a></li>';
												echo '<li><a href="reserveren.php">Praesidiumlokaal</a></li>';
											}
										 ?>
										<li><a href="member.php">Ledenpagina</a></li>
									</ul>
								</span>
							</span>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<div id="content">
		<div id="left">
			<div>
				<b style="color: red;">
					Deze site kan mogelijk problemen vertonen in Internet Explorer. Wij raden aan een andere webbrowser te gebruiken, vb. Google Chrome, Mozilla Firefox...<br /><br />
					Om de foto albums op deze site te bekijken is Adobe Flash vereist. <br /><br />
					Indien andere problemen, contacteer: <a href="mailto:techniek@hetpraesidium.be">techniek@hetpraesidium.be</a>
				</b>
			</div>
			<?php if ($user->isLoggedIn() && $user->hasPermission('editor')) { ?>
				<div style="padding-top: 0px;">
					<span><h3>Voeg Toe</h3></span>
					<p>Klik <a href="add.php?page=<?php echo curPage(true); ?>">hier</a> om tekst toe te voegen aan de site.</p>
				</div>
			<?php } ?>
			<div style="padding-top: 0px;">
				<span><h3>Gebruikers</h3></span>
				<div>
					<?php
						if (isset($_GET['notmember'])) {
							echo "<b style='color: red;'>You are not registered as a Praesidium member.</b><br />";
						}
					?>
				</div>
				<div>
					<?php
					if ($user->isLoggedIn()) {
					?>
						<p>Dag <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->name); ?></a>!</p>

						<ul>
							<li><a href="update.php">Update gegevens</a></li>
							<li><a href="changepassword.php">Wachtwoord veranderen</a></li>
							<li><a href="logout.php">Log Uit</a></li>
						</ul>

						<?php

					} else {
						echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
					}

					?>
				</div>
				
			</div>
		</div>
		<div id="right">