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
        $fm = new FileManager(path('cache'), 'wallpapers');

        //dump($fm->exists('testnames.txt'));
        dump($fm->find('Amazing'));
        //$fm->scan();

        //$fs->add('new_testnames.txt', 'painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss');


        //dump($fm->exists('testnames.txt'));
        //dump($fm->exists('testnames.txt'));
        //dump($fm->get('testnames.txt'));
        //$file = $fm->get('new_testnames.txt');

        // dump($file->getBasename());
        // dump($file->getMimeType());
        // dump($file->getFilesize());

        //$fm->store();
        stamp("end_test");
        // dump($file->getcontent());
        // dump($file->basename);

        dump(Container::getAll('stamp'), 'time stamps');
    }
}
