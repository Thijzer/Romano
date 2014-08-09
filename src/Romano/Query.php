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
        $array = array_filter((array)$array);

        if (!empty($array)) {

            $this->parameter = $array;
            $query = null;
            $this->paramKeys = array_keys($array);
            $this->paramValues = array_values($array);

            switch ($arg['type']) {
                case 'noParams':
                    $query .= $this->sqlImplode($this->paramKeys, '`', '`');
                    $query .= 'VALUES' . $this->sqlImplode($this->paramValues, "'", "'");
                    break;
                
                default: // params

                    foreach ($array as $key => $value) {

                        // example: "`id` ="
                        $query .= '`' . $key . '`' . $arg['operator'];

                        // optional key selection
                        if($arg['type'] ==  'params') {
                            $param = ':' . $key;
                            $this->params[$param] = $value;

                        } elseif($arg['type'] == '?') {

                            $this->params[] = $value;
                            $param = '?';
                        }

                        if ($arg['operator'] == ' LIKE ') {
                            $query .= "CONCAT('%', " . $param . ", '%')";
                        }
                        else $query .= $param;

                        // new line
                        $query .= "\n";

                        // the last key in the array
                        if (!$this->last($array, $key)) $query .= ' ' . $arg['split'] . ' ';
                    }
                    break;
            }
            return $query;
        }
    }

    public function startQuery($sqlValue)
    {
        $this->startQuery = "\n" . $sqlValue . "\n";
        return $this;
    }

    public function endQuery($sqlValue = null, $arg = array())
    {
        $arg = array_merge($this->arguments, $arg);
        if (!$sqlValue) {
            $this->endQuery .= ' ORDER BY ' . $arg['order'];
            $this->endQuery .= ' LIMIT ' . $arg['limit'];
        }
        else $this->endQuery .=  $sqlValue;

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
        $arg = array_merge($this->arguments, $arg);
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
            $query = $this->assembleQuery($where, $arg = array_merge($this->arguments, $arg));
            $this->setWhere($query, $arg);
        }
        return $this;
    }

    static public function table($table = null)
    {
        if ((string) $table) {
            $instance = new Query();
            $instance->table = $table;
            $instance->startQuery('SELECT * FROM ' . $table);
            $instance->settings = array('namedParams' => true);
            return $instance;
        }
    }

    public function onFields($fields = null)
    {
        if ($fields = (array) $fields AND $this->startQuery)
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
        $query = $this->assembleQuery($where, $arg = array_merge($this->arguments, $arg));
        $this->setWhere($query, $arg);
        return $this;
    }

    public function insert($fields = array(), $arg = array())
    {
        $this->assembleQuery((array) $fields, $arg = array_merge($this->arguments, $arg));

        $placeholder = ($this->settings['namedParams'] ===  false) ? array_fill(0, count($this->paramKeys), '?') : array_keys($this->params);

        $this->startQuery('INSERT INTO ' . $this->table . 
            $this->sqlImplode($this->paramKeys, '`', '`') . 'VALUES' .
            $this->sqlImplode($placeholder)
        );
        return $this;
    }

    public function sqlImplode(array $arr, $in = '', $out = '', $segment = ', ')
    {
        array_walk($arr, function(&$x) use ($in, $out){ $x = $in . $x . $out; });
        return ' (' . implode($segment, $arr) . ') ';
    }

    public function update($fields = array(), $arg = array())
    {
        $query = $this->assembleQuery($fields, $arg = array_merge($this->arguments, $arg + array('split' => ',')));
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

    public function save($fields = array(), $id = 'id')
    {
        $query = $this->assembleQuery($fields, $arg = array_merge($this->arguments, array('type' => 'noParams')));
        $this->startQuery('INSERT INTO ' . $this->table . ' ' . $query);
        if(in_array($id, array_flip($fields))) unset($fields[$id]); else exit('query::save no id in fields');

        $q = "\n";
        foreach ($fields as $key => $value) {
            $q .= '`' . $key . '` = VALUES(`' . $key . '`)';
            if (!$this->last($fields, $key)) $q .= ', ';
        }

        $this->endQuery('ON DUPLICATE KEY UPDATE ' . $q);
        return $this;
    }
}
