<?php

class User
{
	private $user;
	private $loggedIn = false;
	private $sessionName;
	private $db;

	public function __construct()
	{
		$this->db = DB::getInstanc($user = null);

		$app = App::getInstance();

		$this->sessionName = $app->get('session', 'name');

		if (empty($user) AND Session::exists($this->sessionName)) {
			$user = Session::get($this->sessionName);
			if ($this->find($user)) {
				$this->loggedIn = true;
			} else {
				// log our
			}
		} else {
			$this->find($user);
		}
	}

	// find the user 
	public function find($fieldName)
	{
		if ($fieldName) {
			$field = (is_numeric($fieldName)) ? 'id' : 'username';
			$data = $this->$db->run(
				Query::select('users')
				->where(array($field => $fieldName))
			)->fetch();

			if (is_array($data)) {
				$this->data = $data;
				return true;
			}
		}
	}

	public function login($username)
	{
		$user = $this->find($username);

		if (is_array($user)) {
		}
	}

	public function Userdata()
	{
		return $this->user;
	}

	public function isLoggedIn()
	{
		return $this->loggedIn;
	}
}