<?php

class mpdf_class {

    public function create_pdf($applicant_name,$decision,$directory)
    {
        require_once 'libs//vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('Dear '.$applicant_name.'<br><p>You application was processed. According to your qualifications and skills you are <strong>'.$decision.'</strong> for the current opportunity at our organization.</p>Cheers<br>Managing Director');                        

        $mpdf->Output($directory, "F");
        
    }
}

?>