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
	   if(json.hasOwnProperty(property)) {
		  max++;
	   }
	}
	for(var i=0; i<max; i++) {
		var disabled = "";
		if(property.enabled) disabled = " disabled";
		$('select#ishall').append("<option data-id=\"" + property.id + "\" " + disabled + ">" + property.name + "</option>");
	}
}