<?php
class Admin
{
	private $view,$user,$post;

	public function __construct()
	{
		$this->hasAcces(7);
		$this->view = new View();
	}
	public function add($data)
	{
		require (MODEL.'post.php');
		$post = new Post();
		$data['list'] = $post->addPost();
		$this->view->render($data);
	}
	public function edit($data)
	{
		require (MODEL.'post.php');
		$post = new Post();
		dump($post->editPost($data['section'][2]));
		$this->view->render($data);
	}
  private function hasAcces($i)
  {
    if ($_SESSION['user']['level'] >= $i){
      return true;
    } else {
      $this->view->error(404,'no access, from admin');
    }
  }
}