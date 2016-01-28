<?php 
 include_once("../includes/header.inc.php");

	require_once("../Classes/Db.class.php");
	require_once("../Classes/Post.class.php");
	
	if(isset($PARAMS['id'])){
		
		$post = new Post();
		$post->id=$PARAMS['id'];
		$post->Find();
		if($post->variables){
			session_start();
			if(isset($_SESSION['username'])){
				$db = new Db();
				$post = $post->variables;
				$liked=$db->query("select id from likes where postId= :id AND username = :username", array('id'=>$post['id'], "username"=>$_SESSION['username']));
				if($liked){
					
					$post->variables['likable'] = 0;
					echo json_encode(array("status"=>"OK", "content" => $post));
					
				}else{

					$post['likable'] = 1;
					echo json_encode(array("status"=>"OK", "content" => $post));
					
				}
			}else{
				$post = $post->variables;
				echo json_encode(array("status"=>"OK", "content" => $post));
			}
			
		}else{
			
			echo json_encode(array("status"=>"postNotFound"));
			
		}
		
	}else{
		
		echo json_encode(array("status"=>"wrongData"));
		
	}
?>