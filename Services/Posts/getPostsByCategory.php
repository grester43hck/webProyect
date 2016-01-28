<?php 
 include_once("../includes/header.inc.php");

	if(isset($PARAMS['id'])){
	 
		require_once("../Classes/Db.class.php");
		$db = new Db();
		session_start();

		//INITIAL CONF.
		$initial = 0; //INDEX INICIAL POR DEFECTO
		$final = $initial + 10; //POST POR PETICION POR DEFECTO
		$verified = 1; //SACAR EN-VOTACION/VERIFICADOS (0/1)
		$cat = 'category' . $PARAMS['id']; //CATEGORIA PARA MINIMO INDICE DE ID
		
		if(isset($PARAMS['from'])) $initial = $PARAMS['from'];
		if(isset($PARAMS['postN'])) $final = $PARAMS['postN'];
		if(!$initial && isset($_SESSION[$cat])) unset($_SESSION[$cat]);
		
		$SQL = "SELECT * FROM view_posts_valoracion WHERE ".$AUTO_CLEAN_REPORTED." AND verified = :verified AND categoryId = :id";
		$db->bind("verified", $verified);
		$db->bind("id", $PARAMS['id']);
		
		if(isset($_SESSION[$cat])){ //APLICACION  DEL INDICE DE ID MINIMO EN CASO DE EXISTIR
			$SQL .= " AND id<:id";
			$db->bind("id", $_SESSION[$cat]);
		}
		
		$db->bind("initial", $initial);
		$db->bind("final", $final);
		$SQL .= " LIMIT :initial, :final";
		
		$posts = $db->query($SQL);
		
		if(!isset($_SESSION[$cat])) $_SESSION[$cat] = $posts[0]['id'];

		//SI ESTA LOGEADO SE AÑADEN LOS CAMPOS likable Y likeId AL ARRAY
		
		if(isset($_SESSION['username'])){
			
			$db = new Db();
			$user = $_SESSION['username'];
			
			foreach($posts as &$p){
				
				$id = $p['id'];
				$db->bind("id", $id);
				$db->bind("user", $user);
				$liked = $db->query("SELECT id FROM likes WHERE postId = :id AND username = :user");
			
				if($liked){
					$likable = 0;
				} 
				else $likable = 1;
				
				$p['likable']=$likable;
				if(!$likable) $p['likeId']=$likeId;
			}
			
		}
		print_r($posts);
		if($posts) echo json_encode($posts);
		else echo json_encode(array("status"=>"noPostsFound"));
		
	}else{
		
		echo json_encode(array("status"=>"wrongData"));
		
	}

?>