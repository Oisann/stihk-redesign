		<div class="news" style="padding-left: 10px; margin-right: -10px">
			<?php
require 'include_now.php';
?>
<h2>Arrangement <?php echo($sesong)?></h2>
<?php
$usr = "stihk_mysql";
$pwd = "wbiPx450";
$db = "stihk_stihk";
$host = "localhost";
$cid = mysql_connect($host,$usr,$pwd);
if (!$cid) { echo("ERROR: " . mysql_error() . "\n"); }
$sqlstring = "select *, UNIX_TIMESTAMP(arr_startdato) as arr_unixtid from stihk_arrangementer WHERE (arr_sesong='$sesong' OR arr_sesong='$nestesesong') ORDER BY arr_startdato ASC, arr_tidspunkt ASC;";
$retid = mysql_db_query($db, $sqlstring, $cid);
if (!$retid) { echo( mysql_error()); }
?>
<table border="1" cellspacing="1" bgcolor="#CCCCCC" bordercolor="#666666">
<tr>
<td bgcolor='ffffff'><b>Tidspunkt</b></td>
<td bgcolor='ffffff'><b>Beskrivelse</b></td>
<td bgcolor='ffffff'><b>Deltakere</b></td>
<td bgcolor='ffffff'><b>Sted</b></td>
<td bgcolor='ffffff'><b>Arrang&oslash;r</b></td>
<td bgcolor='ffffff'><b>Informasjon</b></td>
</tr>
<?php
// Hovedløkke tabell
while ($row = mysql_fetch_array($retid))
	{
	$arr_id = $row['arr_id'];
	$arr_startdato = $row['arr_startdato'];
	$arr_tidspunkt = $row['arr_tidspunkt'];
	$arr_beskrivelse = $row['arr_beskrivelse'];
	$arr_klasser = $row['arr_klasser'];
	$arr_sted = $row['arr_sted'];
	$arr_arrangor = $row['arr_arrangor'];
	$arr_info = $row['arr_info'];
	$arr_farge = $row['arr_farge'];
	$arr_aktiv = $row['arr_aktiv'];
	$arr_unixtid = $row['arr_unixtid'];
	
	echo("<tr>");
	if($arr_unixtid < time())
		{
		echo("<td bgcolor='" . fadecol($arr_farge,0.75) . "'><b>" . htmlentities($arr_tidspunkt) . "</b></td>");
		echo("<td bgcolor='" . fadecol($arr_farge,0.75) . "'><b>" . htmlentities($arr_beskrivelse) . "</b></td>");
		echo("<td bgcolor='" . fadecol($arr_farge,0.75) . "'>" . htmlentities($arr_klasser) . "</td>");
		echo("<td bgcolor='" . fadecol($arr_farge,0.75) . "'>" . htmlentities($arr_sted) . "</td>");
		echo("<td bgcolor='" . fadecol($arr_farge,0.75) . "'>" . htmlentities($arr_arrangor) . "</td>");
		echo("<td bgcolor='" . fadecol($arr_farge,0.75) . "'>" . htmlentities($arr_info) . "</td>");
		}
	else
		{
		echo("<td bgcolor='" . $arr_farge . "'><b>" . htmlentities($arr_tidspunkt) . "</b></td>");
		echo("<td bgcolor='" . $arr_farge . "'><b>" . htmlentities($arr_beskrivelse) . "</b></td>");
		echo("<td bgcolor='" . $arr_farge . "'>" . htmlentities($arr_klasser) . "</td>");
		echo("<td bgcolor='" . $arr_farge . "'>" . htmlentities($arr_sted) . "</td>");
		echo("<td bgcolor='" . $arr_farge . "'>" . htmlentities($arr_arrangor) . "</td>");
		echo("<td bgcolor='" . $arr_farge . "'>" . htmlentities($arr_info) . "</td>");
		}
	echo("</tr>");
	}
?>
</table>
		</div>