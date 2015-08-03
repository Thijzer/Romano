<?php
abstract class Singleton
{
    private static $storage = array();

    public static function getInstance($cls)
    {
        if($cls && !isset(static::$storage[$cls])) static::$storage[$cls] = new $cls();
        return static::$storage[$cls];
    }

    private function  __construct(){}
    private function __clone(){}
}

class Kernel
{
    public function setConfig(array $config)
    {
        Container::set(array('config', $config));
    }
    public function getConfig()
    {
        return Container::getAll('config');
    }
    public function setParameter(array $param)
    {
        Container::setParam(array('config', $param[0], $param[1]));
    }
    public function getParameter($param)
    {
        return Container::get(array('config', (string) $param));
    }
    public function buildPath()
    {
        $config = $this->getConfig();
        $path['app'] = $config['root'] . 'app/' . $config['app_env'] . '/';
        $path['src'] = $config['root'] . 'romano/src/Romano/';
        $path['app_config'] = $path['app'] . 'Config/';
        $path['lang'] = $path['app_config'] . 'Language/';
        $path['url'] = $path['app_config'] . 'Url/';
        $path['resource'] = $path['app'] . 'Resources/';
        $path['cache'] = $path['app'] . 'Cache/';
        $path['controller'] = $path['app'] . 'Controllers/';
        $path['model'] = $path['app'] . 'Models/';
        $path['autoload'] = array($path['controller'], $path['model'], $path['src']);
        if (isset($config['theme']) && isset($config['head']['site'])) {
            $path['root_url'] = $config['head']['site'];
            $path['theme_view'] = $path['app'] . 'Themes/' . $config['theme'] . '/';
            $path['theme_cache'] = $path['cache'] . $config['theme'] . '/';
            $path['theme_name'] = $config['theme'];
        }
        Container::set(array('path', $path));
    }
    public function buildURL($url)
    {
        Container::set(array('url', $url));
    }
}

class Container
{
    private static $container = array();
    public static function getAll($name)
    {
        return self::$container[$name];
    }
    public static function get(array $name)
    {
        return self::$container[$name[0]][$name[1]];
    }
    public static function getParam(array $name)
    {
        return self::$container[$name[0]][$name[1]][$name[2]];
    }
    public static function set(array $vars)
    {
        if (!isset(self::$container[$vars[0]])) {
            self::$container[$vars[0]] = array();
        }
        self::$container[$vars[0]] = array_merge(self::$container[$vars[0]], $vars[1]);
    }
    public static function setParam(array $vars)
    {
        self::$container[$vars[0]][$vars[1]] = $vars[2];
    }
    public static function addToArray(array $vars)
    {
        self::$container[$vars[0]][$vars[1]][] = $vars[2];
    }
    public static function delete($name)
    {
        unset(self::$container[$name]);
    }
}

class Session
{
    private static $token = '';
    private static function token()
    {
        if (!self::$token) {
            self::$token = (string) config('session_token');
            session_start();
        }
        return self::$token;
    }
    public static function set($array)
    {
        foreach ($array as $key => $value) {
            $_SESSION[self::token()][$key] = $value;
        }
    }
    public static function get($name)
    {
        return (isset($_SESSION[self::token()][$name])) ? $_SESSION[self::token()][$name] : false;
    }
    public static function delete($name)
    {
        unset($_SESSION[self::token()][$name]);
    }
    // public static function flash($name, $string)
    // {
    //     if ($session = self::get(array($name, $string))) {
    //         self::delete($name);
    //         return $session;
    //     }
    //     self::set(array($name, $string));
    // }
    public static function destroy()
    {
        $_SESSION[self::token()] = array();
        session_regenerate_id();
    }
}

class Request
{
    private $req = array();
    public function __construct(array $server, array $resquest, Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->req['server'] = (array) $server;
        $this->req['request'] = (array) $resquest;
        $this->req['uri'] = trim(str_replace('?' . $server['QUERY_STRING'], '', $server['REQUEST_URI']), '/');
        $this->req['sections'] = explode('/', $this->req['uri']);
        $this->req['host'] = $server['HTTP_HOST'];
        $this->req['host_sections'] = explode('.', $this->req['host']);
        $this->req['method'] = strtolower($server['REQUEST_METHOD']);
        $this->req['language'] = '';
        $this->getExtension();
    }
    public function getAppEnv()
    {
        $app = $this->kernel->getParameter('app');
        $defHost = $this->kernel->getParameter('default_host');
        $defApp  = $this->kernel->getParameter('default_app');

        // look into the hostname
        if (in_array($this->get('host'), array_keys($app))) {
            $defHost = $this->getHostSection(0);
        }

        // look into the url
        if (isset($app[$defHost]) && in_array($this->getURLSection(0), $app[$defHost])) {
            $defApp = $this->getURLSection(0);
            $this->removeURLsection(0);
        }

        $this->req['app_env'] = $defHost . '/' . $defApp;
        return $this->req['app_env'];
    }
    public function setMultiLanguage($languages)
    {
        if ($this->hasLanguage($this->getURLSection(0), $languages)) {
            $this->req['language'] = $languages[$this->getURLSection(0)];
            $this->removeSection(0);
        }
    }
    public function getLanguage()
    {
        if (empty($this->req['language'])) {
            $languages = $this->kernel->getParameter('site_languages');
            $default = $this->kernel->getParameter('default_language');
            $this->req['language'] = $languages[$default];
        }
        return $this->req['language'];
    }
    public function setLanguage()
    {
        Container::setParam(array('path', 'url', path('url') . $this->getLanguage() . '.php'));
        Container::setParam(array('path', 'lang', path('lang') . $this->getLanguage() . '.php'));
        Container::setParam(array('path', 'routes', path('url')));
    }
    public function hasLanguage($language, $languages)
    {
        return (in_array($language, array_keys($languages)));
    }
    public function get($name)
    {
        return $this->req[(string) $name];
    }
    public function getExtension()
    {
        if (!isset($this->req['view'])) {
            $this->req['view'] = $this->kernel->getParameter('view');
            $parts = pathinfo($this->req['uri']);
            if (isset($parts['extension'])) {
                $this->req['uri'] = str_replace('.' . $parts['extension'], '', $this->req['uri']);
                $this->req['view'] = $parts['extension'];
                $this->req['sections'] = explode('/', $this->req['uri']);
            }
        }
        return $this->req['view'];
    }
    public function getURLSection($section)
    {
        return (!is_integer($section))?: $this->req['sections'][$section];
    }
    public function getHostSection($section)
    {
        return (!is_integer($section))?: $this->req['host_section'][$section];
    }
    public function count($name)
    {
        return count($this->get($name));
    }
    public function removeURLSection($section)
    {
        unset($this->req['sections'][$section]);
        $this->req['sections'] = array_values($this->req['sections']);
        $this->req['uri'] = implode('/', $this->req['sections']);
    }
    public function isMethod($method)
    {
        return (strtolower($method) == $this->get('method'));
    }
    public function isSubmitted($name = 'submit')
    {
        if ($this->count('request') > 0) {
            return isset($this->req['request'][$name]);
        }
    }
}

class Input
{
    private static $submit = array();

    public static function isSubmitted($input = '')
    {
        if (!self::$submit) {
            self::$submit = $_REQUEST;
        }
        return (($input && isset(self::$submit[$input])) || self::$submit);
    }

    public static function get($input = '')
    {
        return (isset(self::$submit[$input])) ? self::$submit[$input] : '';
    }

    public static function getAll()
    {
        return self::$submit;
    }
}

class Route
{
    private $request;
    private $r = array();
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->r['parameter'] = array();
    }
    private function findRoute(array $routes)
    {
        if ($this->request->get('uri') == '' && isset($routes[''])) {
             return $routes[''];
        }
        // reduce the list look for first index
        $foundRoutes = (array) preg_grep("/{$this->request->getURLSection(0)}/i", array_keys($routes));
        foreach ($foundRoutes as $route) {
            if (count($param = explode('/', $route)) === $this->request->count('sections')) {
                // string manipulation
                preg_match_all("/\{(.*?)\}/i", $route, $matches);
                    $value = str_replace($matches[0], '(.*)', $route);

                    // now we know we have the count and the first part is ok
                    if (preg_match('/' . str_replace('/', '\/', $value) . '$/', $this->request->get('uri'))) {
                        $resource = $routes[$route];
                        if ($matches[0]) $this->r['parameter'] = (array) $this->params($matches, $param);
                        return $resource;
                    }
            }
        }
        return array();
    }
    private function params($matches, $param)
    {
        foreach ($matches[0] as $key => $match) {
            $par[$matches[1][$key]] = urlencode($this->request->getURLSection(array_search($match, $param)));
        }
        return $par;
    }
    private function storeRoute()
    {
        if (Session::get('uri') != $this->request->get('uri')) {
            Session::set(array('previous_uri' => Session::get('uri')));
            Session::set(array('uri' => $this->request->get('uri')));
        }
    }
    public function search(array $routes)
    {
        $route = $this->findRoute($routes);
        if (!$route) {
            return false;
        }
        list($this->r['controller'], $this->r['method']) = explode('@', $route['resource']);

        if (isset($route['rel']) && $route['rel'] !== 'nofollow') {
            $this->storeRoute();
        }

        $this->r['path'] = (isset($route['template'])) ? $route['template']: $this->r['controller'] . '/' . $this->r['method'];
        $this->r['path_view'] = $this->r['path'] . '.twig';
        $this->r['path_resource'] = $this->r['path'] . '.php';
        $this->r['filename'] = $this->r['controller'] . '-' . $this->r['method'];
        $this->r['previous_uri'] = Session::get('previous_uri');
        $this->r['resource'] = $route['resource'];
        Container::set(array('route', $this->r));
        return true;
    }
    public function getController()
    {
        $class = ucfirst($this->r['controller']);
        $method = $this->r['method'];

        if (is_callable(array($class, $method))) {
            $class = new $class();
            return array(
                'data' => (array) $class->$method($this->request),
                'path' => $this->r['path_view']
            );
        }
    }
    public function getTemplate()
    {
        if (file_exists(path('theme_view') . $this->r['path_view'])) {
            return array(
                'path' => $this->r['path_view'],
                'data' => array()
            );
        }
    }
    public function getResource()
    {
        $resource = path('resource') . $this->r['path_resource'];

        if (file_exists($resource)) {
            $res = new Resource($this->r);
            require $resource;
            return array(
                'path' => $res->getRender('twig'),
                'data' => (array) $res->getScope()
            );
        }
    }
}

class Lang
{
    public static $array;

    public static function get($route, $replacers = array())
    {
        list($type, $slug) = explode('.', $route, 2);
        if (!isset(self::$array[$type][$slug])) {
            return '!! missing locale : ' . $route;
        }
        $respons = self::$array[$type][$slug];
        if (!empty($replacers)) {
            return str_replace(array_flip($replacers), $replacers, $respons);
        }
        return $respons;
    }

    public static function set($locale)
    {
        if (!self::$array) {
             self::$array = $locale;
        }
    }
}

class Resource
{
    private $storePath = '', $route = array(), $module = array(), $scope = array(), $block, $caviar = array(), $path, $baseFile = 'base.twig', $name, $lock = false;
    private $options = array(
        'twig' => array(
            'extends' => '{% extends "$1" %}',
            'block' => "{% block $1 %}\n$2{% endblock %}",
            'include' => '{% include "$1" %}'
        )
    );

    public function __construct($route)
    {
        $this->route =  $route;
        $this->storePath = $this->route['path'];
    }

    public function block($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setBaseFile($baseFile)
    {
        $this->baseFile = $baseFile;
    }

    public function scope($re) // we need to move it to render
    {
        if(isset($this->scope[$re])) return $this->scope[$re];

        list($ctrl, $method) = explode('@', $re);

        if (!empty($this->module)) {
            require 'modules/' .  $this->module . '/Controllers/' . ucfirst($ctrl) . '.php';
            $this->module = array();
        }

        if (isset($this->index[$ctrl]))
        {
            $this->scope[$re] = (array) $this->index[$ctrl]->$method();
            $this->caviar = array_merge($this->caviar, $this->scope[$re]);
            return $this;
        }
        elseif (is_callable($class = ucfirst($ctrl), $method)) {
            $class = new $class();
            $this->index[$ctrl] = $class;
            $this->scope[$re] = (array) $class->$method();
            $this->caviar = array_merge($this->caviar, $this->scope[$re]);

            return $this;
        }
        else die('resoure@scope undefined method passed');

    }

    public function module($moduleName)
    {
        $this->module = $moduleName;
        return $this;
    }

    public function addToScope($name, $scope)
    {
        $this->caviar = array_merge($this->caviar, array($name => $scope));
    }

    public function html($path)
    {
        $this->block[$this->name][] = $path;
        return $this;
    }

    public function store($path)
    {
        $this->storePath = $path;
    }

    public function getRender($engine, $render = "{# Generated file from Resource #}\n\n")
    {
        $root = path('cache') . path('theme_name') . '/';
        $store = $root . $this->storePath . '.twig';

        if(DEV_ENV !== true && file_exists($store)) return $this->storePath . '.twig';

        if ($options = $this->options[$engine])
        {
            if($this->baseFile)
            {
                $render .= str_replace('$1', $this->baseFile, $options['extends']);
            }
            if(!$this->block) exit('Resource :: we are missing html blocks');

            foreach($this->block as $key => $block)
            {
                $A = array('$1', '$2');
                $B = array($key, Files::get($block, path('theme_view'), 'twig'));
                $render .= str_replace($A, $B, $options['block']) . "\n";
            }
            //return $render;
            if ($this->lock === true) $render .= "\n" . '{# locked #}';
        }
        else exit('Select a proper render engine');

        if(md5(Files::get($this->storePath, $root, 'twig')) !== md5($render))
        {
            Files::root($root);
            Files::collect($render);
            Files::set($this->storePath, 'twig');
        }

        return $this->storePath  . '.twig';
    }

    public function getScope()
    {
        return $this->caviar;
    }

    public function lock()
    {
        $this->lock = true;
    }
}

class DB extends \PDO
{
    /**
    * @var array
    */
    protected $stmt, $query, $params, $results;
    protected $options = array(\PDO::ATTR_EMULATE_PREPARES, false);
    protected $fetchMode = \PDO::FETCH_ASSOC;

    public function __construct($DB = null)
    {
        // \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
        if (!$DB) $DB = config('DB');
        try {
            parent::__construct($DB['DSN'], $DB['USER'], $DB['PASS'], $this->options);
        } catch (\PDOException $e) {
            if (DEV_ENV === true) dump($e->getMessage());
            throw Output::page('500','CONNECTION ERROR');
        }
    }

    private function processParams()
    {
        try {
            if($this->stmt = $this->prepare($this->query)) {
                return $this->stmt->execute($this->params);
            }
        } catch (\PDOException $e) {
            if (DEV_ENV === true) throw $e;
            else throw Output::page('500', 'CONNECTION ERROR');
        }
    }

    public static function run($results = array(), $run = false)
    {
        $instance = Singleton::getInstance(get_class());

        if (!empty($results)) {
            $instance->query = (string) $results['query'];
            $instance->params = (isset($results['params'])) ? (array) $results['params'] : array();
            $instance->results[] = $results;
            $instance->stmt = null;
            if ($run === true) $instance->processParams();
        }
        return $instance;
    }

    public function fetch()
    {
        if ($this->query AND $this->processParams()) return $this->stmt->fetch($this->fetchMode);
    }

    public function get($value)
    {
        if ($this->query AND $this->processParams()) {
            $temp = $this->stmt->fetch($this->fetchMode);
            return (isset($temp[$value])) ? $temp[$value] : die($value . ' is not set');
        }
    }

    public function getId($id = 'id')
    {
        $result = $this->fetch(); return $result[$id];
    }

    public function getInsertedId()
    {
        return $this->lastInsertId();
    }

    public function fetchAll()
    {
        if ($this->query AND $this->processParams()) return $this->stmt->fetchAll($this->fetchMode);
    }

    public function fetchPairs()
    {
        if ($result = $this->stmt->fetch($this->fetchMode)) return array(reset($result) => end($result));
    }

    public function fetchValues($limiter = ',')
    {
        if ($result = $this->stmt->fetch($this->fetchMode)) return implode($limiter, array_values($result));
    }

    public function getResults()
    {
        return (isset($this->results)) ? $this->results : '';
    }
}

abstract class Ctrlr
{
    function __construct()
    {
        $this->route = container::getAll('route');
        $this->params = $this->route['parameter'];
    }

    function param($name)
    {
        return $this->route['parameter'][$name];
    }
}
