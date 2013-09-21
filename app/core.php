<?php

class Router
{
  private $route;

  public function prepareRoute($i1,$i2,$i3)
  { // feeds the autoroute with the correct path if that exists
    define('url', filter_var(trim($_GET[$i3], $i1), FILTER_SANITIZE_URL)); // trim and sanitize the URL
    //list(url, $this->route['act']) = explode($i2, url); //find actions with a dot in the end
    $this->route['section'] = explode($i1, url); //split the sections
    unset($_GET[$i3]);

    if(empty($this->route['section'][1]))
    {
      $this->missingMethod();
    }
    $this->autoRoute($this->route['section'][0], $this->route['section'][1]);
  }

  private function missingMethod()
  { // find a location for the missing method
    $ctrlr = $this->route['section'][0];

    if (empty($ctrlr))
    { //maybe its home, no path = home/index
      $this->autoRoute('home', 'index');
    }
    elseif (file_exists(VIEW.'home/'.$ctrlr.EXT))
    { //maybe its a file in home, if home/file exists
      $this->autoRoute('home', $ctrlr);
    }
    elseif (file_exists(VIEW.$ctrlr.'/index'.EXT))
    { //maybe its and index in a folder, if path/index exists
      $this->autoRoute($ctrlr, 'index');
    }
    else
    {
      require(CONTROLLER.'home'.EXT);
      $init = new Home();
      if (method_exists($init, $ctrlr) AND $ctrlr !== '__construct')
      {
          $init->{$ctrlr}($this->route);
          exit();
      }
    }
  }

  private function autoRoute($ctrlr, $method)
  { // autoloads controller and method if exists
    $this->route['path'] = $ctrlr.'/'.$method;
    if (file_exists(CONTROLLER.$ctrlr.EXT))
    {
      require(CONTROLLER.$ctrlr.EXT);
      $class = ucfirst($ctrlr);
      $init = new $class();
      if (method_exists($init, $method) AND $method !== '__construct')
      {
        $init->{$method}($this->route);
        exit();
      }
    }
    $view = new View();
    // if no_file/no_controller/no_function exists, we break the site with a 404 / dead end
    if (!file_exists(VIEW.$this->route['path'].EXT))
    {
      $view->error(404,'from autoroute');
    }
    // else we load the view without controller/method functionality
    $view->render($this->route, ucfirst($method));
  }
}

class View
{
  public function render($data, $title = null, $theme = null)
  {
    require(TMPL.'theme_library.php');
    require(VIEW.$data['path'].EXT);

    if ($title === null) {$title = ucfirst($data['section'][1]);}
    head($title.=' - '.title);
    css();

    if($theme === null)
    {
      echo '</head><body>';
      nav();
      content($data);
      footer();
      js();
      echo '</body></html>';
    }
    else
    {
      echo '</head><body>';
      content($data);
      echo '</body></html>';
    }
    $this->track();
    die();
  }
  public function error($page,$msg = null)
  {
    require(TMPL.'theme_library.php');
    require(VIEW.'error/'.$page.'.php');
    $this->track($page.' : '.$msg);
    die();
  }
  private function track($msg = null)
  {
    if($_SESSION['current'] !== url)
    {
      $_SESSION['last'] = $_SESSION['current'];
      $_SESSION['current'] = url;

      $_SESSION['track'][] = array(
      'time'  => time(),
      'page'  => url,
      'uid'   => $_SESSION['user']['uid'],
      'speed' => str_replace('.','',substr(microtime(true) - TIMER ,0,5)),
      'msg'   => $msg
      );
    }
  }
}
?>