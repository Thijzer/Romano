<?php

$res->scope('blog@index');

// res->meta('name="robots" content="nofollow"');

$res->block('content')->html('blog/articles');
$res->block('content')->html('pagination');

$res->block('sidebar')->html('blog/recentArticles')->scope('blog@recentArticles');
$res->block('sidebar')->html('blog/recentCategories');
$res->block('sidebar')->html('users/loggedIn');
