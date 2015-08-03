<?php

$res->store('home/index');

$res->block('content')->html('home/index')->scope('home@index');

$res->lock();
return array('path' => $res->getRender('twig'), 'data' => $res->getScope());
