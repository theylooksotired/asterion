<?php
class FormFields_TextareaLong extends FormFields_DefaultTextarea {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['cols'] = '95%';
		$this->options['rows'] = 3;
	}

	static public function create($options) {
		$options['cols'] = '95%';
		$options['rows'] = 3;
		return FormFields_DefaultTextarea::create($options);
	}
	
}
?>