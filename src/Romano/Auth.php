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
* three domains / view / grab / crud
*/



class Auth
{
	private static $container = array();
	private static $rules = array();
	private static $master = null;
	private static $fields = array();
	private static $level = 7;
	private static $go = false;
	private static $crudAcces = false;

	public static function requestAccess($user = null)
	{
		if(!empty($user) AND !$userToken = Session::get($user . '_token'))
		{
			$token = DB::run(Query::table('users')
				->where(array('username' => $user))
				->select('level')
				->build()
			)->fetch();

			Session::set(array($user . '_token' => $token['level']));
			self::$level = !empty($token) ? $token['level'] : 7;
		}
		elseif(!empty($user)) self::$level = $userToken;
	}

	public static function requestTables()
	{
		return array('auth', '', 'posts', 'gallery', 'tags', 'collection_core', 'collection_user', 'collection');
	}

	public static function getContainer($table)
	{
		if ($table) {
			$tablesList = array(
				'' => array(
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
				),
				'collection_user' => array(
					'read' => 52,
					'read_fields' => array(
						'id' => 0,
						'user' => 7,
						'title_id' => 7,
						'own' => 7,
						'additional' => 7
					),
					'crud' => 41
				),
				'collection' => array(
					'read' => 52,
					'read_fields' => array(
						'id' => 7,
						'url' => 7,
						'title' => 7
					),
					'crud' => 41
				),
				'collection_core' => array(
					'read' => 52,
					'read_fields' => array(
						'id' => 1,
						'collection' => 7,
						'title_id' => 7,
						'category' => 7,
						'title' => 7,
						'owner' => 7,
						'pic_path' => 7,
						'release_date' => 7,
						'created_on' => 7
					),
					'crud' => 41
				)
			);
			return $tablesList[$table];
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

	public static function crudAcces($container = array())
	{
		$container = self::getContainer($container);
		if (!empty($container)) {

			$masterKey = substr($container['crud'], 0, 1);

			if ($masterKey >= self::$level) self::$crudAcces = true;

			if (is_array($container)) foreach ($container['read_fields'] as $key => $value) if ($value >= self::$level) $fields[$key] = $key;
			elseif ($value >= self::$level) $fields[$key] = $key;

			self::$fields = $fields;
		}
	}

	public static function getAccess($array)
	{
		$item = DB::run(Query::table('auth')
			->where($array)
			->select('user_id')
			->build())->fetch();
		return $item['user_id'];
	}

	public static function saveAccess($array)
	{
		DB::run(Query::table('auth')->save($array, 'user_id')->build(), true);
	}

	public static function getFields($table)
	{
		self::crudAcces($table);
		return self::$fields;
	}
}
