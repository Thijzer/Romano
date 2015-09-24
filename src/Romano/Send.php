<?php

/**
* mini wrapper for simpler sending
*/



class Send
{
    static function mail($email, $subject, $body)
    {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        //$mail->Host = "mail.yourdomain.com";
        $mail->SMTPDebug = true; // disable error msg
        $mail->do_debug = 0; // disable error msg
        $mail->SMTPDebug = 0;

        $mail->Host = Config::$array['EMAIL']['HOST'];
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = Config::$array['EMAIL']['USER'];
        $mail->Password = Config::$array['EMAIL']['PASS'];
        $mail->Port = 465;
        $mail->AddAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->From = Config::$array['EMAIL']['FWRD'];
        $mail->FromName=Config::$array['EMAIL']['FWRD'];
        $mail->AddReplyTo(Config::$array['EMAIL']['FWRD'], title);
        $mail->SetFrom(Config::$array['EMAIL']['FWRD'], title);
        //$mail->IsHTML(true);
        if($attachment) {
            $mail->AddAttachment($attachment);
        }
        if (!$mail->Send()) {
            if (DEV_ENV === true) {
                $message = $mail->ErrorInfo;
            }
            View::page('500','MAIL ERROR: '. $message);
        }
    }
}
