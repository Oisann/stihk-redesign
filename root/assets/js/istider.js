$.ajax({
	type: "GET",
	url: "http://stihk.no/assets/json/ishaller.json",
	dataType: "json",
	success: updateIshaller
});


function updateIshaller(json) {
	console.log(json);
	$('select#ishall').html("<option data-id=\"NaN\" disabled>Velg en ishall</option>");
	for (property in json) {
		var disabled = "";
		if(!json[property].enabled) disabled = " disabled";
		$('select#ishall').append("<option data-id=\"" + json[property].id + "\" " + disabled + ">" + json[property].name + "</option>");
	}
}