<?php 
	require_once("easyCRUD.class.php");

	class User  Extends Crud {
		
			# Your Table name 
			protected $table = 'users';
			
			# Primary Key of the Table
			protected $pk	 = 'username';
	}

?>