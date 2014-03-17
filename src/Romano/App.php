<?php

Class App
{
  public $i = 0;
  public $container = array();

  public static function getInstance()
  {
    return Singleton::getInstance(get_class());
  }

  public function set($name, $value)
  {
    if ($name AND is_array($value)) $this->container[$name] = $value;
  }

  public function setting($name1, $position, $val)
  {
    if ($val) $this->container[$name1][$position] = $val;
  }

  public function setArray($name, $array)
  {
    if ($name AND is_array($array)) $this->container[$name] = $array;
  }

  public function getVal($name, $value)
  {
    if ($name AND is_array($value)) return $this->container[$name][$value];
  }

  public function get($name)
  {
    if (is_array($name)) return $this->container[$name[0]][$name[1]];
    if ($name) return $this->container[$name];
  }

  public function getAll()
  {
    return $this->container;
  }

  public function config($array)
  {
    $this->setArray('config', $array);
  }

  public function setPath($array)
  {
    $this->setArray('path ' . $this->i++, $array);
  }

  public function getPath()
  {
    return $this->container['path ' . $this->i];
  }
}