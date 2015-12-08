<?php


// set the root directory
chdir(dirname(__FILE__));

/**
 * Include Core Classes
 */

 // in order for the application to work we need to bootstrap a couple of
 // none of it's functionality can work without it.
 // classes :: container,

require 'src/Romano/Container.php';
require 'src/Romano/Request.php';
require 'src/Romano/Config.php';
require 'src/Romano/Application.php';

// require 'src/Romano/App.php';
require 'vendor/autoload.php';

/**
 * Set of Global functions
 * Mostly incapsulating static methods
 */

function timestamp()
{
    return (float) round((round(microtime(true), 4) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 1);
}

function stamp($from)
{
    Container::setParam(array('stamp', $from, timestamp()));
}

// we need to move this to autoload
spl_autoload_register(function ($class) {
    foreach (path('autoload') as $path) {
        if (file_exists($found = $path.$class.'.php')) {
            stamp($class);
            return require $found;
        }
    }
});

function path($path)
{
    return Container::get(array('path', $path));
}

function config($config, $name = null)
{
    return (!empty($name))
        ? Container::getParam(array('config', $config, $name))
        : Container::get(array('config', $config));
}

function url($url = null, array $params = array())
{
    if (strpos($url, '@') !== false) {
        if ($nurl = Container::get(array('url', $url))) {
            if ($params) {
                $glu = implode('_', array_keys($params));
                $route = $nurl['dynamic'][$glu];
                foreach ($params as $key => $value) {
                    $route = str_replace('{'.$key.'}', $value, $route);
                }
                return $route;
            }
            if (!isset($nurl['static'])) {
                return $url.' route doesn\'t exist as static';
            }
            // only return the first static route
            return array_values($nurl['static'])[0];
        }
        // dead end
        return 'no route found for '.$url;
    }

    // asset connection
    $nurl = Container::get(array('url', 'home@index'));
    return array_values($nurl['static'])[0].$url; // asset_folder index
}

function view($result, $debug = true)
{
    $debugMode = (config('kernel_debug') === $debug);
    $loader = new \Twig_Loader_Filesystem(array(path('view_cache'), path('view'), path('view').'/base') );
    $twig = new \Twig_Environment(
        $loader,
        array(
        'cache' => path('cache') . ($debugMode ? 'twig_dev/' : 'twig_prod/' ),
        'debug' => $debugMode,
        )
    );
    $twig->addFilter(new \Twig_SimpleFilter('lng', array('Lang', 'get')));
    $twig->addFunction(new \Twig_SimpleFunction('url', function ($string) {
        return src/Romano/Container::get(array('url', $string));
    }));
    Container::delete('config');
    Container::delete('path');
    echo $twig->render($result['path'], $result['data']);
}

function leave($msg)
{
    $trace = debug_backtrace();
    dump($msg);
    dump("Called by {$trace[1]['class']} @ {$trace[1]['function']}");
    massdump("");
}

function crc32b($str)
{
    return hash('crc32b', $str);
}

function stringToId($string, $replacers = array('-','_','.','/','%2520',' '))
{
    $nums = '';
    $string = str_replace($replacers, '', strtolower(trim($string)));
    $string = (strlen($string) > 10) ? crc32b($string) : $string;
    $az = array_flip(str_split('etaoinsrhldcumfpgwybvkxjqz'));
    foreach (str_split($string) as $split) {
        $nums .= (is_numeric($split)) ?  $split : $az[$split];
    }
    return $nums;
}


if (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] === 'dev') {
    require 'settings/dev.php';
    stamp('Application');
}
