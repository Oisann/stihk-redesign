		<div class="news" style="padding-left: 10px; margin-right: -10px">
<?php

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($mysql_database, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM nyheter WHERE (id = " . $id . ") ORDER BY endret DESC LIMIT 0, 15;";

	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');

	while ($row = mysql_fetch_array($mysql_query)) {
		if(empty($row)) {
			echo "Fant ingen nyhet med id: " . $id;
			return;
		}
		echo "<h1>" . $row['overskrift'] . "</h1>";
		echo utf8_decode($row['tekst']);
	}
	mysql_close($mysql_connection);
?>
		</div>