<?php

class Cookie
{
    static function set($name, $data, $expiry)
    {
        return setcookie($name, json_encode($data), $expiry);
    }

    static function get($name)
    {
        if (self::exists($name)) return (array) json_decode($_COOKIE[$name]);
    }

    static function exists($name)
    {
        return isset($_COOKIE[$name]);
    }

    static function delete($name)
    {
        self::set($name, '', time() - 1);
        unset($_COOKIE[$name]);
    }
}
