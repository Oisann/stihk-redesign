<?php
	session_start();
	$page = $_GET['page'];
	if(empty($page)) $page = "hjem";

	if(!file_exists("./parts/pages/" . $page . ".php")) $page = "404";
	$page_include = "./parts/pages/" . $page . ".php";

	include('./parts/header.php');
	include($page_include);
	include('./parts/footer.php');
?>