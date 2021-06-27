<?php

// Database connection
class config  
{	
	function __construct() {
		$this->host = "localhost";		//host name
		$this->user  = "root";			//database user
		$this->pass = "";				//database password
		$this->db = "candidatesdb";		//database name
	}
}

?>