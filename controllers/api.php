<?php
require (MODEL . 'database.php');
class Api
{
	private $db;

	function __construct()
	{
		$this->db = new Database();
    if ($this->_hasAccess(7) !== true) { $this->view->page(404); }
	}
	public function get($data)
	{
		if(isset($_POST['submit']))
		{
			$data['list'] = $this->db->get($data['section'][2].'s',$_GET,array(
				'like' => $_POST['1'],
				'limit' => $_POST['2'],
				))->fetchAll();
		}
	}
	public function add($route)
	{
		if (isset($_POST['submit'])) {
			require (LIBS . 'class.resize.img.php');
			$img = new ResizeImage;
			$img->store($_FILES['pics']['tmp_name'], array(
		    'sizes' => array(
      		'0' => array(
        		'type' => 'resizeToWidth',
        		'size' => '800',
        		'name' => 'm',
        		'quality' => '80'),
      		'1' => array(
      			'type' => 'resizeToWidth',
        		'size' => '150',
        		'name' => 's',
        		'quality' => '50'),
		    	'2' => array(
      			'type' => 'icon',
        		'size' => '100',
        		'name' => 'icon',
        		'quality' => '30')
		    )));

			$merge = array_merge($_POST, array('pics' => $img->getPath()));

			$q = $this->db->add($route['section'][2].'s',$merge, array());
		}
	}
	public function edit($data) //update
	{
		//$this->db->update($data['section'][2]);
	}
	public function delete($data)
	{
    //$this->db->delete($data['section'][2]);
	}
  function json()
  {

  }
  function csv()
  {

  }
  function printer()
  {

  }
  function pdf()
  {

  }
  function rss()
  {

  }
  function xml()
  {

  }
  private function Loggedin($i)
  {
    if ($_SESSION['user']['level'] >= $i){
      return true;
    } else {
    	$view = new View();
      $view->page(1337, 'no access, from api');
    }
  }
  function limit()
  {

  }
}