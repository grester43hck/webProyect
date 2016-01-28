   <?php 
 include_once("../includes/header.inc.php");

   require_once("../Classes/User.class.php");
   require_once("../Classes/VerifyEmail.class.php");
   
   $user  = new User();
   $VEmail  = new VerifyEmail();
   
   if(isset($PARAMS['username']) && isset($PARAMS['password']) && isset($PARAMS['email'])){
   
   $user->username = $PARAMS['username'];
   $user->Find();
		if(!$user->variables){
			
			$VEmail->email = $PARAMS['email'];
			$VEmail->Find();
			
			if(!$VEmail->variables){
   
				$user->username = $PARAMS['username'];
				$user->password = md5(base64_encode($PARAMS['password']));
				$user->create_date = date("Ymd");
				$user->email = $PARAMS['email'];
				$user->Create();
				
				$VEmail->email = $PARAMS['email'];
				$VEmail->code = getNewCode();
				$VEmail->username = $PARAMS['username'];
				$VEmail->Create();
				
				sendVerificationEmail($VEmail->email, $user->username, $VEmail->code);
			   
				$datos = array("status"=>"OK");
						
				print_r(json_encode($datos));
			   
			}elseif(!$VEmail->verified){
							
				$datos = array("status"=>"inUseNotVerified");
					   
				print_r(json_encode($datos));
							
			
			}else{
				
				$datos = array("status"=>"emailInUse");
					   
				print_r(json_encode($datos));
				
			}
		   
		}else{
			
				$datos = array("status"=>"UsernameInUse");
				   
				print_r(json_encode($datos));
			
		}
   
   }else{
	   
				$datos = array("status"=>"wrongData");
				   
				print_r(json_encode($datos));
	   
   }
   
   function getNewCode(){
	   
			$chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
			srand((double)microtime()*1000000); 
			$i = 0; 
			$pass = '' ; 

			while ($i <= 9) { 
				$num = rand() % 33; 
				$tmp = substr($chars, $num, 1); 
				$pass = $pass . $tmp; 
				$i++; 
			} 

			return $pass; 
	   
   }
   
   function sendVerificationEmail($email, $name, $code){
	   
		$to      = $email; // Send email to our user
		$subject = 'Email verification'; // Give the email a subject 
		$message = '
		 
		Thanks for signing up!
		Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
		 
		------------------------
		Username: '.$name.'
		Email: '.$email.'
		------------------------
		 
		Please click this link to activate your account:
		http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$code.'&u='.$name.'
		 
		'; // Our message above including the link
							 
		$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
		mail($to, $subject, $message, $headers); // Send our email
	   
   }
   
   ?>