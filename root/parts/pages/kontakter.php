		<div class="news" style="padding-left: 10px; margin-right: -10px">
			<?php
require './include_now.php';
require './include_dblogon.php';
?>
<h2>Kontakter <?php echo($sesong)?></h2>
<?php
if ($_REQUEST['klubb']=='')
	{
	$klubb_id=0;
	}
else
	{
	$klubb_id=$_REQUEST['klubb'];
	}
//leser klubblisten
$sqlstring = "select * from stihk_klubber WHERE klubb_aktiv = 1 ORDER BY klubb_navn ASC;";
$retid_klubber = mysql_db_query($db, $sqlstring, $cid);
if (!$retid_klubber) { echo( mysql_error()); }
?>
<form name="kriterier" action="kontakter.php" method="post">
<table border="1" cellpadding="2" bgcolor="#CCCCCC" bordercolor="#666666" cellspacing="1">
<tr><td bgcolor="#FFFFFF">Klubb</td><td bgcolor="#FFFF80">
<select class="fet" name="klubb" onchange="{document.kriterier.submit()}">
<?php
if ($klubb_id==0)
	{
	echo("<option value=0 selected>Velg klubb</option>");
	echo("<option value=-1>Alle klubber</option>");
	}
elseif ($klubb_id==-1)
	{
	echo("<option value=0>Velg klubb</option>");
	echo("<option value=-1 selected>Alle klubber</option>");
	}
else
	{
	echo("<option value=0>Velg klubb</option>");
	echo("<option value=-1>Alle klubber</option>");
	}
while ($row = mysql_fetch_array($retid_klubber))
	{
	$row_klubb_id = $row['klubb_id'];
	$row_klubb_navn = $row['klubb_navn'];
	if ($row_klubb_id == $klubb_id)
		{
		echo("<option value=$row_klubb_id selected>$row_klubb_navn</option>");
		}
	else
		{
		echo("<option value=$row_klubb_id>$row_klubb_navn</option>");
		}
	}
?>
</select>
</td></tr>
</table>
</form>
<?php
if ($klubb_id == 0)
	{
	echo("(Ingen klubb valgt)");
	}
else
	{
	mysql_data_seek($retid_klubber,0);
	while ($row = mysql_fetch_array($retid_klubber))
		{
		$row_klubb_id = $row['klubb_id'];
		$row_klubb_navn = $row['klubb_navn'];
		if ($row_klubb_id == $klubb_id || $klubb_id == -1)
			{
			//leser data for valgt klubb
			$sqlstring = "select * from stihk_klubber WHERE klubb_id = '$row_klubb_id';";
			$retid_valgt_klubb = mysql_db_query($db, $sqlstring, $cid);
			if (!$retid_valgt_klubb) { echo( mysql_error()); }
			//leser valgt klubbs kontakter
			$sqlstring = "select * from stihk_klubber_verv RIGHT OUTER JOIN stihk_personer ON stihk_klubber_verv.person_id = stihk_personer.person_id WHERE stihk_klubber_verv.klubb_id='$row_klubb_id' ORDER BY sortering ASC, klubb_verv ASC;";
			$retid_klubber_verv = mysql_db_query($db, $sqlstring, $cid);
			if (!$retid_klubber_verv) { echo( mysql_error()); }
			//leser valgt klubbs lag
			$sqlstring = "select * from stihk_lag INNER JOIN stihk_serier ON stihk_lag.serie_id = stihk_serier.serie_id WHERE ((lag_sesong = '$sesong') and (stihk_lag.aktiv = 1) and (klubb_id = '$row_klubb_id')) ORDER BY stihk_serier.sortering ASC, stihk_lag.sortering ASC, lag_navn ASC;";
			$retid_lag = mysql_db_query($db, $sqlstring, $cid);
			if (!$retid_lag) { echo( mysql_error()); }

			$row = mysql_fetch_assoc($retid_valgt_klubb);
?>
<p>
<h1><?php echo($row['klubb_navn'])?></h1>
<?php echo($row['klubb_adr1'])?><br>
<?php if ($row['klubb_adr2']!=''){echo($row['klubb_adr2'] . "<br>");}?>
<?php if ($row['klubb_adr3']!=''){echo($row['klubb_adr3'] . "<br>");}?>
<?php echo($row['klubb_pnr'])?>  <?php echo($row['klubb_poststed'])?><br>
<br>
<strong>Drakt:</strong> <?php echo($row['klubb_drakt'])?>
</p>
<p><font size="+1">Styre</font></p>
<table border="1" cellpadding="0" bgcolor="#CCCCCC" bordercolor="#666666" cellspacing="0">
  <tr>
    <td bgcolor="#CCFFCC" class="mindre">Verv</td>
    <td></td>
    <td bgcolor="#CCFFCC" class="mindre">Navn</td>
    <td bgcolor="#CCFFCC" class="mindre">Telefon (M/P/J)</td>
    <td bgcolor="#CCFFCC" class="mindre">e-Post</td>
  </tr>
<?php
//Lister verv
while ($row = mysql_fetch_array($retid_klubber_verv))
	{
	echo("<tr><td bgcolor='#FFFFFF' class='mindre'><strong>" . $row['klubb_verv'] . "</strong></td>");
	echo("<td></td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'>" . $row['person_fnavn'] . ' ' . $row['person_enavn'] . "</td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'>" . str_replace(" ","&nbsp;",$row['person_tlf_mobil']) . '/' . str_replace(" ","&nbsp;",$row['person_tlf_privat']) . '/' . str_replace(" ","&nbsp;",$row['person_tlf_jobb']) . "</td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'><a href='mailto:" . $row['person_epost1'] . "'>" . $row['person_epost1'] . "</a></td></tr>");
	}
?>
</table>
<p><font size="+1">Lag</font></p>
<?php
//Lister lag
while ($row = mysql_fetch_array($retid_lag))
	{
?>
<table border="1" cellpadding="0" bgcolor="#CCCCCC" bordercolor="#666666" cellspacing="0">
<tr><td bgcolor="#FFFFCC" colspan="5">
<?php
	echo("<strong>" . $row['serie_kode'] . "-" . $row['lag_navn'] . "</strong>");
	if ($row['lag_antall_spillere']!=''){echo(" - " . $row['lag_antall_spillere'] . " spillere");}
	$lag_id = $row['lag_id'];
?>
</td>
</tr>
  <tr>
    <td bgcolor="#FFFFCC" class="mindre">Verv</td>
    <td></td>
    <td bgcolor="#FFFFCC" class="mindre">Navn</td>
    <td bgcolor="#FFFFCC" class="mindre">Telefon (M/P/J)</td>
    <td bgcolor="#FFFFCC" class="mindre">e-Post</td>
  </tr>

<?php
//leser lagets kontakter
$sqlstring = "select * from stihk_lag_verv RIGHT OUTER JOIN stihk_personer ON stihk_lag_verv.person_id = stihk_personer.person_id WHERE stihk_lag_verv.lag_id='$lag_id' ORDER BY stihk_lag_verv.sortering ASC, lag_verv ASC;";
$retid_lag_verv = mysql_db_query($db, $sqlstring, $cid);
if (!$retid_lag_verv) { echo( mysql_error()); }
while ($row = mysql_fetch_array($retid_lag_verv))
	{
	echo("<tr><td bgcolor='#FFFFFF' class='mindre'><strong>" . $row['lag_verv'] . "</strong></td>");
	echo("<td></td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'>" . $row['person_fnavn'] . ' ' . $row['person_enavn'] . "</td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'>" . str_replace(" ","&nbsp;",$row['person_tlf_mobil']) . '/' . str_replace(" ","&nbsp;",$row['person_tlf_privat']) . '/' . str_replace(" ","&nbsp;",$row['person_tlf_jobb']) . "</td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'><a href='mailto:" . $row['person_epost1'] . "'>" . $row['person_epost1'] . "</a></td></tr>");
	}
?>
</table>
<br>
<?php
	}
?>
<p><font size="+1">Registrerte dommere</font></p>
<table border="1" cellpadding="0" bgcolor="#CCCCCC" bordercolor="#666666" cellspacing="0">
  <tr>
    <td bgcolor="#CCFFFF" class="mindre">Type</td>
    <td></td>
    <td bgcolor="#CCFFFF" class="mindre">Navn</td>
    <td bgcolor="#CCFFFF" class="mindre">Telefon (M/P/J)</td>
    <td bgcolor="#CCFFFF" class="mindre">e-Post</td>
  </tr>

<?php
//leser klubbens dommere
$sqlstring = "SELECT * from stihk_dommere WHERE stihk_dommere.dommer_klubb='$row_klubb_id' ORDER BY dommer_enavn ASC, dommer_fnavn ASC;";
$retid_dommere = mysql_db_query($db, $sqlstring, $cid);
if (!$retid_dommere) { echo( mysql_error()); }
while ($row = mysql_fetch_array($retid_dommere))
	{
	echo("<tr><td bgcolor='#FFFFFF' class='mindre'><strong>" . $row['dommer_type'] . "</strong></td>");
	echo("<td></td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'>" . $row['dommer_fnavn'] . ' ' . $row['dommer_enavn'] . "</td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'>" . str_replace(" ","&nbsp;",$row['dommer_tlf_mobil']) . '/' . str_replace(" ","&nbsp;",$row['dommer_tlf_privat']) . '/' . str_replace(" ","&nbsp;",$row['dommer_tlf_jobb']) . "</td>");
	echo("<td bgcolor='#FFFFFF' class='mindre' align='left'><a href='mailto:" . $row['dommer_epost1'] . "'>" . $row['dommer_epost1'] . "</a></td></tr>");
	}
?>
</table>
<?php
			}
		}
	}
?>
		</div>