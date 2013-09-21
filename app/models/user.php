<?php
require (MODEL.'database.php');

class User
{
	private $db, $u, $p, $e, $active, $newpass;

	function __construct()
	{
		$this->db 				= new Database;
		$this->active 		= rand(1000,9999);
		$this->newpass 		= random().$this->active;
	}
	function checkLogin($username,$pass)
	{
		return $this->db->get('users', array(
			'username' => strtolower(trim($username)),
			'password' => $this->hashSalt($pass),
			'active' => '1'))->fetch();
	}
	function checkUser($username,$reg	= '/^[a-zA-Z0-9]{6,16}$/')
	{
		if (!$username = strtolower(trim($username))) {
			return 'enter a username';
		}	elseif (!preg_match($reg, $username)) {
			return 'invalid username, between 6-16 characters, letters and/or numbers';
		} elseif ($this->db->get('users', array('username' => $username))->fetch()) {
			return $username. ' exists';
		} else {
			$this->u = $username;
		}
	}
	function checkPass($pass, $pass2, $reg = '/^[a-z0-9_-]{6,18}$/')
	{
		if (!$pass) {
			return 'enter a password';
		}	elseif (!preg_match($reg, $pass)) {
			return 'invalid password, between 6-18 characters, letters and/or numbers';
		} elseif ($pass != $pass2) {
			return 'password don\'t match';
		} else {
			$this->p = $this->hashSalt($pass);
		}
	}
	function checkMail($email, $reg = '/.+@.+\..+/i')
	{
		if (!strtolower(trim($email))) {
			return 'enter an email';
		}	elseif (!preg_match($reg, $email)) {
			return $email. ' is not a valid email address';
		} elseif ($this->db->get('users', array('email' => $email))->fetch()) {
			return $email. ' exists';
		} else {
			$this->e = $email;
		}
	}
	function checkReset($code)
	{
		$this->q("SELECT * FROM `users` WHERE `user_reset` = '$code'");
		$user = $this->result->fetch(PDO::FETCH_ASSOC);
		$uid = $user['uid'];
		if ($this->result->rowCount() == 1){
			return $uid;
		}
	}
	function checkActivation()
	{
		$username 	= $_GET['username'];
		$active 		= $_GET['id'];

		$this->q("SELECT * FROM `users` WHERE `username` = '$username' AND `user_active` = '1'");
		if ($this->result->rowCount() === 1){
			$errors .= "already activated,  <br> <a href='/'>back to main</a>";
		}else {
			$this->q("SELECT * FROM `users` WHERE `user_active` = '$active'");
			if ($this->result->rowCount() === 1){
				$this->q("UPDATE `users` SET `user_active` = '1' WHERE `username` = '$username' AND `user_active` = '$active'");
				$errors .= "Thank you, your account hase been activated, <br> <a href='/'>back to main</a>!";
			} else {
				$errors .= "cant activate<br> <a href='/'>back to main</a>";
			}
		}
		return $errors;
	}
	function hashSalt($p)
	{
		return hash('sha256', $p . SALT);
	}
	function registerUser()
	{
		$this->db->add('users', array('username' => $this->u, 'email' => $this->e, 'password' => $this->p, 'active' => $this->active));

		$subject	= "Confirm you are $this->u";
		$body		 .= "Hallo $this->u and welcome to our site.";
		$body		 .= "We would like you to confirm your username and registration by activating this link";
		$body		 .= site."/users/activate?id=$this->active&usesername=$this->u";
		$body		 .= "thank you,";
		sendMail($this->e, $subject, $body);
	}
  function isLost()
  {
  	if (isset($_POST['lost'])) {
  		$newpass 	= $this->newpass;
  		$email		= $this->email;

		if (!empty($email)) {
			if($this->mailExists($email) == false){
				$errors[] = 'email does not exsist';
			}
			//activation check
		} else {
			$errors .= 'no email is given.<br/>';
		}
		if(!$errors) {
			$errors 	= 'check your mail!!<br/>';
			$subject	= "reset yourself";
			$body		= "here is your reset code $site/reset/$newpass";
			$body		.= "thank you,";
			$body		.= "Thijzer.com";
			sendMail($email, $subject, $body);
			$this->q("UPDATE `users` SET `user_reset` = '$newpass' WHERE `email` = '$email'");
			$user = $this->result->fetch(PDO::FETCH_ASSOC);
			header('Location: /');
			die();
		}
		$data['errors'] = $errors;
		$data['email'] = $email;
		return $data;
		}
	}
	function reset($code)
	{
		$uid = $this->checkReset($code);
		$password = $this->password;

		if($uid == ""){
			header('Location: /');
			die();
			// detect ip address here for security for forced entries
		}
		if (isset($_POST['reset'])) {
			$errors .= $this->checkPass();

			if (!$errors) {
				$this->q("UPDATE `users` SET `password` = '$password', `user_reset` = null WHERE `uid` = '$uid'");
				header('Location: /');
				die();
			}
		}
		$data['errors'] = $errors;
		return $data;
	}
}

?>