<?php 
 include_once("../includes/header.inc.php");
 include_once("../includes/needLogIn.inc.php");
   
   require_once("../Classes/User.class.php");
   
   $user  = new User();
   
  if(isset($PARAMS['password']) && isset($PARAMS['newPassword'])){
	   
	   $u = $_SESSION['username'];
	   $p = $PARAMS['password'];
	   $p2 = $PARAMS['newPassword'];
	   
	   $user->username = $u;		
	   $user->Find();
	   
	   if($user->variables&&$user->delete_date==""&&md5(base64_encode($p))==($user->password)){
	   
			$user->password = md5(base64_encode($p2));
			$user->Save();
	   
		   $datos = array("status"=>"OK");
		   
		   print_r(json_encode($datos));
	   
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
	   
	?>