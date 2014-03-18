<?php

/**
* @author Thijs De Paepe <thijs.depaepe@wijs.be>
**/

class SimpleRoute
{
  var $r = array();

  function __construct($app)
  {
    $app->setting('stamp', 'router', timestamp(2) );

    $url = str_replace('?'. $_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']);

    // find view with a dot in the end
    list($url, $view) = explode('.', $url);

    // count,trim, dissect the given url into sections, 1 ctrlr / 2 method
    $pos = count($section = list($ctrlr, $method) = explode('/', $url = trim($url, '/')));
 
    // find the missing values first = nothing = home/index,
    // 2nd find physical index and last we latch on a home as ctrlr.
    if (!$method)
    {
      if (!$ctrlr) {
        $ctrlr = 'home'; $method = 'index';
      } elseif (file_exists(VIEW . $ctrlr . '/index.php')) {
        $method = 'index';
      } else {
        $method = $ctrlr; $ctrlr = 'home';
      }
    }

    // now all values are set lets compare against the paths array
    $this->r = array(
      'controller' => $ctrlr, 
      'method' => $method, 
      'uri' => $url,
      'view' => ($view ? $view : $view = 'twig'), 
      'parameter' => ($section[2] ? array_splice($section, 2, $pos) : false), 
      'positions' => $pos, 
      'path' => $ctrlr . '/' . $method
    );

    $app->setArray('route', $this->r);   

    if (file_exists (CONTROLLER.$this->r['controller'] .'.php') ) {
      require (CONTROLLER.$this->r['controller'] .'.php');
      $class = ucfirst($this->r['controller']);
      $init = new $class();
      if (method_exists($init, $this->r['method']) && $this->r['method'][0] !== '_') {
        $data = $init->{$this->r['method']}($app);
        exit();
      }
      if ($this->r['view'] != 'twig') Output::{$this->r['view']} ($data, $ctrlr);
    }

    if (file_exists (VIEW . $this->r['path'] . '.twig') AND !empty($this->r['controller']) ) {
      \View::twig($this->r['path'] . '.twig');
      exit();
    }

    \View::page(404, 'error');
  }
}