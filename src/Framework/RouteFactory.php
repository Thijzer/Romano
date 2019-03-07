<?php

namespace Romano\Framework;

class RouteFactory
{
    public function getRoutes(): array
    {
        $routes = require path('routes');
        $this->buildURL($routes['routes']);
        return $routes['routes'];
    }

    private function buildURL($urlList)
    {
        $app = '/';
        $app .= ($this->defApp !== 'default') ? $this->defApp.'/' : '';
        $app .= ($this->currentLanguage) ? $this->currentLanguage.'/' : '';

        $tmp = [];
        foreach ($urlList as $key => $route) {
            if (isset($route['params'])) {
                preg_match_all('~{(.*?)}~', $key, $output);
                $glu = implode('_', $output[1]);
                $tmp[$route['resource']]['dynamic'][$glu] = $app.$key;
                continue;
            }

            $tmp[$route['resource']]['static'][] = $app.$key;
        }

        $this->config->setParameter('url', $tmp);
    }

    public static function buildRouter(ConfigurationManager $config)
    {
        return new Router();
    }
}