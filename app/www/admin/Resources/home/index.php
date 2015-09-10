<?php

$res->store('home/index');
$res->block('content')->html('home/index')->scope('home@index');
$res->lock();
