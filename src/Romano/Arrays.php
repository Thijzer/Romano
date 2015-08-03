<?php

class Arrays
{
	private static $array;

	private static $foreignChars =  array(
		'from' => array ('ç','æ','œ','á','é','í','ó','ú','à','è','ì','ò','ù','ä','ë','ï','ö','ü','ÿ','â','ê','î','ô','û','å','e','i','ø','u'),
		'to' => array ('c','ae','oe','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','y','a','e','i','o','u','a','e','i','o','u')
	);

	private static function getChars()
	{
		return array(
			'specials' => array ("'",'’'),
			'markUp' => array ('(',')','[',']','"','«','»',':','.','?','!',',',';','{','}','`'),
			'html' => array ('<','>','/'),
			'extras' => array ('~','@','$','%','^','&','|','+','='),
			'markDown' => array ('#','-','*'),
			'alfabet' => range('a', 'z'),
			'alfabetCap' => range('A', 'Z'),
			'numbers' => range(0, 9)
		);
	}

	/**
	 * return a glued array from arrays with a mutual key
	*/
	static public function mergeOnKey($key, $array1, $array2)
	{
		$r = array();
		foreach(array_slice(func_get_args(), 1) as &$a) {
			if(array_key_exists($key, $a)) {
				$r[] = $a[$key];
				continue;
			}
		}
		return $r;
	}

	/**
	 * returns an cleaned array on provided keys
	 */
	static function returnOnKeys($rr, $keys) {
		// arraflip rotates the array key => val to val => key
		return array_intersect_key($rr, array_flip($keys));
	}

	/**
	 * returns an array with replaced values
	 */
	public static function replaceValue($haystack, $needle, $replaceValue)
	{
		foreach (in_array($needle, $haystack) as $key) {
			$haystack[$key] = $replaceValue;
		}
		return $haystack;
	}

	public static function Clean($rr)
	{
		$this->array = array_filter($rr);
		return $this;
	}

	/**
	 * return keys from your array with a mutual key
	 *
	 */
	public static function getKeys($results)
	{
		$this->array = array_keys($results);
		return $this;
	}

    private function checkLastKey($rr, $key)
    {
        return ($key === self::getLastKey($rr));
    }

	public static function getLastKey($rr)
	{
		end($rr);
		return key($rr);
	}

	public static function getLastValue($rr)
	{
		return $rr[self::getLastKey($rr)]:
	}
}
