<?php 
 include_once("../includes/header.inc.php");

   require_once("../Classes/User.class.php");
   require_once("../Classes/VerifyEmail.class.php");
   
   $user  = new User();
   $VEmail  = new VerifyEmail();
   
   if(isset($PARAMS['email']) && isset($PARAMS['hash']) && isset($PARAMS['u'])){
	   
	   $username = $PARAMS['u'];
	   $code = $PARAMS['hash'];
	   $email = $PARAMS['email'];
	   
	   $VEmail->email = $email;		
	   $VEmail->Find();
	   
	   if($VEmail->variables&&!$VEmail->verified&&$VEmail->username==$username&&$VEmail->code==$code){
	   
			$user->username = $username;
			$user->Find();
			
			$user->verified=1;
			$user->userLevel=2;
			$user->Save();
			
			$VEmail->verified = 1;
			$VEmail->Save();
	   
		   $datos = array("status"=>"OK");
		   
		   print_r(json_encode($datos));
	   
	   }else if($VEmail->variables&&$VEmail->verified&&$VEmail->username==$username&&$VEmail->code==$code){

		   $datos = array("status"=>"alreadyVerified");
		   
		   print_r(json_encode($datos));
	   
	   }else{
		   
		   $datos = array("status"=>"NoResults");
		   
		   print_r(json_encode($datos));
		   
		   
	   }

   
   }else{
	   
			$datos = array("status"=>"WrongData");
		   
			print_r(json_encode($datos));
	   
   }
   
?>
