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
   * The current globals
   *
   * @var 
   */
  protected static $instance = null;
  protected $stmt;
  protected $table;
  protected $where  = false;
  protected $query = false;
  protected $options = array(\PDO::ATTR_EMULATE_PREPARES, false, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
  protected $fetchMode = \PDO::FETCH_ASSOC;

 /**
   * some standard arguments we use.
   *
   * array
   */
  protected $params;
  protected $arguments = array(
      'field' => '*',
      'operator' => '=',
      'order' => '1',
      'limit' => 100
      );
 
  /**
   * constructs the connection.
   *
   * throws an error if needed with message if your in development mode.
   */

  function __construct()
  {    
    try {
      parent::__construct(\Config::$array['DB']['DSN'],\Config::$array['DB']['USER'],\Config::$array['DB']['PASS'],$this->options); 
    } catch (\PDOException $e) {
      if (DEV_ENV === true) $message = $e->getMessage();
      throw View::page('500','PDO ERROR: '. $message);
    }
  }

  /**
   * assembles the queries.
   *
   * returns an array with query and separated values
   */
  protected function action($array, $arg)
  {
    if ($i = count($array) AND is_array($array) ) {
      $query = null;
      
      $x = 1;

      foreach ($array as $key => $value) {
        
        $query .= "`{$key}` {$arg['operator']} ";
        ($arg['operator'] == 'LIKE CONCAT' ? $query .= "('%', :{$key}, '%')": $query .= ":{$key}");
        if ($x < $i) {
          $query .= $arg['split'];
          $x++;
        }
        $this->params[$key] = $value;
      }
      
      return array('query' => $query); 
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

  public function setQuery($sqlValue)
  {
    if (!$this->query) $this->query = (string) $sqlValue;
    return $this;
  }

  private function setWhere($whereValue, $arg)
  {
    if ($this->where === true) {
      $this->query .= $arg['split'] . (string) $whereValue;
    } else {
      $this->where = true;
      $this->query .= ' WHERE ' . (string) $whereValue;
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

  public function select($fields)
  {
    if($this->query) {
      $this->query = str_replace('*', implode(', ', (array) ($fields)), $this->query);
    } else {
      $this->arguments['field'] = (array) $fields;
    }
    return $this;
  }


  public function where($where, $arg = array() )
  {
    $action = $this->action((array) $where, $arg = array_merge($this->arguments, $arg + array('split' => ' AND ' )) );
    $this->setQuery("SELECT {$arg['field']} FROM {$this->table}");
    $this->setWhere($action['query'], $arg);
    return $this;
  }

  public function like($where)
  {
    return $this->where($where, array('operator' => 'LIKE CONCAT'));
  }

  public function delete($where, $arg = array() )
  {
    $action = $this->action($where, $arg = array_merge($this->arguments, $arg + array('split' => ' AND ' )) );
    $this->setQuery("DELETE {$arg['field']} FROM {$this->table}");
    $this->setWhere($action['query'], $arg);
    return $this;
  }

  public function insert($fields, $arg = array() )
  {
    $action = $this->action($fields, $arg = array_merge($this->arguments, $arg) );
    $this->setQuery("INSERT INTO {$this->table} (`" . implode('`, `', array_keys($action['values'])) . "`) VALUES (:". implode(', :', array_keys($action['values'])) .")");
    $this->setWhere($action['query'], $arg);
    return true;
  }

  public function update($fields, $id, $arg = array() )
  {
    $action = $this->action($fields, $arg = array_merge($this->arguments, $arg + array('split' => '`, `')) );
    $sql = "UPDATE {$this->table} SET {$action['query']}";
    $this->setWhere($action['query'], $arg);
    return true;
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
  public function fetch()
  {
    if ($this->process($this->query, $this->params) ) return $this->stmt->fetch($this->fetchMode);
  }

  public function fetchAll()
  {
    if ($this->process($this->query, $this->params) ) return $this->stmt->fetchAll($this->fetchMode);
  }

  public function fetchPairs()
  {
    if ($result = $this->fetch()) return array(reset($result) => end($result));
  }

  public function fetchValues($limiter = ', ')
  {
    if ($result = $this->fetch()) return implode($limiter, array_values($result));
  }

  public function fetchJson()
  {
    if ($result = $this->fetch()) return json_encode($result);
  }

  public function build()
  {

    return array('query' => $this->query, 'params' => $this->params);
  }
}