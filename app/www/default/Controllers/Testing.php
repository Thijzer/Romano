<?php

class Testing extends Ctrlr
{
    public function MainTest()
    {
      $text = (string) $this->params['text'];
      dump(stringToId($text));
      return array();
    }
}
