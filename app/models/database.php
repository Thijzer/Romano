<?php
class Database extends PDO
{
  protected $stmt,$params,$slip;
  private $default;

  function __construct()
  {
    $this->default = array(
      'fields' => '*',
      'operator' => '=',
      'order' => '1',
      'limit' => 50,
      'date' => true
      );
    try
    {
      parent::__construct(Config::DB_TYPE.':host='.Config::DB_HOST.';dbname='.Config::DB_NAME,Config::DB_USER,Config::DB_PASS);
      if (DEV_ENV === true) {
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      }
    }
    catch(PDOException $e)
    {
      $view = new View();
      $view->page('500','PDO_ERROR: '. $e->getMessage());
    }
  }
  function get($table,$array,$arg = array())
  {
    $arg = array_merge($this->default,$arg);
    $query = "SELECT {$arg['fields']} FROM {$table} ";

    if ($array = $this->cleanup($array)) {
      if ($arg['operator'] === 'like') {
        $query .= 'WHERE ' . implode(' AND ', $array['like']);
        $this->slip = '%';
      } else {
        $query .= 'WHERE ' . implode(' AND ', $array['reg']);
      }
    }
    $query .= " ORDER BY {$arg['order']} LIMIT {$arg['limit']} ";
    $this->execute($query);
    return $this;
  }
  function delete($table,$array,$arg = array())
  {
    $arg = array_merge($this->default,$arg);

    if ($array = $this->cleanup($array)) {
      $query  = "DELETE {$arg['what']} FROM `{$table}` ";
      $query .= 'WHERE ' . implode(' AND ', $array['like']);
      $this->slip = '%';
      $this->execute($query);
    }
    return false;
  }
  function add($table,$array,$arg = array())
  {
    $arg = array_merge($this->default,$arg);

    if ($array = $this->cleanup($array)) {
      if ($arg['date'] === true) {
        $array['fields'][]      = '`date`';
        $array['conditions'][]  = 'NOW()';
      }
      $query   = "INSERT INTO {$table} (";
      $query  .= implode(', ', $array['fields']);
      $query  .= ') VALUES (';
      $query  .= implode(', ', $array['conditions']);
      $query  .= ')';
      $this->execute($query);
    }
    return false;
  }
  function edit($table,$array,$arg = array())
  {
    $arg = array_merge($this->default,$arg);
    if ($array = $this->cleanup($array)) {
      $query  = 'UPDATE `'.$table.'` SET ';
      $query .= implode(', ', $array['field']);
      $key    = current(array_keys($where));
      $query .= " WHERE $key = $where[pid]";
      $this->execute($query);
    }
    return false;
  }
  private function cleanup($array) // cleans array, fills params
  {
    $this->params = null;
    if ($array) {
      foreach ($array as $field => $value) {
        if ($value) {
          $conditions[] = ":$field";
          $fields[]     = "`$field`";
          $like[]       = "`$field` LIKE CONCAT (:$field)";
          $reg[]        = "`$field` = :$field";
          $this->params[$field] = $value;
        }
      }
      return array('conditions' => $conditions, 'like' => $like, 'fields' => $fields, 'reg' => $reg);
    }
  }
  private function execute($query) // we need a params and the array for the values
  {
    if ($query) {
      $this->stmt = null;
      $this->stmt = $this->prepare($query);
      if ($this->params) {
        foreach ($this->params as $key => $value) {
          $this->stmt->bindValue(':'.$key, $this->slip.$value.$this->slip);
        }
      }
      $this->stmt->execute(); // returns false on error
    }
  }
  function fetchAll()
  {
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function fetch()
  {
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }
}

?>