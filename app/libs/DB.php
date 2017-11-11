<?php
/**
* DB wrapper Tacito
* 
*/
class DB //extends PDO
{
  private static $_instance = null;
  private $_pdo, $_stmt, $_error;

  function __construct($dsn = null, $username = null, $password = null, $options = array() )
  {
    try {
      $options = $options + array(
        PDO::ATTR_EMULATE_PREPARES, false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      );
      //$this->_pdo = new PDO($dsn,$username,$password,$options);
      //parent::__construct($dsn,$username,$password,$options); 
    } catch (PDOException $e) {
        throw $e;
    } catch(Exception $e) {
        throw $e;
    }
  }
  static function getInstance()
  {
    if (!isset(self::$_instance) ) {
      self::$_instance = new PDO(
        $dsn      = Config::$array['DB']['DSN'],
        $username = Config::$array['DB']['USER'],
        $password = Config::$array['DB']['PASS']
      );
      return self::$_instance;
    } 
  }
  private function arguments($arg)
  {
    return array_merge(array(
      'field' => '*',
      'operator' => '=',
      'order' => '1',
      'limit' => 50
      ), $arg);
  }
  private function action($table, $array, $arg)
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
    return false;
  }
  function exec($sql, $params)
  {
    $this->stmt = null;
    if ($this->_stmt = $this->prepare($sql)) {
      if ($params) {
        foreach ($params as $key => $param) {
          $this->_stmt->bindvalue(':'.$key, $param);
        }
      }
      $this->_stmt->execute();
    }
  }
  function get($table, $where, $arg = array() )
  {
    $action = $this->action($table, $where, $arg = $this->arguments($arg + array('split' => ' AND ' )) );
    $sql = "SELECT {$arg['field']} FROM {$table} WHERE {$action['query']}";
    if (!$this->exec($sql, $action['values']) ) {
      return $this;
    }
  }
  function delete($table, $where, $arg = array() )
  {
    $action = $this->action($table, $where, $arg = $this->arguments($arg + array('split' => ' AND ' )) );
    $sql = "DELETE {$arg['field']} FROM {$table} WHERE {$action['query']}";
    if (!$this->exec($sql, $action['values']) ) {
      return $this;
    }
  }
  function insert($table, $fields, $arg = array() )
  {
    $action = $this->action($table, $fields, $arg = $this->arguments($arg) );
    $sql = "INSERT INTO {$table} (`" . implode('`, `', array_keys($action['values'])) . "`) VALUES (:". implode('`, `:', array_keys($action['values'])) .")";
    if ($this->exec($sql, $action['values']) ) {
      return true;
    }
  }
  function update($table, $fields, $id, $arg = array() )
  {
    $action = $this->action($table, $fields, $arg = $this->arguments($arg + array('split' => '`, `')) );
    $sql = "UPDATE {$table} SET {$action['query']} WHERE `uid` = {$id}";
    if ($this->exec($sql, $action['values']) ) {
      return true;
    } 
  }
  function save($table, $fields, $id, $arg = array() )
  {
    if (!$this->update($table, $fields, $id, $arg)) {
      $this->insert($table, $fields, $arg);
    }
  }
  function fetch()
  {
    return $this->_stmt->fetch(PDO::FETCH_ASSOC);
  }
  function fetchAll()
  {
    return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}