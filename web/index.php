<?php
require '../globals.php';
require 'settings/dev.php';
stamp('Application');

// start Request
$request = new Request($_SERVER, $_REQUEST);

// start Application Environment
$application = new Application($request);
$application->setRootDirectory(dirname(__DIR__).'/');
$application->buildEnvironmentFromRequest();

// setup locale language
Lang::set(require path('lang'));

// start routes
$route = new Route($request);
$routes = require path('routes');
if
(
    ($route->search($routes['routes'])) &&
    ($result = $route->getResource()) ||
    ($result = $route->getController()) ||
    ($result = $route->getTemplate())
)
{
    $application->buildURL($routes['routes']);
    $view = $request->get('VIEW');
    //$track = Track::get()->fromClient();

    // route view
    if ($view === config('view')) {
        view($result);
    } elseif (config('kernel_debug') === true && $view === 'dev') {
        stamp('View');
        massdump($result);
    }
} else {
    Output::page(404);
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
