window.onresize = resize;

function css() {
	document.getElementById('banner').style.width = Math.round(document.getElementById('content').offsetWidth * 507 / 900) + 'px';
	document.getElementById('banner').style.height = Math.round(document.getElementById('banner').style.width.substring(0, document.getElementById('banner').style.width.length - 2) * 211 / 507) + 'px';
	var temp = $("#banner").css('width');
	$("#banner div img").css('width', temp);
	temp = $('.crop img').css('width');
	$(".crop").css('width', temp);
	temp = Math.round(temp.substring(0, temp.length - 2) *250/600);
	$(".crop").css('height', temp);
}

function rotateImages(){
	var height = Math.round(document.getElementById('banner').style.width.substring(0, document.getElementById('banner').style.width.length - 2) * 211 / 507);
	$.get('core/js/numberoffiles.php', function(data) {
		for (var i = 0; i <= data - 3; i++) {
			$("#bannerdiv").animate({marginTop: "-" + i*height + "px"}, 1000).delay(4000);
		};
	});
}

function resize() {
	clearInterval(setInterval(rotateImages, 35000));
	css();
	rotateImages();
	setInterval(rotateImages, 35000);
}


$(document).ready(function() {
	css();
	rotateImages();
	setInterval(rotateImages, 35000);
	$("#pictures_" + window.location.hash.substring(1)).delay(100).animate({height: 'toggle'});
});

function showPictures(id) {
	window.location.hash = id;
	if (document.getElementById("pictures_" + id).style.display === 'block') {
		window.location.hash = '';
	};
	$("#pictures_" + id).animate({height: 'toggle'});
	var html = document.getElementById('albums').innerHTML,
		count = html.split('<h3>').length - 1;
	for (var i = 1; i <= count; i++) {
		if (i != id) {
			if (document.getElementById("pictures_" + i).style.display === 'block') {
				$("#pictures_" + i).animate({height: 'toggle'});
			};
		};
	};
}