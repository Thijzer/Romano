<?php
/**
* DB wrapper Tacito
* a very small but functional wrapper around the most basic functions
* it's called staticly but functions as a real object.
* it's still very experimental, I'm still moving things around to see the effect
* I know extending the PDO class is a little silly, but it helps on my shortcommings :D
*/

class DB extends \PDO
{
  /**
   * @var string
   */
  protected $stmt;
  protected $query;
  protected $params;
  protected $options = array(\PDO::ATTR_EMULATE_PREPARES, false, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
  protected $fetchMode = \PDO::FETCH_ASSOC;
 
  /**
   * constructs the connection.
   *
   * throws an error if needed with message if your in development mode.
   */
  function __construct()
  {
    $DB = App::getInstance()->get(array('config', 'DB'));
    //dump($DB);exit();
    try {
      parent::__construct($DB['DSN'],$DB['USER'],$DB['PASS'],$this->options); 
    } catch (\PDOException $e) {
      if (DEV_ENV === true) $message = $e->getMessage();
      throw View::page('500','PDO ERROR: '. $message);
    }
  }

  /**
   * prepares the statement and processes the values  
   *
   * returns the object if stamement is something
   */
  private function processParams($sql, $params)
  {
    $this->stmt = null;
    if ($this->stmt = $this->prepare($sql)) {
      if ($params) {
        foreach ($params as $key => $param) {
          $this->stmt->bindvalue($key, $param);
        }
      }
      $this->stmt->execute();
      return $this;
    }
  }

  /*
  * public functions 
  */
  static function run($results = array())
  {
    if (is_array($results)) { 
      $instance = Singleton::getInstance(get_class());    
      $instance->query = $results['query'];
      $instance->params = $results['params'];
      return $instance;
    }
  }

  // public function save($fields, $arg = array() )
  // {
  //   if (!$this->update($fields, $arg)) {
  //     $this->insert($fields, $arg);
  //   }
  // }

  /*
  * the following methods are extensions of the PDO class
  */
  public function fetch()
  {
    if ($this->processParams($this->query, $this->params)) return $this->stmt->fetch($this->fetchMode);
  }

  public function fetchAll()
  {
    if ($this->processParams($this->query, $this->params)) return $this->stmt->fetchAll($this->fetchMode);
  }

  public function fetchPairs()
  {
    if ($result = $this->fetch()) return array(reset($result) => end($result));
  }

  public function fetchValues($limiter = ', ')
  {
    if ($result = $this->fetch()) return implode($limiter, array_values($result));
  }
}