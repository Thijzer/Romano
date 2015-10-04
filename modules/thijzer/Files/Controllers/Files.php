<?php

class Files extends Ctrlr
{
    public function index()
    {
        $fm = new FileManager(path('cache').'test');
        $pages = $this->pagination($fm->getFileCount(), 0, 100);
        $response['pages'] = $pages;
        $response['files'] = $fm->getFiles($pages['limit'], $pages['offset']);
        return $response;
    }

    public function detail()
    {
    }
}
