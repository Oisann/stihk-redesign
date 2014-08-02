$.ajax({
	type: "GET",
	url: "http://stihk.no/assets/json/ishaller.json",
	dataType: "json",
	success: updateIshaller
});


function updateIshaller(json) {
	$('select#ishall').html("<option data-id=\"NaN\" selected disabled> - Velg en ishall - </option>");
	for (property in json) {
		var disabled = "";
		if(!json[property].enabled) disabled = " disabled";
		$('select#ishall').append("<option data-id=\"" + json[property].listname + "\" " + disabled + ">" + json[property].name + "</option>");
	}
}

function updateUker(json) {
	console.log("Dette funker vell..");
}

$('select#ishall').change(function() {
	$("select#ishall option:selected" ).each(function() {
		var name = $(this).text(),
			id = $(this).attr("data-id"),
			season = $("span#season").text().replace("/", "_");
		$.ajax({
			type: "GET",
			url: "http://stihk.no/assets/json/ishaller_uker.json?id=" + id + "&season=" + season,
			dataType: "json",
			success: updateUker
		});
    });
});