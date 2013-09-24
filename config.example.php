<?php
chdir (__DIR__);
define('EXT', '.php');

/*
*     this file only hosts the settings
* ----------------- WARNING ------------------
*      if you change these settings on
* a running site the whole site will be broken
*                SO BE WARNED
*/

class Config
{
  const DB_HOST = '',
        DB_PASS = '',
        DB_USER = '',
        DB_NAME = '',
        DB_TYPE = 'mysql',

        EM_USER = '',
        EM_PASS = '',
        EM_FWRD = '',
        EM_HOST = '',
        SALT    = '';
}

// ROOT directory constants
  define('PROJECT',     __DIR__.'/');
  define('PUB',         PROJECT.'pub/');
  define('APP',         PROJECT.'app/');
  define('VIEW',        PROJECT.'views/');
  define('TMPL',        PROJECT.'template/default/');
  define('CONTROLLER',  PROJECT.'controllers/');
  define('LIBS',        APP.'libs/');
  define('MODEL',       APP.'models/');
// site global
  define('url',         trim($_GET['q'],'/')); unset($_GET['q']);
  define('site',        'http://localhost/');
  define('title',       'your.blog');

// uncomment this dev.php to enable development mode
require (APP.'dev.php');
require (APP.'core.php');

?>