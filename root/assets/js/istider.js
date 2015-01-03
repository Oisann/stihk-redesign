$.urlParam = function(name){
    var results = new RegExp('[\?&#]' + name + '=([^&#]*)').exec(window.location.href);
    if (results===null){
	return null;
    } else {
	return results[1] || 0;
    }
}

$.setUrlParam = function(param, data) {
	var before = new RegExp('[\?&#]' + param + '=([^&#]*)').exec(window.location.hash);
	if(before===null) {
		return null;
	} else {
		window.location.hash = (window.location.hash).replace(param + '=' + before[1], param + '=' + data);
		
		return true;
	}
}

if(window.location.hash=="") window.location.hash = '#h=null&w=null'; //add a shareable settings

var selected_ishall = "",
	season = $("span#season").text().replace("/", "_");

/*$.ajax({
	type: "GET",
	url: "http://stihk.no/assets/json/ishaller.json",
	dataType: "json",
	success: updateIshaller
});*/

$.get("http://stihk.no/assets/json/ishaller.json", function( data ) {
	updateIshaller(data);
});

Date.prototype.getWeekNumber = function(){
    var d = new Date(+this);
    d.setHours(0,0,0);
    d.setDate(d.getDate()+4-(d.getDay()||7));
    return Math.ceil((((d-new Date(d.getFullYear(),0,1))/8.64e7)+1)/7);
};

function updateIshaller(json) {
	$('select#ishall').html("<option data-id=\"NaN\" selected disabled> - Velg en ishall - </option>");
	var index = 0;
	for (property in json) {
		var disabled = "";
		if(!json[property].enabled) disabled = " disabled";
		$('select#ishall').append("<option data-id=\"" + json[property].listname + "\" " + disabled + ">" + json[property].name + "</option>");
		if($.urlParam('h') === json[property].listname) {
			$('select#ishall')[0].selectedIndex = index;
			$('select#ishall').trigger("change");
		}
		index++;
	}
}

function updateUker(json) {
	var uke = new Date().getWeekNumber();
	$('select#uke').html("");
	if(Object.keys(json).length === 1) {
		var only_week = json[Object.keys(json)[0]].week;
		if(only_week !== undefined) $('iframe#istid').attr("src", "./" + season + "/uke_" + only_week + "_" + selected_ishall + ".htm");
	}
	var index = 0;
	for (property in json) {
		if(json[property].error) {
			var err = json[property].error == 'no files found' ? 'Istidene for denne hallen er ikke ute enda.' : json[property].error;
			$('select#uke').html("<option disabled selected>" + err + "</option>");
			return;
		}
		var select = "",
			star = "";
		if(json[property].week == uke) {
			select = "selected";
			star = "*";
			$('iframe#istid').attr("src", "./" + season + "/uke_" + (uke<=9?"0"+uke:uke) + "_" + selected_ishall + ".htm");
		}
		$('select#uke').append("<option data-week=\"" + json[property].week + "\" " + select + ">Uke " + json[property].week + star + " - " + json[property].first + "-" + json[property].last + "</option>");
		if($.urlParam('w') === json[property].week) {
			$('select#uke')[0].selectedIndex = index;
			$('select#uke').trigger("change");
		}
		index++;
	}
}

$('select#uke').change(function() {
	$("select#uke option:selected" ).each(function() {
		var selected_week = $(this).attr("data-week");
		$('iframe#istid').attr("src", "./" + season + "/uke_" + selected_week + "_" + selected_ishall + ".htm");
		$.setUrlParam('q', selected_week);
	});
});

$('select#ishall').change(function() {
	$("select#ishall option:selected" ).each(function() {
		var name = $(this).text();
		selected_ishall = $(this).attr("data-id");
		$('select#uke').html("<option selected disabled><- Velg en ishall først</option>");
		/*$.ajax({
			type: "GET",
			url: "http://stihk.no/assets/json/istider.json?id=" + selected_ishall + "&season=" + season,
			dataType: "json",
			success: updateUker
		});*/
		$.get("http://stihk.no/assets/json/istider.json?id=" + selected_ishall + "&season=" + season, function( data ) {
			$.setUrlParam('h', selected_ishall);
			updateUker(data);
		});
    });
});
