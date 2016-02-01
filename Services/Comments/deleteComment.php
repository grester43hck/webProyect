<?php

 include_once("../includes/header.inc.php");
  $REQUIRED_USER_LEVEL="LoggedVerified";//NIVEL DE USUARIO MINIMO REQUERIDO
 include_once("../includes/needLogIn.inc.php");
 
  require_once("../Classes/Comment.class.php");
  
  if(isset($PARAMS['id'])){
	  
	  $c = new Comment();
	  $c->id = $PARAMS['id'];
	  $c->Find();

	  if($c->variables){
		  
		  if($c->username == $_SESSION['username'] && !$c->delete_date){
			  
			  $c->delete_date = date("Ymd");
			  $c->Save();

			  echo json_encode(array("status"=>"OK"));
			  
		  }else{
			  
			  echo json_encode(array("status"=>"commentNotFound"));
			  
		  }
		  
	  }else{
		  
		  echo json_encode(array("status"=>"commentNotFound"));
		  
	  }
	  
  }else{
	  
	  echo json_encode(array("status"=>"wrongData"));
	  
  }
  
 ?>