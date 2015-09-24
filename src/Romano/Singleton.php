<?php



abstract class Singleton
{
    private static $storage = array();

    public static function getInstance($cls)
    {
        if(!isset(static::$storage[$cls])) static::$storage[$cls] = new $cls();
        return static::$storage[$cls];
    }

    private function  __construct(){}
    private function __clone(){}
}
