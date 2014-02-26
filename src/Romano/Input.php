<?php

/**
* Input library 
* -------------
* creator/source : Alex Garrett
* - added auto-escape to the get func
* - decoupled the class
* - less hardcoding
*
* creation date       : 11/2013
* dependencies        : none
* modification date   : 2/2014
*/

class Input 
{
  public static function submitted($input = null)
  {
    if (!empty($_POST[$input]) OR !empty($_POST))
    {
      return true;
    }
    elseif (!empty($_GET[$input]) OR !empty($_GET))
    {
      return true;
    }
  }

  public static function get($input, $escape = 'yes')
  {
    if (isset($_POST[$input])) {
      $input = $_POST[$input];
    } elseif (isset($_GET[$input])) {
      $input = $_GET[$input];
    } else {
      $input = '';
    }
    if ($escape !== 'no' AND $input !== '') {
      $input = self::escape($input);
    }
    return $input;
  }
  public static function escape($string)
  {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
  }
}