<?php
 // merges with global settings
return array(

        'head' => array(
            'title' => 'blog.dev',
            'site' => 'http://web.blog_test.dev',
        ),

        'meta' => array(
            'charset' => 'utf-8',
            'author' => '',
            'keywords' => 'GG, GG',
            'description' => '',
            'site' => 'http://web.blog_test.dev',
            'robots' => 'noindex, nofollow'
        ),

        'site_languages' => array(
            'en' => 'en_EN',
            'nl' => 'nl_BE',
            'fr' => 'fr_FR'
        ),


        'EMAIL' => array(
            'HOST' => 'smtp.gmail.com',
            'USER' => 'TBCdevil@gmail.com',
            'PASS' => '5783A5799U',
            'FWRD' => 'donotreply@thijzer.com'
        ),

        /**
         *   please do no switch your multi_language boolean in production
         *   all te routes will change seo lost
         */

        'multi_language' => false,
        'default_language' => 'en',

        'extensions' => array(
            'txt', 'xls', 'csv', 'json', 'rss'
        ),

        'view' => 'twig',

        'theme' => 'romano',
);
