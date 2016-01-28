<?php 
	require_once("easyCRUD.class.php");

	class Like  Extends Crud {
		
			# Your Table name 
			protected $table = 'likes';
			
			# Primary Key of the Table
			protected $pk	 = 'id';
	}

?>