<?php

class Application
{
    private $request;
    private $config;
    private $currentLanguage = '';

    public function setRootConfiguration($root, $configurationFile)
    {
        $this->config = new Config(require $configurationFile);
        $this->config->setParameter('root', $root.'/');
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
        $config = $this->config->getConf();
        $path['root'] = $config['root'];
        $path['app'] = $config['root'].'app/'.$config['app_env'].'/';
        $path['src'] = $config['root'].'src/Romano/';
        $path['app_config'] = $path['app'].'Config/';
        $path['lang'] = $path['app_config'].'Language/';
        $path['url'] = $path['app_config'].'Url/';
        $path['resource'] = $path['app'].'Resources/';
        $path['cache'] = $path['app'].'Cache/';
        $path['controller'] = $path['app'].'Controllers/';
        $path['model'] = $path['app'].'Models/';

        $path['autoload'] =  array_merge(
            array($path['controller'], $path['model'], $path['src']),
            $this->getModules($config['root'], $config['modules'])
        );

        if (isset($config['theme']) && isset($config['head']['site'])) {
            $path['root_url'] = $config['head']['site'];
            $path['theme_view'] = $path['app'].'Themes/'.$config['theme'].'/';
            $path['theme_cache'] = $path['cache'].$config['theme'].'/';
            $path['theme_name'] = $config['theme'];
        }

        Container::set('path', $path);
    }

    public function buildURL($urlList)
    {
        $app = '/';
        $app .= ($this->defApp !== 'default') ? $this->defApp.'/' : '';
        $app .= ($this->currentLanguage) ? $this->currentLanguage.'/' : '';

        foreach ($urlList as $key => $route) {
            if (isset($route['params'])) {
                preg_match_all('~{(.*?)}~', $key, $output);
                $glu = implode('_', $output[1]);
                $tmp[$route['resource']]['dynamic'][$glu] = $app.$key;
                continue;
            }

            $tmp[$route['resource']]['static'][] = $app.$key;
        }

        Container::set('url', $tmp);
    }

    public function buildEnvironmentFromRequest(Request $request)
    {
        $this->request = $request;
        $app = $this->config->getParameter('app');
        $defHost = $this->config->getParameter('default_host');
        $this->defApp = $this->config->getParameter('default_app');

        // look into the hostname
        if (in_array($this->request->get('HTTP_HOST'), array_keys($app))) {
            $defHost = $this->request->getHostSection(0);
        }

        // look into the url
        if (in_array($this->request->getURLSection(0), $app[$defHost])) {
            $this->defApp = $this->request->getURLSection(0);
            $this->request->removeURLsection(0);
        }

        $appEnv = $defHost.'/'.$this->defApp;
        $this->config->setConfiguration(require 'app/'.$appEnv.'/Config/Settings.php');

        // we push the default view
        if (!$this->request->get('VIEW')) {
            $this->request->set('VIEW', $this->config->getParameter('view'));
        }

        $this->config->setParameter('app_env', $appEnv);
        $this->config->setParameter('app_domain', $this->request->get('HTTP_HOST'));

        $this->buildProject();

        if ($this->config->getParameter('multi_language') === true) {
            $this->setMultiLanguage();
        }
        $this->setLanguage();
    }

    public function setMultiLanguage()
    {
        $languages = $this->config->getParameter('site_languages');
        $section = $this->request->getURLSection(0);
        if ($this->hasLanguage($section, $languages)) {
            $this->request->set('LANGUAGE', $languages[$section]);
            $this->request->removeURLSection(0);
            $this->currentLanguage = $section;
            return;
        }
        // multi language
        // Output::page(404);exit;
    }

    public function getLanguage()
    {
        if (!$this->request->get('LANGUAGE')) {
            $languages = $this->config->getParameter('site_languages');
            $default = $this->config->getParameter('default_language');
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
