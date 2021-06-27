<?php
	
	class candidatesModel
	{
		// database config
		function __construct($consetup)
		{
			$this->host = $consetup->host;
			$this->user = $consetup->user;
			$this->pass =  $consetup->pass;
			$this->db = $consetup->db;            					
		}
		// connect to database
		public function open_db()
		{
			$this->condb=new mysqli($this->host,$this->user,$this->pass,$this->db);
			if ($this->condb->connect_error) 
			{
    			die("Connection error: " . $this->condb->connect_error);
			}
		}
		// close database
		public function close_db()
		{
			$this->condb->close();
		}	

		// insert record
		public function insertRecord($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("INSERT INTO basic_profile (first_name,last_name,email,phone,education,edu_level,industry,work_exp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
				$query->bind_param("ssssiiii",$obj->first_name,$obj->last_name,$obj->email,$obj->phone,$obj->education,$obj->edu_level,$obj->industry,$obj->work_exp);
				$query->execute();
				$res= $query->get_result();
				$last_id=$this->condb->insert_id;
				$query->close();
				$this->close_db(); 	//close database connection
				return $last_id;
			}
			catch (Exception $e) 
			{
				$this->close_db();
            	throw $e;
        	}
		}

        //update record
		public function updateRecord($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("UPDATE basic_profile SET first_name=?,last_name=?,phone=?,education=?,edu_level=?,industry=?,work_exp=? WHERE email=?");
				$query->bind_param("sssiiiis", $obj->first_name,$obj->last_name,$obj->phone,$obj->education,$obj->edu_level,$obj->industry,$obj->work_exp,$obj->email);
				$query->execute();
				$res=$query->get_result();
				$query->close();
				$this->close_db();
				return true;
			}
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}
        }   

        // select record     
		public function selectRecord($email)
		{			
			try
			{
                $this->open_db();              
				$query=$this->condb->prepare("SELECT id FROM basic_profile WHERE email=?");
				$query->bind_param("s",$email);
								
				$query->execute();
				$res=$query->get_result();	
				$query->close();				
				$this->close_db();   				
                return $res;
			}
			catch(Exception $e)
			{
				$this->close_db();
				throw $e; 	
			}
			
		}
	}

?>