<?php


class Route
{
  var $r = array();

  function __construct($url, $paths)
  {
  	$this->finder($url, $paths);
  }

  private function finder($url, $paths)
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
    if ($array = $paths[$ctrlr][$method]){
      $this->r = array(
        'method' => $method, 
        'controller' => $ctrlr, 
        'url' => $url, 
        'section' => $section, 
        'pos' => $pos, 
        'path' => $ctrlr.'/'.$method
      );
      $this->autoRoute($array);
    } else {
    // no array no go we give them the 404;
      View::page(404,'from Route');
    }
  }

  private function autoRoute($path)
  {
    if (!is_array($path) && empty($this->r['section'][2]))  {
      View::render($this->r);
    } else {
      foreach ($path as $set => $rules) {
        if ($set[0] === '$' && !empty($this->r['section'][2])) {
          $rules[substr($set, 1)] = $this->r['section'][2];
          // now lets grab the rules stick and them in the data container
          if (is_array($rules) ) {
            if ($rules['type'] === 'numeric' && !is_numeric($this->r['section'][2]) ) {
              View::page(404,'from Route');
              exit();
            }
            $this->r = array_merge($rules, $this->r);
          }
        }
      }

      if (file_exists (CONTROLLER.$this->r['controller'].EXT)) {
        require (CONTROLLER.$this->r['controller'].EXT);
        $class = ucfirst($this->r['controller']);
        $init = new $class();
        $init->{$this->r['method']}($this->r);
        exit();
      }
    }
  }
}