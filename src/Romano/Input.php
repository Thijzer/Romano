<?php

class Input 
{
  private static $submit = null;

  public static function submitted($input = null)
  {
    if (is_array($input)) {
     self::$submit = $input;
    }
    else {
      self::$submit = array_merge($_POST, $_GET);
    }

    if (!empty($input) AND isset(self::$submit[$input])) return true;
    if (!empty(self::$submit)) return true;
    return false;
  }

  public static function escape($string)
  {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
  }

  public static function get($input = null)
  {
    if ($input) return self::$submit[$input];
  }

  public static function getInputs()
  {
    return self::$submit;
  }
}