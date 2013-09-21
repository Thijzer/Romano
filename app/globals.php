<?php

function sendMail($email, $subject, $body)
{
	require_once(LIBS .'class.phpmailer.php');
	//$mail->Host = "mail.yourdomain.com";
	$mail = new PHPMailer(true);
	$mail->SMTPDebug = false; // disable error msg
	$mail->do_debug = 0; // disable error msg
	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->Host = mailh;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Username = mailu;
	$mail->Password = mailp;
	$mail->Port = 465;
	$mail->AddAddress($email);
	$mail->Subject = "$subject";
	$mail->Body = "$body";
	$mail->From = mailf;
	$mail->FromName= mailf;
	$mail->AddReplyTo(mailf, site);
	$mail->SetFrom(mailf, site);
	//$mail->IsHTML(true);
	$mail->Send();
	return true;
}
function random($length = 8, $chars = 'bcdfghjklmnprstvwxzaeiou')
{
	for ($p = 0; $p < $length; $p++){
		$result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
	}
	return $result;
}

function track()
{
  if($_SESSION['track'])
  {
    //foreach ($_SESSION['track'] as $row)
    //{
    //  $sql[] = "('{$row['time']}', '{$row['page']}', '{$row['uid']}', '{$row['speed']}', '{$row['msg']}')";
    //}
    //$this->query('INSERT INTO `pageviews` (`udate`, `page`, `uid`, `speed`, `msg`) VALUES '.implode(', ', $sql));
    unset($_SESSION['track']);
  }
}

?>