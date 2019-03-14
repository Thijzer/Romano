<?php

namespace Romano\Framework\Functions;

class Characters
{
    private static $FOREIGN = ['ç','æ','œ','á','é','í','ó','ú','à','è','ì','ò','ù','ä','ë','ï','ö','ü','ÿ','â','ê','î','ô','û','å','e','i','ø','u'];
    private static $FOREIGN_replacements = ['c','ae','oe','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','y','a','e','i','o','u','a','e','i','o','u'];

    private static function getChars()
    {
        return array(
            'specials' => array ("'",'’'),
            'markUp' => array ('(',')','[',']','"','«','»',':','.','?','!',',',';','{','}','`'),
            'html' => array ('<','>','/'),
            'extras' => array ('~','@','$','%','^','&','|','+','='),
            'markDown' => array ('#','-','*'),
            'alfabet' => range('a', 'z'),
            'alfabetCap' => range('A', 'Z'),
            'numbers' => range(0, 9)
        );
    }
}