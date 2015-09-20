<?php

class Testing extends Ctrlr
{
    public function MainTest()
    {
      $text = (string) $this->params['text'];
      dump( url('js/jquery/jquery.min.js') );
      dump( url('home@about'));
      dump( url('blog@related'));
      dump( url('blog@article', ['id' => '1', 'title' => $text]) );
      exit;
      return array();
    }
}
