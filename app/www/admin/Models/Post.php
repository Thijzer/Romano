<?php

class Post
{
    function getPosts()
    {
        return DB::run(
            Query::table('posts')
            ->build()
        )->fetchAll();
    }

    function getPost($pid = null)
    {
        return DB::run(
            Query::table('posts')
            ->where(array('id' => $pid, 'active' => '1'))
            ->build()
        )->fetch();
    }

    function getId($pid = null)
    {
        return (bool) DB::run(
            Query::table('posts')
            ->select(array('id'))
            ->where(array('id' => $pid, 'active' => '1'))
            ->build()
        )->fetch();
    }

    private function getPid($title, $user)
    {
        if (DB::connect('posts')->where(array('title' => str_replace('-', ' ', $title), 'user' => $user))->fetch()) return $this;
    }

    function editPost($tags)
    {
        if (isset($_POST['public'])) $public = '1';
        DB::connect('posts')->edit(array('title' => $_POST['title'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
    }

    // add a new blog entry
    function addPost($tags)
    {
        if (isset($_POST['public'])) $public = '1';
        DB::connect('posts')->add(array('title' => $_POST['title'], 'uid' => $_SESSION['uid'], 'user' => $_SESSION['username'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
    }

    function getTitles()
    {
        return DB::run()->query("SELECT `title`,`id`, `uri` FROM `posts` WHERE `active` = '1' ORDER BY `date` DESC LIMIT 5")->fetchAll();
    }

    // function getId()
    // {
    //     return DB::run()->lastInsertId();
    // }

    function getComments($pid)
    {
        if (is_numeric($pid)) return DB::run()->query("SELECT `body`,`user`, DATE_FORMAT(`date`, '%d/%m/%Y %H:%i:%s') AS `date` FROM `comments` WHERE `pid` = '$pid'")->fetchAll();
    }

    function addComment($pid, $user, $body)
    {
        if (DB::connect('comments')->add(array('id' => $pid, 'user' => $user, 'body' => $body))) return true;
    }
}
