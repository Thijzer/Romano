<?php

class Post
{
    private $table = array(
        'posts' => 'posts'
    );

    function getPosts($limit = 4, $offset = 0)
    {
        $lim = (int) $limit;
        $off = (int) $offset;

        return DB::run(array('query' =>
            "SELECT id, title, user, uri,
            LEFT(body, 300) AS preview,
            DATE_FORMAT(date, '%d/%m/%Y') AS date,
            DATE_FORMAT(date, '%H:%i:%s') AS time
            FROM posts
            WHERE public = 1 AND active = 1
            ORDER BY date DESC LIMIT {$off} ,{$lim}"
            )
        )->fetchAll();
    }

    function getRowCount()
    {
        $row = DB::run(array('query' => "SELECT COUNT(*) as count from `posts`"))->fetch();
        return (int) $row['count'];
    }

    function getPost($pid = null)
    {
        return DB::run(
            Query::table($this->table['posts'])
            ->where(array('id' => $pid, 'active' => '1'))
            ->build()
        )->fetch();
    }

    function getId($pid = null)
    {
        return (bool) DB::run(
            Query::table($this->table['posts'])
            ->select(array('id'))
            ->where(array('id' => $pid, 'active' => '1'))
            ->build()
        )->fetch();
    }

    function getArchivedArticles()
    {
        return DB::run(
            Query::table($this->table['posts'])
            ->select(array('id', 'title', 'uri'))
            ->where(array('active' => '1'))
            ->endQuery('Group by date')
            ->build()
        )->fetch();
    }

    function getArticlesFromUser($user)
    {
        $results = DB::run(
            Query::table($this->table['posts'])
            ->where(array('user' => $user, 'active' => '1'))
            ->build()
        )->fetchAll();

        if($results) return $results;
    }

    private function getPid($title, $user)
    {
        if (DB::connect($this->table['posts'])->where(array('title' => str_replace('-', ' ', $title), 'user' => $user))->fetch()) return $this;
    }

    function editPost($tags)
    {
        if (isset($_POST['public'])) $public = '1';
        DB::connect($this->table['posts'])->edit(array('title' => $_POST['title'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
    }

    // add a new blog entry
    function addPost($tags)
    {
        if (isset($_POST['public'])) $public = '1';
        DB::connect($this->table['posts'])->add(array('title' => $_POST['title'], 'uid' => $_SESSION['uid'], 'user' => $_SESSION['username'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
    }

    function getTitles()
    {
        return DB::run()->query("SELECT `title`,`id`, `uri` FROM `posts` WHERE `active` = '1' ORDER BY `date` DESC LIMIT 5")->fetchAll();
    }

    function getLastId()
    {
        return DB::run()->lastInsertId();
    }

    function getComments($pid)
    {
        if (is_numeric($pid)) return DB::run()->query("SELECT `body`,`user`, DATE_FORMAT(`date`, '%d/%m/%Y %H:%i:%s') AS `date` FROM `comments` WHERE `pid` = '$pid'")->fetchAll();
    }

    function addComment($pid, $user, $body)
    {
        if (DB::connect('comments')->add(array('id' => $pid, 'user' => $user, 'body' => $body))) return true;
    }
}
