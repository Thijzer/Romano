<?php
define('TIME', microtime(true));
define('DEV_ENV', true);

// error reporting
ini_set('display_errors', 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_STRICT);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// a simple function to display array data
function dump($i)
{
  $i = print_r($i, true);
  echo "<pre>$i</pre>";
}
function timestamp($i = null)
{
  return (float)substr(microtime(true) - TIME ,0,(int)$i+5) * 1000;
}