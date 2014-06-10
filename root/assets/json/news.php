<?php
	include('../../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json');

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($mysql_database, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM stihk_nyheter WHERE (nyhet_skjult = 0) ORDER BY nyhet_id DESC LIMIT 0, 10;";
	
	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');

	$articles = array();
	while ($row = mysql_fetch_array($mysql_query)) {
		$articles[$row['nyhet_id']] = array('date' => $row['nyhet_dato'], 'type' => intval($row['nyhet_type']), 'headline' => htmlentities($row['nyhet_overskrift']), 'text' => htmlentities($row['nyhet_tekst']), 'image' => htmlentities($row['nyhet_bilde']), 'hidden' => 0);
	}
	mysql_close($mysql_connection);
	echo html_entity_decode(json_encode($articles));
?>