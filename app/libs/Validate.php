<?php
/*
* Validation library 11/2013
* --------------------------
* creator/source : Alex Garrett
* - added regex
* - decoupled
* - CheckDB method
*
* dependencies : needs DB layer/wrapper for "checkDB"
*/
class Validate
{
  private $gate;

  private $errors = array(),
          $data = array();

  public function check($source, $items = array() )
  {
    foreach ($items as $item => $rules) {
      $this->gate = true;
      foreach ($rules as $rule => $rule_value) {
        $value = trim($source[$item]);
        if ($this->gate === true) {
          switch ($rule) {
            case 'required':
              if (empty($value) AND $rule_value === true ) {
                $this->addError("{$item} is required ");
              }
              break;
            case 'min':
              if (strlen($value) < $rule_value) {
                $this->addError("{$item} must have a minimum of {$rule_value} characters ");
              }
              break;
            case 'max':
              if (strlen($value) > $rule_value) {
                $this->addError("{$item} must have a maximum of {$rule_value} characters ");
              }
              break;
            case 'matches':
              if ($value !== $source[$rule_value]) {
                $this->addError("{$item} has no match ");
              }
              break;
            case 'regex':
              if (!preg_match($rule_value, $value) ) {
                $this->addError("{$item} has no character match ");
              }
              break;
            case 'db':
              if (is_array($rule_value)) {
                $this->checkDB($rule_value, $item, $value);
              }
              break;
            default:
              $this->addError("{$rule} is not an active rule ");
              break;
          }
        }
      }     
      if (!$this->errors) {
        $this->data[$item] = $value;
      }
    }
  }
  public function checkDB($array, $where_key, $where_val)
  {
    if ($result = DB::connect($array['table'])->get(array($where_key => strtolower($where_val)))->fetch() ) {
      foreach ($array as $key => $value) {
        switch ($key) {
          case 'unique':
            if ($result AND $value === true) {
              $this->addError($where_key . ' exists ');
            }
            break;
          case 'active':
            if ($result['active'] === 1 AND $value === false) {
              $this->addError($where_key . " is activated ");
            }elseif (empty($result['active']) AND $value === true) {
              $this->addError($where_key . " is not activated ");
            }
            break;        
        }
      }
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
  public function getField($item)
  {
    return $this->data[$item];
  }
} 