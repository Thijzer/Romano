<?php
$res->setBaseFile('base-simple.twig');
$res->block('css')->html('users/login.css');
$res->block('content')->html('users/login.html');
if ($this->request->isMethod('get')) $res->scope('users@login');
elseif ($this->request->isMethod('post')) $res->scope('users@checkLogin');
