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
  protected $table = null;
  protected $startQuery = null;
  protected $query = null;
  protected $endQuery = null;
  protected $parameter = null;

 /**
   * @var array
   */
  protected $settings = array('namedParams' => true);
  protected $params = array();
  protected $paramKeys = array();
  protected $arguments = array(
    'operator' => ' = ',
    'type' => 'params',
    'order' => 1,
    'limit' => 100,
    'split' => 'AND'
  );
 
  /**
   * assembles the queries.
   */
  private function assembleQuery($array, $arg)
  {
    if (!empty($array)) {

      $this->parameter = $array;
      $query = null;
      $this->paramKeys = array_keys($array);
      $this->paramValues = array_values($array);

      // foreach loop of params //type foreach
      if ($arg['type'] != 'noParams') {

        foreach ($array as $key => $value) {

          if (!empty($value)) {

            // example: "`id` ="
            $query .= '`' . $key . '`' . $arg['operator'];

            // optional key selection
            if($arg['type'] ==  'params') {
              $param = ':' . $key;
              $this->params[$param] = $value;

            } elseif($arg['type'] ==  '?') {

              $this->params[] = $value;
              $param = '?';
            }

            // optional RULES like example: " LIKE CONCAT('%', :id, '%')"
            if ($arg['operator'] == ' LIKE ') {
              $query .= "CONCAT('%', " . $param . ", '%')";
            }
            else $query .= $param;

            // new line 
            $query .= "\n";

            // the last key in the array
            if (!$this->last($array, $key)) $query .= ' ' . $arg['split'] . ' ';
          }
        }

      // direct implode injection   //type implode
      } elseif($arg['type'] == 'noParams') {
        $keys = $this->paramKeys;
        //$placeholder = '?'; array_fill(0, count($Keys), '?') ;
        foreach ($this->paramValues as $value) {
          $placeholder[] = "'" . $value . "'";
        }
        //$placeholder = $this->paramValues;
        $quote = "'";

        $query .= ' (`' . implode('`, `', $keys) . '`) VALUES (' . implode(', ', $placeholder) . ')';
      }

      return $query;
    }
  }

  public function startQuery($sqlValue = null)
  {
    $this->startQuery = "\n" . (string) $sqlValue . "\n";
    return $this;
  }

  public function endQuery($sqlValue = null, $arg = array())
  {
    if (!$this->startQuery) return false;
    $arg = array_merge($this->arguments, $arg);
    if (!$sqlValue) {
      $this->endQuery .= ' ORDER BY ' . $arg['order'];
      $this->endQuery .= ' LIMIT ' . $arg['limit'];
    }
    else {
      $this->endQuery .= (string) $sqlValue;
    }
    $this->endQuery .= "\n";
    return $this;
  }

  public function settings($set)
  {
    $this->settings = $set;
    return $this;
  }

  private function setWhere($whereValue, $arg)
  {
    if ($this->where === true) {
      $this->query .= ' ' . $arg['split'] . ' ' . (string) $whereValue;
    } else {
      $this->where = true;
      $this->query .= ' WHERE ' . (string) $whereValue;
    }
  }

  public function where($where = array(), $arg = array())
  {
    if ((array) $where)  {
      $query = $this->assembleQuery((array) $where, $arg = array_merge($this->arguments, $arg) );
      $this->setWhere($query, $arg);
    }
    return $this;
  }

  static public function select($table = null)
  {
  	if ((string) $table) {
  		$instance = Singleton::getInstance(get_class());
	  	$instance->table = $table;
	  	$instance->startQuery('SELECT * FROM ' . $table);
      $instance->params = array();
      $instance->parameter = array();
      $instance->paramKeys = array();
      $instance->where = false;
      $instance->query = null;
      $instance->settings = array('namedParams' => true);
	    return $instance;
  	}
  }

  public function onFields($fields = null)
  {
		if ($fields = (array)$fields AND $this->startQuery) 
      $this->startQuery = str_replace('*', implode(', ', $fields), $this->startQuery);
    return $this;
  }

  public function like($where = array())
  {
    return $this->where($where, array('operator' => ' LIKE '));
  }

  public function delete($where = array(), $arg = array())
  {
    $this->startQuery('DELETE * FROM ' . $this->table);
    $query = $this->assembleQuery((array) $where, $arg = array_merge($this->arguments, $arg));
    $this->setWhere($query, $arg);
    return $this;
  }

  public function insert($fields = array(), $arg = array())
  {
    $this->assembleQuery((array) $fields, $arg = array_merge($this->arguments, $arg) );

    $placeholder = ($this->settings['namedParams'] ===  false) ? array_fill(0, count($this->paramKeys), '?') : array_keys($this->params);

    $this->startQuery(
    	'INSERT INTO ' . $this->table . ' (`' . 
    	implode('`, `', $this->paramKeys) . '`) VALUES (' . 
    	implode(', ', $placeholder) . ')'
    );
    return $this;
  }

  public function update($fields = array(), $arg = array())
  {
    $query = $this->assembleQuery((array) $fields, $arg = array_merge($this->arguments, $arg + array('split' => ',')) );
    $this->startQuery('UPDATE ' . $this->table . ' SET ' . $query);
    return $this;
  }

  public function build()
  {
    return array(
      'query' => $this->startQuery . $this->query . $this->endQuery, 
      'params' => $this->params
    );
  }

  private function last(&$array, $key)
  {
    end($array);
    return $key === key($array);
  }

  public function save($fields = array(), $id = null, $on = 'ON DUPLICATE KEY UPDATE ')
  {
    $query = $this->assembleQuery((array) $fields, $arg = array_merge($this->arguments, array('type' => 'noParams')) );
    $this->startQuery('INSERT INTO ' . $this->table . ' ' . $query);
    $parameter = $this->parameter;
    unset($parameter[$id]);
    $parameter = array_keys($parameter);
     foreach ($parameter as $key => $value) {
      $q .= "\n";
      $q .= '`' . $value . '` = VALUES(`' . $value . '`)';
      if (!$this->last($parameter, $key)) $q .= ', ';
    }

    $this->endQuery($on . $q);
    return $this;
  }
}

// $query = Query::select('users') //select
  //   ->startQuery('SELECT * FROM users')
  //   ->like(array('active' => '1'))
  //   ->delete(array('active' => '1'), array('split' => 'OR'))
  //   ->insert(array('active' => '1'))
  //   ->update(array('active' => '1'))
  //   ->where(array('active' => '1'))
  //   ->like(array('uid' => (int) $pid))
  //   ->onFields(array('username', 'uid'))
  //   ->build();

  // $results = DB::run($query)->fetchAll();