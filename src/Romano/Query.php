<?php

class Query
{
  /**
   * @var bool
   */
  protected $where = false;

  /**
   * @var string
   */
  protected $table;
  protected $fields;
  protected $query = null;

 /**
   * @var array
   */
  protected $params;
  protected $arguments = array(
      'field' => '*',
      'operator' => '=',
      'order' => '1',
      'limit' => 100
      );

	/**
	 * @var array
	 */
	protected static $instance = null;
 
  /**
   * assembles the queries.
   *
   * returns an array with query and separated values
   */
  private function action($array, $arg)
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

  static public function table($table)
  {
  	static::$instance = new self();
  	static::$instance->table = $table;
    return static::$instance;
  }

  public function select($fields = null)
  {
    $this->fields = $fields;
    if($this->query AND is_array($this->fields)) {
      $this->query = str_replace('*', implode(', ', $this->fields), $this->query);
    } elseif (is_array($this->fields)) {
      $this->setQuery('SELECT '. implode(', ', $this->fields) . " FROM {$this->table}");
    }
    elseif (!$this->query) {
      $this->setQuery("SELECT {$this->arguments['field']} FROM {$this->table}");
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

  public function build()
  {
    return array('query' => $this->query, 'params' => $this->params);
  }
}