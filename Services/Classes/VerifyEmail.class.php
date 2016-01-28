<?php 
	require_once("easyCRUD.class.php");

	class VerifyEmail Extends Crud {
		
			# Your Table name 
			protected $table = 'verify_email';
			
			# Primary Key of the Table
			protected $pk	 = 'email';
	}

?>