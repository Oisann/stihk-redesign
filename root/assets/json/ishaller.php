<?php
	include('../../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json, charset=utf-8');
	header("Access-Control-Allow-Origin: *");

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($mysql_database, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM ishaller WHERE (aktiv = 1) ORDER BY sortering ASC;";
	
	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');

	$articles = array();
	while ($row = mysql_fetch_array($mysql_query)) {
		$aktiv = (intval($row['sortering']) != 999);
		$array_count = intval($row['sortering']);
		if($articles[$array_count]) $array_count++;
		$articles[$array_count] = array('id' => intval($row['id']), 'enabled' => $aktiv, 'code' => htmlentities($row['kode']), 'short' => htmlentities($row['kortnavn']), 'name' => htmlentities($row['navn']), 'listname' => htmlentities($row['listenavn']));
	}
	mysql_close($mysql_connection);
	echo utf8_encode(html_entity_decode(json_encode($articles)));
?>
