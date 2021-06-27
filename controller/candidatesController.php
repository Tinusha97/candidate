<?php
    require 'model/candidatesModel.php';
    require 'model/candidates.php';
    require_once 'config.php';
    require_once 'phpmailer_class.php';
    require_once 'mpdf_class.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class candidatesController 
	{ 

 		function __construct() 
		{
			$this->objconfig = new config();
			$this->objsm =  new candidatesModel($this->objconfig);
		}

        // mvc handler request
		public function mvcHandler() 
		{                       
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) 
			{
                case 'add' :
					$this->insert();
					break;				
				default:
                    $this->list();
			}
		}	

        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}

        //Default page
        public function list(){                     
            include "view/insert.php";                                        
        }
        
        // validation
		public function checkValidation($candidatestbl)
        {
            $noerror=true;       
            // Validate inputs
            if(isset($candidatestbl->recaptcha) && !empty($candidatestbl->recaptcha)){
                // Google secret API
                $secretAPIkey = '6LfcAFcbAAAAAA0XRwH5WKOwgnucFs2da1sl2Vdb';

                // reCAPTCHA response verification
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$candidatestbl->recaptcha);

                // Decode JSON data
                $response = json_decode($verifyResponse);
                    if($response->success){
                        $noerror=true;
                    }else{
                        $candidatestbl->robot_msg = "Robot verification failed, please try again.";
                        $noerror=false;
                    }
            }else{
                $candidatestbl->robot_msg = "Robot verification failed, please try again.";
                $noerror=false;
            }
            if(empty($candidatestbl->last_name)){
                $candidatestbl->last_name_msg = "Field is empty.";
                $noerror=false;
            }elseif(!filter_var($candidatestbl->last_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $candidatestbl->last_name_msg = "Invalid entry.";
                $noerror=false;
            }else{
                $candidatestbl->last_name_msg ="";
            }
            if(empty($candidatestbl->email)){
                $candidatestbl->email_msg = "Field is empty.";
                $noerror=false;
            }elseif(!filter_var($candidatestbl->email, FILTER_VALIDATE_EMAIL)){
                $candidatestbl->email_msg = "Invalid email format.";
                $noerror=false;
            }else{
                $candidatestbl->email_msg ="";
            }
            if(empty($candidatestbl->education)){
                $candidatestbl->education_msg = "Field is empty.";
                $noerror=false;
            }else{
                $candidatestbl->education_msg ="";
            } 
            if(empty($candidatestbl->edu_level)){
                $candidatestbl->edu_level_msg = "Field is empty.";
                $noerror=false;
            }
            if(empty($candidatestbl->industry)){
                $candidatestbl->industry_msg = "Field is empty.";
                $noerror=false;
            }
            if(empty($candidatestbl->work_exp) && $candidatestbl->industry != '5'){
                $candidatestbl->work_exp_msg = "Field is empty.";
                $noerror=false;
            }                        

            return $noerror;
        }

        // add new record
		public function insert()
		{       
           
            try{
                $candidatestbl = new candidates();
                if (isset($_POST['addbtn'])) 
                {                   
                    // read form value
                    $candidatestbl->recaptcha = $_POST['g-recaptcha-response'];
                    $candidatestbl->first_name = trim($_POST['firstname']);
                    $candidatestbl->last_name = trim($_POST['lastname']);
                    $candidatestbl->email = trim($_POST['email']);
                    $candidatestbl->phone = trim($_POST['phone']);
                    $candidatestbl->education = trim($_POST['education']);
                    $candidatestbl->edu_level = trim($_POST['edu_level']);
                    $candidatestbl->industry = trim($_POST['industry']);
                    $candidatestbl->work_exp = trim($_POST['work_exp']);

                    //get education name
                    switch ($candidatestbl->education) {
                        case '1':
                            $education = 'Software Engineering';
                            break;
                        case '2':
                            $education = 'Information Technology';
                            break;
                        case '3':
                            $education = 'Computer Science';
                            break;
                        case '4':
                            $education = 'Computer Application';
                            break;
                        case '5':
                            $education = 'Others';
                            break;
                        default:
                            $education = '-';
                    }

                    //get education level name
                    switch ($candidatestbl->edu_level) {
                        case '1':
                            $edu_level = 'Post Graduate';
                            break;
                        case '2':
                            $edu_level = 'Under Graduate';
                            break;
                        case '3':
                            $edu_level = 'Diploma';
                            break;
                        case '4':
                            $edu_level = 'Others';
                            break;                        
                        default:
                            $edu_level = '-';
                    }

                    //get industry name
                    switch ($candidatestbl->industry) {
                        case '1':
                            $industry = 'Software Engineering';
                            break;
                        case '2':
                            $industry = 'QA Automation';
                            break;
                        case '3':
                            $industry = 'Database administration';
                            break;
                        case '4':
                            $industry = 'System Administration';
                            break;
                        case '5':
                            $industry = 'N/A';
                            break;
                        default:
                            $industry = '-';
                    }

                    //get work experience
                    switch ($candidatestbl->work_exp) {
                        case '1':
                            $work_exp = '1 Yr';
                            break;
                        case '2':
                            $work_exp = '2 Yrs';
                            break;
                        case '3':
                            $work_exp = '3 Yrs';
                            break;
                        case '4':
                            $work_exp = '4 Yrs';
                            break;
                        case '5':
                            $work_exp = '5 Yrs';
                            break;
                        case '6':
                            $work_exp = '6 Yrs';
                            break;
                        case '7':
                            $work_exp = 'More than 6 Yrs';
                            break;
                        default:
                            $work_exp = '';
                    }

                    //call validation
                    $validate = $this->checkValidation($candidatestbl);   
                
                    if($validate)
                    {
                        //check existing record
                        $pid = $this -> objsm ->selectRecord($candidatestbl->email);                        

                        if ($pid->num_rows == 0) {
                            //insert record                                    
                            $lid = $this -> objsm ->insertRecord($candidatestbl);
                            if($lid>0){
                                //send email to nulosoft
                                $email_send = new phpmailer_class();                                
                                $user_email = 'developer@nulosoft.com.au';
                                
                                $message = '<h2>New Candidate Details</h2>';
                                $message .= '<br>First Name - '.$candidatestbl->first_name;
                                $message .= '<br>Last Name - '.$candidatestbl->last_name;
                                $message .= '<br>Email - '.$candidatestbl->email;
                                $message .= '<br>Phone - '.$candidatestbl->phone;
                                $message .= '<br>Education - '.$education;
                                $message .= '<br>Education Level - '.$edu_level;
                                $message .= '<br>Industry - '.$industry;
                                $message .= '<br>Work Experience - '.$work_exp;

                                $subject = 'New Application';
                                $email_send->sendMail1($user_email,$message,$subject,'','');
                                
                                //create pdf
                                if ($education == 'Others' || $edu_level == 'Others' || $industry == 'N/A' || $work_exp == '3 Yrs' || $work_exp == '2 Yrs' || $work_exp == '1 Yr') {
                                    $decision = "Not selected this time";   //Working Industry field doesn't have an other option. I used N/A instead of Other
                                } else {
                                    $decision = "Selected to next round";
                                }

                                $unique_code = md5(time());
                                $directory = 'assets/['.$unique_code.']_'.$candidatestbl->first_name.'_'.$candidatestbl->last_name.'.pdf';
                                $attachment = 'attachment.pdf';
                                $create_pdf = new mpdf_class();
                                $create_pdf->create_pdf($candidatestbl->first_name.' '.$candidatestbl->last_name,$decision,$directory);

                                //send pdf to applicant
                                $email_send->sendMail1($candidatestbl->email,'Thank you for your application','Thank you for your application',$directory,$attachment);

                                $this->list();
                            }else{
                                echo "Something is wrong..., try again.";
                            }
                        }else{
                            $stt = $this -> objsm ->updateRecord($candidatestbl);
                            if($stt>0){	
                                //send email
                                $email_send = new phpmailer_class();
                                $user_email = 'ntinusha@gmail.com';

                                $message = '<h2>New Candidate Details</h2>';
                                $message .= '<br>First Name - '.$candidatestbl->first_name;
                                $message .= '<br>Last Name - '.$candidatestbl->last_name;
                                $message .= '<br>Email - '.$candidatestbl->email;
                                $message .= '<br>Phone - '.$candidatestbl->phone;
                                $message .= '<br>Education - '.$education;
                                $message .= '<br>Education Level - '.$edu_level;
                                $message .= '<br>Industry - '.$industry;
                                $message .= '<br>Work Experience - '.$work_exp;

                                $subject = 'New Application';
                                $email_send->sendMail1($user_email,$message,$subject,'','');		

                                //create pdf
                                if ($education == 'Others' || $edu_level == 'Others' || $industry == 'N/A' || $work_exp == '3 Yrs' || $work_exp == '2 Yrs' || $work_exp == '1 Yr') {
                                    $decision = "Not selected this time";   //Working Industry field doesn't have an other option. I used N/A instead of Other
                                } else {
                                    $decision = "Selected to next round";
                                }

                                $unique_code = md5(time());
                                $directory = 'assets/['.$unique_code.']_'.$candidatestbl->first_name.'_'.$candidatestbl->last_name.'.pdf';
                                $attachment = 'attachment.pdf';
                                $create_pdf = new mpdf_class();
                                $create_pdf->create_pdf($candidatestbl->first_name.' '.$candidatestbl->last_name,$decision,$directory);

                                //send pdf to applicant
                                $email_send->sendMail1($candidatestbl->email,'Thank you for your application','Thank you for your application',$directory,$attachment);

                                $this->list();
                            }else{
                                echo "Something is wrong..., try again.";
                            }
                        }                        

                    }else
                    {    
                        $_SESSION['candidatestbl0']=serialize($candidatestbl);     //add session obj                                                         
                        // $this->pageRedirect("view/insert.php");                                    
                    }
                }
            }catch (Exception $e)
            {
                $this->close_db();
                throw $e;
            }
        }

    }
		
?>