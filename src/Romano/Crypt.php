<?php

/**
* Crypt library 11/2013
* --------------------------
* creator/source : Thijs
* returns crypted or modified strings
*
* dependencies : none
*/

class Crypt
{
  static function toSalt($stringA = null, $stringB = null)
  {
    $ab = (string)$stringA . self::salt($stringB);
    if (!empty($ab)) return hash('sha256', $ab );
  }

  static function salt($string = null)
  {
    require_once ('app/config/salt.php');

    $length = strlen($string);
    if ($length) {
      for ($i = 0; $i < $length; $i++) $salt .= $char[$string[$i]];
      return $salt;
    }
  }
  static function oldSalt($string)
  {
    return hash('sha256', $string . App::getInstance()->get(array('config', 'SALT')));
  }
  static function random($length = 8, $chars = 'bcdfghjklmnprstvwxzaeiou')
  {
    $i = strlen($chars)-1;
    for ($p = 0; $p < $length; $p++) $result .= ($p%2) ? $chars[mt_rand($i%2,$i)] : $chars[mt_rand(0,$i)];
    return $result;
  }
  static function randomPlus()
  {
    return self::random().rand(1000,9999);
  }
  static function token()
  {
    return Session::put(App::getInstance()->get('config', array('session', 'token'), self::unique()));
  }
  static function check($token)
  {
    $token_name = App::getInstance()->get('config', array('session', 'token'));

    if (Session::get($token_name) && $token === Session::get($token_name)) {
      Session::delete($token_name);
      return true;
    }
    return false;
  }
  static function unique()
  {
    return self::md5(uniqid() . microtime(TRUE) . mt_rand());
  }
  static function timeout($marker = array(), $unit = null)
  {
    $timeTable = array('month' => 12, 'week' => 30, 'day' => 7, 'hour' => 24, 'minute' => 60, 'second' => 60);

    if (array_key_exists($marker, $timeTable)) {

      $loop = false;
      $timeout = 1;

      foreach ($timeTable as $mark => $units) {

        if ($loop === true) $timeout = $timeout * $units;

        if ($mark == $marker) {
          $timeout = $timeout * $unit;
          $loop = true;
        }
      }
      return $timeout;
    }
  }
  static function getTime()
  {
    return strtotime( '+30 days' );
  }
}
