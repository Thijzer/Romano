<?php
define('TIME', microtime(true));
session_start();
require ('../config.php');
/*
My basic global functions
*/
function timestamp($i = 5)
{
  return (float)substr(microtime(true) - TIME ,0,(int)$i) * 1000;
}
function random($length = 8, $chars = 'bcdfghjklmnprstvwxzaeiou')
{
  for ($p = 0; $p < $length; $p++) {
    $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
  }
  return $result;
}
/*
Simple Core Automatic Router 
- do not filter_var the url query it has no purpose
*/
class Route
{
  var $r = array();

  public function __construct()
  {
  	define('url', trim($_GET['q'],'/') ); unset($_GET['q']);
    $this->r['section'] = explode('/', url);
    $pos = count($this->r['section']);
    //list($this->r['section'][$pos-1], $this->r['action']) = explode('.', $this->r['section'][$pos-1]);

    if (empty($this->r['section'][1])) {
      if (!$ctrlr = $this->r['section'][0]) {
        $this->autoRoute('home', 'index');
      } elseif (file_exists(VIEW.$ctrlr.'/index.php')) {
        $this->autoRoute($ctrlr, 'index');
      } else {
        $this->autoRoute('home', $ctrlr);
      }
    }
    $this->autoRoute($this->r['section'][0], $this->r['section'][1]);
  }
  private function autoRoute($ctrlr, $method)
  {
    $this->r['path'] = $ctrlr.'/'.$method;
    $this->r['section'][0] = $ctrlr;
    $this->r['section'][1] = $method;
    if (file_exists (CONTROLLER.$ctrlr.EXT)) {
      require (CONTROLLER.$ctrlr.EXT);
      $class = ucfirst($ctrlr);
      $init = new $class();
      if (method_exists($init, $method) && $method[0] !== '_') {
        $init->{$method}($this->r);
        exit();
      }
    }
    $view = new View();
    if (file_exists (VIEW.$this->r['path'].EXT)) {
      $view->render($this->r);
    }
    $view->page(404,'from autoRoute');
  }
}
/*
The Core View Class
*/
class View
{
  public function render($data, $arg = array())
  {
    $arg = array_merge(array('title' => ucfirst($data['section'][1]), 'path' => $data['path'], 'theme' => 'theme', 'base' => 'base.php'),$arg);
    require (VIEW.$arg['path'].EXT);
    if (DEV_ENV === true) {echo timestamp(6);}
    if ($arg['theme'] !== 'no') {
      require (TMPL.$arg['theme'].EXT);
      if ($_SESSION['current'] !== url) { $_SESSION['last'] = $_SESSION['current']; $_SESSION['current'] = url; }
    }
    require (TMPL.$arg['base']);
    die();
  }
  public function page($code,$msg = null)
  {
    $data = array('code' => $code, 'msg' => $msg);
    require (VIEW.'page.php');
    require (TMPL.'base.php');
    die();
  }
}
/*
Main controller class
 - set of controller methods to extend
*/
class Ctrlr
{
  protected function _init_($i)
  {
    require (MODEL.$i.EXT);
    $class = ucfirst($i);
    $init = new $class();
    return $init;
  }
  protected function _hasAccess($i = 7)
  {
    if ($_SESSION['level'] >= $i){ return true; }
  }
}
New Route;
?>