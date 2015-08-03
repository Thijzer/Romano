<?php

$res->store('blog/index'); // cache();

$res->block('content')->html('blog/index')->scope('blog@index');

$res->lock();
return array('path' => $res->getRender('twig'), 'data' => $res->getScope());
