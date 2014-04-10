<?php

/**
* @author Thijs De Paepe <thijs.depaepe@wijs.be>
**/

class SimpleRoute
{
  function __construct($app)
  {
    $app->setting('stamp', 'router', timestamp(2) );

    $url = str_replace('?'. $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

    // find view with a dot in the end
    list($url, $view) = explode('.', $url);

    // count,trim, dissect the given url into sections, 1 ctrlr / 2 method
    $pos = count($section = list($ctrlr, $method) = explode('/', $url = trim($url, '/')));
 
    // find the missing values first = nothing = home/index,
    // 2nd find physical index and last we latch on a home as ctrlr.
    if (empty($method))
    {
      if (empty($ctrlr)) {
        $ctrlr = 'home';
        $method = 'index';
      } elseif (file_exists(VIEW . $ctrlr . '/index.php')) {
        $method = 'index';
      } else {
        $method = $ctrlr;
        $ctrlr = 'home';
      }
    }

    // now all values are set lets compare against the paths array
    $app->setArray(
      'route', 
      array(
        'controller' => $ctrlr, 
        'method' => $method,
        'parameter' => ($section[2] ? array_splice($section, 2, $pos) : false), 
        'positions' => $pos, 
        'path' => $path = $ctrlr . '/' . $method,
        'uri' => $url,
        'view' => ($view ? $view : $view = 'twig')
      )
    );

    if ($method[0] !== '_' && method_exists($class = ucfirst($ctrlr), $method) && is_callable($class , $method)) {
      $object = new $class($app);
      $data = $object->$method($app);

      // action line
      if ($view !== 'twig' AND !empty($app)) Output::$view($data, $ctrlr);
      return;
    }

    if (file_exists(VIEW . $path . '.twig')) {
      \View::twig($path . '.twig');
      return;
    }

    \View::page(404, 'error');
  }
}