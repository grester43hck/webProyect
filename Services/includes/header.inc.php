<?php 
header('Content-Type: application/json');
	//ASOCIACION DE PARAMETROS
	$PARAMS = $_GET;
	
	//FILTRO DE AUTOLIMPIADO POR NUMERO DE REPORTS/LIKES
	$AUTO_CLEAN_REPORTED= "(reports<10 OR reports<likes)"; 
?>