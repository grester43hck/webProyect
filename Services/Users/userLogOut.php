<?php 
 include_once("../includes/header.inc.php");
 include_once("../includes/needLogIn.inc.php");

	unset($_SESSION['username']);
	session_destroy();
	
		$datos = array("status"=>"OK");
		   
		print_r(json_encode($datos));

?>