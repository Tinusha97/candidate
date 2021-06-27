<?php

class candidates
{    
    // table fields
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $education;
    public $edu_level;
    public $industry;
    public $work_exp;   

    // message string
    public $id_msg;
    public $first_name_msg;
    public $last_name_msg;
    public $email_msg;
    public $phone_msg;
    public $education_msg;
    public $edu_level_msg;
    public $industry_msg;
    public $work_exp_msg;   

    // default values
    function __construct()
    {
        $id=0;
        $first_name="";
        $last_name="";
        $email="";
        $phone="";
        $education="";
        $edu_level="";
        $industry="";
        $work_exp="";
        
        $id_msg="";
        $first_name_msg="";
        $last_name_msg="";
        $email_msg="";
        $phone_msg="";
        $education_msg="";
        $edu_level_msg="";
        $industry_msg="";
        $work_exp_msg="";
    }
}

?>