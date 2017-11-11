<?php
chdir (__DIR__);

/*
*     this file only hosts the settings
* ----------------- WARNING ------------------
*      if you change these settings on
* a running site the whole site will be broken
*                SO BE WARNED
*/

class Config
{
  public static $array = array(
    'DB' => array( 
      'DSN' => 'mysql:host=localhost;dbname=thijzer',
      'PASS' => 'mysql',
      'USER' => 'root'
  ));
  //public static function get() {
  //    return self::$_array;
  //}
}
spl_autoload_register(function($class) {
  require_once 'app/libs/'. $class . '.php';
});

// uncomment this dev.php to enable development mode
require ('dev.php');