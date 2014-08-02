<?php
	include('../../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json, charset=utf-8');
	
	die("ID: " . $_GET['id']);

	$articles = array();
	while ($row = mysql_fetch_array($mysql_query)) {

		$articles[$array_count] = array('id' => intval($row['id']), 'enabled' => $aktiv, 'code' => htmlentities($row['kode']), 'short' => htmlentities($row['kortnavn']), 'name' => htmlentities($row['navn']), 'listname' => htmlentities($row['listenavn']));
	}
	
	echo utf8_encode(html_entity_decode(json_encode($articles)));
?>