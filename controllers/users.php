<?php
require (MODEL.'user.php');
class Users
{
	private  $view,$user;

	public function __construct()
	{
		$this->user = new User();
		$this->view = new View();
	}
	public function settings($data)
	{
		echo 'in process';
		//$this->view->render($data);
	}
	public function register($data)
	{
		if (isset($_POST['register'])) {
			$u  = $this->user->checkUser($_POST['username']);
			$p 	= $this->user->checkPass($_POST['password'], $_POST['password2']);
			$m  = $this->user->checkMail($_POST['email']);

			if (!$q = $u.$p.$m) {
				$this->user->registerUser();
				header('Location: '.site.$_SESSION['last']); // should be thank you instead of header
			  die();
			}
			$data['errors'] = array('u' => $u, 'p' => $p, 'm' => $m);
		}
		$this->view->render($data, 'Register', 'no');
	}
	public function lost($data)
	{
		$data['data'] = $this->user->isLost();
		$this->view->render($data, 'Lost', 'no');
	}
	public function reset($data)
	{
		$data['data'] = $this->user->reset($args['args']);
		$this->view->render($data, 'Reset', 'no');
	}
  public function activate($data)
  {
  	$data['msg'] = $this->user->checkActivation();
  	$this->view->render($data, 'Activate', 'no');
  }
}