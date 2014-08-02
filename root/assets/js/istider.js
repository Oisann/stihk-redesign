$.ajax({
	type: "GET",
	url: "http://stihk.no/assets/json/ishaller.json",
	dataType: "json",
	success: updateIshaller
});


function updateIshaller(json) {
	console.log(json);
	$('select#ishall').html("<option data-id=\"NaN\" disabled>Velg en ishall</option>");
	var max = 0;
	for (property in json) {
	   console.log(property);
	}
	for(var i=0; i<max; i++) {
		var disabled = "";
		if(!json[i].enabled) disabled = " disabled";
		$('select#ishall').append("<option data-id=\"" + json[i].id + "\" " + disabled + ">" + json[i].name + "</option>");
	}
}