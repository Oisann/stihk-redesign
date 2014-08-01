		<div class="news" style="padding-left: 10px; margin-right: -10px">
<?php

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($mysql_database, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM nyheter WHERE (id = " . $id . ") ORDER BY endret DESC LIMIT 0, 15;";

	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');
	
	if(empty($mysql_query)) die('Nyhetsartikkelen ble ikke funnet... Error: 11');

	while ($row = mysql_fetch_array($mysql_query)) {
		echo "<h1>" . $row['overskrift'] . "</h1>";
		echo $row['tekst'];
	}
	mysql_close($mysql_connection);
?>
		</div>