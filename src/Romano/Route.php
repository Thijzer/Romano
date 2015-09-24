<?php


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
        // home
        if ($this->request->get('URI') == '' && isset($routes[''])) {
             return $routes[''];
        }
        unset($routes['']);

        // reduce the list based on the first section
        $foundRoutes = (array) preg_grep("/{$this->request->getURLSection(0)}/i", array_keys($routes));

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
        list($route['controller'], $route['method']) = explode('@', $route['resource']);

        $path = (isset($route['template'])) ?
            $route['template']:
            $route['controller'].'/'.$route['method'];
        $route['path_view'] = $path.'.twig';
        $route['path_resource'] = $path.'.php';
        $route['resource'] = $route['resource'];
        $this->r = array_merge($this->r, $route);
        Container::set('route', $this->r);
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
