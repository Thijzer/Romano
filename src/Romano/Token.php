<?php
/**
* moved to Crypt
*/
class Token
{	
	public static function generate()
	{
		return Session::set(Config::$array['session']['token'], md5(uniqid()));
	}
	public static function check($token)
	{
		$token_name = Config::$array['session']['token'];

		if (Session::get($token_name) && $token === Session::get($token_name)) {
			Session::delete($token_name);
			return true;
		}
		return false;
	}
}
