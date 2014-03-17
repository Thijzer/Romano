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
* modification date   : 3/2014
*/

class Input 
{
  private static $submit = array();

  public static function submitted($input = null)
  {
    if (!empty($_POST[$input]) OR !empty($_POST)) self::$submit[] = array('type' => 'post', 'value' => $input);
    if (!empty($_GET[$input]) OR !empty($_GET)) self::$submit[] = array('type' => 'get', 'value' => $input);

    return (is_array(self::$submit[0])) ? true : false;
  }

  public static function get($input = null, $autoEscape = true)
  {
    if (is_array($input))
    {
      foreach ($input as $key => $inputValue)
      {
        if (empty($inputValue))
        {
          unset($input[$key]);
        }
        elseif ($autoEscape !== false)
        {
          $input[$key] = self::escape($inputValue);
        }
      }
      return $input;
    }
    elseif (isset($_POST[$input]))
    {
      $input = $_POST[$input];
    }
    elseif (isset($_GET[$input]))
    {
      $input = $_GET[$input];
    }
    else break;

    if ($autoEscape !== false AND $input !== null) $input = self::escape($input);

    return $input;
  }

  public static function escape($string)
  {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
  }
}