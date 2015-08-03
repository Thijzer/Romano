<?php
 // merges with global settings
return array(

        'head' => array(
            'title' => 'blog.dev',
            'site' => 'http://blog_test.dev/',
        ),

        'meta' => array(
            'charset' => 'utf-8',
            'author' => '',
            'keywords' => 'GG, GG',
            'description' => '',
            'site' => 'http://blog_test.dev/',
            'robots' => 'noindex, nofollow'
        ),

        'site_languages' => array(
            'en' => 'en_EN',
            'nl' => 'nl_BE',
            'fr' => 'fr_FR'
        ),

        /* please do no switch your multi_language boolean in production */

        'multi_language' => false,
        'default_language' => 'en',

        'extensions' => array(
            'txt', 'xls', 'csv', 'json', 'rss'
        ),

        'view' => 'twig',

        'theme' => 'admin',
);
