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
  static function toSalt($string)
  {
    return hash('sha256', $string . Config::$array['SALT']);
  }
  static function random($length = 8, $chars = 'bcdfghjklmnprstvwxzaeiou')
  {
    for ($p = 0; $p < $length; $p++) {
      $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
    }
    return $result;
  }
  static function randomPlus()
  {
    return self::random().rand(1000,9999);
  }
  static function token()
  {
    return Session::put(Config::$array['session']['token'], md5(uniqid()));
  }
  static function check($token)
  {
    $token_name = Config::$array['session']['token'];

    if (Session::get($token_name) && $token === Session::get($token_name)) {
      Session::delete($token_name);
      return true;
    }
    return false;
  }
}