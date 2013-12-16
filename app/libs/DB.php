<?php
/**
* DB wrapper Tacito
* a very small but functional wrapper around the most basic functions
* it's called staticly but functions as a real object.
* it's still very experimental, I'm still moving things around to see the effect
* I know extending the PDO class is a little silly, but it helps on my shortcommings :D
*/
class DB extends PDO
{

  /**
   * The current globally used instance.
   *
   * @var 
   */
  protected static $instance = null;

  /**
   * The statement object for prepared queries.
   *
   * @var 
   */
  protected $stmt;

  /**
   * The affeced table we will be working on.
   *
   * @var 
   */
  protected $table;

  /**
   * The default fetch mode of the connection.
   *
   * @var int
   */
  protected $fetchMode = PDO::FETCH_ASSOC;

  /**
   * constructs the connection.
   *
   * throws an error if needed with message if your in development mode.
   */
  function __construct()
  {    
    $options = array(PDO::ATTR_EMULATE_PREPARES, false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    try {
      parent::__construct(Config::$array['DB']['DSN'],Config::$array['DB']['USER'],Config::$array['DB']['PASS'],$options); 
    } catch (PDOException $e) {
      if (DEV_ENV === true) {
        $message = $e->getMessage();
      }
      throw view::page('500','PDO ERROR: '. $message);
    }
  }

  /**
   * some standard arguments we use.
   *
   * returns an array
   */
  protected function arguments($arg)
  {
    return array_merge(array(
      'field' => '*',
      'operator' => '=',
      'order' => '1',
      'limit' => 50
      ), $arg);
  }

  /**
   * assembles the queries.
   *
   * returns an array with query and separated values
   */
  protected function action($array, $arg)
  {
    if ($i = count($array)) {
      $query = null;
      $values = array();
      $x = 1;
      foreach ($array as $key => $value) {
        $query .= "`{$key}` {$arg['operator']} :{$key}";
        if ($x < $i) {
          $query .= $arg['split'];
          $x++;
        }
        $values[$key] = $value;
      }
      return array('query' => $query, 'values' => $values); 
    }
  }

  /**
   * prepares the statement and processes the values  
   *
   * returns the object if stamement is something
   */
  protected function process($sql, $params)
  {
    $this->stmt = null;
    if ($this->stmt = $this->prepare($sql)) {
      if ($params) {
        foreach ($params as $key => $param) {
          $this->stmt->bindvalue(':'.$key, $param);
        }
        $this->stmt->execute();
        return $this;
      }
    }
  }
  /*
  * public functions 
  */
  static function connect($table = '')
  {
    static::$instance = new self();
    static::$instance->table($table);
    return static::$instance;
  }
  public function table($table)
  {
    $this->table = $table;
  }
  public function get($where, $arg = array() )
  {
    $action = $this->action($where, $arg = $this->arguments($arg + array('split' => ' AND ' )) );
    $sql = "SELECT {$arg['field']} FROM {$this->table} WHERE {$action['query']}";
    if ($this->process($sql, $action['values']) ) {
      return $this;
    }
  }
  public function delete($where, $arg = array() )
  {
    $action = $this->action($where, $arg = $this->arguments($arg + array('split' => ' AND ' )) );
    $sql = "DELETE {$arg['field']} FROM {$this->table} WHERE {$action['query']}";
    if ($this->process($sql, $action['values']) ) {
      return $this;
    }
  }
  public function insert($fields, $arg = array() )
  {
    $action = $this->action($fields, $arg = $this->arguments($arg) );
    $sql = "INSERT INTO {$this->table} (`" . implode('`, `', array_keys($action['values'])) . "`) VALUES (:". implode(', :', array_keys($action['values'])) .")";
    if ($this->process($sql, $action['values']) ) {
      return true;
    }
  }
  public function update($fields, $id, $arg = array() )
  {
    $action = $this->action($fields, $arg = $this->arguments($arg + array('split' => '`, `')) );
    $sql = "UPDATE {$this->table} SET {$action['query']} WHERE `uid` = {$id}";
    if ($this->process($sql, $action['values']) ) {
      return true;
    } 
  }
  public function save($fields, $id, $arg = array() )
  {
    if (!$this->update($fields, $id, $arg)) {
      $this->insert($fields, $arg);
    }
  }
  /*
  * the following methods are extensions of the PDO class
  */
  function fetch()
  {
    return $this->stmt->fetch($fetchMode);
  }
  function fetchAll()
  {
    return $this->stmt->fetchAll($fetchMode);
  }
}