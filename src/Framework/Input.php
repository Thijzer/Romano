<?php



class Input
{
    private static $submit = array();

    public static function isSubmitted($input = '')
    {
        if (!self::$submit) {
            self::$submit = $_REQUEST;
        }
        return (($input && isset(self::$submit[$input])) || self::$submit);
    }

    public static function get($input = '')
    {
        return (isset(self::$submit[$input])) ? self::$submit[$input] : '';
    }

    public static function getAll()
    {
        return self::$submit;
    }
}
