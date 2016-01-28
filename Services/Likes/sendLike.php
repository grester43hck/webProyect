<?php

$autoverify=true; //AUTOVERIFICACIÃ“N DE POSTS ACTIVO/DESACTIVO
$minLikesToVerify = 20; //MÃ?NIMO DE LIKES PARA LA VERIFICACIÃ“N
$maxReportToVerify = 15; //MÃ?XIMO DE REPORTS PARA LA VERIFICACIÃ“N

 include_once("../includes/header.inc.php");
 include_once("../includes/needLogIn.inc.php");
 
 require_once("../Classes/Like.class.php");
 require_once("../Classes/Post.class.php");
 require_once("../Classes/DB.class.php");
 
 if(isset($PARAMS['id'])){
	 
	 $post = new Post();
	 $post->id = $PARAMS['id'];
	 $post->Find();
	 if($post->variables){
		 $db = new Db();
		 $liked=$db->query("select id from likes where postId= :id AND username = :username", array('id'=>$PARAMS['id'], "username"=>$_SESSION['username']));
		 if($liked){
			 
			 $like = new Like();
			 $like->Find($liked[0]['id']);
			 $like->Delete();
			 echo json_encode(array("status"=>"OK"));
		 }else{
			 
			 $like = new Like();
			 $like->postId=$PARAMS['id'];
			 $like->username = $_SESSION["username"];
			 $like->Create();
			 
			 //AUTOVERIFICACION DE POST 
			 if($autoverify){
				$db->bind("id", $PARAMS['id']);
				$aux = $db->query("SELECT * FROM view_posts_valoracion WHERE id = :id");
				$aux = $aux[0];

				if($aux['likes']>=$minLikesToVerify&&$aux['reports']<=$maxReportToVerify&&!$aux['verified']){
					 $post->Find();
					 $post->verified=1;
					 $post->Save();
				}
				 
			 }
				
			 echo json_encode(array("status"=>"OK"));
		 }
	 }else{
		 echo json_encode(array("status"=>"postNotFound"));
	 }
 }else{
	 echo json_encode(array("status"=>"wrongData"));
 }
 
 ?>