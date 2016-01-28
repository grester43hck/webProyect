<?php

 include_once("../includes/header.inc.php");
	
	if(isset($PARAMS['username'])){

		require_once("../Classes/Db.class.php");

		$db = new Db();
		$db->bind("username", $PARAMS['username']);
		$posts = $db->query("SELECT * FROM `view_posts_valoracion` where (reports<10 or reports<likes) AND username = :username");
		if($posts){
			echo json_encode(array("status"=>"OK", "content"=>$posts));
		}else{
			echo json_encode(array("status"=>"ceroPosts"));
		}
	
	}else{
		
		echo json_encode(array("status"=>"wrongData"));
		
	}

?>