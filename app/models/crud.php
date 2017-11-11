<?php
require (MODEL . 'database.php');

class Crud extends Database
{
  public function __construct(){
    parent::__construct();
  }
  function insert($table)
  {
  	$table = $table.'s';
		if (!empty($_GET))
		{
			$this->qBuild('INSERT', null ,$table , $_GET);
			echo '<BR>returns ok or an error, id value is invalid, dat value is added automaticly';
		}
  }
  function select($table)
  {
  	$table = $table.'s';
		if (!empty($_GET))
		{
			$q = $this->qBuild('SELECT', '*' ,$table , $_GET);
			dump($q);
		}
  }
  function update($table)
  {
  	$table = $table.'s';
		if (!empty($_POST))
		{
			$this->qBuild('UPDATE', '*' ,$table , $_GET);
			echo '<BR>returns ok or an error';

		}
		echo 'how would edit work best?';
  }
  function delete($table)
  {
  	$table = $table.'s';
		if (!empty($_GET))
		{
			$this->qBuild('DELETE', '*' ,$table ,$_GET);
			echo '<BR>returns ok or an error';
		}
  }
   function qBuild($selector, $what = '*', $table, $array, $where = null) // bound to moved between DB and model
  {
    $slip = '';
    foreach($array as $field => $value){
      if (!empty($field) && !empty($value)) {
        $conditions[] = "`$field`";
        $condition[] = "`$field` = :$field";
        $like[] = "`$field` LIKE CONCAT (:$field)";
        $fields[] = ":$field";
        $params[] = $field;
      }
    }

    if($selector === 'INSERT')
    {
      $conditions[] = '`date`';
      $fields[] = 'NOW()';

      if(isset($_FILES['pics']['tmp_name'])){
        $conditions[] = '`pics`';$fields[] = ':pics';$params[] = 'pics'; //ok we save a string
        $c = count($_FILES['pics']['tmp_name']);
        $y = 0;
        $h = 0;
        $IMG = '.jpg';
        include(LIBS.'class.resize.img'.EXT);
        $image = new ResizeImage();
        for ($i = 0; $i < $c; $i++){
          if (!empty($_FILES['pics']['tmp_name'][$i])) {
            $pics = date('Ymd-His').'_'.$y;
            $path = PUB.'/storage/db/prop/'.$pics;
            move_uploaded_file($_FILES['pics']['tmp_name'][$i],$path.'_or'.$IMG);
            $image->load($path.'_or'.$IMG);
            $image->resizeToWidth(800);
            $image->save($path.'_m'.$IMG, 70);
            //$image->load($path.'_or'.$IMG);
            $image->resizeToWidth(256);
            $image->save($path.'_s'.$IMG, 50);
            $image->resize(128,128);
            $image->save($path.'_ico'.$IMG, 50);
            $picsstr[] = $pics;
            $y++;
          }
        }
        $picsstr = implode('%%', $picsstr);
        $array['pics'] = $picsstr; // no needed in loop
      }

      $query = 'INSERT INTO `'.$table.'` (';
      $query .= implode(', ', $conditions);
      $query .= ') VALUES (';
      $query .= implode(', ', $fields);
      $query .= ')';
    }
    elseif($selector === 'SELECT')
    {
        $query = 'SELECT '.$what.' FROM `'.$table.'` ';
        if(!empty($like)){$query .= 'WHERE ' . implode(' AND ', $like);$slip = '%';}
    }
    elseif($selector === 'UPDATE')
    {
      $query = 'UPDATE '.$what.' FROM `'.$table.'` SET ';
      $query .= implode(', ', $condition);
      $key = current(array_keys($where));
      $query .= " WHERE $key = $where[pid]";
    }elseif ($selector === 'DELETE')
    {
      $query = 'DELETE '.$what.' FROM `'.$table.'` ';
			if(!empty($like)){$query .= 'WHERE ' . implode(' AND ', $like);$slip = '%';}
    }
    $stmt = $this->prepare($query);
    if(!empty($params)){
      foreach($params as $param)
      {
        $stmt->bindValue(':'.$param, $slip.$array[$param].$slip);
      }
    }
    //$stmt->execute();
    echo $query;
    //if($selector === 'SELECT'){return $stmt->fetchAll();}
  }
  function limiter() // bound to moved between DB and model
  {
  	// limits the options you can control in the DB
  	// also expects that you meet certain values for example if foo is not a table then we return an error.
  	// best placed between db and model together with Qbuild
	  	// api level 0 read only limit // but can be overriden by a higher level
	  	// user level 1 limits to his own creations 
	  	// operator level 3 
	  	// dominator level 5 limits to the site creations
	  	// admin level 7 no limit poker
  }
}
?>