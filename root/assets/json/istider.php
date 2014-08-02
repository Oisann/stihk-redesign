<?php
	include('../../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json, charset=utf-8');

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($mysql_database, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM ishaller WHERE (aktiv = 1 AND sortering != 999) ORDER BY sortering DESC;";
	
	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');

	$articles = array();
	while ($row = mysql_fetch_array($mysql_query)) {
		$articles[intval($row['sortering'])] = array('id' => intval($row['id']), 'code' => $row['kode'], 'short' => $row['kortnavn'], 'name' => $row['navn'], 'listname' => $row['listenavn']);
	}
	mysql_close($mysql_connection);
	echo utf8_encode(html_entity_decode(json_encode($articles)));
?>