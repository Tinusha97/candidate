<?php
	session_unset();     
	require_once  'controller/candidatesController.php';		
    $controller = new candidatesController();	// view pages
    $controller->mvcHandler(); 
?>