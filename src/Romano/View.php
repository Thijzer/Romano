<?php

class View
{
  public static function render($data, $arg = array())
  {
    $arg = array_merge(array('title' => ucfirst($data['section'][1]), 'path' => $data['path'], 'theme' => 'theme', 'base' => 'base.php'), $arg);
    require (VIEW . $arg['path'] . EXT);
    echo timestamp(2);
    if ($arg['theme'] !== 'no') {
      require (TMPL . $arg['theme'] . EXT);
      if ($_SESSION['current'] !== url) { $_SESSION['last'] = $_SESSION['current']; $_SESSION['current'] = url; }
    }
    require (TMPL.$arg['base']);
    die();
  }
  public static function page($code, $data = array())
  {
    $data = array('code' => $code);
    require (VIEW.'page.php');
    require (TMPL.'base.php');
    die();
  }
}