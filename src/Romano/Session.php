<?php

/**
* Session wrapper 11/2013
* --------------------------
* creator/source : Alex Garrett
* - removed exists as it is equal to get
* - put uses an array
*
* dependencies : none
*/
class Session
{
  public static function set($array)
  {
    foreach ($array as $key => $value)
    {
      if (!empty($value)) $_SESSION[$key] = $value;
    }
  }

  public static function get($name)
  {
    return $_SESSION[$name];
  }

  public static function delete($name)
  { 
    if (self::get($name)) unset($_SESSION[$name]);
  }

  public static function exists($name)
  {
    return (isset($_SESSION[$name])) ? true : false;
  }

  public static function flash($name, $string)
  {
    if (self::exists($name)) {
      $session = self::get($name);
      self::delete($name);
      return $session;
    } else {
      self::set(array($name, $string));
    }
  }
}