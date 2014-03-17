<?php

abstract class Singleton {

    private static $storage = array();

    public static function getInstance($class)
    {
        if(!static::$storage[$class]) {
            static::$storage[$class] = new $class();
        }

        return static::$storage[$class];
    }
    public static function storage()
    {
       return static::$storage;
    }

    private function  __construct() { }
    private function __clone() { }
}