<?php
session_start();

spl_autoload_register(function($class)
{
  $array = array('app/models/', 'app/libs/src/Romano/', 'app/controllers/');
  foreach ($array as $value) if( file_exists($value . $class . '.php')) require_once $value . $class . '.php';
  App::getInstance()->set('stamp', $class, timestamp(2) );
});

function timestamp($i = null)
{
  return (float)substr(microtime(true) - TIME, 0, (int) $i+5) * 1000;
}

abstract class Singleton
{
    private static $storage = array();

    static function getInstance($class = null)
    {
        if(!isset(static::$storage[$class])) static::$storage[$class] = new $class();

        return static::$storage[$class];
    }

    static function storage()
    {
       return static::$storage;
    }

    private function  __construct() { }
    private function __clone() { }
}

class App
{
  public $container = array();

  static function getInstance()
  {
    return Singleton::getInstance(get_class());
  }

  function set($name, $value, $values = null)
  {
    if (is_string($name . $value) AND !empty($values)) $this->container[$name][$value] = $values;
    elseif (!empty($name) AND is_array($value)) $this->container[$name] = $value;
  }

  function get($name)
  {
    if (count($name) === 3) return $this->container[$name[0]][$name[1]][$name[2]];
    elseif (is_array($name)) return $this->container[$name[0]][$name[1]];
    elseif (!empty($name)) return $this->container[$name];
  }

  function getAll()
  {
    return $this->container;
  }

  function delete($name)
  {
    unset($this->container[$name]);
  }
}

class Session
{
  static function set($array)
  {
    foreach ($array as $key => $value) if (!empty($value)) $_SESSION[$key] = $value;
  }

  static function get($name)
  {
    if(isset($_SESSION[$name])) return $_SESSION[$name];
  }

  static function delete($name)
  {
    if(is_array($name)) unset($_SESSION[$name[0]][$name[1]]);
    else unset($_SESSION[$name]);
  }

  static function flash($name, $string)
  {
    if (self::exists($name)) {
      $session = self::get($name);
      self::delete($name);
      return $session;
    }
    else self::set(array($name, $string));
  }

  static function destroy()
  {
    $_SESSION = array();
    session_regenerate_id();
  }
}

class Cookie
{
  static function set($name, $val, $expiry)
  {
    return setcookie($name, serialize(array("data" => $val, "expiry" => $expiry)), $expiry);
  }

  static function get($name)
  {
    return unserialize($_COOKIE[$name]);
  }

  static function exists($name)
  {
    return isset($_COOKIE[$name]);
  }

  static function delete($name)
  {
    self::set($name, '', time() - 1);
    unset($_COOKIE[$name]);
  }
}

class Input
{
  private static $submit = null;

  public static function submitted($input = null)
  {
    if (is_array($input)) self::$submit = $input;
    else self::$submit = array_merge($_POST, $_GET);

    if (!empty($input) AND isset(self::$submit[$input])) return true;
    elseif (!empty(self::$submit)) return true;
    return false;
  }

  public static function escape($string)
  {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
  }

  public static function get($input = null)
  {
    return self::$submit[$input];
  }

  public static function getInputs()
  {
    return self::$submit;
  }
}

class Output
{

  static function redirect($uri = '')
  {
     header('Location: ' . site . $uri);
  }

  static function page($code, $data = array())
  {
    $data = array('code' => $code);
    require VIEW . THEME . 'page.php';
  }

  static function twig($data = null, $path, $filename = null)
  {
      $path = $path . '.twig';
      $loader = new Twig_Loader_Filesystem(VIEW . THEME);
      $twig = new Twig_Environment($loader);
      $twig = new Twig_Environment($loader, array('debug' => true, 'cache' => CACHE));
      self::view( $path . '.twig', $twig->render($path, (array) $data) );
  }

  static function csv($results, $path, $filename = null)
  {
    if(!$filename) $filename = self::uniqueFilename() . '.csv';

    $outstream = fopen("php://output", "w");

    self::setheader('Content-Type: text/csv', $filename);

    fputcsv($outstream, array_keys($results[0]));

    foreach($results as $key => $result) fputcsv($outstream, $result);

    fclose($outstream);
  }

  static function xml($results, $path, $filename = null, $name = 'xml')
  {
    if(!$filename) $filename = self::uniqueFilename() . '.xml';

    self::setheader('Content-Type: text/xml', $filename);

    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8');
    if (empty($results[0])) foreach ($results as $key => $result) self::xml_parse($xml, $result, $key);

    else self::xml_parse($xml, $results, $name);
  }

  static function rss($results, $path, $filename = null, $name = 'rss')
  {
    if(!$filename) $filename = self::uniqueFilename() . '.rss';

    self::setheader('Content-Type: application/xml; charset=ISO-8859-1', $filename);

    $xml = new XMLWriter();

    date_default_timezone_set("Europe/Brussels");

    $xml->openMemory();
    $xml->startElement( 'rss' );
    $xml->writeAttribute( 'version', '2.0' );
    $xml->writeAttribute( 'xmlns:atom', 'http://www.w3.org/2005/Atom' );
    $xml->startElement( 'channel' );
    // $xml->writeElement( 'title', $title ); //required
    // $xml->writeElement( 'link', urlencode( $link ) ); //required
    // $xml->writeElement( 'description', $description ); //required
    $xml->writeElement( 'pubDate', date("Y-m-d H:i:s") );
    // $xml->writeElement( 'language', $language );
    // $xml->writeElement( 'copyright', $copyright );
    if (empty($results[0])) {
      foreach ($results as $key => $result) self::xml_parse($xml, $result, $key);
    }
    else self::xml_parse($xml, $results, $name);
  }

  static function json($results, $path, $filename = null, $name = 'json')
  {
      if(!$filename) $filename = self::uniqueFilename() . '.json';
      self::setheader('Content-type: application/json', $filename);
      self::view( $filename, json_encode($results));
  }

  static function txt($results, $path, $filename = null, $name = 'txt')
  {
    if(!$filename) $filename = self::uniqueFilename() . '.txt';

    self::setheader(array('Content-Type: application/octet-stream', 'Content-Transfer-Encoding: binary'), $filename);

    $data = 'fields = ' . implode (', ', array_keys($results[0])) . "\n\n";

    foreach($results as $key => $result) {
      $data .= 'item '. $key . ':' . "\n";
        foreach($result as $item_key => $item) {
          $data .= $item_key . '=' . $item . "\n";
        }
        $data .= "\n";
    }
    self::view( $filename, $data);
  }

  static function dev($results)
  {
    if(DEV_ENV) dump(App::getInstance()->getAll()); dump($_SESSION); dump($results);
  }

  static function view($filename, $data)
  {
    // file_put_contents(CACHE . 'html/' . $filename, $data);
    echo $data;
  }

  static function xml_parse($xml, $results, $name)
  {
    $xml->startElement($name);
    foreach($results as $result) {
        $xml->startElement($name . '-item');
        foreach($result as $item_key => $item) {
            $xml->startElement($item_key);
            //$xml->writeAttribute($item_key, $item);
            $xml->text($item);
            $xml->endElement();
        }
        $xml->endElement();
    }
    $xml->endElement();
    $xml->endDocument();
    self::view( $filename, $xml->outputMemory(true));
    $xml->flush();
  }

  static function setHeader($headers, $filename)
  {
    if (!is_array($headers)) header($headers);
    else foreach ($headers as $value) header($value);
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Pragma: no-cache');
    header("Expires: 0");
  }

  static function uniqueFilename()
  {
    return md5(uniqid() . microtime(TRUE) . mt_rand());
  }
}

class Track
{
  static function getIP()
  {
      foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
          if (isset($_SERVER[$key])) {
              foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var(trim($ip), FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                  return $ip;
                }
                elseif (DEV_ENV === true) return $ip;
              }
          }
      }
  }

  static function location($url)
  {
    if ($url AND Session::get('current_location') !== $url) {
      Session::set(array('previous_location' => Session::get('current_location')));
      Session::set(array('current_location' => $url));
    }
  }

  static function getOS()
  {
    //$spiders = array('Googlebot', 'Yammybot', 'Openbot', 'Yahoo', 'Slurp', 'msnbot', 'ia_archiver', 'Lycos', 'Scooter', 'AltaVista', 'Teoma', 'Gigabot', 'Googlebot-Mobile');
    $OS = array(
      'Windows 7' => '(Windows NT 6.1)', 'Windows 8' => '(Windows NT 6.2)',
      'Windows Vista' => '(Windows NT 6.0)', 'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
      'Linux' => '(Linux)|(X11)',

      'iPhone' => 'Apple-iPhone/', 'iPod' => 'Apple-iPod/',
      'iPad' => 'Apple-iPad/', 'Android' => 'Linux; U; Android',
      'Search Bot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)',
      'Windows 3.11' => 'Win16', 'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
      'Windows 98' => '(Windows 98)|(Win98)', 'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
      'Windows XP' => '(Windows NT 5.1)|(Windows XP)', 'Windows Server 2003' => '(Windows NT 5.2)',
      'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)', 'Windows ME' => 'Windows ME',
      'Open BSD' => 'OpenBSD', 'Sun OS' => 'SunOS', 'QNX' => 'QNX', 'BeOS' => 'BeOS', 'OS/2' => 'OS/2'
    );

    foreach($OS as $current0S => $match) {
        if (eregi($match, $_SERVER['HTTP_USER_AGENT'])) return $current0S;
    }
  }
}

class Route
{
  function express($app)
  {
    $seo = $app->get('seo');
    $uri = trim(str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']), '/');
    $uri_parts = pathinfo($uri); //'filename', 'basename', 'extension'
    $pos = count($section = explode('/', $uri));
    $pos > 1 ? list($ctrlr, $method) = $section : $ctrlr = $section[0];

    if ((!isset($method) AND $seoPath = $seo[$ctrlr])
      OR (isset($seo[$ctrlr . '/' . $method]) AND $seoPath = $seo[$ctrlr . '/' . $method])
      OR (isset($seo[$ctrlr . '/$']) AND $seoPath = $seo[$ctrlr . '/$'])
      OR (isset($seo[$ctrlr . '/' . $method . '/$']) AND $seoPath = $seo[$ctrlr . '/' . $method . '/$'])
    )
    {

      // correct the new variables
      $count = count(list($ctrlr, $method) = explode('/', $seoPath['path']));

      if (isset($seoPath['addParam'])) {

        $i = $pos - $seoPath['addParam'];
        $max = $count + $seoPath['addParam'];

        // redirect if we find more the allowed params
        if ($pos > $max) Output::redirect( trim($url, $section[$pos - 1]) );
        for ($i; $i < $pos ; $i++) $params[] = $section[$i];
      }
    }

    // now all values are set lets compare against the paths array
    $app->set(
      'route', array(
        'parameter' => isset($params) ? $params : null,
        'controller' => $ctrlr, 'method' => $method,
        'positions' => $pos,
        'path' => $path = $ctrlr . '/' . $method,
        'filename' => $ctrlr . '-' . $method,
        'view' => $view = (!isset($uri_parts['extension']) ? 'twig' : $uri_parts['extension'])
    ));

    $meta = array(
        'site' => site,
        'uri' => $uri,
        'title' => title,
        'language' => '',
        'description' => ''
    );

    // check if method exists
    if (method_exists($class = ucfirst($ctrlr), $method) && is_callable($class , $method)) {
      $object = new $class($app);
      $results = $object->$method($app);
      $results['meta'] = $meta;
      return $results;
    }
    // check if file exsists
    elseif (file_exists(VIEW . THEME . $path . '.' . $view)) {
      $results['meta'] = $meta;
      return $results;
    }

    Output::page(404);
  }
}
