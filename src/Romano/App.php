<?php
// session_save_path('/tmp');
session_start();

function timestamp($i = null)
{
    return (float) substr(microtime(true) - TIME, 0, (int) $i + 5) * 1000;
}

spl_autoload_register(function($class)
{
    $app = App::getInstance();
    $array = array('app/controllers/', 'app/models/', 'app/libs/src/Romano/');
    foreach ($array as $path) {
        if(!class_exists($class) && is_file($path . $class . '.php')) {
            $app->set('stamp', $class, timestamp(2));
            //if (is_callable($class, '__init__')) $class::__init__();
            return require_once $path . $class . '.php';
        }
    }
});

abstract class Singleton
{
    private static $storage = array();

    static function getInstance($cls)
    {
        if($cls && !isset(static::$storage[$cls])) static::$storage[$cls] = new $cls();
        return static::$storage[$cls];
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
        if (is_string($value) && !empty($values)) $this->container[$name][$value] = $values;
        elseif (!empty($name) && is_array($value)) $this->container[$name] = $value;
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
    static function set($name, $data, $expiry)
    {
        return setcookie($name, serialize($data), $expiry);
    }

    static function get($name)
    {
        if (self::exists($name)) return unserialize($_COOKIE[$name]);
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

        if (!empty($input) && isset(self::$submit[$input])) return true;
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
    static function redirect($uri = null)
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
        if (is_file(VIEW . THEME . $path)) {
            $loader = new Twig_Loader_Filesystem(VIEW . THEME);
            // $twig = new Twig_Environment($loader);
            $twig = new Twig_Environment($loader, array('debug' => true, 'cache' => CACHE));
            $twig->addFilter(new Twig_SimpleFilter('lng', array('Lang', 'get')));
            self::view( $path . '.twig', $twig->render($path, (array) $data) );
        }
    }

    static function dev($results)
    {
        $app = App::getInstance();
        if(DEV_ENV) dump($app->get('stamp'), 'time stamps'); dump($results, 'results'); dump($_COOKIE, 'cookie'); dump($_SESSION, 'session'); dump($app->get('client'), 'tracker');//dump(Input::getInputs(), 'inputs');
    }

    static function view($filename, $data)
    {
        // file_put_contents(CACHE . 'html/' . $filename, $data);
        echo $data;
    }

    static function uniqueFilename()
    {
        return md5(uniqid() . microtime(TRUE) . mt_rand());
    }
}

class Track
{
    public $settings = array();

    function getIP()
    {
        $ipList = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');

        foreach ($ipList as $key){
            if (isset($_SERVER[$key])) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var(trim($ip), FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        $this->settings['env'] = 'global';
                        return $ip;
                    }
                    else {
                        $this->settings['env'] = 'local';
                        return $ip;
                    }
                }
            }
        }
    }

    function location($route)
    {
        if ($route['path'] && (Session::get('current_uri') !== $route['current_uri'])) {
            Session::set(array('previous_uri' => Session::get('current_uri')));
            Session::set(array('current_uri' => $route['current_uri']));
        }
    }

    function getOS($os)
    {
        foreach ($os as $type => $osTypes) {
            foreach($osTypes as $current0S => $match) {
                if (eregi($match, $_SERVER['HTTP_USER_AGENT'])) return $current0S;
            }
        }
    }
}

class Route
{
    function express($app)
    {
        $method = null;
        $params = array();

        $uri = trim(str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']), '/');

        // find the extension
        $uri_parts = pathinfo($uri); //'filename', 'basename', 'extension'
        if(isset($uri_parts['extension'])) {
            $uri = str_replace('.' . $uri_parts['extension'], '', $uri);
        }
        else $uri_parts['extension'] = 'twig';

        $pos = count($section = explode('/', $uri));

        // the language slug handler
        $languages = array('en', 'nl', 'fr', 'pl');
        if (isset($languages[$section[0]])) {
            $pos--;
            $seo = $app->get(array('seo', $section[0]));
            unset($section[0]);
            $section = array_values($section);
        }
        else $seo = $app->get(array('seo', 'en'));

        $pos > 1 ? list($ctrlr, $method) = $section : $ctrlr = $section[0];

        // the uri detector
        switch (true) {
            // uri found in seo table
            case isset($seo[$uri]):
                $seoPath = $seo[$uri];
                break;
            // parameter is in the back
            case isset($seo[$ctrlr . '/$']):
                $seoPath = $seo[$ctrlr . '/$'];
                $param = true;
                $pos--;
                break;
            // uri is a parameter
            case (isset($seo['$' . $ctrlr]) && !isset($section[1])):
                $seoPath = $seo['$' . $ctrlr];
                $params[] = $ctrlr;
                break;
            // parameter is in the back
            case isset($seo[$ctrlr . '/' . $method . '/$']):
                $seoPath = $seo[$ctrlr . '/' . $method . '/$'];
                $param = true;
                break;
            default:
                return false;
        }

        // override method controller
        $max = count(list($ctrlr, $method) = explode('/', $seoPath));

        if (isset($param)) {

            $p = $pos;
            if ($pos > $max) return false;
            for ($p; $p < $max ; $p++) if(isset($section[$p])) $params[] = $section[$p ];
        }

        $route = array(
            'parameter' => $params,
            'controller' => $ctrlr,
            'method' => $method,
            'positions' => $pos,
            'path' => $ctrlr . '/' . $method,
            'filename' => $ctrlr . '-' . $method,
            'view' => $uri_parts['extension'],
            'current_uri' => $uri,
            'previous_uri' => Session::get('previous_uri')
        );
        return $route;
    }

    function getResults($app)
    {
        // check if method exists
        $route = $app->get('route');
        if (method_exists($class = ucfirst($route['controller']), $route['method'])) {
            $class = ucfirst($route['controller']);
            $object = new $class($app);
            return $object->$route['method']($app);
        }
    }
}

class Lang
{
    public static $array;

    static function get($route, $replacers = array())
    {

        list($type, $slug) = explode('.', $route, 2);
        if (!self::$array) self::$array = App::getInstance()->get('trans');
        $respons = self::$array[$type][$slug];
        if (!empty($replacers)) str_replace(array_flip($replacers), $replacers, $respons);
        else return $respons;
    }
}
