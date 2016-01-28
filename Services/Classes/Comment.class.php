<?php 
	require_once("easyCRUD.class.php");

	class Comment  Extends Crud {
		
			# Your Table name 
			protected $table = 'comments';
			
			# Primary Key of the Table
			protected $pk	 = 'id';
	}

?>