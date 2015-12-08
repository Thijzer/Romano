<?php
$res->setBaseFile('base-simple.twig');
$res->block('content')->html('users/register.html');
if ($this->request->isMethod('get')) $res->scope('users@registerElems');
elseif ($this->request->isMethod('post')) $res->scope('users@register');
$res->block('css')->html('users/login.css');
// $r->block('content')->form('users/login.css');
