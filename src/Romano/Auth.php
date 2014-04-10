<?php

/*
* user levels
* ===========
* system 	= 0 nobody
* owner 	= 1
* admin 	= 2
* admin-mod = 3
* mod 		= 4
* user-mod 	= 5
* user 		= 6
* global 	= 7
*
*/

class Auth
{
	private static $container = array();
	private static $rules = array();
	private static $master = null;
	private static $fields = array();
	private static $level = null;
	private static $go = false;
	private static $crudAcces = false;

	public static function requestAccess($token = 7)
	{
		$user = Session::get('user');

		if ($token === 7 AND $user) {

			$token = DB::run(Query::select('users')
				->where(array('username' => $user))
				->onFields('level')
				->build())->fetch();
			$token = !empty($token) ? $token['level'] : $token = 7;
		}
		self::$level = $token;
	}

	public static function getContainer($table)
	{
		if ($table) {
			$cont = array(
				'users' => array(
					'read' => 52,
					'read_fields' => array(
						'id' => 5,
						'password' => 0,
						'email' => 5,
						'reset' => 0,
						'image' => 7,
						'active' => 0,
						'first' => 7,
						'date' => 7,
						'last' => 7,
						'gender' => 7,
						'language' => 7,
						'username' => 7,
						'level' => 0
					),
					'crud' => 41
				)
			);
			return $cont[$table];
		}
	}

	private static function permissions($container, $level)
	{
		//
		$container = self::$container[$container];

		$masterKey = substr($container['read'], 0, 1);

		if ($masterKey > $level) {
			self::$master;
			self::$go;
		}
	}

	public static function crudAcces($container, $level)
	{
		$container = self::getContainer($container);
		$masterKey = substr($container['crud'], 0, 1);

		if ($masterKey >= $level) self::$crudAcces = true; 

		foreach ($container['read_fields'] as $key => $value) {

			if ($value >= $level) $fields[] = $key;

		}
		self::$fields = $fields;
	}

	public static function saveAccess($array)
	{
		DB::run(Query::select('auth')
			->save($array, 'user_id')
			->build(), true);
	}

	public static function getFields($table)
	{
		self::crudAcces($table, self::$level);
		dump( self::$crudAcces );
		return self::$fields;
	}
}