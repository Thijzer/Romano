<?php

$res->scope('blog@getAllArticlesFromUser');
$res->block('content')->html('blog/articles');
//$res->block('sidebar')->html('home/recentPost');
$res->block('sidebar')->html('users/loggedIn');
