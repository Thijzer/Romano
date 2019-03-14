<?php

class DB //extends PDO
{
    private static $_instance = null;
    private $_pdo;
    private $_stmt;
    private $_error;

    public function __construct($dsn = null, $username = null, $password = null, $options = [])
    {
        try {
            $options = $options + [
                PDO::ATTR_EMULATE_PREPARES, false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];
            //$this->_pdo = new PDO($dsn,$username,$password,$options);
            //parent::__construct($dsn,$username,$password,$options);
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function getInstance()
    {
        if (!isset(\Romano\Infrastructure\self::$_instance)) {
            \Romano\Infrastructure\self::$_instance = new PDO(
              $dsn = ConfigurationManager::$array['DB']['DSN'],
              $username = ConfigurationManager::$array['DB']['USER'],
              $password = ConfigurationManager::$array['DB']['PASS']
            );

            return \Romano\Infrastructure\self::$_instance;
        }
    }

    public function exec($sql, $params)
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

    public function get($table, $where, $arg = [])
    {
        $action = $this->action($table, $where, $arg = $this->arguments($arg + ['split' => ' AND ']));
        $sql = "SELECT {$arg['field']} FROM {$table} WHERE {$action['Framework\Infrastructure\Query']}";
        if (!$this->exec($sql, $action['values'])) {
            return $this;
        }
    }

    public function delete($table, $where, $arg = [])
    {
        $action = $this->action($table, $where, $arg = $this->arguments($arg + ['split' => ' AND ']));
        $sql = "DELETE {$arg['field']} FROM {$table} WHERE {$action['Framework\Infrastructure\Query']}";
        if (!$this->exec($sql, $action['values'])) {
            return $this;
        }
    }

    public function insert($table, $fields, $arg = [])
    {
        $action = $this->action($table, $fields, $arg = $this->arguments($arg));
        $sql = "INSERT INTO {$table} (`".implode('`, `', array_keys($action['values'])).'`) VALUES (:'.implode('`, `:', array_keys($action['values'])).')';
        if ($this->exec($sql, $action['values'])) {
            return true;
        }
    }

    public function update($table, $fields, $id, $arg = [])
    {
        $action = $this->action($table, $fields, $arg = $this->arguments($arg + ['split' => '`, `']));
        $sql = "UPDATE {$table} SET {$action['Framework\Infrastructure\Query']} WHERE `uid` = {$id}";
        if ($this->exec($sql, $action['values'])) {
            return true;
        }
    }

    public function save($table, $fields, $id, $arg = [])
    {
        if (!$this->update($table, $fields, $id, $arg)) {
            $this->insert($table, $fields, $arg);
        }
    }

    public function fetch()
    {
        return $this->_stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function arguments($arg)
    {
        return array_merge([
            'field' => '*',
            'operator' => '=',
            'order' => '1',
            'limit' => 50,
        ], $arg);
    }

    private function action($table, $array, $arg)
    {
        if ($i = count($array)) {
            $query = null;
            $values = [];
            $x = 1;
            foreach ($array as $key => $value) {
                $query .= "`{$key}` {$arg['operator']} :{$key}";
                if ($x < $i) {
                    $query .= $arg['split'];
                    ++$x;
                }
                $values[$key] = $value;
            }

            return ['Framework\Infrastructure\Query' => $query, 'values' => $values];
        }

        return false;
    }
}
