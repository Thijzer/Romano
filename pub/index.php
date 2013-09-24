<?php
define(TIME, microtime(true));

function timestamp($i = 5)
{
 return (float)str_replace('.','',substr(microtime(true) - TIME ,0,(int)$i));
}
session_start();
require ('../config.php');
?>