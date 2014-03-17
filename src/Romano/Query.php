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
  protected $query = null;

 /**
   * @var array
   */
  protected $settings = array('namedParams' => true);
  protected $params;
  protected $arguments = array(
      'operator' => ' = ',
      'order' => '1',
      'limit' => 100,
      'split' => 'AND'
      );
 
  /**
   * assembles the queries.
   */
  private function assembleQuery($array, $arg)
  {
    if (is_array($array)) {

      $query = null;
      foreach ($array as $key => $value) {

 				if (!empty($value)) {

	        // example: "`id` ="
	        $query .= '`' . $key . '`' . $arg['operator'];

	        // optional key selection
	        if($this->settings['namedParams'] ===  true) {
	        	$param = ':' . $key;
	        	$this->params[$param] = $value;
	        } 
	        else {
						$this->params[] = $value;
						$param = '?';
					}

	        // optional like example: " LIKE CONCAT('%', :id, '%')"
	        ($arg['operator'] == ' LIKE ' ? $query .= "CONCAT('%', " . $param . ", '%')": $query .= $param);

	        // new line 
					$query .= "\n";

	        // the last key in the array
	        if (!$this->last($array, $key)) $query .= ' ' . $arg['split'] . ' ';
        }
      }
      return $query;
    }
  }

  public function setQuery($sqlValue = null)
  {
    if (!$this->query) $this->query = "\n" . (string) $sqlValue . "\n";
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

  public function endQuery($sqlValue = null, $arg = array())
  {
    if (!$this->query) return false;
    $arg = array_merge($this->arguments, $arg);
    if (!$sqlValue) {
    	$this->query .= ' ORDER BY ' . $arg['order'] . ' LIMIT ' . $arg['limit'];
    }
    else {
    	$this->query .= (string) $sqlValue;
    }
    $this->query .= "\n";
    return $this;
  }

  static public function select($table = null)
  {
  	if ((string) $table) {
  		$instance = Singleton::getInstance(get_class());
	  	$instance->table = $table;
	  	$instance->query = 'SELECT * FROM ' . $table;
      $instance->params = '';
	    return $instance;
  	}
  }

  public function onFields($fields = null)
  {
  	$fields = (array) $fields;
    if($fields) {
			if ($this->query) {
				$this->query = str_replace('*', implode(', ', $fields), $this->query);
			} else {
				$this->setQuery('SELECT '. implode(', ', $fields) . ' FROM ' . $this->table);
    	}
    } 
    elseif (!$this->query AND !$fields) {
    	$this->setQuery('SELECT * FROM ' . $this->table);	
    }
    return $this;
  }

  public function where($where = array(), $arg = array() )
  {
  	$this->setQuery('SELECT * FROM ' . $this->table);
    $query = $this->assembleQuery((array) $where, $arg = array_merge($this->arguments, $arg) );
    $this->setWhere($query, $arg);
    return $this;
  }

  public function like($where = array())
  {
    return $this->where($where, array('operator' => ' LIKE '));
  }

  public function delete($where = array(), $arg = array() )
  {
  	$this->setQuery('DELETE * FROM ' . $this->table);
    $query = $this->assembleQuery((array) $where, $arg = array_merge($this->arguments, $arg) );
    $this->setWhere($query, $arg);
    return $this;
  }

  public function insert($fields = array(), $arg = array() )
  {
    $this->assembleQuery((array) $fields, $arg = array_merge($this->arguments, $arg) );

  	$paramKeys = array_keys($this->params);
    $this->setQuery(
    	'INSERT INTO ' . $this->table . ' (`' . 
    	implode('`, `', $paramKeys) . '`) VALUES (:' . 
    	implode(', :', $paramKeys) . ')'
    );
    return $this;
  }

  public function update($fields = array(), $arg = array() )
  {
    $query = $this->assembleQuery((array) $fields, $arg = array_merge($this->arguments, $arg + array('split' => ',')) );
    $this->setQuery('UPDATE ' . $this->table . ' SET ' . $query);
    return $this;
  }

  public function build()
  {
    return array('query' => $this->query, 'params' => $this->params);
  }

  private function last(&$array, $key) {
    end($array);
    return $key === key($array);
  }
}

      // $query = Query::select('users') //select
      //   ->setQuery('SELECT * FROM users')
      //   ->like(array('active' => '1'))
      //   ->delete(array('active' => '1'), array('split' => 'OR'))
      //   ->insert(array('active' => '1'))
      //   ->update(array('active' => '1'))
      //   ->where(array('active' => '1'))
      //   ->like(array('uid' => (int) $pid))
      //   ->onFields(array('username', 'uid'))
      //   ->build();

      // $results = DB::run($query)->fetchAll();