<?php

$res->scope('blog@article');

$res->block('content')->html('blog/article');
$res->block('content')->html('blog/blog_comment');
