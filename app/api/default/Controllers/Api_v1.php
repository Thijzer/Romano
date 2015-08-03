<?php

class Api_v1
{
    public $filename;
    public $tables = array();

    public function __construct($app)
    {
        $this->filename = $app->get(array('route', 'parameter', 0));
        $this->tables = Auth::requestTables();
        Auth::requestAccess();
    }

    public function get($app = null)
    {
        if (in_array($this->filename, $this->tables)) {

            $query = Query::table($this->filename);
            $query->onfields(Auth::getFields($this->filename));

            // we accept input values and crudaccess()
            if (Input::submitted()) $query = $this->_filterQuery($query);

            $query = $query->build();
            return DB::run($query)->fetchAll();
        }
    }

    public function insert($app = null)
    {
        if (in_array($this->filename, $this->tables)) {

            // submitted input values
            if (Input::submitted()) {

                //validation
                $validation = New Validate();
                $values = Input::getInputs();
                $validation->requireAll($values);

                if (!$validation->errors()) {
                    $query = Query::table($this->filename)->insert($values)->build();

                    $app->setArray('values', $values);

                    return ;//DB::run($query)->fetchAll();
                }
            }
        }
    }

    public function delete($app = null)
    {
        if (in_array($this->filename, $this->tables)) {

            $query = Query::table($this->filename);

            //validation

            // submitted input values
            if (Input::submitted()) $query->delete();

            $query = $query->build();

            return DB::run($query)->fetchAll();
        }
    }

    public function add($app = null)
    {
        if (in_array($this->filename, $this->tables)) {

            $query = Query::table($this->filename);

            //validation

            // submitted input values
            if (Input::submitted()) $query->add();

            $query = $query->build();

            return DB::run($query)->fetchAll();
        }
    }

    private function _filterQuery($query)
    {
        // input id
        if ($id = (int) Input::get('id')) $query->where(array('id' => $id));

        // input count
        if ($count = (int) Input::get('count')) $query->endQuery(null, array('limit' => $count));

        // input username
        if ($username = (string) Input::get('username')) $query->where(array('username' => $username));

        return $query;
    }
}
