<?php

class Output
{
    private static $site = '';

    public static function redirect($uri = null)
    {
        header('Location: /' . self::$site . $uri);
    }

    public static function page($code)
    {
        $data = array('code' => $code);
        require path('theme_view') . 'page.php';
    }
}
