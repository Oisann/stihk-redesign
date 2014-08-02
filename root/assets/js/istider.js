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
		$('select#ishall').append("<option data-id=\"" + json[property].id + "\" " + disabled + ">" + json[property].name + "</option>");
	}
}

$('select#ishall').change(function() {
	console.log(this.selected.text);
});