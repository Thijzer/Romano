<?php


class SimpleRoute
{
  var $r = array();

  function __construct($url, $paths)
  {

    // count,trim, dissect the given url into sections, 1 ctrlr / 2 method
    $pos = count($section = list($ctrlr, $method) = explode('/', $url = trim($url,'/')));
 
    // find the missing values first = nothing = home/index ,2nd find physical index and last we latch on a home as ctrlr.
    if (!$method)
    {
      if (!$ctrlr) {
        $ctrlr = 'home'; $method = 'index';
      } elseif (file_exists(VIEW.$ctrlr.'/index.php')) {
        $method = 'index';
      } else {
        $method = $ctrlr; $ctrlr = 'home';
      }
    }

    // now all values are set lets compare against the paths array
    $this->r = array(
      'method' => $method, 
      'controller' => $ctrlr, 
      'url' => $url, 
      'section' => $section, 
      'pos' => $pos, 
      'path' => $ctrlr . '/' . $method
    );

    $this->autoRoute();
  }

  private function autoRoute()
  {
    if (file_exists (CONTROLLER.$this->r['controller'].EXT) ) {
        require (CONTROLLER.$this->r['controller'].EXT);
        $class = ucfirst($this->r['controller']);
        $init = new $class();
        if (method_exists($init, $this->r['method']) && $this->r['method'][0] !== '_') {
          $init->{$this->r['method']}($this->r);
          exit();
        }
    } 
    if (file_exists (VIEW.$this->r['path'].EXT) && empty($this->r['section'][2]) ) {
      View::render($this->r);
    } else {
      View::page(404,'from Route');
    }
  }
}