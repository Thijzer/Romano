<?php

require '../bootstrap.php';

// start Request
$request = new Request($_SERVER, $_REQUEST);

// start Application Environment
$application = new Application();
$application->setRootConfiguration(dirname(__DIR__), 'settings/globals.php');
$application->buildEnvironmentFromRequest($request);

// start Routes
$route = new Route($request);
if (($route->search($application->getRoutes())) && ($result = $route->getResource())) {
    $view = $request->get('VIEW');
    //$track = Track::get()->fromClient();

    // route view
    if ($route->getTemplate() && $view === config('view')) {
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
