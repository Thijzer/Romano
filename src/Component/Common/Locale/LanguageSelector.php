<?php

namespace Romano\Component\Common\Locale;

use Romano\Framework\Container;
use Romano\Framework\Lang;

class LanguageSelector
{
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
        Container::setParam(array('path', 'Romano\Component\Common\Locale\Lang', path('Romano\Component\Common\Locale\Lang') . $this->getLanguage() . '.php'));
        Container::setParam(array('path', 'routes', path('url')));

        // setup locale language
        Lang::set(require path('Romano\Component\Common\Locale\Lang'));
    }

    public function hasLanguage($language, $languages)
    {
        return (in_array($language, array_keys($languages)));
    }
}