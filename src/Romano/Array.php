<?php

class Array
{
	private static $alfabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	private static $numbers = array (0,1,2,3,4,5,6,7,8,9);
	private static $foreignChars =  array(
		'from' => array ('ç','æ','œ','á','é','í','ó','ú','à','è','ì','ò','ù','ä','ë','ï','ö','ü','ÿ','â','ê','î','ô','û','å','e','i','ø','u'),
		'to' => array ('c','ae','oe','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','y','a','e','i','o','u','a','e','i','o','u')
	);
	private static $Chars =  array(
		'specials' => array ("'",'’'),
		'markUp' => array ('(',')','[',']','"','«','»',':','.','?','!',',',';','{','}','`'),
		'html' => array ('<','>','/'),
		'extras' => array ('~','@','$','%','^','&','|','+','='),
		'markDown' => array ('#','-','*')
	);

	/*
	* return a glued array from arrays with a mutual key
	*/
	static public function merge_on_key($key, $array1, $array2) {

      $arrays = array_slice(func_get_args(), 1);
      $r = array();
      foreach($arrays as &$a) {
         if(array_key_exists($key, $a)) {
            $r[] = $a[$key];
            continue;
         }
      }
      return $r;
   }
}
