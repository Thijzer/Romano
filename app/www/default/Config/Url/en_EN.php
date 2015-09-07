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
// $routes['pagination'] = array('resource' => 'home@index', 'route' => 'page/{page}');
// $routes['blog_index'] = array('resource' => 'blog@index', 'route' => 'blog', 'nav_name' => 'blog');
// $routes['blog_$users'] = array('resource' => 'blog@users', 'route' => 'blog/{user}');
// $routes['collections'] = array('resource' => 'collection@index', 'route' => 'collections', 'nav_name' => 'collections');
// $routes['collections_$type'] = array('resource' => 'collection@index', 'route' => 'collections/{type}', 'nav_name' => 'collections_$type');

$routes = array(
    '' => array('resource' => 'home@index'),
    'page/{page}' => array('resource' => 'home@index', 'rel' => 'nofollow'),
    'users/login' => array('name' => 'u_login', 'resource' => 'users@login', 'rel' => 'nofollow'),
    'login/facebook' => array('resource' => 'users@facebook', 'rel' => 'nofollow'),
    'login/fbaccess' => array('resource' => 'users@fbaccess', 'rel' => 'nofollow'),
    'logout' => array('resource' => 'users@logout', 'rel' => 'nofollow'),
    'register' => array('resource' => 'users@register', 'rel' => 'nofollow'),
    'lost' => array('resource' => 'users@lost', 'rel' => 'nofollow'),
    'about' => array('resource' => 'home@about'),
    'contact' => array('resource' => 'home@contact'),
    'collections' => array('resource' => 'collection@index'),
    'collections/{type}' => array('resource' => 'collection@index'),
    'movies' => array('resource' => 'collection@movies', 'template' => 'collection/index'),
    'movie/{title}' => array('resource' => 'collection@details'),
    'blog/article/{id}/{title}' => array('resource' => 'blog@article'),
    'blog/{user}' => array('resource' => 'blog@users'),
    'testing/{text}' => array('resource' => 'testing@MainTest')
);


// $urls['collection@index'][] = 'collections';
// $urls['collection@index'][] = 'collections/{type}';
// $urls['collection@index'][] = 'movies';
// $urls['collection@details'][] = 'movie/{title}';
// $urls['contact'] = '/contact';
// $urls['movies'] = '/movies';
// $urls['tvshows'] = '/tvshows';
// $urls['login'] = '/login';
// $urls['about'] = '/about';
// $urls['lost'] = '/lost';
// $urls['logout'] = '/logout';
// $urls['collections'] = '/collections';

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
