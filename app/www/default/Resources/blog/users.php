<?php
$res->scope('blog@getAllArticlesFromUser');
$res->block('content')->html('home/articles');
//$res->block('sidebar')->html('home/recentPost');
$res->block('sidebar')->html('users/loggedIn');
