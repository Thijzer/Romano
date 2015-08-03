<?php

class Crypt
{
    static function toSalt($stringA = null, $stringB = null)
    {
        $ab = (string) self::dynSalt($stringA) . self::dynSalt($stringB);
        return hash('SHA512', $ab );
    }

    static function dynSalt($string = null, $salt = null)
    {
        require 'settings/salt.php';

        for ($i = 0; $i < strlen($string); $i++) $salt .= $char[$string[$i]];
        return $salt;
    }

    static function token()
    {
        return Session::put(App::getInstance()->get('config', array('session', 'token'), self::unique()));
    }

    static function check($token)
    {
        $token_name = App::getInstance()->get('config', array('session', 'token'));

        if (Session::get($token_name) && $token === Session::get($token_name)) {
            Session::delete($token_name);
            return true;
        }
        return false;
    }

    static function unique()
    {
        return (implode(range('A', 'Z'), '') . time(TRUE));
    }

    static function getTime()
    {
        return strtotime( '+30 days' );
    }

    static function random($size = 8, $chars = null, $result = null)
    {
        if (!$chars) $chars = self::unique();
        $i = strlen($chars) - 1;
        for ($p = 0; $p < $size; $p++) {
            $result .= ($p % 2) ? $chars[mt_rand($i % 2, $i)] : $chars[mt_rand(0, $i)];
        }
        return $result;
    }
}
