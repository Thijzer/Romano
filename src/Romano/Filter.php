<?php

/**
* Filter library 
* -------------
* creator/source : Thijs De Paepe
*/

class Filter 
{
  private static $foreignChars =  array(
    'from' => array ('ç','æ','œ','á','é','í','ó','ú','à','è','ì','ò','ù','ä','ë','ï','ö','ü','ÿ','â','ê','î','ô','û','å','e','i','ø','u'),
    'to' => array ('c','ae','oe','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','y','a','e','i','o','u','a','e','i','o','u')
  );
  private static $Chars =  array(
    'specials' => array ("'",'’'),
    'markUp' => array ('(',')','[',']','"','«','»',':','.','?','!',','),
    'html' => array ('<','>','/'),
    'markDown' => array ('#',' - ','*')
  );

  public static function fromUrl($input = null, $autoEscape = true)
  {
    // grab to sections and controller from app
  }

  public static function urlise($input = null, $foreignChars = true,  $spacer = '-', $remove = array())
  {
    $characters = array_merge(self::$Chars['markUp'], self::$Chars['specials'], $remove);
    // Convert accented characters, and remove parentheses and apostrophes
    $input = str_replace ($characters, '', $input);

    // we add the space char
    if ($foreignChars === true) $chars = self::$foreignChars;

    $chars['from'][] = ' ';
    $chars['to'][] = $spacer;
    
    // Do the replacements, and convert all foreign characters to their counterparts
    return strtolower(str_replace ($chars['from'], $chars['to'], trim($input)));
  }
}