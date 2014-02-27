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
}