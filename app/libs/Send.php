<?php

/**
* hacked wrapper for simpler sending
* this needs to change pronto
*/
class Send
{
	static function mail($email, $subject, $body)
	{
	  require (LIBS .'class.phpmailer.php');
	  //$mail->Host = "mail.yourdomain.com";
	  $mail = new PHPMailer(true);
	  $mail->SMTPDebug = false; // disable error msg
	  $mail->do_debug = 0; // disable error msg
	  $mail->IsSMTP();
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
	  $mail->Send();
	  //return true;
	}
}