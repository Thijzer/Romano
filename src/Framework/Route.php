<?php

namespace Romano\Framework;

class Route
{
    private $request;
    private $r = array();

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->r['parameter'] = array();
        $this->r['path_view'] = '';
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
                    $this->r['parameter'] = array_merge($this->request->get('PARAMS'), $this->r['parameter']);
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
        if (!isset($route['resource'])) {
            return false;
        }
        list($route['controller'], $route['method']) = explode('@', $route['resource']);

        $route['template'] = (isset($route['template'])) ?: $route['controller'].'_'.$route['method'];
        $route['path_view'] = $route['template'].'.twig';
        $route['url'] = $this->request->get('URI');
        $route['path_resource'] = $route['template'].'.php';
        $this->r = array_merge($this->r, $route);

        Container::set('route', $this->r);
        return true;
    }

    public function getTemplate()
    {
        if (is_file(path('view_cache').$this->r['path_view']) || is_file(path('view').$this->r['path_view'])) {
            return array(
                'path' => $this->r['path_view'],
                'data' => array()
            );
        }
    }

    public function getResource()
    {
        $resource = path('resource').$this->r['path_resource'];

        if (is_file($resource)) {
            $res = new Resource($this->r['path_view'], 'twig');
            require $resource;
            return array(
                'path' => $res->render(),
                'data' => (array) $res->getScope()
            );
        }
    }
}
