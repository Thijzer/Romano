<?php

$res->store('overview/index');

//$res->block('content')->html('overview/index');


$res->lock();
return array('path' => $res->getRender('twig'), 'data' => $res->getScope());
