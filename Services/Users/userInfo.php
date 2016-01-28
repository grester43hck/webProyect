<?php 
 include_once("../includes/header.inc.php");
 include_once("../includes/needLogIn.inc.php");
	
	require_once("../Classes/User.class.php");
	$user  = new User();

	$user->username = $_SESSION['username'];
	$user->Find();
	
	if($user->variables){
	
		$datos = array("status"=>"OK", "name"=>$user->username, "level"=>$user->userLevel, "signedin"=>$user->create_date, "email"=>$user->email);
		   
		print_r(json_encode($datos));
	
	}else{
		
		$datos = array("status"=>"userNotFound");
		   
		print_r(json_encode($datos));
		
	}
	
?>