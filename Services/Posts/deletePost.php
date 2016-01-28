<?php 
 include_once("../includes/header.inc.php");
  $REQUIRED_USER_LEVEL=2;//NIVEL DE USUARIO MINIMO REQUERIDO
 include_once("../includes/needLogIn.inc.php");

	require_once("../Classes/Post.class.php");
   
	if(isset($PARAMS['id'])){
   
		$post = new Post();
		$post->id = $PARAMS['id'];
		$post->Find();
		
		if($post->variables&&!$post->delete_date&&$post->username==$_SESSION['username']){
			
			$post->delete_date = date("Ymd");
			$post->Save();
			
			echo json_encode(array("status"=>"OK"));			
			
		}else{
			
			echo json_encode(array("status"=>"unknowPost"));
			
		}

	}else{
		
		echo json_encode(array("status"=>"wrongData"));
		
	}

?>