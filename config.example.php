<?php
/*
* the config file lives in the root of our site directory
* for this reason we define the __DIR__ here.
*/
chdir (__DIR__);

/* 
  *  ------------------ WARNING ---------------
  *             please make sure to 
  * !!NEVER!! run development mode during publication
  *                 SO BE WARNED
  *
  * uncomment this dev.php to enable development mode, remove them to during publication
  */
require ('dev.php');

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
      'DSN' => 'mysql:host=;dbname=',
      'PASS' => '',
      'USER' => ''
    ),
    'EMAIL' => array(
      'HOST' => '',
      'USER' => '',
      'PASS' => '',
      'FWRD' => ''
    ),
    'session' => array(
      'session_name' => 'user',
      'token_name' => 'token'
    ),
    'remember' => array(
      'cookie_name' => 'hash',
      'cookie_expiry' => 604800
    ),
    'SALT' => '',
    'PATH' => array(
      'users' => array(
        'activate' => array(
          'http' => 'get'
        ),
        'register' => array(
          '$token' => array(
            'type' => 'numeric',
            'http' => 'post'
          )
        )
      ),
      'home' => array(
        'login' => array(
          'controller' => 'home'),
        'logout' => array(
          'controller' => 'home'),
        'index' => array(
          'controller' => 'home'),
        'gallery' => 'page',
        'about' => 'page',
        'contact' => array(
          '$token' => array(
            'http' => 'post'
          )
        )
      )
    )
  );
  static function get() {
    return self::$_array;
  }
}

// ROOT directory constants
  define('PROJECT',     __DIR__.'/');
  define('PUB',         PROJECT.'pub/');
  define('APP',         PROJECT.'app/');
  define('VIEW',        APP.'views/');
  define('CONTROLLER',  APP.'controllers/');
  define('LIBS',        APP.'libs/');
  define('MODEL',       APP.'models/');
  define('TMPL',        APP.'template/default/');
// site global
  define('EXT', '.php');
  define('site',        '');
  define('title',       '');
  define('url', trim($_SERVER['REQUEST_URI']));

spl_autoload_register(function($class)
{
    if( is_file('app/models/' . $class . '.php')) {
      require_once 'app/models/' . $class . '.php';
    } elseif ( is_file('app/libs/' . $class . '.php')) {
      require_once 'app/libs/'. $class . '.php';
    }
});