<?php

class Container
{
    private static $container = array();

    public static function getAll($name)
    {
        return self::$container[$name];
    }

    public static function get(array $name)
    {
        return (isset(self::$container[$name[0]][$name[1]])) ? self::$container[$name[0]][$name[1]] : '';
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
