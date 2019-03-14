<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../app/config.php';

use \Romano\Framework\HTTP\Request;
use \Romano\Framework\Application;

$request = new Request();
$application = new Application(dirname(__DIR__), $configuration);
$application->buildEnvironmentFromRequest($request);
$router = $application->buildRouter();

if ($route = $router->search($request)) {
    $view = $request->get('VIEW');
    //$track = Track::get()->fromClient();
    $response = $route->getResponse();

//    // route view
//    if ($route->getTemplate() && $view === config('view')) {
//        view($result);
//    } elseif (config('kernel_debug') === true && $view === 'dev') {
//        stamp('View');
//        massdump($result);
//    }
//} else {
//    Output::page(404);
}





//Meta::Set(config('meta'));












// $template = new tempate();
// $template->style('bootstrap');
// $template->meta('site', 'bootstrap');
// cache::('nav', function($routes) {
//     return $template->createMainNav($routes['nav'])
// });


//$route->get('extras', array('resource' => $request['uri']));

//echo (App::getInstance()->get(array('config', 'theme')) );

// if (file_exists(CACHE . 'html/'. $url . '.' . $view )) {
//   echo require(CACHE .  'html/'. $url . '.' . $view ); exit;
// }
