var trondheim_url = "https://oisann.net/yr/Norge/S%C3%B8r-Tr%C3%B8ndelag/Trondheim/Trondheim", //Yr.no mirrors > Allowing cross domain
	korsvegen_url = "https://oisann.net/yr/Norge/S%C3%B8r-Tr%C3%B8ndelag/Melhus/Korsvegen",
	adressa_hockey = "https://oisann.net/adressa/ishockey/",
	symbol_url_start = "http://symbol.yr.no/grafikk/sym/b38/"; //Start of weathersymbol. Ends with .png
$(document).ready(function() { //no need for this, since i load it at the bottom of the page. EH
	updateClock();
	updateWeather();
	updateAdressa();
	setInterval(function() {
		updateWeather();
	}, 12 * 60000); //update every hour

	setInterval(function() {
		updateClock();
	}, 1);

	var socket = io.connect('http://www.oisann.net:3000');
	var usersOnline = $('.currentVisitorCount');

	socket.on('online', function(data) {
		usersOnline.each(function() {
			$(this).text(data);
		});
	});

	socket.on('notification', function(data) {
		notification(data.title, data.line1, data.line2);
	});

	$(".mininav").change(function() {
		window.location.href = "./" + $(this).find(":selected").text().replace(/ /g, "");
	});

	$('.notification a').click(function() {
		if($(this).attr("href") === "#close") {
			closeNotification($(this).parent());
		}
	});

	$('.navigation a').click(function() {
	    if($(this).attr("href") === "#logginn") {
	    	var login_box = $('.login');
	    	if(login_box.hasClass('hidden')) {
	    		if(!$('.morenav').hasClass('hidden')) { $('.morenav').addClass('hidden'); }
	    		login_box.removeClass('hidden');
	    	} else {
	    		login_box.addClass('hidden');
	    	}
	    }
	    if($(this).attr("href") === "#annet") {
	    	var morenav = $('.morenav');
	    	if(morenav.hasClass('hidden')) {
	    		if(!$('.login').hasClass('hidden')) { $('.login').addClass('hidden'); }
	    		morenav.removeClass('hidden');
	    	} else {
	    		morenav.addClass('hidden');
	    	}
	    }
	});
});

function closeNotification(element) {
	element.fadeOut(function() {
		onCloseNotification(element);
		element.remove();
	});
}

function onCloseNotification(element) {
	var bottomPX = parseInt(element.css('bottom'));
	$('.notification').each(function(index) {
		var new_bottomPX = parseInt($(this).css('bottom'));
		if(new_bottomPX >= bottomPX) {
			new_bottomPX -= 120;
			$(this).animate({bottom: new_bottomPX + "px"}, 500);
		}
	});
}

function notification(title, line1, line2) {
	var count = $('.notification').length,
		id = +new Date + parseInt(Math.random() * 1000);
	$('body').append('<div id="' + id + '" class="notification" style="bottom: ' + (count * 120 + 20) + 'px; display: none;"><a href="#close">x</a><h3>' + title + '</h3>' + line1 + '<br />' + line2 + '</div>');
	$('#' + id).fadeIn();
	setTimeout(function() {
		closeNotification($('#' + id));
	}, 15000);
}

function addNewsfeedItem(title, text, link) {
	$('.newsfeed').append("<span class=\"feeditem\"><a href=\"" + link + "\" alt=\"" + title + "\"><strong>" + title + "</strong>: " + text + "</a></span>");
	startNewsfeed();
}

function startNewsfeed() {
	var scrollspeed = $('.newsfeed').text().length * 100;
	$('.newsfeed').marquee({
		duration: scrollspeed,
		pauseOnHover: true,
		duplicated: true
	});
}

function addAdressaArticle(json) {
	var adressa = $('table.adressa');
	adressa.html(""); //clear all articles
	var max = 4;
	for(var i=0; i<max; i++) {
		if(i == 0) addNewsfeedItem("[Adressa] " + json[i].headline, json[i].lead, json[i].link);
		adressa.append("<tr><td><a href=\"" + json[i].link + "\" class=\"normal\" target=\"_blank\"><img class=\"article\" src=\"" + json[i].image + "\" alt=\"" + json[i].headline + "\" /></a></td><td><h3 class=\"headline\"><a href=\"" + json[i].link + "\" class=\"normal\" target=\"_blank\">" + json[i].headline + "</a></h3>" + json[i].lead + "</td></tr>");
	}
}

function updateClock() {
	d = new Date();
	datetext = d.toTimeString();
	datetext = datetext.split(' ')[0];
	clock = $('.clock');
	if(clock.text() !== datetext)
		clock.text(datetext);
}

function updateAdressa() {
	$.ajax({
		type: "GET",
		url: adressa_hockey,
		dataType: "json",
		success: addAdressaArticle
	});
}

function updateWeather() {
	$.ajax({
		type: "GET",
		url: trondheim_url,
		dataType: "xml",
		success: setWeather
	});
	$.ajax({
		type: "GET",
		url: korsvegen_url,
		dataType: "xml",
		success: setWeather
	});
}

function setWeather(xml) {
	var location = $(xml).find("weatherdata location name").first().text().toLowerCase();
	$(xml).find("weatherdata tabular time temperature").first().each(function() {
		var span = $(this);
		$('span.temperature').each(function() {
			if($(this).attr('location') === location) {
				$(this).text(span.attr('value'));
			}
		});
	});
	$(xml).find("weatherdata tabular time symbol").first().each(function() {
		var span = $(this);
		$('.weather table tr td').each(function() {
			if($(this).attr('location') === location) {
				$(this).removeClass('center');
				$(this).html('<img src="' + symbol_url_start + span.attr('var') + '.png" alt="' + span.attr('name') + '" />');
			}
		});
	});
}