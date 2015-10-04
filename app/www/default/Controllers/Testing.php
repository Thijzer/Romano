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

        // dump($file->exsists());
        // dump($file->getExtension());
        // dump($file->getMimeType());
        //dump($fm->exists('testnames.txt'));

        //$fm->scan();
        //$files = $fm->getAll('044', '056');

        $fm = new FileManager(path('cache').'paco');
        $pages = $this->pagination($fm->getFileCount(), 0, 4);
        $response['pages'] = $pages;
        $response['files'] = $fm->getAll($pages['limit'], $pages['offset']);
        return $response;

        //dump($files);

        //$fs->add('new_testnames.txt', 'painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss, painisss');

        //dump($fm->exists('testnames.txt'));
        //dump($fm->exists('testnames.txt'));
        //dump($fm->get('testnames.txt'));
        //$file = $fm->get('SAM_0446.JPG');

        //$fm->addFile($file);
        //
        //$fm->add('_test.txt', 'testing');
        //
        // $file = $fm->get('_test.txt');
        //
        $fm->store();

        // dump($file->getBasename());
        //dump($file->getMimeType());
        //dump($files);

        dump(array_slice($files, 0, 30));

        stamp("end_test");
        // dump($file->getcontent());
        // dump($file->basename);

        dump(Container::getAll('stamp'), 'time stamps');
    }
}
