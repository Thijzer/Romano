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

    function __construct($DB = null)
    {
        if ($DB === null) $DB = App::getInstance()->get(array('config', 'DB'));

        try {
            parent::__construct($DB['DSN'], $DB['USER'], $DB['PASS'], $this->options);
        } catch (\PDOException $e) {
            if (DEV_ENV === true) $message = $e->getMessage(); dump($message);
            throw Output::page('500','PDO CONNECTION ERROR: ' . $message);
        }
    }

    private function processParams()
    {
        try {
            if($this->stmt = $this->prepare($this->query)) {
                return $this->stmt->execute($this->params);
            }
        } catch (\PDOException $e) {
            if (DEV_ENV === true) $message = $e->getMessage(); dump($message);
            throw Output::page('500', 'PDO QUERY ERROR: ' . $message);
        }
    }

    static function run($results = array(), $run = false)
    {
        $instance = Singleton::getInstance(get_class());

        if (!empty($results)) {
            $instance->query = (string) $results['query'];
            $instance->params = (isset($results['params'])) ? (array) $results['params'] : array();
            $instance->stmt = null;
            if ($run === true) $instance->processParams();
        }
        return $instance;
    }

    public function fetch()
    {
        if ($this->query AND $this->processParams()) return $this->stmt->fetch($this->fetchMode);
    }

    public function getId($id = 'id')
    {
        $result = $this->fetch(); return $result[$id];
    }

    public function getInsertedId()
    {
        return $this->lastInsertId();
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
