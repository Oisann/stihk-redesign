<?php
	error_reporting(0);
	include('../../config.php');
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: ' . date("D, d M Y G:i:s T", strtotime("+1 week")) );
	header('Content-type: application/json, charset=utf-8');
	
	$id = $_GET['id'];
	$sesong = $_GET['season'];
	
	if(empty($id) || empty($sesong)) die('{ "error" : "Missing arguments" }');
	
	$articles = array();
	$istider = glob('../../istider/' . $sesong . '/uke_*' . $id . '.htm');
	foreach($istider as $uke) {
		$uke = str_replace('../../istider/' . $sesong . '/uke_', '', $uke);
		$uke = intval(str_replace('.htm', '', $uke));
		$aar = explode("_", $sesong);
		if($uke < 23) { $aar = intval($aar[1]); } else { $aar = intval($aar[0]); };
		$articles[strtotime($aar . 'W' . $uke)] = array('week' => $uke, 'first' => date("d.m.Y", intval(strtotime($aar . 'W' . $uke))), 'last' => date("d.m.Y", intval(strtotime($aar . 'W' . $uke . ' + 6 days'))));
	}
	if(count($articles) == 0) $articles[0] = array('error' => 'no files found', 'time' => time());
	echo utf8_encode(html_entity_decode(json_encode($articles)));
?>
