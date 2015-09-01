<?php
class FormFields_SelectCheckbox extends FormFields_DefaultSelect {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['checkbox'] = true;
	}

	static public function create($options) {
		$options['checkbox'] = true;
		return FormFields_DefaultSelect::create($options);
	}

}
?>