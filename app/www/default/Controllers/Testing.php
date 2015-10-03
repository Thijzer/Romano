<?php

class Testing extends Ctrlr
{
    public function MainTest()
    {
        $this->fileTest();
    //   $text = (string) $this->params['text'];
    //   dump( url('js/jquery/jquery.min.js') );
    //   dump( url('home@about'));
    //   dump( url('blog@related'));
    //   dump( url('blog@article', ['id' => '1', 'title' => $text]) );
        exit;
    }

    public function fileTest()
    {
        // $file = new File(path('cache').'test/testname.txt');
        $fm = new FileManager(path('cache').'paco');

        // dump($file->exsists());
        // dump($file->getExtension());
        // dump($file->getMimeType());
        //dump($fm->exists('testnames.txt'));

        //$fm->scan();
        //$files = $fm->find('044', '056');

        //dump($files);

        //$fs->add('new_testnames.txt', 'painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss');

        //dump($fm->exists('testnames.txt'));
        //dump($fm->exists('testnames.txt'));
        //dump($fm->get('testnames.txt'));
        $file = $fm->get('SAM_1044.JPG');
        //
        //$fm->add('_test.txt', 'testing');
        //
        // $file = $fm->get('_test.txt');
        //
        $fm->store();

        // dump($file->getBasename());
        //dump($file->getMimeType());
        dump($file);

        stamp("end_test");
        // dump($file->getcontent());
        // dump($file->basename);

        dump(Container::getAll('stamp'), 'time stamps');
    }
}
