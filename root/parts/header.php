<?php
	$title = empty($title) ? "STIHK" : $title;
	$description = empty($description) ? "Oversikt over sesongens kamper, hallfordelinger, dommere, generelle nyheter og alt annet som STIHK gjør." : $description;
	$keywords = empty($keywords) ? "ishockey, trondheim, sør-trøndelag, leangen, dalgård, ishall" : $keywords;
?><!doctype html>
<html class="media">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?> - Sør-Trøndelag Ishockeykrets</title>
		<meta name="description" content="<?php echo $description; ?>">
		<meta name="keywords" content="<?php echo $keywords; ?>">
		<meta name="author" content="Jonas Refseth">
		<meta name="viewport" content="width=device-width">
		<meta property="og:image" content="<?php echo $funksjoner->fix_linking(); ?>assets/img/logo.png" />
		<meta property="og:updated_time" content="<?php echo time(); ?>" />
		<link rel="icon" href="<?php echo $funksjoner->fix_linking(); ?>assets/img/favicon.png">
		<link rel="stylesheet" href="<?php echo $funksjoner->fix_linking(); ?>assets/css/style.css">
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="https://cdn.socket.io/socket.io-1.0.0.js"></script>
	</head>
	<body>
		<header>
			<a href="<?php echo $funksjoner->fix_linking(); ?>hjem" alt="STIHK - Sør-Trøndelag Ishockeykrets"><div class="logo"></div></a>
			<select class="mininav">
				<option selected disabled>-- Meny --</option>
				<option>istider</option>
				<option>serier</option>
				<option>arrangement</option>
				<option>dommere</option>
				<option>kontakter</option>
				<option disabled>-- Annet --</option>
				<option>om oss</option>
				<option>bestemmelser</option>
				<option>dokumenter</option>
				<option>rom</option>
				<option>lenker</option>
				<option>logg inn</option>
			</select>
			<table class="navigation">
				<tr>
					<td>
						<a href="<?php echo $funksjoner->fix_linking(); ?>istider" alt="Istider">istider</a>
					</td>
					<td>
						<a href="<?php echo $funksjoner->fix_linking(); ?>serier" alt="Serier">serier</a>
					</td>
					<td>
						<a href="<?php echo $funksjoner->fix_linking(); ?>arrangement" alt="Arrangement">arrangement</a>
					</td>
					<td>
						<a href="<?php echo $funksjoner->fix_linking(); ?>dommere" alt="Dommere">dommere</a>
					</td>
					<td>
						<a href="<?php echo $funksjoner->fix_linking(); ?>kontakter" alt="Kontakter">kontakter</a>
					</td>
					<td>
						<a href="#annet" alt="Annet">annet</a>
					</td>
					<td class="button">
						<a href="#logginn" alt="Logg inn">logg inn</a>
					</td>
				</tr>
			</table>
			<div class="login hidden">
				<form method="post" action="">
					<input type="text" name="username" value="" placeholder="Brukernavn" />
					<input type="password" name="password" value="" placeholder="Passord" />
					<input type="submit" name="submit" value="Logg inn" />
				</form>
			</div>
			<div class="morenav hidden">
				<table>
					<tr>
						<td>
							<a href="<?php echo $funksjoner->fix_linking(); ?>omoss" alt="Om oss">om oss</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="<?php echo $funksjoner->fix_linking(); ?>bestemmelser" alt="Bestemmelser">bestemmelser</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="<?php echo $funksjoner->fix_linking(); ?>dokumenter" alt="Dokumenter">dokumenter</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="<?php echo $funksjoner->fix_linking(); ?>rom" alt="rom">rom</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="<?php echo $funksjoner->fix_linking(); ?>lenker" alt="Lenker">lenker</a>
						</td>
					</tr>
				</table>
			</div>
		</header>
		<div class="header">
			<div class="background"></div>
			<div class="weather">
				<table>
					<tr>
						<td class="headline">Trondheim Sentrum</td>
					</tr>
					<tr>
						<td location="trondheim" class="center"><span class="loading" title="Loading..."></span></td>
					</tr>
					<tr>
						<td class="celsius"><span class="temperature" location="trondheim">N/A</span> °C</td>
					</tr>
					<tr>
						<td class="headline">Hølonda Utebane</td>
					</tr>
					<tr>
						<td location="korsvegen" class="center"><span class="loading" title="Loading..."></span></td>
					</tr>
					<tr>
						<td class="celsius"><span class="temperature" location="korsvegen">N/A</span> °C</td>
					</tr>
				</table>
			</div>
			<div class="clock"></div>
			<div class="newsfeed"><strong>OBS!:</strong> Denne siden er under utvikling...</div>
		</div>
		<div class="shadow"></div>