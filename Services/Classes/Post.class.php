<?php 
	require_once("easyCRUD.class.php");

	class Post  Extends Crud {
		
			# Your Table name 
			protected $table = 'posts';
			
			# Primary Key of the Table
			protected $pk	 = 'id';
	}

?>