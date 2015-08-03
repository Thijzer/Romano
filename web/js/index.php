<?php

$resource = new Resource();
$resource->setBaseFile('base.twig');
$resource->store('blog/index');

$resource->block('content')->html('blog/index')->scope('blog@index');

$resource->lock();
return array('path' => $resource->getRender('twig'), 'data' => $resource->getScope());
