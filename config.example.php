<?php
chdir (__DIR__);
define('EXT', '.php');

/*
*     this file only hosts the settings
* ----------------- WARNING ------------------
*      if you change these settings on
* a running site the whole site will be broken
*                SO BE WARNED
*/

class Config
{
  const DB_HOST = '',
        DB_PASS = '',
        DB_USER = '',
        DB_NAME = '',
        DB_TYPE = 'mysql',

        EM_USER = '',
        EM_PASS = '',
        EM_FWRD = '',
        EM_HOST = '',
        SALT    = '';
}

// ROOT directory constants
  define('PROJECT',     __DIR__.'/');
  define('PUB',         PROJECT.'pub/');
  define('APP',         PROJECT.'app/');
  define('VIEW',        PROJECT.'views/');
  define('TMPL',        PROJECT.'template/default/');
  define('CONTROLLER',  PROJECT.'controllers/');
  define('LIBS',        APP.'libs/');
  define('MODEL',       APP.'models/');
// site global
  define('url',         trim($_GET['q'],'/')); unset($_GET['q']);
  define('site',        'http://localhost/');
  define('title',       'your.blog');

function sendMail($email, $subject, $body)
{
  require (LIBS .'class.phpmailer.php');
  //$mail->Host = "mail.yourdomain.com";
  $mail = new PHPMailer(true);
  $mail->SMTPDebug = false; // disable error msg
  $mail->do_debug = 0; // disable error msg
  $mail->IsSMTP();
  $mail->Host = Config::EM_HOST;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "ssl";
  $mail->Username = Config::EM_USER;
  $mail->Password = Config::EM_PASS;
  $mail->Port = 465;
  $mail->AddAddress($email);
  $mail->Subject = $subject;
  $mail->Body = $body;
  $mail->From = Config::EM_FWRD;
  $mail->FromName= Config::EM_FWRD;
  $mail->AddReplyTo(Config::EM_FWRD, title);
  $mail->SetFrom(Config::EM_FWRD, title);
  //$mail->IsHTML(true);
  $mail->Send();
  //return true;
}

function random($length = 8, $chars = 'bcdfghjklmnprstvwxzaeiou')
{
  for ($p = 0; $p < $length; $p++) {
    $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
  }
  return $result;
}

// uncomment this dev.php to enable development mode
require (APP.'dev.php');
require (APP.'core.php');

?>