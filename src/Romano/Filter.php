<?php

/**
* Filter library
* -------------
* creator/source : Thijs De Paepe
*/

Class Filter
{

  public static function fromUrl($input = null, $autoEscape = true)
  {
    // grab to sections and controller from app
  }

  public static function urlise($input = null, $foreignChars = true, $remove = array(), $spacer = '-')
  {
    $characters = array_merge(Array::$Chars['markUp'], Array::$Chars['specials'], $remove);

    // Convert accented characters, and remove parentheses and apostrophes
    $input = str_replace($characters, '', $input);

    // we add the space char
    if ($foreignChars === true) $chars = Array::$foreignChars;

    $chars['from'][] = ' ';
    $chars['to'][] = $spacer;

    // Do the replacements, and convert all foreign characters to their counterparts
    return strtolower(str_replace($chars['from'], $chars['to'], trim($input)));
  }
}
