<?php
$res->scope('files@index');

$res->block('content')->html('files/index');
$res->block('content')->html('pagination');

// $res->block('sidebar')->html('blog/recentArticles')->scope('blog@recentArticles');
// $res->block('sidebar')->html('blog/recentCategories');
// $res->block('sidebar')->html('users/loggedIn');
