<?php
include_once (LIBS.'database.php');
class Post
{
  public $db;
  public function __construct() {
    $this->db = new Database;
  }

  function getPosts() {
    return $this->db->query(
      "SELECT `posts`.`pid`,
      `posts`.`title`,
      `posts`.`user`,
      LEFT(`body`, 300) AS `preview`,
      DATE_FORMAT(`date`, '%d/%m/%Y') AS `date`,
      DATE_FORMAT(`date`, '%H:%i:%s') AS `time`,
      `comments`.`total_comments`,
      DATE_FORMAT(`comments`.`last_comment`, '%d/%m/%Y %H:%i:%s') AS `last_comment`
      FROM `posts` LEFT JOIN (
        SELECT
        `pid`,
        COUNT(`cid`) AS `total_comments`,
        MAX(`date`) AS `last_comment`
        FROM `comments`
        GROUP BY `pid`
        )
      AS `comments` ON `posts`.`pid` = `comments`.`pid`
      WHERE `posts`.`public` = '1' AND `posts`.`active` = '1'
      ORDER BY `date` DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
  }

  function getPost($pid) {
    if (is_numeric($pid)) {
      return $this->db->get('posts', array('pid' => $pid, 'active' => '1'))->fetch();
    }
  }

  function getPid($title, $user) {
    if($this->db->get('posts', array('title' => str_replace('-', ' ', $title), 'user' => $user))->fetch()) {
      return $this;
    }
  }

  function editPost($tags) {
    if (isset($_POST['public'])) {
      $public = '1';
    }
    $this->db->edit('posts', array('title' => $_POST['title'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
  }
  // add a new blog entry
  function addPost($tags) {
    if (isset($_POST['public'])) {
      $public = '1';
    }
    $this->db->add('posts', array('title' => $_POST['title'], 'uid' => $_SESSION['uid'], 'user' => $_SESSION['username'], 'body' => $_POST['body'], 'tag' => $tags, 'public' => $public ));
  }
  function getTitles() {
    return $this->db->query("SELECT `title`,`pid` FROM `posts` WHERE `active` = '1' ORDER BY `date` DESC LIMIT 5")->fetchAll();
  }
  function getId() {
    return $this->db->lastInsertId();
  }
  function getComments($pid) {
    if (is_numeric($pid)) {
      return $this->db->query("SELECT
      `body`,
      `user`,
      DATE_FORMAT(`date`, '%d/%m/%Y %H:%i:%s') AS `date`
      FROM `comments`
      WHERE `pid` = '$pid'")->fetchAll();
    }
  }
  function addComment($pid, $user, $body) {
    if($this->db->add('comments', array('pid' => $pid, 'user' => $user, 'body' => $body)))
    {
      return true;
    }
  }
}

?>