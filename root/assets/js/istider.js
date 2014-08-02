$.ajax({
	type: "GET",
	url: "http://stihk.no/assets/json/ishaller.json",
	dataType: "json",
	success: updateIshaller
});


function updateIshaller(json) {
	console.log(json);
	$('select#ishall').html("<option data-id=\"NaN\" disabled>Velg en ishall</option>");
}