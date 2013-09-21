<?php
require (MODEL.'post.php');

class Blog
{
	private $view,$post;

	public function __construct()
	{
	$this->post = new Post();
	$this->view = new View();
	}
	public function article($data)
	{
		if (!$data['post'] = $this->post->getPost($data['section'][2]) OR !empty($data['section'][3]))
		{
			$this->view->error(404,'from article');
		}
		$data['comments'] = $this->post->getComments($data['section'][2]);

		if (isset($_POST['body']) && isset($_POST['user']))
		{
			$this->post->addComment($data['section'][2], $_POST['user'], $_POST['body']);
		}
		$this->view->render($data);
	}
}