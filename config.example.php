<?php
/*
*     this file only hosts the settings
* ----------------- WARNING ------------------
*      if you change these settings on
* a running site the whole site will be broken
*                SO BE WARNED
*/
// ROOT directory constants
  define('PUB', $_SERVER[DOCUMENT_ROOT]. '/');
  define('PROJECT', PUB.'../');
  define('APP', PUB.'../app/');
  define('VIEW', PROJECT.'views/');
  define('TMPL', PROJECT.'template/default/');
  define('CONTROLLER', PROJECT.'/controllers/');
// some mySQL db shizzle
  define('DB_TYPE', 'mysql');
  define('DB_NAME', 'romano');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_HOST', 'localhost');
// site global
  define('site', 'http://localhost/');
  define('title', 'romano');
  define('SALT', 'PASTYOURLANGSALTYCODEHERE');
// site mail
  define('mailu', '');
  define('mailp', '');
  define('mailf', '');
// do not adjust these
  define('EXT', '.php');
  define('LIBS', APP.'libs/');
  define('MODEL', APP.'models/');

// $config['DB'] = array(
//  'TYPE'      => 'mysql',
//  'HOST'      => 'localhost',
//  'USER'      => 'root',
//  'PASSWORD'  => 'yelgre',
//  'NAME'      => 'baxy'
// );

// uncomment this dev.php to enable development mode
require(APP.'dev.php');
require(APP.'core.php');
$route = new Router();
$route->prepareRoute('/','.','q');