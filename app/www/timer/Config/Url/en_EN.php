<?php

/**
* dynamic routes
*
* here rest the dynamic routes, navigation and url
*
* they can be adjusted from here or from the CMS
* the CMS will look for possible missing routes and
* offer a alternative redirect of none is given.
*
*/

$routes = array(
    // auto controller mode
    '' => array('resource' => 'home@index'),
    '{model}/{controller}/$' => array('resource' => '{model}@{controller}'),
);

return array('routes' => $routes);
