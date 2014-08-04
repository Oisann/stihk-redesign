var selected_ishall = "",
	season = $("span#season").text().replace("/", "_");

$.ajax({
	type: "GET",
	url: "http://stihk.no/assets/json/ishaller.json",
	dataType: "json",
	success: updateIshaller
});

Date.prototype.getWeekNumber = function(){
    var d = new Date(+this);
    d.setHours(0,0,0);
    d.setDate(d.getDate()+4-(d.getDay()||7));
    return Math.ceil((((d-new Date(d.getFullYear(),0,1))/8.64e7)+1)/7);
};

function updateIshaller(json) {
	$('select#ishall').html("<option data-id=\"NaN\" selected disabled> - Velg en ishall - </option>");
	for (property in json) {
		var disabled = "";
		if(!json[property].enabled) disabled = " disabled";
		$('select#ishall').append("<option data-id=\"" + json[property].listname + "\" " + disabled + ">" + json[property].name + "</option>");
	}
}

function updateUker(json) {
	var uke = new Date().getWeekNumber();
	$('select#uke').html("");
	for (property in json) {
		var select = "",
			star = "";
		if(json[property].week == uke) {
			select = "selected";
			star = "*";
			$('iframe#istid').attr("src", "./" + season + "/uke_" + uke + "_" + selected_ishall + ".htm");
		}
		$('select#uke').append("<option data-week=\"" + json[property].week + "\" " + select + ">Uke " + json[property].week + star + " - " + json[property].first + "-" + json[property].last + "</option>");
	}
	if($("select#uke").children().length === 1 && $('select#uke option').text() === "<- Velg en ishall først") $("select#uke").html("<option selected disabled>Denne ishallen har ingen isfordelinger enda</option>");
}

$('select#uke').change(function() {
	$("select#uke option:selected" ).each(function() {
		var selected_week = $(this).attr("data-week");
		$('iframe#istid').attr("src", "./" + season + "/uke_" + selected_week + "_" + selected_ishall + ".htm");
	});
});

$('select#ishall').change(function() {
	$("select#ishall option:selected" ).each(function() {
		var name = $(this).text();
		selected_ishall = $(this).attr("data-id");
		$('select#uke').html("<option selected disabled><- Velg en ishall først</option>");
		$.ajax({
			type: "GET",
			url: "http://stihk.no/assets/json/istider.json?id=" + selected_ishall + "&season=" + season,
			dataType: "json",
			success: updateUker
		});
    });
});