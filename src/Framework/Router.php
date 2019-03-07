<?php

namespace Romano\Framework;

class Router
{
    /** @var array */
    private $routes;

    private $r = [
        'parameter' => [],
        'path_view' => '',
    ];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    private function findRoute(Request $request)
    {
        $routes = $this->routes;

        // home
        if (isset($routes['']) && $request->get('URI') === '') {
             return $routes[''];
        }
        unset($routes['']);

        // reduce the list based on the first section
        $foundRoutes = preg_grep("/{$request->getURLSection(0)}/i", array_keys($routes));

        foreach ($foundRoutes as $route) {
            if (\count($param = \explode('/', $route)) === \count($request->getURLSections())) {

                // string manipulation
                preg_match_all("/\{(.*?)\}/", $route, $matches);

                $value = str_replace($matches[0], '(.*)', $route);

                // now we know we have the count and the first part is ok
                if (preg_match('/' . str_replace('/', '\/', $value) . '$/', $request->get('URI'))) {
                    $resource = $routes[$route];
                    if ($matches[0]) {
                        $this->r['parameter'] = (array) $this->params($request, $matches, $param);
                    }
                    $this->r['parameter'] = array_merge($request->get('PARAMS'), $this->r['parameter']);
                    return $resource;
                }
            }
        }

        return [];
    }

    private function params(Request $request, $matches, $param)
    {
        foreach ($matches[0] as $key => $match) {
            $par[$matches[1][$key]] = urlencode($request->getURLSection(\array_search($match, $param)));
        }
        return $par;
    }

    public function search(Request $request)
    {
        $route = $this->findRoute($request);
        if (!isset($route['resource'])) {
            return false;
        }

        // controller Action
        list($route['controller'], $route['method']) = explode('@', $route['resource']);

        // template Action
        $route['template'] = isset($route['template']) ?: $route['controller'].'_'.$route['method'];

        $route['path_view'] = $route['template'].'.twig';
        $route['url'] = $request->get('URI');
        $route['path_resource'] = $route['template'].'.php';

        // we need to validate & generate the route

//        return $this->r['path_view'];
//
//        if (is_file(path('view_cache').$this->r['path_view']) || is_file(path('view').$this->r['path_view'])) {
//            return array(
//                'path' => $this->r['path_view'],
//                'data' => array()
//            );
//        }
//
//        $resource = path('resource').$this->r['path_resource'];
//
//        if (is_file($resource)) {
//            $res = new Resource($this->r['path_view'], 'twig');
//            require $resource;
//            return array(
//                'path' => $res->render(),
//                'data' => (array) $res->getScope()
//            );
//        }

        $route = array_merge($this->r, $route);

        $url = $route['url'];
        $resource = new Resource(new TemplateBuilder(), $route['path_resource']);
        $viewPath = $route['path_view'];

        return new Route($url, $resource, $viewPath);
    }
}
