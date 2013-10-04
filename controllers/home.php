<?php
class Home extends Ctrlr
{
  private $view;

  public function __construct()
  {
    $this->view = new View();
  }
	public function index($data)
	{
		$post = $this->_init_('post');
		$data['titles'] = $post->getTitles();
		$data['post'] = $post->getPosts();
		$this->view->render($data, array('title' => 'Blog'));
	}
	public function contact($data)
	{
		if (isset($_POST['submit'])) {

			$user = $this->_init_('user');

			if (!$errors  = $user->checkMail($_POST['email'])) {
				$subject		= 'Contact Msg from '.$_POST['name'];
				$body				= "user : ".$_POST['name']."\nemail : ".$_POST['email']."\nhas sent the following message : \n".$_POST['Fmessage'];
				sendMail('Thijs.dp@gmail.com', $subject, $body);
				$data['msg']['notice'] = "message is sent!"; // $_POST is still active // header with a session msg?
			} else {
				$data['msg']['errors'] = $errors;
			}
	  }
	  $this->view->render($data);
	}
	public function login($data)
	{
		if (isset($_SESSION['username'])) {
			$data['msg']['notice'] = 'You are logged in!';
		}
		if (isset($_POST['login'])) {
			$user = $this->_init_('user');
			if (!$data['user'] = $user->loginUser($_POST['username'],$_POST['password'])) {
				$data['msg']['errors'] = 'wrong username or password <br/>';
			} else {
				$_SESSION['username'] = $data['user']['username'];
				$_SESSION['uid'] 			= $data['user']['uid'];
				$_SESSION['level'] 			= $data['user']['level'];
				exit(header('Location: ' .site.$_SESSION['last']));
			}
		}
		$this->view->render($data, array('theme' => 'no'));
	}
	public function logout()
	{
		unset($_SESSION['username']);
		unset($_SESSION['level']);
		die(header('Location: ' .site.$_SESSION['last']));
	}
}
?>