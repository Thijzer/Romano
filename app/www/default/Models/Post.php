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

        return DB::run(['query' =>
            "SELECT p.id, pc.title, p.author, p.slug,
            LEFT(pc.body, 300) AS preview,
            DATE_FORMAT(p.publish_on, '%d/%m/%Y') AS date,
            DATE_FORMAT(p.publish_on, '%H:%i:%s') AS time
            FROM posts AS p
            INNER JOIN posts_content AS pc ON pc.id = p.id
            WHERE p.public = 1 AND p.active = 1
            ORDER BY p.publish_on DESC LIMIT {$off} ,{$lim}"]
        )->fetchAll();
    }

    function getRowCount()
    {
        return DB::run(['query' => "SELECT COUNT(*) as count from posts"])->get('count');
    }

    function getPost($postId)
    {
        return DB::run(
            Query::table($this->table['posts'], 'p')
            ->join('posts_content', 'pc', 'p.id = pc.id')
            ->where(array('p.id' => (int) $postId, 'p.active' => '1'))
            ->build()
        )->fetch();
    }

    function getId($postId)
    {
        return DB::run(
            Query::table($this->table['posts'])
            ->where(array('id' => (int) $postId, 'active' => 1))
            ->build()
        )->getId();
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

    function getArticlesFromUser($author)
    {
        return DB::run(
            Query::table($this->table['posts'])
            ->where(array('author' => $author, 'active' => '1'))
            ->build()
        )->fetchAll();
    }

    private function getIdFromSLug($slug, $author)
    {
        return DB::run(
            Query::table($this->table['posts'])
                ->where(array('slug' => $slug))
        )->getId();
    }

    // function editPost($tags)
    // {
    //     if (isset($_POST['public'])) $public = '1';
    //     DB::connect($this->table['posts'])->edit(array('title' => $_POST['title'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
    // }
    //
    // // add a new blog entry
    // function addPost($tags)
    // {
    //     if (isset($_POST['public'])) $public = '1';
    //     DB::connect($this->table['posts'])->add(array('title' => $_POST['title'], 'uid' => $_SESSION['uid'], 'author' => $_SESSION['username'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
    // }

    function getTitles()
    {
        return DB::run(['query' =>
            "SELECT pc.title, p.id, p.slug
             FROM posts AS p
             INNER JOIN posts_content AS pc ON pc.id = p.id
             WHERE p.active = '1'
             ORDER BY p.publish_on
             DESC LIMIT 5"]
        )->fetchAll();
    }

    function getLastId()
    {
        return DB::run()->lastInsertId();
    }

    function getComments($postId)
    {
        return DB::run(
            ['query' => "SELECT `body`,`author`, DATE_FORMAT(`date`, '%d/%m/%Y %H:%i:%s') AS `date` FROM `comments` WHERE `id` = '$postId'"]
        )->fetchAll();
    }

    function addComment($postId, $author, $body)
    {
        DB::run(
            Query::table('comments')
                ->add(array('id' => $postId, 'author' => $author, 'body' => $body))
        );
    }
}
