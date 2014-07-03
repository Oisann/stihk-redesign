<?php
	session_start();
	$classes = glob('./classes/*.class.php');
	foreach($classes as $class) {
		include($class);
	}
	$funksjoner = new funksjoner();
	$page = $_GET['page'];
	if(empty($page)) $page = "hjem";

	if(!file_exists("./parts/pages/" . $page . ".php")) $page = "404";
	$page_include = "./parts/pages/" . $page . ".php";

	if($page == "404") $title = "Siden kan ikke vises - Error 404";
	
	include('./parts/header.php');
	include($page_include);
	include('./parts/footer.php');
?>