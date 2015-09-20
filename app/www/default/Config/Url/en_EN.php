<?php

/**
* dynamic routes
*
* here rest the dynamic routes, dyn navigation, dyn url
*
* they can be adjusted from here or from the CMS
* the CMS will look for possible missing routes and
* offer a alternative redirect of none is given.
*
*/

$routes = array(
    '' => array('resource' => 'home@index'),
    'page/{page}' => array('resource' => 'home@index', 'rel' => 'nofollow', 'params' => 1),
    'users/login' => array('name' => 'u_login', 'resource' => 'users@login', 'rel' => 'nofollow'),
    'login/facebook' => array('resource' => 'users@facebook', 'rel' => 'nofollow'),
    'login/fbaccess' => array('resource' => 'users@fbaccess', 'rel' => 'nofollow'),
    'logout' => array('resource' => 'users@logout', 'rel' => 'nofollow'),
    'register' => array('resource' => 'users@register', 'rel' => 'nofollow'),
    'lost' => array('resource' => 'users@lost', 'rel' => 'nofollow'),
    'about' => array('resource' => 'home@about'),
    'contact' => array('resource' => 'home@contact'),
    'collections' => array('resource' => 'collection@index'),
    'collections/{type}' => array('resource' => 'collection@type', 'template' => 'collection/index', 'params' => 1),
    'movies' => array('resource' => 'collection@movies', 'template' => 'collection/index'),
    'movie/{title}' => array('resource' => 'collection@details', 'params' => 1),
    'blog/article/{id}/{title}' => array('resource' => 'blog@article', 'params' => 1),
    'blog/{user}' => array('resource' => 'blog@users', 'params' => 1),
    'testing/{text}' => array('resource' => 'testing@MainTest', 'params' => 1),
);

$sibs = array(
    'movies' => array(
        'label' => 'movies',
        'url' => 'movies'
    ),
    'tvshows' => array(
        'label' => 'tvshows',
        'url' => 'tvshows'
    ),
);

$blog = array(
    'label' => 'blog',
    'url' => ''
);

$collection = array(
    'label' => 'collection',
    'url' => 'collection',
    'sibs' => $sibs
);

$contact = array(
    'label' => 'contact',
    'url' => 'contact'
);

$about = array(
    'label' => 'about',
    'url' => 'about'
);

$nav = array(
    'main' => array(
        'blog' => $blog,
        'collections' => $collection,
        'contact' => $contact,
        'about' => $about
    )
);

return array('nav' => $nav, 'routes' => $routes);
