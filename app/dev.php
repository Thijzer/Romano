<?php
// error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
define(DEV_ENV, true);
//error_reporting(E_STRICT);
// a simple function to display array data
function dump($i)
{
  $i = print_r($i, true);
  echo "<pre>$i</pre>";
}
//dumps data passed
function devdump($data)
{
	$time = timestamp();
  echo "<div class = 'well' style='background-color: rgb(229, 103, 103)'>";
  echo '<h3>DEVELOPERS PAGE</h3>';
  echo "Page loaded in $time seconds<br><br>";
  if(!empty($_SESSION)){echo '<h4>SESSION</h4>';dump($_SESSION);}
  if(!empty($data)){echo '<h4>DATA</h4>';dump($data);}
  echo '</div>';
}

?>