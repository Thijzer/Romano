<?php

class Testing extends Ctrlr
{
    public function MainTest()
    {
        $this->FileTest();
    //   $text = (string) $this->params['text'];
    //   dump( url('js/jquery/jquery.min.js') );
    //   dump( url('home@about'));
    //   dump( url('blog@related'));
    //   dump( url('blog@article', ['id' => '1', 'title' => $text]) );
      exit;
      return array();
    }

    public function FileTest()
    {
        dump(path('cache'));

        stamp('A');
        $fs = new FileSystem(path('cache'), 'test');

        //dump($fs->exists('testnames.txt'));
        dump($fs->find('testnames.txt'));
        stamp('find');
        $fs->scan();
        stamp('scan');

        $fs->add('new_testnames.txt', 'painisss');
        //$fs->store();

        //dump($fs->exists('testnames.txt'));
        dump($fs->exists('testnames.txt'));
        dump($fs->get('testnames.txt'));
        $file = $fs->get('new_testnames.txt');

        stamp('newfile');
        dump($file->getcontent());

        stamp('C');

        dump(Container::getAll('stamp'), 'time stamps');
    }
}
