<?php

 include_once("../includes/header.inc.php");
  $REQUIRED_USER_LEVEL="LoggedVerified";//NIVEL DE USUARIO MINIMO REQUERIDO
 include_once("../includes/needLogIn.inc.php");
 
 require_once("../Classes/Comment.class.php");
 require_once("../Classes/Post.class.php");
 
 if(isset($PARAMS['id']) && isset($PARAMS['content'])){
	 
	 $post = new Post();
	 $post->id=$PARAMS['id'];
	 $post->Find();
	 if($post->variables){
		 
		 if(!isset($PARAMS['referId'])){
			 
			 //COMENTARIO BASE
			 $comment = new Comment();
			 $comment->postId = $PARAMS['id'];
			 $comment->content = $PARAMS['content'];
			 $comment->create_date = date("Ymd");
			 $comment->create_hour = date("G:i:s");
			 $comment->username = $_SESSION['username'];
			 $comment->Create();
			 echo json_encode(array("status"=>"OK"));
			 
		 }else{
			 
			 //CONTESTACION
			 $c = new Comment();
			 $c->id = $PARAMS['referId'];
			 $c->Find();
			 
			 if($c->variables && $c->postId = $PARAMS['id']){
				 
				 $comment = new Comment();
				 $comment->postId = $PARAMS['id'];
				 $comment->content = $PARAMS['content'];
				 $comment->create_date = date("Ymd");
				 $comment->create_hour = date("G:i:s");
				 $comment->username = $_SESSION['username'];
				 $comment->referId = $PARAMS['referId'];
				 $comment->Create();
				 echo json_encode(array("status"=>"OK"));
			 
			 }else{
				 
				 echo json_encode(array("status"=>"referNotFound"));
				 
			 }
			 
		 }
		 
	 }else{
		 
		 echo json_encode(array("status"=>"postNotFound"));
		 
	 }
	 
 }else{
	 
	 echo json_encode(array("status"=>"wrongData"));
	 
 }
 
 
 ?>
