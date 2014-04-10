<?php

class Array
{
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