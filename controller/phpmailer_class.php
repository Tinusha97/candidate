<?php

class phpmailer_class {

    public function sendMail1($email, $message, $subject, $directory, $attachment)
    {
        
        if (!class_exists('PHPMailer\PHPMailer\Exception'))
        {
            require 'libs/phpmailer/src/Exception.php';            
        }
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer'))
        {
            require 'libs/phpmailer/src/PHPMailer.php';           
        }
        if (!class_exists('PHPMailer\PHPMailer\SMTP'))
        {
            require 'libs/phpmailer/src/SMTP.php';
        }
                        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
 
        $mail->isSMTP();                      // Set mailer to use SMTP 
        $mail->Mailer = "smtp"; 
        $mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
        // $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;               // Enable SMTP authentication 
        $mail->Username = 'yourmail@gmail.com';   // google mail
        $mail->Password = 'password';   // mail password
        $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
        $mail->Port = 587;                    // TCP port to connect to 
        
        // Sender info 
        $mail->setFrom('online@application.com', 'Online Application Portal');
        
        // Add a recipient 
        $mail->addAddress($email);
        
        // Set email format to HTML 
        $mail->isHTML(true);
        
        // Mail subject 
        $mail->Subject = $subject;
        
        // Mail body content         
        $mail->Body = $message;

        //Add attachment
        $mail->addAttachment($directory,$attachment);
        
        // Send email 
        $mail->send();
    }
    
}

?>