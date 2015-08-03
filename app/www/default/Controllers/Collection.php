<?php

Class Collection extends Ctrlr
{
    private $crud;

    function __construct()
    {
        parent::__construct();
        $this->crud = new Crud();
    }

    public function index()
    {
        $response['collection'] = $this->crud->select('collection')->fetchAll();
        return $response;
    }

    public function movies()
    {
        $response['collection'] = $this->crud->select('collection_core', array('collection' => 'movies'))->fetchAll();
        return $response;
    }

    public function details()
    {
        $response['movie'] = $this->crud->select(
          'collection_core',
          array('title_id' => $this->params['title'])
        )->fetch();

        if ($user = Session::get('user')) {
          $response['user'] = $this->crud->select(
            'collection_user',
            array(
              'title_id' => $response['movie']['title_id'],
              'user' => $user)
          )->fetch();
        }
        return $response;
    }
}
