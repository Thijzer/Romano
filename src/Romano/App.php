<?php
abstract class Singleton
{
    private static $storage = array();

    public static function getInstance($cls)
    {
        if(!isset(static::$storage[$cls])) static::$storage[$cls] = new $cls();
        return static::$storage[$cls];
    }

    private function  __construct(){}
    private function __clone(){}
}

class Application extends Container
{
    private static $container = array();
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function setRootDirectory($root)
    {
        $this->setParameter(array('root', $root));
        $this->setConfigFile('settings/globals.php');
    }
    public function setConfigFile($config)
    {
        self::set(array('config', require $config));
    }
    public function getConfig()
    {
        return self::getAll('config');
    }
    public function setParameter(array $param)
    {
        self::setParam(array('config', $param[0], $param[1]));
    }
    public function getParameter($param)
    {
        return self::get(array('config', (string) $param));
    }
    private function getModules($app, $modules)
    {
      $app = $app . 'modules/';
      foreach ($modules as $module) {
        $tmp[] = $app.$module."/Controllers/";
        $tmp[] = $app.$module."/Models/";
      }
      return $tmp;
    }
    public function buildProject()
    {
        $config = $this->getConfig();
        $path['app'] = $config['root'].'app/'.$config['app_env'].'/';
        $path['src'] = $config['root'].'src/Romano/';
        $path['app_config'] = $path['app'].'Config/';
        $path['lang'] = $path['app_config'].'Language/';
        $path['url'] = $path['app_config'].'Url/';
        $path['resource'] = $path['app'].'Resources/';
        $path['cache'] = $path['app'].'Cache/';
        $path['controller'] = $path['app'].'Controllers/';
        $path['model'] = $path['app'].'Models/';
        $modules = $this->getModules($config['root'], $config['modules']);
        $path['autoload'] =  array_merge(array($path['controller'], $path['model'], $path['src']), $modules);

        if (isset($config['theme']) && isset($config['head']['site'])) {
            $path['root_url'] = $config['head']['site'];
            $path['theme_view'] = $path['app'].'Themes/'.$config['theme'].'/';
            $path['theme_cache'] = $path['cache'].$config['theme'].'/';
            $path['theme_name'] = $config['theme'];
        }
        Container::set(array('path', $path));
    }
    public function buildURL($urlList)
    {
        $meta = $this->getParameter('meta');
        foreach($urlList as $key => $route) {
            if (isset($route['name'])) {
                $tmp[$route['name']] = $meta['site'].'/'.$key;
                continue;
            }
            $tmp[str_replace(array('{','}'), '', $key)] = $meta['site'].'/'.$key;
        }
        Container::set(array('url', $tmp));
    }
    public function buildEnvironmentFromRequest()
    {
        $app = $this->getParameter('app');
        $defHost = $this->getParameter('default_host');
        $defApp  = $this->getParameter('default_app');

        // look into the hostname
        if (in_array($this->request->get('HTTP_HOST'), array_keys($app))) {
            $defHost = $this->request->getHostSection(0);
        }

        // look into the url
        if (in_array($this->request->getURLSection(0), $app[$defHost])) {
            $defApp = $this->request->getURLSection(0);
            $this->request->removeURLsection(0);
        }

        $appEnv = $defHost.'/'.$defApp;
        $this->setConfigFile('app/'.$appEnv.'/Config/Settings.php');

        // we push the default view
        if (!$this->request->get('VIEW')) {
            $this->request->set('VIEW', $this->getParameter('view'));
        }

        $this->setParameter(array('app_env', $appEnv));
        $this->setParameter(array('app_domain', $this->request->get('HTTP_HOST')));

        $this->buildProject();

        if ($this->getParameter('multi_language') === true) {
            $this->setMultiLanguage();
        }
        $this->setLanguage();
    }
    public function setMultiLanguage()
    {
        $languages = $this->getParameter('site_languages');
        $section = $this->request->getURLSection(0);
        if ($this->hasLanguage($section, $languages)) {
            $this->request->set('LANGUAGE', $languages[$section]);
            $this->request->removeSection(0);
        }
    }
    public function getLanguage()
    {
        if ($this->request->get('LANGUAGE') === '') {
            $languages = $this->getParameter('site_languages');
            $default = $this->getParameter('default_language');
            $this->request->set('LANGUAGE', $languages[$default]);
        }
        return $this->request->get('LANGUAGE');
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
        $token = self::token();
        foreach ($array as $key => $value) {
            $_SESSION[$token][$key] = $value;
        }
    }
    public static function get($name)
    {
        $token = self::token();
        return (isset($_SESSION[$token][$name])) ? $_SESSION[$token][$name] : false;
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
    public function __construct(array $server, array $resquest)
    {
        $this->req = array_merge($server, $resquest);
        $this->req['URI'] = trim(str_replace('?'.$server['QUERY_STRING'], '', $server['REQUEST_URI']), '/');
        $this->req['SECTIONS'] = explode('/', $this->req['URI']);
        $this->req['HOST_SECTIONS'] = explode('.', $this->req['HTTP_HOST']);
        $this->req['LANGUAGE'] = '';
        $this->req['VIEW'] = '';
        $parts = pathinfo($this->req['URI']);
        if (isset($parts['extension'])) {
            $this->req['URI'] = str_replace('.'.$parts['extension'], '', $this->req['URI']);
            $this->req['VIEW'] = $parts['extension'];
            $this->req['SECTIONS'] = explode('/', $this->req['URI']);
        }
    }
    public function get($name)
    {
        return $this->req[(string) $name];
    }
    public function set($name, $value)
    {
        return $this->req[(string) $name] = $value;
    }
    public function getURLSection($section)
    {
        return (!is_integer($section))?: $this->req['SECTIONS'][$section];
    }
    public function getHostSection($section)
    {
        return (!is_integer($section))?: $this->req['HOST_SECTION'][$section];
    }
    public function count($name)
    {
        return count($this->get($name));
    }
    public function removeURLSection($section)
    {
        unset($this->req['SECTIONS'][$section]);
        $this->req['SECTIONS'] = array_values($this->req['SECTIONS']);
        $this->req['URI'] = implode('/', $this->req['SECTIONS']);
    }
    public function isMethod($method)
    {
        return (strtoupper($method) === $this->get('REQUEST_METHOD'));
    }
    public function isSubmitted($name = 'submit')
    {
        if ($this->count('REQUEST_METHOD') > 0) {
            return isset($this->req['REQUEST_METHOD'][$name]);
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
        $this->r['controller'] = '';
        $this->r['method'] = '';
        $this->r['path_view'] = '';
    }
    private function findRoute(array $routes)
    {
        // home
        if ($this->request->get('URI') == '' && isset($routes[''])) {
             return $routes[''];
        }
        unset($routes['']);

        // reduce the list look for first index
        $foundRoutes = (array) preg_grep("/{$this->request->getURLSection(0)}/i", array_keys($routes));

        // auto controller
        if (isset($routes["{model}/{controller}/$"]) && count($foundRoutes) === 0) {
            $class = $this->request->getURLSection(0);
            $ctrlr = $this->request->getURLSection(1);
            $index = $class.'/'.$ctrlr;
            $routes[$index] =  array('resource' => $class.'@'.$ctrlr, 'rel' => 'nofollow');
            $foundRoutes[] = $index;
        }

        foreach ($foundRoutes as $route) {
            if (count($param = explode('/', $route)) === $this->request->count('SECTIONS')) {
                // string manipulation
                preg_match_all("/\{(.*?)\}/i", $route, $matches);
                    $value = str_replace($matches[0], '(.*)', $route);

                    // now we know we have the count and the first part is ok
                    if (preg_match('/' . str_replace('/', '\/', $value) . '$/', $this->request->get('URI'))) {
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
    public function search(array $routes)
    {
        $route = $this->findRoute($routes);
        if (!$route) {
            return false;
        }
        list($this->r['controller'], $this->r['method']) = explode('@', $route['resource']);

        $this->r['path'] = (isset($route['template'])) ? $route['template']: $this->r['controller'].'/'.$this->r['method'];
        $this->r['path_view'] = $this->r['path'].'.twig';
        $this->r['path_resource'] = $this->r['path'].'.php';
        $this->r['filename'] = $this->r['controller'].'-'.$this->r['method'];
        // we need to move this to the tracker
        $this->r['previous_uri'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
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
        if (file_exists(path('theme_view').$this->r['path_view'])) {
            return array(
                'path' => $this->r['path_view'],
                'data' => array()
            );
        }
    }
    public function getResource()
    {
        $resource = path('resource').$this->r['path_resource'];

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
            return '!! missing locale : '.$route;
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
    private $storePath = '', $route = array(), $scope = array(), $block, $caviar = array(), $path, $baseFile = 'base.twig', $name, $lock = false;
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
        if(isset($this->scope[$re])) {
          return $this->scope[$re];
        }

        list($ctrl, $method) = explode('@', $re);
        if (is_callable($class = ucfirst($ctrl), $method)) {
            $class = new $class();
            $this->index[$ctrl] = $class;
            $this->scope[$re] = (array) $class->$method();
            $this->caviar = array_merge($this->caviar, $this->scope[$re]);
            return $this;
        }
        die('resoure@scope undefined method passed');
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

    public function getRender($engine, $render = "{# Generated file from Resource #}\n")
    {
        $root = path('cache') . path('theme_name').'/';
        $store = $root . $this->storePath.'.twig';
        $render .= "{# ".date('l jS \of F Y h:i:s A')." #}\n\n";

        if(DEV_ENV !== true && file_exists($store)) return $this->storePath.'.twig';

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

        return $this->storePath.'.twig';
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

    public function __construct($DB = array())
    {
        try {
            $DB = array_merge(config('DB'), $DB);
            parent::__construct($DB['DSN'], $DB['USER'], $DB['PASS'], $this->options);
        } catch (\PDOException $e) {
            if (DEV_ENV === true) {
                throw dump($e->getMessage());
            }
            throw Output::page('500','CONNECTION ERROR');
        }
    }

    private function processParams()
    {
        $this->stmt = $this->prepare($this->query);
        $check = $this->stmt->execute($this->params);
        if ($check === false) {
            dump($this->stmt->errorInfo());
            dump($this->results);
            Output::page('500', 'CONNECTION ERROR');
        }
        return $check;
    }

    public static function run(array $process)
    {
        $instance = Singleton::getInstance(get_class());
        $instance->query = (string) $process['query'];
        $instance->params = (isset($process['params'])?$process['params']:[]);
        $instance->stmt = null;
        $instance->results[] = $process;
        $instance->processParams();
        return $instance;
    }

    public function fetch()
    {
        return $this->stmt->fetch($this->fetchMode);
    }

    public function fetchAllBy($value)
    {
        $results = $this->stmt->fetchAll($this->fetchMode);
        foreach ($results as $result) {
            $tmp[$result['id']] = $result;
        }
        return $tmp;
    }

    public function get($value)
    {
        $temp = $this->stmt->fetch($this->fetchMode);
        return (isset($temp[$value])) ? $temp[$value] : dump($value.' is not set');
    }

    public function getId($id = 'id')
    {
        return $this->get('id');
    }

    public function getInsertedId()
    {
        return $this->lastInsertId();
    }

    public function fetchAll()
    {
        return $this->stmt->fetchAll($this->fetchMode);
    }

    public function fetchPairs($a, $b)
    {
        if ($results = $this->stmt->fetchAll($this->fetchMode)) {
            foreach ($results as $result) {
                $tmp[$result[$a]] = $result[$b];
            }
            return $tmp;
        }
    }

    public function fetchValues($limiter = ',')
    {
        if ($result = $this->stmt->fetch($this->fetchMode)) {
            return implode($limiter, array_values($result));
        }
    }

    public function getResults()
    {
        return $this->results;
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
        return $this->params[$name];
    }

    function pagination($rowCount, $offset, $limit)
    {
        $requestedPage = 1;
        if (!isset($this->params['page'])) {
            $this->params['page'] = 1;
        }
        $options['offset'] = $offset;
        $options['limit'] = $limit;

        $options['num_items'] = $rowCount;
        $requestedPage = (int) $this->params['page'];
        $options['num_pages'] = (int) ceil($options['num_items'] / $options['limit']);

        if ($options['num_pages'] === 0) {
            $options['num_pages'] = 1;
        }
        if ($requestedPage > $options['num_pages'] || $requestedPage < 1) {
            Output::redirect(404);
        }

        $options['requested_page'] = $requestedPage;
        $options['prev'] = $requestedPage-1;
        $options['next'] = $requestedPage+1;
        $options['url'] = '/page';
        $options['next_lbl'] = Lang::get('lbl.next');
        $options['prev_lbl'] = Lang::get('lbl.prev');
        $options['offset'] = ($options['requested_page'] * $options['limit']) - $options['limit'];
        return $options;
    }
}
