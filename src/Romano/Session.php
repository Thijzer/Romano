<?php

class Session
{
    private static $token = '';
    private static function token()
    {
        if (!self::$token) {
            self::$token = (string) config('session_token');
            session_start();
        }
        return self::$token;
    }
    public static function set($array)
    {
        $token = self::token();
        foreach ($array as $key => $value) {
            $_SESSION[$token][$key] = $value;
        }
    }
    public static function get($name)
    {
        $token = self::token();
        return (isset($_SESSION[$token][$name])) ? $_SESSION[$token][$name] : false;
    }
    public static function delete($name)
    {
        unset($_SESSION[self::token()][$name]);
    }
    // public static function flash($name, $string)
    // {
    //     if ($session = self::get(array($name, $string))) {
    //         self::delete($name);
    //         return $session;
    //     }
    //     self::set(array($name, $string));
    // }
    public static function destroy()
    {
        $_SESSION[self::token()] = array();
        session_regenerate_id();
    }
}
