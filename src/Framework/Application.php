<?php

namespace Romano\Framework;

class Application
{
    private $request;
    private $config;

    private $currentLanguage = '';
    private $defApp;

    public function __construct(string $root, array $configurations)
    {
        $this->config = new ConfigurationManager(new Matroska($configurations));
        $this->config->setParameter('root', $root.'/');
    }

    public function buildProject(): void
    {
        $config = $this->config->getAll();
        $path['root'] = $config['root'];
        $path['app'] = 'app/'.$config['app_name'].'/';
        $path['src'] = 'src/';
        $path['app_config'] = $path['app'].'config/';
        $path['lang'] = $path['app_config'].'Language/';
        $path['url'] = $path['app_config'].'Url/';
        $path['resource'] = $path['src'].'Resources/';
        $path['cache'] = $path['src'].'Cache/';
        $path['controller'] = $path['src'].'Controllers/';
        $path['model'] = $path['src'].'Models/';

        if (isset($config['head']['site'])) {
            $path['root_url'] = $config['head']['site'];
            $path['view'] = $path['app'].'Views/'.$config['view'].'/';
            $path['view_cache'] = $path['cache'].$config['view'].'_view/';
        }

        $this->config->setParameter('path', $path);
    }

    /**
     * @param Request $request
     * Allow the request to decide which configuration set should be loaded
     * This is important for example multi domain, locale based routes,
     * The configuration should be hard backed (read-only) into the configuration
     */
    public function buildEnvironmentFromRequest(Request $request): void
    {
        $app = $this->config->getParameter('app');
        $defHost = $this->config->getParameter('default_host');
        $this->defApp = $this->config->getParameter('default_app');
        $appEnv = $defHost.'/'.$this->defApp;

        // look into the hostname
        if (array_key_exists($request->get('HTTP_HOST'), $app)) {
            $defHost = $request->getHostSection(0);
        }

        // look into the url
        if (array_key_exists($request->getURLSection(0), $app[$defHost])) {
            $this->defApp = $this->request->getURLSection(0);
            $this->request->removeURLsection(0);
        }

        //$this->config->setConfiguration(require 'app/'.$appEnv.'/Config/Settings.php');

        // we push the default view
        if (!$request->get('VIEW')) {
            $request->set('VIEW', $this->config->getParameter('view'));
        }

        $this->config->setParameter('app_name', $appEnv);
        $this->config->setParameter('app_domain', $request->get('HTTP_HOST'));

        $this->buildProject();

        if ($this->config->getParameter('multi_language') === true) {
            //$this->setMultiLanguage();
        }
        //$this->setLanguage();
    }

    public function buildRouter(): router
    {
        return RouteFactory::buildRouter($this->getProvisionedConfig());
    }

    public function getProvisionedConfig(): ConfigurationManager
    {
        return $this->config;
    }

    public function getConfig(): ConfigurationManager
    {
        return $this->config;
    }
}
