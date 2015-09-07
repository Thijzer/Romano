<?php

class Blog extends Ctrlr
{
    private $post;

    function __construct()
    {
        parent::__construct();
        $this->post = new Post();
    }

    public function index()
    {
        $pages = $this->pagination($this->post->getRowCount(), 0, 4);
        $response['pages'] = $pages;
        $response['post'] = $this->post->getPosts($pages['limit'], $pages['offset']);
        $response['titles'] = $this->post->getTitles();
        return $response;
    }

    function article()
    {
        $id = (int) $this->param('id');
        $title = (string) $this->param('title');

        if (!$this->post->exists($id)){
            Output::page(404, 'from article');
        }

        $response['post'] = $this->post->getPost($id);
        $slug = $response['post']['slug'];

        if ($slug !== $title) {
            Output::redirect($this->route['path'].'/'.$id.'/'.$slug);
        }
        return $response;

    }

    function recentArticles()
    {
        $view['titles'] = $this->post->getTitles();
        return $view;
    }

    function getAllArticlesFromUser()
    {
        $user = (string) $this->params['user'];

        if ($user){
            $response['post'] = $this->post->getArticlesFromUser($user);
            return $response;
        }
        Output::page(404, 'from Usersbloggers');
    }

    function getArchivedArticles()
    {
        $response['archived'] = $this->post->getArchivedArticles();
        return $response;
    }
}
//$app->set('comments', $post->getComments($route['controller']));

/*
if (Input::get('body') AND isset(Input::get('user'))) {
    $post->addComment($route['controller'], Input::get('user'), Input::get('body'));
}
*/
