<?php 
	require_once("../Classes/User.class.php");
	session_start();

	if(!isset($_SESSION['username'])){
		
		echo json_encode(array("status"=>"needLogIn"));
		exit();
		
	}else{
		
		$user = new User();
		$user->username = $_SESSION['username'];
		$user->Find();
		$USER_DATA = array();
		$USER_DATA = $user->variables; //USER_DATA CONTIENE TODOS LOS DATOS DEL USUARIO ACTIVO
		
		//VERIFICACION DE NIVEL DE USUARIO
		//USAR $REQUIRED_USER_LEVEL=%NIVEL% ANTES DEL INCLUDE DE ESTE ARCHIVO.
		if(isset($REQUIRED_USER_LEVEL) && $USER_DATA['userLevel']<$REQUIRED_USER_LEVEL){ 
			
			echo json_encode(array("status"=>"needMoreUserLevel"));
			exit();
			
		}elseif($user->banned){

			echo json_encode(array("status"=>"banned", "reasson"=>$user->reasson));
			exit();

		}

	}
?>