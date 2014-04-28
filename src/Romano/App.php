<?php
session_start();

abstract class Singleton
{
    private static $storage = array();

    public static function getInstance($class)
    {
        if(!static::$storage[$class]) static::$storage[$class] = new $class();

        return static::$storage[$class];
    }
    public static function storage()
    {
       return static::$storage;
    }

    private function  __construct() { }
    private function __clone() { }
}

class App
{
  public $i = 0;
  public $container = array();

  public static function getInstance()
  {
    return Singleton::getInstance(get_class());
  }

  public function set($name, $value)
  {
    if (!empty($name) AND is_array($value)) $this->container[$name] = $value;
  }

  public function setting($name1, $position, $val)
  {
    if (!empty($val)) $this->container[$name1][$position] = $val;
  }

  public function setArray($name, $array)
  {
    if (!empty($name)  AND is_array($array)) $this->container[$name] = $array;
  }

  public function getVal($name, $value)
  {
    if (!empty($name)  AND is_array($value)) return $this->container[$name][$value];
  }

  public function get($name)
  {
    if (count($name) === 3) return $this->container[$name[0]][$name[1]][$name[2]];
    elseif (is_array($name)) return $this->container[$name[0]][$name[1]];
    elseif (!empty($name)) return $this->container[$name];
  }

  public function getAll()
  {
    return $this->container;
  }

  public function config($array)
  {
    $this->setArray('config', $array);
  }

  public function setPath($array)
  {
    $this->setArray('path ' . $this->i++, $array);
  }

  public function getPath()
  {
    return $this->container['path ' . $this->i];
  }
}

class Session
{
  public static function set($array)
  {
    foreach ($array as $key => $value) if (!empty($value)) $_SESSION[$key] = $value;
  }

  public static function get($name)
  {
    return $_SESSION[$name];
  }

  public static function delete($name)
  { 
    unset($_SESSION[$name]);
  }

  public static function exists($name)
  {
    return (isset($_SESSION[$name])) ? true : false;
  }

  public static function flash($name, $string)
  {
    if (self::exists($name)) {
      $session = self::get($name);
      self::delete($name);
      return $session;
    } else {
      self::set(array($name, $string));
    }
  }
}

class Cookie
{
  public static function set($name, $value, $expiry)
  {
    $cookieData = array( "data" => $value, "expiry" => $expiry );
    if (setcookie($name, serialize( $cookieData ), $expiry)) return true;
    return false;
  }

  public static function get($name)
  {
    return unserialize($_COOKIE[$name]);
  }
  /*
  public static function delete($name)
  { 
    if (self::get($name)) {
      unset($_COOKIE[$name]);
    }
  }

  public static function exists($name)
  {
    if (isset($_COOKIE[$name])) {
      return true; 
    }
    return false;
  }

  public static function delete($name)
  {
    self::set($name, '', time() - 1);
  }
  */
}

class Http
{

  static function redirect($value = '')
  {
     exit(header('Location: ' . site . $value));
  }
}

class View
{

  public static function render($data, $arg = array())
  {
    $arg = array_merge(array('title' => ucfirst($data['section'][1]), 'path' => $data['path'], 'theme' => 'theme', 'base' => 'base.php'), $arg);
    require (VIEW . $arg['path'] . EXT);

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
    if (Session::get('current_location') !== url) {
      Session::set(array('previous_location' => Session::get('current_location')));
      Session::set(array('current_location' => url));
    }
  }
  public static function twig($string  = null , $data = null)
  {
    self::track();
    $loader = new Twig_Loader_Filesystem(VIEW);
    $twig = new Twig_Environment($loader);
    $twig = new Twig_Environment($loader, array('debug' => true, 'cache' => CACHE));
    $twig->addGlobal('site', site);
    $twig->addGlobal('title', title);
    $twig->addGlobal('url', url);
    $twig->addGlobal('session', $_SESSION);
    echo $twig->render($string, (array) $data);
  }
}

class Route
{
  function __construct($app)
  {
    $app->setting('stamp', 'router_start', timestamp(2) );

    $url = str_replace('?'. $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

    // find view with a dot in the end
    list($url, $view) = explode('.', $url);

    // count,trim, dissect the given url into sections, 1 ctrlr / 2 method
    $pos = count($section = list($ctrlr, $method) = explode('/', $url = trim($url, '/')));
 
    $seo = array(
      '' => array('path' => 'home/index'),
      'login' => array('path' => 'home/login'),
      'logout' => array('path' => 'home/logout'),
      'lost' => array('path' => 'users/lost'),
      'about' => array('path' => 'home/about'),
      'contact' => array('path' => 'home/contact'),
      'collection' => array('path' => 'collection/index'),
      'movies' => array('path' => 'collection/index', 'addParam' => 1),
      //'movies/$' => array('path' => 'collection/index', 'addParam' => 1),
      'movie/$' => array('path' => 'collection/details', 'addParam' => 1)
    );

    if (($d = $seo[$ctrlr . '/' . $method]) OR ($d = $seo[$ctrlr . '/$']) OR ($d = $seo[$ctrlr] AND empty($method)) ) {

      if (!empty($d['addParam'])) $d['path'] .= '/' . $url;
      $pos = count($section = list($ctrlr, $method) = explode('/', $d['path']));
    }
        //dump(trim($url, $section[$pos-1]));

    if (($d['addParam'] - $pos + 3) < 0) Http::redirect( trim(trim($url, $section[$pos-1]), '/') );

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

    //dump($app->get('route'));

    if ($method[0] !== '_' && method_exists($class = ucfirst($ctrlr), $method) && is_callable($class , $method)) {
      $object = new $class($app);
      $data = $object->$method($app);

      // action line
      if ($view !== 'twig' AND !empty($app)) {
        $app->setting('stamp', 'view_exit', timestamp(2) );
        Output::$view($data, $ctrlr);
      }
      return;
    }

    if (file_exists(VIEW . $path . '.twig')) {
      \View::twig($path . '.twig');
      return;
    }

    \View::page(404, 'error');
  }
}