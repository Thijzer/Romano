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
			  die(header('Location: '.site.$_SESSION['last'])); // should be thank you instead of header
			}
			$data['msg']['errors'] = array('u' => $u, 'p' => $p, 'm' => $m);
		}
		$this->view->render($data, ['theme' =>'no']);
	}
	public function lost($data)
	{
  	if (isset($_POST['lost'])) {
  		$e     = $_POST['email'];
			$error = $this->user->checkMail($e); // a problem with the check

			if ($error === $e. ' exists') {
				$this->user->lost($e);
				$data['msg']['notice'] = 'a reset mail has been sent';
			} elseif (!$error) {
				$data['msg']['errors'] = 'email is not reconized';
			} else {
				$data['msg']['errors'] = $error;
			}
		}
		$this->view->render($data, ['theme' => 'no']);
	}
	public function reset($data)
	{
		if($uid = $this->user->checkReset($data['section'][2]) === false) {
			$this->view->error(1337, 'from reset'); echo $uid;
		}
		if (isset($_POST['reset'])) {
			$error = $this->user->checkPass($_POST['password'],$_POST['password2']);

			if (!$error) {
				$this->user->resetUser($uid);
				$data['msg']['notice'] = 'user is reset, thank you!';
				//die(header('Location: /'));
			} else {
				$data['msg']['errors'] = $error;
			}
		}
		$this->view->render($data, ['theme' => 'no']);
	}
  public function activate($data)
  {
  	if (isset($_GET['username']) && isset($_GET['id'])) {

			$error = $this->user->checkActivation($_GET['username'], $_GET['id']);
			if (!$error) {
				$this->user->activateUser();
				$data['msg']['notice'] = 'thank you, your account has been activated';
			} else {
				$data['msg']['errors'] = $error;
			}
		} else {
			$data['msg']['errors'] = 'something went wrong!';
		}
  	$this->view->render($data, ['theme' => 'no']);
  }
}

?>