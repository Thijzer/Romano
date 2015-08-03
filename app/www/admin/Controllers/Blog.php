<?php

class Blog
{
    function __construct()
    {
        $this->route = config('route');
    }

    function index()
    {
        $post = New Post();
        $result['posts'] = $post->getPosts();
        $result['path'] = $this->route['path'];
        return $result;
    }

    function add()
    {

    }

    function edit()
    {

    }

    function delete()
    {

    }
}
