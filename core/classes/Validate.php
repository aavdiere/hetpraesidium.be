<?php
class Validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check ($source, $items = array()) {
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				
				$value = htmlentities((trim($source[$item])));
				$item = escape($item);

				if ($rule === 'required' && $value == '') {
					$this->addError("{$item} is vereist"); // Check 11 -> 23:00
				} else if (!empty($value)) {
					switch($rule) {
						case 'min';
							if (strlen($value) < $rule_value) {
								$this->addError("{$item} mag maar een minimum van {$rule_value} tekens hebben.");
							}
							break;
						case 'max';
							if (strlen($value) > $rule_value) {
								$this->addError("{$item} mag maar een maximum van {$rule_value} tekens hebben.");
							}
							break;
						case 'matches';
							if ($value != $source[$rule_value]) {
								$this->addError("{$rule_value} moet gelijk zijn aan {$item}");
							}
							break;
						case 'unique';
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if ($check->count()) {
								$this->addError("{$item} bestaat al.");
							}
							break;
						case 'not_unique';
							$check = $this->_db->get($rule_value, array(($item), '=', escape($value)));
							if (!$check->count()) {
								$this->addError("{$item} is niet terug te vinden in de lijst, het spijt ons...");
							}
							break;
						case 'not';
							if ($value === $rule_value) {
								$this->addError("{$item} mag niet '{$rule_value}' zijn.");
							}
							break;
						case 'unique_link';
							$link = $rule_value[0];
							$table = $rule_value[1];
							$check = $this->_db->get($table, array($item, '=', $value, '&&', $link, '=', $source[$link]));
							if ($check->count()) {
								$this->addError("{$item} en {$link} zijn al in beslag genomen.");
							}
							break;
						case 'format';
							switch ($rule_value) {
								case 'alphanumeric';
									$pattern = '#^[A-Z0-9 ]+$#i';
									if (!preg_match($pattern, $value)) {
										$this->addError("{$item} moet {$rule_value} zijn.");
									}
									break;
								case 'alphabetic';
									$pattern = '#^[A-Z ]+$#i/u';
									if (!preg_match($pattern, $value)) {
										$this->addError("{$item} moet {$rule_value} zijn.");
									}
									break;
								case 'numeric';
									$pattern = '#^[-0-9.]+$#i';
									if (!preg_match($pattern, $value)) {
										$this->addError("{$item} moet {$rule_value} zijn.");
									}
									break;
								case 'date';
									if (!checkdate(date('m', strtotime($value)), date('d', strtotime($value)), date('Y', strtotime($value)))) {
										$this->addError("{$item} moet een {$rule_value} zijn.");
									}
									break;
							}
							break;
					}
				}

			}
		}

		if (empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}
}

?>