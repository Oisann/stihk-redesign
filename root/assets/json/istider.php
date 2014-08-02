<?php
	include('../../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json, charset=utf-8');
	
	$id = $_GET['id'];
	$sesong = $_GET['season'];
	
	if(empty($id) || empty($sesong)) die('{ "error" : "Missing arguments" }');
	
	$istider = glob('../../istider/' . $sesong . 'uke_*' . $id . '.htm');
	foreach($istider as $istid) {
		echo $istid . '<br>';
	}
	die();
	$articles = array();
	while ($row = mysql_fetch_array($mysql_query)) {
		
		$articles[$array_count] = array('id' => intval($row['id']), 'enabled' => $aktiv, 'code' => htmlentities($row['kode']), 'short' => htmlentities($row['kortnavn']), 'name' => htmlentities($row['navn']), 'listname' => htmlentities($row['listenavn']));
	}
	
	echo utf8_encode(html_entity_decode(json_encode($articles)));
?>