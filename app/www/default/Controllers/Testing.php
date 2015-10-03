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
        // $file = new File(path('cache').'test/testname.txt');
        $fm = new FileManager(path('cache'), 'paco');

        // dump($file->exsists());
        // dump($file->getExtension());
        // dump($file->getMimeType());
        //dump($fm->exists('testnames.txt'));

        $fm->scan()->store();
        dump($fm->find('044', '056'));

        //$fs->add('new_testnames.txt', 'painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss');


        //dump($fm->exists('testnames.txt'));
        //dump($fm->exists('testnames.txt'));
        //dump($fm->get('testnames.txt'));
        $file = $fm->get('SAM_1044.JPG');

        // dump($file->getBasename());
        //dump($file->getMimeType());
        dump($file->getFullPath());

        stamp("end_test");
        // dump($file->getcontent());
        // dump($file->basename);

        dump(Container::getAll('stamp'), 'time stamps');
    }
}
