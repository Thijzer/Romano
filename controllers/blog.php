<?php

class Blog extends Ctrlr
{
	private $view;

	public function __construct()
	{
		$this->view = new View();
	}
	public function article($data)
	{
		$post = $this->_init_('post');
		if (!$data['post'] = $post->getPost($data['section'][2]))
		{
			$this->view->page(404,'from article');
		}
		$data['comments'] = $post->getComments($data['section'][2]);

		if (isset($_POST['body']) && isset($_POST['user']))
		{
			$post->addComment($data['section'][2], $_POST['user'], $_POST['body']);
		}
		$this->view->render($data);
	}
}