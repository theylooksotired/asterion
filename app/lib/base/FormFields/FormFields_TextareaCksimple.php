<?php
class FormFields_TextareaCksimple extends FormFields_DefaultTextarea {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['cols'] = 70;
		$this->options['rows'] = 6;
		$this->options['class'] = 'ckeditorAreaSimple';
	}

	static public function create($options) {
		$options['cols'] = 70;
		$options['rows'] = 6;
		$options['class'] = 'ckeditorAreaSimple';
		return FormFields_DefaultTextarea::create($options);
	}
	
}
?>