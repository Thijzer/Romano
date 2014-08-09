<?php
/*
  * Validation library 11/2013
  * --------------------------
  * creator/source : Alex Garrett
  * - added regex
  * - decoupled
  * - CheckDB method
  * - gate system for less validations
  *
  * dependencies : needs DB layer/wrapper for "checkDB"
  */
class Validate
{
    private $gate;
    private $errors = array();
    private $source =  array();
    private $data = array();

    function __construct($data)
    {
        $this->source = $data;
    }

    public function check($item ,$rules = array() )
    {
        $this->gate = true;
        foreach ($rules as $rule => $rule_value) {
            $value = trim($this->source[$item]);
            if ($this->gate === true) {
                switch ($rule) {
                    case 'required':
                        if (empty($value) AND $rule_value === true ) {
                            $this->addError(Lang::get('error.valid.required', array('{{item}}' => $item)));
                        }
                        break;
                    case 'min':
                        if (strlen($value) < $rule_value) {
                            $this->addError(Lang::get('error.valid.minchar', array('{{item}}' => $item, '{{rule_value}}' => $rule_value)));
                        }
                        break;
                    case 'max':
                        if (strlen($value) > $rule_value) {
                            $this->addError(Lang::get('error.valid.maxchar', array('{{item}}' => $item, '{{rule_value}}' => $rule_value)));
                        }
                        break;
                    case 'matches':
                        if ($value !== $rule_value) {
                            $this->addError(Lang::get('error.valid.nomatch', array('{{item}}' => $item)));
                        }
                        break;
                    case 'regex':
                        if (!preg_match($rule_value, $value) ) {
                            $this->addError(Lang::get('error.valid.nomatch', array('{{item}}' => $item)));
                        }
                        break;
                    case 'db':
                        if (is_array($rule_value)) $this->checkDB($rule_value, strtolower($item), strtolower($value));
                        break;
                    default:
                        // needs to be logged
                        exit(Lang::get('error.valid.norule', array('{{rule}}' => $item)));
                        break;
                }
            }
        }
        if (!$this->errors) $this->data[$item] = $value;
    }

    public function requireAll()
    {
        foreach ($this->source as $key => $value) if (empty($value)) {
            $this->addError(Lang::get('error.valid.required', array('{{item}}' => $item)));
        }
    }

    public function checkDB($array, $where_key, $where_val)
    {
        $result = DB::run(
            Query::table($array['table'])
            ->where(array($where_key => $where_val))->build()
        )->fetch();

        if ($result) {
            foreach ($array as $key => $value) {
                switch ($key) {
                    case 'unique':
                        if ($result AND $value === true) {
                            $this->addError(Lang::get('error.valid.db.exsits', array('{{item}}' => $where_key)));
                        }
                        break;
                    case 'active':
                        if ($result['active'] === 1 AND $value === false) {
                            $this->addError(Lang::get('error.valid.db.active', array('{{item}}' => $where_key)));
                        }
                        elseif (empty($result['active']) AND $value === true) {
                            $this->addError(Lang::get('error.valid.db.notactive', array('{{item}}' => $where_key)));
                        }
                        break;
                }
            }
            if (!$this->errors) $this->data[$where_key] = $where_val;
        }
    }

    private function addError($error)
    {
        $this->errors[] = $error;
        $this->gate = false;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function get($item)
    {
        return trim($this->data[$item]);
    }
}
