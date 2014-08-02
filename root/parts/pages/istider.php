		<div class="news" style="padding-left: 10px; margin-right: -10px">
			<h2>Istider <?php echo($sesong)?></h2>
<table border="1" cellspacing="1" bgcolor="#CCCCCC" bordercolor="#808080">
<?php
//leser hall-listen
$sqlstring = "select * from stihk_haller WHERE aktiv = 1 AND hall_islistenavn <> '' ORDER BY hall_sortering ASC, hall_navn ASC;";
$retid_haller = mysql_db_query($db, $sqlstring, $cid);
if (!$retid_haller) { echo( mysql_error()); }

$mappenavn = "istider/" . str_replace("/","_",$sesong);
// lager et sortert array som inneholder ukenummeret på alle de "uke_<ukenr>.zip"  som er lagt ut i istidsmappen
$mappe = opendir($mappenavn . "/");
$weeklist = array();
$weeklist_keys = array();

while (false !== ($fil_navn = readdir($mappe))) 
	{
	$fil_navn = basename($fil_navn);
	If (substr($fil_navn,0,4) == 'uke_' && substr($fil_navn,strrpos($fil_navn,'.'),4)=='.zip')
		{
		array_push($weeklist,substr($fil_navn,4,2));
		if ((0 + substr($fil_navn,4,2)) < 30)
			{
			array_push($weeklist_keys,100 + substr($fil_navn,4,2));
			}
		else
			{
			array_push($weeklist_keys,0 + substr($fil_navn,4,2));
			}
		}
	}
array_multisort($weeklist_keys,SORT_DESC,SORT_NUMERIC,$weeklist);
// beregner ukenummeret på gjeldende uke
$denne_uken = strftime("%V",time());
// beregner dato på mandag i uke 1 i begge sesongens år
$dag_i_uke1 = strtotime("4 january " . substr($sesong,0,4));
$dag_i_uke1_2 = strtotime("4 january " . substr($sesong,5,4));
if(date("w", $dag_i_uke1)==1)
	$mandag_i_uke1 = $dag_i_uke1;
else
	$mandag_i_uke1 = strtotime("last monday", $dag_i_uke1);
if(date("w", $dag_i_uke1_2)==1)
	$mandag_i_uke1_2 = $dag_i_uke1_2;
else
	$mandag_i_uke1_2 = strtotime("last monday", $dag_i_uke1_2);
?>

  <tr>
    <td bgcolor="#FFFFFF" colspan="2">
	<strong>Uke</strong>
	</td>
    <td>
	</td>
<?php
$hallnavn = array();
$islistenavn = array();
$antall_haller = 0;
while ($row_hall = mysql_fetch_assoc($retid_haller))
	{
	$antall_haller += 1;
	$hallnavn[$antall_haller]=$row_hall['hall_navn'];
	$islistenavn[$antall_haller]=$row_hall['hall_islistenavn'];
	echo("<td bgcolor='#FFFFFF'><strong>$hallnavn[$antall_haller]</strong></td>");
	}
?>
  </tr>
  <tr>
<?php
for ($i = 1; $i <= $antall_haller+1; $i++)
    echo("<td></td>");
?>
  </tr>

<?php
 for ($i=0;$i<count($weeklist);$i++)
 	{
?>
  <tr>
    <?php 
	if ($weeklist[$i]==$denne_uken)
		echo("<td bgcolor='#C0FFC0'>");
	else
		echo("<td bgcolor='#FFFFFF'>");
	?>
	<?php echo "$weeklist[$i]" ?>
	</td>
    <?php 
	if ($weeklist[$i]==$denne_uken)
		echo("<td bgcolor='#C0FFC0'>");
	else
		echo("<td bgcolor='#FFFFFF'>");
	?>

	<?php
	if ($weeklist[$i] > 24)
		$mandag = strtotime("+ " . ($weeklist[$i] - 1) . " week", $mandag_i_uke1);
	else
		$mandag = strtotime("+ " . ($weeklist[$i] - 1) . " week", $mandag_i_uke1_2);
	echo(strftime("%d.%m",$mandag)) . " ->";
	  ?>
	</td>
    <td>
	</td>
    <?php 
	for ($j = 1; $j <= $antall_haller; $j++)
		{
		if ($weeklist[$i]==$denne_uken)
			echo("<td bgcolor='#C0FFC0'>");
		else
			echo("<td bgcolor='#FFFFFF'>");
		if (file_exists("$mappenavn/uke_$weeklist[$i]_$islistenavn[$j].htm"))
			{
			echo "<a href='$mappenavn/uke_$weeklist[$i]_$islistenavn[$j].htm'>Se istid</a>";
			}
		echo("</td>");
		}
	?>
  </tr>

<?php } ?>
  <tr>
<?php
for ($i = 1; $i <= $antall_haller+1; $i++)
    echo("<td></td>");
?>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" colspan="2">
	<strong>Mal</strong>
	</td>
    <td>
	</td>
<?php
for ($j = 1; $j <= $antall_haller; $j++)
	{
	echo("<td bgcolor='#FFFFFF'>");
	if (file_exists("$mappenavn/_isfordeling_h_$islistenavn[$j].htm"))
		{
		echo "<a href='$mappenavn/_isfordeling_h_$islistenavn[$j].htm'>Høst</a>";
		}
	echo("<br>");
	if (file_exists("$mappenavn/_isfordeling_v_$islistenavn[$j].htm"))
		{
		echo "<a href='$mappenavn/_isfordeling_v_$islistenavn[$j].htm'>Vår</a>";
		}
	echo("</td>");
	}
		 ?>
  </tr>

</table>
<p><font size="-2">
Forklaringer:<br>
------------------------------<br>
<strong>Se istid</strong> - Klikk her for &aring; se istidene p&aring; skjermen<br>
<table><tr><td bgcolor="#C0FFC0">Den uken vi er inne i er markert</td></tr></table>
<br>
</font></p>
		</div>