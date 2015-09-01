<?php
class FormFields_TextareaLarge extends FormFields_DefaultTextarea {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['cols'] = 70;
		$this->options['rows'] = 15;
	}

	static public function create($options) {
		$options['cols'] = 70;
		$options['rows'] = 15;
		return FormFields_DefaultTextarea::create($options);
	}
	
}
?>