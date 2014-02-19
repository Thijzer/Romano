<?php

/**
* Input library 
* -------------
* creator/source : Alex Garrett
* - added auto-escape to the get func
* - decoupled
*
* creation date       : 11/2013
* dependencies        : none
* modification date   : 12/2013
*/


class Input 
{
  public static function exists($type = 'post')
  {
    switch ($type) {
      case 'post':
        return (!empty($_POST)) ? true: false;
        break;
      case 'get':
        return (!empty($_GET)) ? true: false;
        break;    
      default:
        return false;
        break;
    }
  }
  public static function get($value, $escape = 'yes')
  {
    if (isset($_POST[$value])) {
      $value = $_POST[$value];
    } elseif (isset($_GET[$value])) {
      $value = $_GET[$value];
    } else {
      $value = '';
    }
    if ($escape !== 'no' AND $value !== '') {
      $value = self::escape($value);
    }
    return $value;
  }
  public static function escape($string)
  {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
  }
}