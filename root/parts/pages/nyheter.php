		<div class="news" style="padding-left: 10px; margin-right: -10px">
<?php

	$mysql_connection = mysql_connect($mysql_host,$mysql_user,$mysql_password);
	if (!$mysql_connection) die('{ "error":"mysql connection failed" }');
	if (!mysql_select_db($mysql_database, $mysql_connection)) die('{ "error":"mysql database not found" }');
	$mysql_selector = "SELECT * FROM nyheter ORDER BY endret DESC LIMIT 0, 15;";

	$mysql_query = mysql_query($mysql_selector, $mysql_connection);
	if(!$mysql_query) die('{ "error":"' . mysql_error() . '" }');
	$error = true;
	while ($row = mysql_fetch_array($mysql_query)) {
		if($id == 'error') {
			echo '<div class="news"><h1 class="center">Nyheter</h1><table class="stihknews"><tr><td><span class="loading" title="Loading..."></span></td></tr></table></div>';
			$error = false;
			return;
		} else {
			if($row['id'] == $id) {
				echo "			<h1>" . htmlentities($row['overskrift']) . "</h1>\n";
				$facebook_like = '<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fstihk.no%2Fnyheter%2F' . $id . '&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=21&amp;appId=172164879660704" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>';
				if($row['laget'] != $row['endret']) {
					echo "			<div class=\"byline\">Av: " . htmlentities($row['av']) . " - Laget: " . date("d.m.Y H:i:s", $row['laget']) . " - Endret: " . date("d.m.Y H:i:s", $row['endret']) . "</div>\n";
				} else {
					echo "			<div class=\"byline\">Av: " . htmlentities($row['av']) . " - Laget: " . date("d.m.Y H:i:s", $row['laget']) . "</div>\n";
				}
				echo "			" . htmlentities($row['tekst']) . "\n";
				echo "			<div class=\"social\"><input type=\"text\" value=\"http://stihk.no/nyheter/" . $id . "\"  disabled> " . $facebook_like . "</div>";
				$error = false;
				return;
			}
		}
	}
	if(!$error) {
		echo "			<h1>Error 11</h1>\n";
		echo "			Fant ingen nyhet med id: " . $id . "\n";
	}
	mysql_close($mysql_connection);
?>
		</div>
