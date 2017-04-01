<?php require_once 'core/init.php' ?>

<?php delete(); show(); ?>

<?php

if (Input::get('event') === 'galabal' && Input::get('year') == 2014) {

?>
	<div>
		<h3>Foto's Bal van Sint-Lodewijks</h3>
		<p>
			<div>
				<div class="titlealbum" id="titlealbum_7" onclick="showPictures('7')">
					<h3>Bal van Sint-Lodewijks 2014 - 1</h3>
				</div>
				<div class="pictures" id="pictures_7" style="display: none;">
					<h2 style="text-align: center;">Met dank aan Kevin De Vos</h2>
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9.0.0.0" width="600" height="450" ID="sf" VIEWASTEXT>
						<param name="movie" value="Galabal.swf" />
						<param name="quality" value="high" />
						<param name="wmode" value="transparent" />
						<param name="allowScriptAccess" value="always" />
						<param name="allowFullScreen" value="true" />
						<embed src="images/albums/swf/Galabal/Galabal.swf" quality="high" name="sf" allowScriptAccess="always" allowFullScreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="600" height="450" />
					</object>
				</div>
			</div>
			<div class="clear"></div>
			<div>
				<div class="titlealbum" id="titlealbum_8" onclick="showPictures('8')">
					<h3>Bal van Sint-Lodewijks 2014 - 2</h3>
				</div>
				<div class="pictures" id="pictures_8" style="display: none;">
					<h2 style="text-align: center;">Met dank aan Alec Buyse</h2>
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9.0.0.0" width="600" height="450" ID="sf" VIEWASTEXT>
						<param name="movie" value="Galabal_Alec_Buyse.swf" />
						<param name="quality" value="high" />
						<param name="wmode" value="transparent" />
						<param name="allowScriptAccess" value="always" />
						<param name="allowFullScreen" value="true" />
						<embed src="images/albums/swf/Galabal_Alec_Buyse/Galabal_Alec_Buyse.swf" quality="high" name="sf" allowScriptAccess="always" allowFullScreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="600" height="450" />
					</object>
				</div>
			</div>
			<div class="clear"></div>
			<div>
				<div class="titlealbum" id="titlealbum_9" onclick="showPictures('9')">
					<h3>Bal van Sint-Lodewijks 2014 - 3</h3>
				</div>
				<div class="pictures" id="pictures_9" style="display: none;">
					<h2 style="text-align: center;">Met dank aan Arthur Joos</h2>
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9.0.0.0" width="600" height="450" ID="sf" VIEWASTEXT>
						<param name="movie" value="Galabal_Arthur_Joos.swf" />
						<param name="quality" value="high" />
						<param name="wmode" value="transparent" />
						<param name="allowScriptAccess" value="always" />
						<param name="allowFullScreen" value="true" />
						<embed src="images/albums/swf/Galabal_Arthur_Joos/Galabal_Arthur_Joos.swf" quality="high" name="sf" allowScriptAccess="always" allowFullScreen="true" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="600" height="450" />
					</object>
				</div>
			</div>
		</p>
	</div>
<?php } ?>

<?php require_once 'core/includes/footer.php' ?>