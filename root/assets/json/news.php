<?php
	include('../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json');

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($db, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM stihk_nyheter WHERE (nyhet_skjult = 0) ORDER BY nyhet_id DESC LIMIT 0, 10;";
	
	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');

	$articles = array();
	while ($row = mysql_fetch_array($mysql_query)) {
		$articles[$row['nyhet_id']] = array('date' => $row['nyhet_dato'], 'type' => $row['nyhet_type'], 'headline' => $row['nyhet_overskrift'], 'text' => $row['nyhet_text'], 'image' => $row['nyhet_image'], 'hidden' => 0);
	}

	echo json_encode($articles);
?>