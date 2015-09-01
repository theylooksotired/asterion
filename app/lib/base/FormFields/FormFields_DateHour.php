<?php
class FormFields_DateHour extends FormFields_DefaultDate {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['view'] = 'hour';
	}
	
	static public function create($options) {
		$options['view'] = 'hour';
		return FormFields_DefaultDate::create($options);
	}
	
}
?>