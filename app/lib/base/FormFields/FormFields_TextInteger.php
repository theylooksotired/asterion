<?php
class FormFields_TextInteger extends FormFields_Text {

	protected $options;
	
	public function __construct($options) {
		parent::__construct($options);
		$this->options['size'] = 10;
	}

	static public function create($options) {
		$options['size'] = 10;
		return FormFields_Default::create($options);
	}
	
}
?>