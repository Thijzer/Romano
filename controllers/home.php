<?php
class Home
{
	private $view;

	public function __construct()
	{
	$this->view = new View();
	}
	public function index($data)
	{
		require(MODEL.'post.php');
		$post = new Post();
		$data['titles'] = $post->getTitles();
		$data['post'] = $post->getPosts();
		$this->view->render($data, 'Blog');
	}
	public function contact($data)
	{
		if(isset($_POST['submit'])) {
			require(MODEL.'user.php');
			$user 	= new User();
			$errors = $user->checkMail();

			if (!$errors) {
				$name 			= $_POST['name'];
				$subject		= "Contact Msg from $name";
				$usermail 	= $_POST['email'];
				$email			= 'Thijs.dp@gmail.com';
				$body				= "user : $name, email : $usermail has sent the following message : ";
				$body				.= $_POST['Fmessage'];
				sendMail($email, $subject, $body);
				$data['notice'] = "message is sent!";
			} else {
				$data['errors'] = $errors;
			}
	  }
	  $this->view->render($data, 'Contact');
	}
	public function login($data)
	{
		if(isset($_SESSION['username'])) {
			header('Location: '.site);
			die();
		}
		if(isset($_POST['login'])) {
			require(MODEL.'user.php');
			$user = new User();
			if (!$data['user'] = $user->checkLogin($_POST['username'],$_POST['password'])) {
				$data['msg'] = 'wrong username or password <br/>';
			}
			else {
				$_SESSION['username'] = $data['user']['username'];
				$_SESSION['uid'] 			= $data['user']['uid'];
				header('Location: '.site.$_SESSION['last']);
				exit();
			}
		}
		$this->view->render($data, 'Login', 'no');
	}
	public function logout()
	{
		unset($_SESSION['username']);
		header('Location: ' .site.$_SESSION['last']);
		die();
	}
}
?>