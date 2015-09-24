<?php

class Config extends Container
{
    public function __construct($configurationFile)
    {
        $this->setConfiguration($configurationFile);
    }

    public function setConfiguration($configurationFile)
    {
        self::set('config', $configurationFile);
    }

    public function getConf()
    {
        return self::getAll('config');
    }

    public function setParameter($key, $value)
    {
        self::setParam(array('config', $key, $value));
    }

    public function getParameter($param)
    {
        return self::get(array('config', (string) $param));
    }
}
