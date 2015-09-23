<?php

class DB extends \PDO
{
    /**
    * @var array
    */
    protected $stmt, $query, $params, $results;
    protected $options = array(\PDO::ATTR_EMULATE_PREPARES, false);
    protected $fetchMode = \PDO::FETCH_ASSOC;

    public function __construct($DB = array())
    {
        try {
            $DB = array_merge(config('DB'), $DB);
            parent::__construct($DB['DSN'], $DB['USER'], $DB['PASS'], $this->options);
        } catch (\PDOException $e) {
            if (DEV_ENV === true) {
                throw dump($e->getMessage());
            }
            throw Output::page('500','CONNECTION ERROR');
        }
    }

    private function processParams()
    {
        $this->stmt = $this->prepare($this->query);
        $check = $this->stmt->execute($this->params);
        if ($check === false) {
            dump($this->stmt->errorInfo());
            dump($this->results);
            Output::page('500', 'CONNECTION ERROR');
        }
        return $check;
    }

    public static function run(array $process)
    {
        $instance = Singleton::getInstance(get_class());
        $instance->query = (string) $process['query'];
        $instance->params = (isset($process['params'])?$process['params']:[]);
        $instance->stmt = null;
        $instance->results[] = $process;
        $instance->processParams();
        return $instance;
    }

    public function fetch()
    {
        return $this->stmt->fetch($this->fetchMode);
    }

    public function fetchAllBy($value)
    {
        $results = $this->stmt->fetchAll($this->fetchMode);
        foreach ($results as $result) {
            $tmp[$result['id']] = $result;
        }
        return $tmp;
    }

    public function get($value)
    {
        $temp = $this->stmt->fetch($this->fetchMode);
        return (isset($temp[$value])) ? $temp[$value] : dump($value.' is not set');
    }

    public function getId($id = 'id')
    {
        return $this->get('id');
    }

    public function getInsertedId()
    {
        return $this->lastInsertId();
    }

    public function fetchAll()
    {
        return $this->stmt->fetchAll($this->fetchMode);
    }

    public function fetchPairs($a, $b)
    {
        if ($results = $this->stmt->fetchAll($this->fetchMode)) {
            foreach ($results as $result) {
                $tmp[$result[$a]] = $result[$b];
            }
            return $tmp;
        }
    }

    public function fetchValues($limiter = ',')
    {
        if ($result = $this->stmt->fetch($this->fetchMode)) {
            return implode($limiter, array_values($result));
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}
