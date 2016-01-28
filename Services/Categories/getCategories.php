<?php 
 include_once("../includes/header.inc.php");


	require_once("../Classes/Db.class.php");
   
	$db = new Db();
   
	$categories = $db->query("Select id, name, URI from categories where active=1");
	
	echo json_encode(array("status"=>"OK", "content"=>$categories));
	

?>