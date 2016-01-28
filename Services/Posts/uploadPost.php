<?php 
 include_once("../includes/header.inc.php");
 $REQUIRED_USER_LEVEL=2;//NIVEL DE USUARIO MINIMO REQUERIDO
 include_once("../includes/needLogIn.inc.php");

	require_once("../Classes/Post.class.php");
	require_once("../Classes/Category.class.php");
   
	if(isset($PARAMS['categoryId']) && isset($PARAMS['type']) && isset($PARAMS['title'])){
   
		$post = new Post();
		$cat = new Category();
		
		$cat->id = $PARAMS['categoryId'];
		$cat->Find();
		
		if($cat->variables){

			$post->categoryId = $PARAMS['categoryId'];
			$post->media = $_FILES['media']['name'].$d;
			$post->type = $PARAMS['type'];
			$post->create_date = date("Ymd");
			$post->create_hour = date("G:i:s");
			$post->username = $_SESSION['username'];
			$post->title = $PARAMS['title'];
			if(isset($PARAMS['content'])) $post->content = $PARAMS['content'];
			$post->Create();

			echo json_encode(array("status"=>"OK"));
		
		}else{
			
			echo json_encode(array("status"=>"unknowCategory"));
			
		}

	}else{
		
		echo json_encode(array("status"=>"wrongData"));
		
	}

?>