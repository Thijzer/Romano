<?php
include_once (LIBS.'database.php');

class Photo
{
	private $code;

	function __construct()
	{
		$this->db = new Database;
	}

	function getPictures($array=null)
	{
		return $this->db->get('pics',$array)->fetchAll();
	}
	function getPicture($array=null)
	{
		return $this->db->get('pics',$array)->fetch();
	}
	function getAlbums($array= null)
	{
		return $this->db->get('gallery',$array)->fetchAll();
	}
	function getAccessCodes($id)
	{
		if (is_numeric($id)) {
			return $this->db->get('gallery',array('id' => $id),array('fields' => '`keycode`, `guestcode`'))->fetch();
		}
	}
	function editPictures($id)
	{ // get + save combined
		return $this->db->get('pics', array('gid' => $id))->fetchAll();
	}
	function editAlbum($id)
	{ // get + save combined
		return $this->db->get('gallery', array('id' => $id))->fetch();
	}

	function savePictures($picsarray,$array)
	{ // add pictures to the db
		include_once (LIBS.'class.resize.img.php');
		$img = new ResizeImage();
		$dirname = 'img/'.date('YmdHis').'/';
		mkdir(PUB.$dirname);

		$img->store($picsarray, array(
			'filename' =>'original',
			'path' => $dirname,
		    'sizes' => array(
      		'0' => array(
        		'type' => 'resizeToWidth',
        		'size' => '700',
        		'name' => 'm',
        		'quality' => '80'),
      		'1' => array(
      			'type' => 'resizeToWidth',
        		'size' => '150',
        		'name' => 's',
        		'quality' => '70')
		    )));
		$pics = $img->getArrayPath();
		$merge = array_merge($array, array(
			'guestcode' => random().rand(1000,9999),
			'path' => $dirname,
			'cover' => $pics[0],
			'keycode' => random(5)));
		$this->db->add('gallery', $merge);
		$id = $this->db->lastInsertId();
		foreach ($pics as $key => $value) {
			$query[] = "('{$id}', '{$dirname}', '{$value}', '{$key}', NOW())";
		}
		$query = implode(', ', $query);
		$this->db->query("INSERT INTO `pics` (`gid`,`path`,`filename`, `order`, `date`) VALUES $query");
		//$this->db->add('pics', array('gid' =>$id, 'filename' => ));
	}
	function update($gid,$array,$pub = 'public')
	{ // get + save combined
		if (isset($array['public'])) {
			$public = "`public` = '1', ";
		}
		if (isset($array['title'])) {
		  $this->db->query("UPDATE `gallery` SET {$public} `description` = '{$array['description']}', `title` = '{$array['title']}', `keycode` = '{$array['keycode']}'  WHERE `id` = '{$gid}'");
		}
		$this->db->query("UPDATE `pics` SET `{$pub}` = null WHERE `gid` = '{$gid}'");
		foreach ($array as $key => $value) {
			if ($value === 'on') {
				$this->db->query("UPDATE `pics` SET `{$pub}` = '1' WHERE `id` = '{$key}'");
			}
		}
	}
}

?>