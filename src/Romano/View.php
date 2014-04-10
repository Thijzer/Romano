<?php

class View
{

  public static function render($data, $arg = array())
  {
    $arg = array_merge(array('title' => ucfirst($data['section'][1]), 'path' => $data['path'], 'theme' => 'theme', 'base' => 'base.php'), $arg);
    require (VIEW . $arg['path'] . EXT);
    echo timestamp(2); self::track();
    if ($arg['theme'] !== 'no') {
      require (TMPL . $arg['theme'] . EXT);
    }
    require (TMPL . $arg['base']);
    die();
  }
  public static function page($code, $data = array())
  {
    $data = array('code' => $code);
    require (VIEW . 'page.php');
    require (TMPL . 'base.php');
    die();
  }
  private static function track()
  {
    if ($_SESSION['current_location'] !== url) { $_SESSION['previous_location'] = $_SESSION['current_location']; $_SESSION['current_location'] = url;}
  }
  public static function twig($string  = null , $data = null)
  {
    $loader = new Twig_Loader_Filesystem(VIEW);
    $twig = new Twig_Environment($loader);
    $twig = new Twig_Environment($loader, array('debug' => true, 'cache' => CACHE));
    $twig->addGlobal('site', site);
    echo $twig->render($string, (array) $data);
  }
}