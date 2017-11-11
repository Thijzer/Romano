<?php
include_once (MODEL.'database.php');

class User
{
	private $db, $u, $p, $e, $uid, $active, $resetcode;

	function __construct()
	{
		$this->db 	= new Database;
		$this->code = random().rand(1000,9999);
	}

	// check something
	function checkUser($username,$reg	= '/^[a-zA-Z0-9]{6,16}$/')
	{
		if (!$username = strtolower(trim($username))) {
			return 'enter a username';
		}	elseif (!preg_match($reg, $username)) {
			return 'invalid username, between 6-16 characters, letters and/or numbers';
		} elseif ($this->checkDB(array('username' => $username))) {
			return $username. ' exists';
		} else {
			$this->u = $username;
		}
	}
	function checkPass($pass, $pass2, $reg = '/^[a-zA-Z0-9_-]{6,20}$/')
	{
		if (!trim($pass)) {
			return 'enter a password';
		}	elseif (!preg_match($reg, $pass)) {
			return 'invalid password, between 6-18 characters, letters and/or numbers';
		} elseif ($pass != trim($pass2)) {
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
		} elseif ($this->checkDB(array('email' => $email))) {
			return $email. ' exists';
		} else {
			$this->e = $email;
		}
	}
	function checkReset($code)
	{
		if (!$code) {
			return false;
		} elseif (mb_strlen($code) !== mb_strlen($this->code)) {
			return false;
		} elseif (!$result = $this->db->query("SELECT `uid` FROM `users` WHERE `reset` = '$code'")->fetch(PDO::FETCH_ASSOC)) {
			return false;
		} else {
			$this->uid = $result['uid'];
		}
	}
	function checkActivation($u, $id)
	{
		$result = $this->db->get('users', array('username' => $u, 'reset' => $id), array('fields' => 'active, reset'))->fetch();
		if ($result['active'] === '1') {
			return "this account is already activated";
		} elseif ($result['reset'] !== $id) {
			return "can't activate this user, please contact the administrator";
		} elseif (!$this->checkDB(array('username' => $u))) {
			return "username is not know to us";
		} else {
			$this->code = $result['reset'];
			$this->u = $u;
		}
	}
	function checkDB($value = array(), $fields = '*')
	{
		if($value = $this->db->get('users', $value, array( 'fields' => $fields))->fetch()) {
			return $value;
		}
	}

	//do something
	function loginUser($username,$pass)
	{
		return $this->db->get('users', array(
			'username' => strtolower(trim($username)),
			'password' => $this->hashSalt($pass),
			'active' => '1'))->fetch();
	}
	function activateUser()
	{
		$this->db->query("UPDATE `users` SET `active` = '1', `reset` = null WHERE `username` = '$this->u' AND `reset` = '$this->code'");
	}
	function registerUser()
	{
		$this->db->add('users', array('username' => $this->u, 'email' => $this->e, 'password' => $this->p, 'reset' => $this->code));

		$subject	= "Confirm you are $this->u";
		$body		  = "Hallo $this->u and welcome to our site.\n\n";
		$body		 .= "We would like you to confirm your username and registration by activating this link\n\n";
		$body		 .= site."users/activate?id=$this->code&username=$this->u\n\n";
		$body		 .= "thank you,\nthe ".title." team.";
		sendMail($this->e, $subject, $body);
	}
	function lost($e)
	{
		$url 			= site."users/reset/".$this->code;
		$subject	= title.": reset code";
		$body			= "here is your reset code \n".$url."\n\nthank you,\nthe ".title." team";
		$this->db->query("UPDATE `users` SET `reset` = '$this->code' WHERE `email` = '$e'");
		//$this->db->edit('users', array('email' => $this->e))->set('reset' => $this->code);
		sendMail($e, $subject, $body);
	}
	function resetUser()
	{
		$this->db->query("UPDATE `users` SET `password` = '$this->p', `reset` = null WHERE `uid` = '$this->uid'");
	}

	function hashSalt($p)
	{
		return hash('sha256', $p . Config::SALT);
	}
}

?>