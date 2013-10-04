<?php
class Admin extends Ctrlr
{
	private $view,$user,$post;

	public function __construct()
	{
		$this->view = new View();
	  if ($this->_hasAccess(7) !== true) { $this->view->page(1337); }
	}
	public function add($data)
	{
		$post = $this->_init_('post');
		$data['list'] = $post->addPost();
		$this->view->render($data);
	}
	public function edit($data)
	{
		$post = $this->_init_('post');
		dump($post->editPost($data['section'][2]));
		$this->view->render($data);
	}
}