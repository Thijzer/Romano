<?php
define('TIME', microtime(true));
session_start();
require('../config.php');
/*
* My basic global functions
*/
function timestamp($i = null)
{
  return (float)substr(microtime(true) - TIME ,0,(int)$i+5) * 1000;
}
function random($length = 8, $chars = 'bcdfghjklmnprstvwxzaeiou')
{
  for ($p = 0; $p < $length; $p++) {
    $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
  }
  return $result;
}
function escape($array)
{
  foreach ($array as $value) {
    $array = htmlentities($value, ENT_QUOTES, 'UTF-8');
  }
  return $array;
}
echo timestamp(2).'<BR>';
DB::getInstance();
$user = DB::getInstance()->get("users", array('username' => 'thijzer'))->fetch(); echo $user['username'];
DB::getInstance()->update("users", array('username' => 'thijzer'), 20);
echo timestamp(2);
