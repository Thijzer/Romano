<?php

class Http
{

  static function redirect($value = '')
  {
     exit(header('Location: ' . site . $value));
  }
}