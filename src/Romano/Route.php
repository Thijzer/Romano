<?php

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
        if (file_exists(path('theme_view').$this->r['path_view']) || file_exists(path('theme_cache').$this->r['path_view'])) {
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
