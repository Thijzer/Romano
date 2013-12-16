<?php
/*
* our public index
*/
session_start();
require ('../config.php');
New Route(str_replace('?'. $_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']), Config::$array['PATH']);