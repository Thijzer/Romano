<?php

namespace Romano\Component\Common\Locale;

class Lang
{
    public static $array;

    public static function get($route, $replacers = array())
    {
        list($type, $slug) = explode('.', $route, 2);
        if (!isset(self::$array[$type][$slug])) {
            return '!!! missing locale !!! : ' . $route;
        }

        $response = self::$array[$type][$slug];
        if (!empty($replacers)) {
            return str_replace(array_flip($replacers), $replacers, $response);
        }

        return $response;
    }

    public static function set(array $locale)
    {
        if (!self::$array) {
            self::$array = $locale;
        }
    }
}
