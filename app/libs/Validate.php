<?php
/*
* Validation library 11/2013
* --------------------------
* creator/source : Alex Garrett
* - added regex
* - decoupled
*
* dependencies : needs DB layer/wrapper for "unique check"
*/

class Validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function check()
	{
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				$value = $source[$item];
				if ($rule === 'required' && empty($values)) {
					$this->addError("{$item} is required");
				} elseif (!empty($value)) {
					switch ($rule) {
						case 'min':
							if (strlen($value) < $rule_value) {
								$this->addError("{$item} must be minimum of {$rule_value} ");
							}
							break;
						case 'max':
							if (strlen($value) > $rule_value) {
								$this->addError("{$item} must be maximum of {$rule_value} ");
							}
							break;
						case 'matches':
							if ($value !== $source[$rule_value]) {
								$this->addError("{$rule} has no match");
							}
							break;
						case 'regex':
							if (!preg_match($rule_value, $value) ) {
								$this->addError("{$rule} no character match");
							}
							break;
						case 'unique':
							$_db = new PDO();
							if($_db = DB->query("SELECT {$item} FROM {$rule_value} WHERE {$item} = {$value} ")->fetch() ) {
								$this->_addError("{$item} exists");
							}
							break;						
					}

				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
	}
	private function addError($error)
	{
		$this->_errors[] = $error; 
	}
	public function errors()
	{
		return $this->_errors;
	}
}