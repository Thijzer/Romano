<?php



class Files
{
    private static $resourse = array(), $root, $files;

    static function get($path, $root, $ext = 'php')
    {
        $content = null;
        if(is_array($path)) {
            foreach ($path as $p)
            {
                $content .= file_get_contents($root . $p . '.' . $ext);
            }
        }
        else $content = file_get_contents($root . $path . '.' . $ext);
        return $content;
    }

    static function getKey($path, $ext)
    {
        if(self::exists($path) && !self::$files[$path]['key']) {
            self::$files[$path] = array( 'key' => $key = md5(self::get($path, $ext)));
            return $key;
        }
    }

    static function compare($path1, $path1)
    {
        return (self::getKey($path1) == self::getKey($path2))? true : false;
    }

    // http://php.net/manual/en/function.fwrite.php
    static function collect($resourse )
    {
        self::$resourse = $resourse;
    }

    static function set($path, $ext = 'php')
    {
        $fpath = self::$root . $path . '.' . $ext;
        if (file_exists($fpath)) {
            $fp = fopen($fpath, "w+");
        }
        else {
            self::create($path);
            $fp = fopen($fpath, "a+");
        }
        fwrite($fp, self::$resourse);
        fclose($fp);
    }

    static function root($root)
    {
        self::$root = $root;
    }

    static function create($path)
    {
        $c = count($arrPath = explode('/', $path)) -1;

        $parent = self::$root;
        foreach($arrPath as $key => $path)
        {
            if (!self::exists($parent .$path) && $c !== $key ){
                mkdir($parent . $path);
                $parent .= $path . '/';
            }
        }
    }

    static function exists($path)
    {
        if(isset(self::$files[$path]) || file_exists($path)){
            self::$files[$path] = array( 'path' => $path);
            return true;
        }
        else return false;
    }
}
