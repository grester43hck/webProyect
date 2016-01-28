<?php

 include_once("../includes/header.inc.php");
	
	if(isset($PARAMS['id'])){

		require_once("../Classes/Db.class.php");
		require_once("../Classes/Post.class.php");

		$db = new Db();
		$db->bind("id", $PARAMS['id']);
		$comments = $db->query("SELECT * FROM comments where postId = :id AND (delete_date is null or delete_date='') AND (referId not in (select id from comments where delete_date is not null or delete_date<>'')) order by id desc");
		if($comments){
			$response = array();
			$aux = array();

			foreach($comments as $comment => $c){
				if($c['referId']){

					//ES RESPUESTA A OTRO COMENTARIO
					if(isset($response[$c['id']]['content']))array_push($response[$c['id']]['content'],$c);
					else $response[$c['id']]['content']=$c;
					if(isset($response[$c['referId']]['content']))array_push($response[$c['referId']]['content'],$response[$c['id']]);
					else $response[$c['referId']]['content']=array($response[$c['id']]);
					
				}else{
					
					//COMENTARIO BASE
					$response[$c['id']]['content']=$c;
					
				}
				
			}
			foreach($response as $r){
				
				if(!$r['content']['referId']) array_push($aux, $r);
				
			}
			$response=$aux;
			echo json_encode(array("status"=>"OK", "comments"=>$response));
		}else{
			echo json_encode(array("status"=>"ceroComments"));
		}
	
	}else{
		
		echo json_encode(array("status"=>"wrongData"));
		
	}
	
	

?>