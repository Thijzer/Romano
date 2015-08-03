<?php

class Blog extends Ctrlr
{
    private $post;

    function __construct()
    {
        parent::__construct();
        $this->post = new Post();
    }

    function article()
    {
        $id = (int) $this->param('id');
        $title = (string) $this->param('title');

        var_dump($this->post->getPost($id));exit;

        if ($this->post->getId($id)){
            $response['post'] = $this->post->getPost($id);
            if ($response['post']['slug'] != $title) Output::redirect($this->route['path'] . '/' . $id . '/' .  $response['post']['slug']);

            return $response;
        }
        else Output::page(404, 'from article');
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
        else Output::page(404, 'from Usersbloggers');
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
