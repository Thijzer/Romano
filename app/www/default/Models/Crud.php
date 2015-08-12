<?php

Class Crud extends DB
{
    public $tables = array();

    public function __construct()
    {
        parent::__construct();
        Auth::requestAccess(Session::get('user'));
        $this->tables = Auth::requestTables();
    }

    public function select($table, $where = array(), $fields = array())
    {
        if (in_array($table, $this->tables)) {

            $authTables = Auth::getFields($table);

            $query = Query::table($table)
                ->select(array_intersect_key($fields, $authTables))
                ->where(array_intersect_key($where, $authTables))
                ->build();

            return self::run($query);
        }
    }

    function insert($table, $values = array())
    {
        if (in_array($table, $this->tables) AND !empty($values)) {
            return self::run(Query::table($table)->insert(Auth::getFields($values))->build(), true);
        }
    }

    function delete($table, $values = array())
    {
        if (in_array($table, $this->tables) AND !empty($values)) {
            return self::run(Query::table($table)->delete(Auth::getFields($values))->build(), true);
        }
    }

    function update($table, $values = null, $id = null)
    {
        if (in_array($table, $this->tables) AND !empty($values) AND !empty($values)) {
            return self::run(Query::table($table)->save(Auth::getFields($values), $id)->build(), true);
        }
    }
}
