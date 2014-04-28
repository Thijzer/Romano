<?php

class DB extends \PDO
{
  /**
   * @var string
   */
  protected $stmt;
  protected $query;
  protected $params;
  protected $options = array(\PDO::ATTR_EMULATE_PREPARES, false, \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  protected $fetchMode = \PDO::FETCH_ASSOC;
 
  // constructs the connection.
  function __construct()
  {
    $DB = App::getInstance()->get(array('config', 'DB'));

    try {
      parent::__construct($DB['DSN'], $DB['USER'], $DB['PASS'], $this->options); 
    } catch (\PDOException $e) {
      if (DEV_ENV === true) $message = $e->getMessage(); dump($message);
      throw View::page('500','PDO CONNECTION ERROR: ' . $message);
    }
  }

  // prepares the statement and processes the values 
  private function processParams()
  {
    try {
      //if (!empty($sql) AND empty($params)) return $this->exec($sql);
      if($this->stmt = $this->prepare($this->query)) return $this->stmt->execute($this->params);
    } catch (\PDOException $e) {
     if (DEV_ENV === true) $message = $e->getMessage(); dump($message);
     throw View::page('500','PDO QUERY ERROR: ' . $message);
    }
  }

  // public functions 
  static function run($results = array(), $run = false)
  {
    $instance = Singleton::getInstance(get_class());  
    if (!empty($results)) {    
      $instance->query = $results['query'];
      $instance->params = (!empty($results['params'])) ? $results['params'] : null;
      $instance->stmt = null;
      if ($run === true) $instance->processParams();
    }
    return $instance;
  }

  // the following methods are extensions of the PDO class
  public function fetch()
  {
    if ($this->query AND $this->processParams()) return $this->stmt->fetch($this->fetchMode);
  }

  public function fetchAll()
  {
    if ($this->query AND $this->processParams()) return $this->stmt->fetchAll($this->fetchMode);
  }

  public function fetchPairs()
  {
    if ($result = $this->stmt->fetch($this->fetchMode)) return array(reset($result) => end($result));
  }

  public function fetchValues($limiter = ', ')
  {
    if ($result = $this->stmt->fetch($this->fetchMode)) return implode($limiter, array_values($result));
  }
}