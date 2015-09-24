<?php

class Blog extends Ctrlr
{
    private $post;

    public function __construct()
    {
        parent::__construct();
        $this->post = new Post();
    }

    public function index()
    {
        $pages = $this->pagination($this->post->getRowCount(), 0, 4);
        $response['pages'] = $pages;
        $response['post'] = $this->post->getPosts($pages['limit'], $pages['offset']);
        return $response;
    }

    public function article()
    {
        $articleId = (int) $this->param('id');
        $title = (string) $this->param('title');

        if (!$this->post->exists($articleId)) {
            Output::page(404, 'from article');
        }

        $response['post'] = $this->post->getPost($articleId);
        $slug = $response['post']['slug'];

        if ($slug !== $title) {
            Output::redirect($this->route['path'].'/'.$articleId.'/'.$slug);
        }
        return $response;
    }

    public function recentArticles()
    {
        $view['titles'] = $this->post->getTitles();
        return $view;
    }

    public function getAllArticlesFromUser()
    {
        $user = (string) $this->params['user'];

        if ($user) {
            $response['post'] = $this->post->getArticlesFromUser($user);
            return $response;
        }
        Output::page(404);
    }

    public function getArchivedArticles()
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
