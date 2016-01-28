<?php 
 include_once("../includes/header.inc.php");

   require_once("../Classes/User.class.php");
   
   $user  = new User();
   
   if(isset($PARAMS['username']) && isset($PARAMS['password'])){
	   
	   $u = $PARAMS['username'];
	   $p = $PARAMS['password'];
	   
	   $user->username = $u;		
	   $user->Find();
	   
	   if($user->variables&&$user->delete_date==""&&md5(base64_encode($p))==($user->password)){
	   
			if(!$user->banned){
				
				$user->lastip = getIP();
				$user->Save();
		   
				session_start();
				$_SESSION['username'] = $user->username;
		   
				$datos = array("status"=>"OK", "name"=>$user->username, "level"=>$user->userLevel, "signedin"=>$user->create_date, "email"=>$user->email);
				   
				print_r(json_encode($datos));
				
			}else{
				
				$datos = array("status"=>"banned", "reasson"=>$user->reasson);
				   
				print_r(json_encode($datos));
				
			}
	   
	   }else if($user->variables&&$user->delete_date==""&&md5(base64_encode($p))!=($user->password)){

		   $datos = array("status"=>"WrongPassword");
		   
		   print_r(json_encode($datos));
	   
	   }else if(!$user->variables||$user->delete_date!=""){
		   
		   $datos = array("status"=>"NoResults");
		   
		   print_r(json_encode($datos));
		   
		   
	   }

   
   }else{
	   
			$datos = array("status"=>"WrongData");
		   
			print_r(json_encode($datos));
	   
   }
   
   	function getIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}

?>
