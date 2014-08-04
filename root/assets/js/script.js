var trondheim_url = "https://oisann.net/yr/Norge/S%C3%B8r-Tr%C3%B8ndelag/Trondheim/Trondheim", //Yr.no mirrors > Allowing cross domain
	korsvegen_url = "https://oisann.net/yr/Norge/S%C3%B8r-Tr%C3%B8ndelag/Melhus/Korsvegen",
	adressa_hockey = "https://oisann.net/adressa/ishockey/",
	symbol_url_start = "http://symbol.yr.no/grafikk/sym/b38/", //Start of weathersymbol. Ends with .png
	news_url = "http://stihk.no/demo/assets/json/news.json",
	socket = io.connect('http://www.oisann.net:3000');
$(document).ready(function() { //no need for this, since i load it at the bottom of the page. EH
	var path = $(location).attr('href');
	try {
		var filename = path.split('/')[3];
		if(filename == "") filename = "hjem";
		if(filename.startsWith('#')) filename = "hjem";
	} catch(err) {
		var filename = 'hjem';
	}
	$('html').addClass(filename);
	updateClock();
	updateWeather();
	updateAdressa();
	updateNews();
	setInterval(function() {
		updateWeather();
	}, 12 * 60000); //update every hour

	setInterval(function() {
		updateClock();
	}, 1);

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
		window.location.href = "/" + $(this).find(":selected").text().replace(/ /g, "") + "/";
	});

	$('.menu td').click(function(e) {
		e.preventDefault();
		var link = $(this).children().attr("href");
		window.location.href = link;
	});

	/*$('.notification a').click(function() {
		console.log($(this).parent().attr("id"));
		if($(this).attr("href") === "#close") {
			console.log($(this).parent().attr("id"));
			closeNotification($(this).parent());
		}
	});*/
	
	$('#weather-korsvegen').click(function() {
		window.open('http://www.yr.no/sted/Norge/S%C3%B8r-Tr%C3%B8ndelag/Melhus/Korsvegen/','_blank');
	});
	
	$('#weather-trondheim').click(function() {
		window.open('http://www.yr.no/sted/Norge/S%C3%B8r-Tr%C3%B8ndelag/Trondheim/Trondheim/','_blank');
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
	$('iframe').load(function() {
		setTimeout(function() {
		try {
			document.getElementById('istid').style.height = document.getElementById('istid').contentWindow.document.body.offsetHeight + 100 + 'px';
		} catch(err) {}
		}, 5);
	});
});

if (typeof String.prototype.startsWith != 'function') {
	String.prototype.startsWith = function (str){
		return this.slice(0, str.length) == str;
	};
}

function closeNotification(element) {
	if($(window).width() <= 711) {
		element.animate({"margin-top": "-100px"}, 500);
		setTimeout(function() {
			element.remove();
		}, 500);
	} else {
		element.fadeOut(function() {
			onCloseNotification(element);
			element.remove();
		});
	}
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

function push(title, line1, line2, passcode) {
	var data = {
	    title:title,
	    line1:line1,
	    line2:line2,
	    passcode:passcode
	};
	socket.emit('notification', data);
}

function notification(title, line1, line2) {
	var count = $('.notification').length,
		id = +new Date + parseInt(Math.random() * 1000);
	$('body').append('<div id="' + id + '" class="notification" style="bottom: ' + (count * 120 + 20) + 'px; display: none;"><a class="close" href="#close" onclick="closeNotification($(this).parent())">x</a><h3>' + title + '</h3>' + line1 + '<br />' + line2 + '</div>');
	$('#' + id).fadeIn();
	if($(window).width() <= 711) {
		$('#' + id).css("margin-top", "-100px");
		$('#' + id).animate({"margin-top": "0px"}, 500);
	}
	setTimeout(function() {
		closeNotification($('#' + id));
	}, 15000);
}

function addNewsfeedItem(title, text, link) {
	$('.newsfeed').append("<span class=\"feeditem\"><a href=\"" + link + "\" target=\"_blank\" alt=\"" + title + "\"><strong>" + title + "</strong>: " + text + "</a></span>");
}

function startNewsfeed() {
	var scrollspeed = $('.newsfeed').text().length * 100;
	$('.newsfeed').marquee({
		duration: scrollspeed,
		pauseOnHover: true,
		duplicated: true
	});
}

var adressa_ready = false,
	stihknews_ready = false;

function addAdressaArticle(json) {
	var adressa = $('table.adressa');
	adressa.html(""); //clear all articles
	var max = 4;
	for(var i=0; i<max; i++) {
		if(i == 0) addNewsfeedItem("[Adressa] " + json[i].headline, json[i].lead, json[i].link);
		adressa.append("<tr><td><a href=\"" + json[i].link + "\" class=\"normal\" target=\"_blank\"><img class=\"article\" src=\"" + json[i].image + "\" alt=\"" + json[i].headline + "\" /></a></td><td><h3 class=\"headline\"><a href=\"" + json[i].link + "\" class=\"normal\" target=\"_blank\">" + json[i].headline + "</a></h3>" + json[i].lead + "</td></tr>");
		if(i == max - 1) adressa_ready = true;
	}
}

function timeToDate(format, time) {
	$.get("/dato.php?format=" + format + "&tid=" + parseInt(time), function( data ) {
		console.log(data);
	});
}

function addNewsArticle(json) {
	var stihknews = $('table.stihknews');
	if($('.news h1.center').text() !== "ERROR 404") stihknews.html(""); //clear all articles
	for(var i=0; i<15; i++) {
		var article = json[i];
		if(i == 14) stihknews_ready = true;
		if(article == null) {
			stihknews_ready = true
			return;
		}
		var changed_date = new Date(article.changed * 1000);
		var changed_article = article.changed == article.date ? '' : ' <img src="http://stihk.no/assets/img/updated.png" />';
		addNewsfeedItem(article.headline, shorten(article.text), "/nyheter/" + article.id);
		if($('.news h1.center').text() !== "ERROR 404") stihknews.append('<tr><td>' + timeToDate("d.m.Y H:i:s", article.changed) + '</td><td><h3 class="headline"><a href="/nyheter/' + article.id + '" class="normal">' + article.headline + '</a>' + changed_article + '</h3>' + shorten(article.text) + '</td></tr><tr class="lesmer"><td></td><td><a href="/nyheter/' + article.id + '" class="normal" style="font-weight: bold">Les mer...</a></td></tr>');
	}
}

function shorten(text) {
	var length = text.length;
	if(length > 130) {
		var innledning = text.split(" "),
			result = "";
		for(word in innledning) {
			if(result.length <= 130) {
				result += " " + innledning[word];
			}
		}
		return result + "...";
	}
	return text;
}

function leadingZero(num) {
	return num <= 9 ? "0" + num : num;
}

function updateClock() {
	d = new Date();
	datetext = d.toTimeString();
	datetext = datetext.split(' ')[0];
	clock = $('.clock');
	if(adressa_ready && stihknews_ready) {
		adressa_ready = false;
		stihknews_ready = false;
		startNewsfeed();
	}
	if(clock.text() !== datetext)
		clock.text(datetext);
}

function updateAdressa() {
	if($('html').hasClass('news')) return; //Save oisann.net for unnecessary traffic and load
	$.ajax({
		type: "GET",
		url: adressa_hockey,
		dataType: "json",
		success: addAdressaArticle
	});
}

function updateNews() {
	if($('html').hasClass('news')) return;
	$.ajax({
		type: "GET",
		url: news_url,
		dataType: "json",
		success: addNewsArticle
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