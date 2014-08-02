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
	console.log("Det er uke:", new Date().getWeekNumber());
}

$('select#ishall').change(function() {
	$("select#ishall option:selected" ).each(function() {
		var name = $(this).text(),
			id = $(this).attr("data-id"),
			season = $("span#season").text().replace("/", "_");
		$.ajax({
			type: "GET",
			url: "http://stihk.no/assets/json/istider.json?id=" + id + "&season=" + season,
			dataType: "json",
			success: updateUker
		});
    });
});