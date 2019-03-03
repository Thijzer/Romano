<?php
define('DEV_ENV', true);

// error reporting
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
#error_reporting(E_ALL & ~E_NOTICE);
#error_reporting(E_STRICT);

// a simple function to display array data
function dump($i)
{
  $i = print_r($i, true);
  echo "<pre>$i</pre>";
}
?>