<?php
define(TIME, microtime(true));

function timestamp($i = 5)
{
 return (float)substr(microtime(true) - TIME ,0,(int)$i) * 1000;
}
session_start();
require ('../config.php');
?>