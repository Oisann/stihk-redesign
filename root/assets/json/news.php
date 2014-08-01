<?php
	include('../../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json');

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($mysql_database, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM nyheter WHERE (skjul = 0) ORDER BY endret DESC LIMIT 0, 15;";
	
	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');

	$articles = array();
	while ($row = mysql_fetch_array($mysql_query)) {
		$articles[intval($row['nid'])] = array('id' => intval($row['id']), 'date' => intval($row['laget']), 'changed' => intval($row['endret']), 'type' => intval($row['type']), 'headline' => htmlentities($row['overskrift']), 'text' => htmlentities($row['tekst']), 'hidden' => 0);
	}
	mysql_close($mysql_connection);
	echo html_entity_decode(json_encode($articles));
?>